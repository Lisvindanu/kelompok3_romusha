<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Services\AuthService;
use App\Services\InventoryServices;
use App\Models\Inventory;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;



class InventoryController extends Controller
{
    protected $productService;
    protected $inventoryServices;
    protected $authService;

    public function __construct(ProductService $productService, InventoryServices $inventoryServices, AuthService $authService) {
        $this->productService = $productService;
        $this->inventoryServices = $inventoryServices;
        $this->authService = $authService;
    }

    public function getUserInventory(Request $request): JsonResponse
    {
        $userId = $request->query('userId');
        $inventory = Inventory::where('user_id', $userId)
            ->get()
            ->map(function ($item) {
                $product = $this->productService->getProduct($item->product_id);
                return [
                    'item_id' => $item->id,
                    'product_name' => $product['name'] ?? 'Unknown Product',
                    'quantity' => $item->quantity,
                    'last_updated' => $item->last_updated,
                    'imageUrl' => $product['imageUrl'] ?? null
                ];
            });

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => $inventory
        ]);
    }

    public function useInventoryItem(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'userId' => 'required|integer',
            'itemId' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            $response = $this->inventoryServices->useInventoryItem($validatedData);
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }


    public function getOrderHistory(Request $request)
    {
        try {
            $token = session('user');
            $response = $this->authService->getUserProfile($token);

            // Get user from database
            $user = DB::connection('mariadb')->table('users')->where('email', $response['data']['email'])->first();

            if (!$user) {
                throw new \Exception('User not found');
            }

            $orders = Inventory::where('user_id', $user->id)
                ->orderBy('last_updated', 'desc')
                ->get()
                ->map(function ($item) {
                    try {
                        $productResponse = Http::withHeaders([
                            'X-Api-Key' => 'secret',
                            'Accept' => 'application/json',
                        ])->get("https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products/{$item->product_id}");

                        if ($productResponse->successful()) {
                            $product = $productResponse->json()['data'];
                            return [
                                'id' => $item->id,
                                'product_name' => $product['name'] ?? 'Unknown Product',
                                'quantity' => $item->quantity,
                                'price' => $product['price'] ?? 0,
                                'image_url' => $product['imageUrl'] ?? null,
                                'status' => $item->status ?? 'processing',
                                'reason' => $item->reason ?? 'No specific reason provided', // Tambahkan reason default
                            ];
                        }

                        return [
                            'id' => $item->id,
                            'product_name' => 'Unknown Product',
                            'quantity' => $item->quantity,
                            'price' => 0,
                            'image_url' => null,
                            'status' => $item->status ?? 'processing',
                            'reason' => 'Product data not found',
                        ];
                    } catch (\Exception $e) {
                        \Log::error('Error fetching product: ' . $e->getMessage());
                        return [
                            'id' => $item->id,
                            'product_name' => 'Unknown Product',
                            'quantity' => $item->quantity,
                            'price' => 0,
                            'image_url' => null,
                            'status' => $item->status ?? 'processing',
                            'reason' => 'Error fetching product data',
                        ];
                    }
                });


            return view('profile-users.history-order', [
                'userData' => $response['data'],
                'orders' => $orders,
                'activePage' => 'history'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getOrderHistory: ' . $e->getMessage());
            return view('profile-users.history-order', [
                'userData' => [
                    'fullname' => 'User',
                    'username' => 'User',
                    'email' => ''
                ],
                'orders' => [],
                'activePage' => 'history',
                'error' => 'Failed to load order history'
            ]);
        }
    }



    public function addToInventory(Request $request)
    {
        try {
            $token = session('user');
            \Log::info('Session token retrieved', ['token' => $token]);

            // Ambil data user melalui AuthService
            $userData = $this->authService->getUserProfile($token);
            $userEmail = $userData['data']['email'] ?? null;
            \Log::info('User email retrieved', ['email' => $userEmail]);

            if (!$userEmail) {
                throw new \Exception('User email not found in API response');
            }

            // Validasi user di MariaDB
            $user = DB::connection('mariadb')->table('users')->where('email', $userEmail)->first();
            if (!$user) {
                throw new \Exception('User not found in MariaDB');
            }

            $userId = $user->id;
            \Log::info('User ID retrieved:', ['user_id' => $userId]);

            // Validasi input
            $validatedData = $request->validate([
                'productId' => 'required|integer|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Gunakan transaksi untuk atomicity
            DB::transaction(function () use ($validatedData, $userId) {
                // Periksa stok produk di MariaDB
                $product = DB::connection('mariadb')->table('products')
                    ->where('id', $validatedData['productId'])
                    ->lockForUpdate()
                    ->first();

                if (!$product) {
                    throw new \Exception('Product not found');
                }

                if ($product->quantity < $validatedData['quantity']) {
                    throw new \Exception('Insufficient product stock');
                }

                // Kurangi stok produk di MariaDB
                DB::connection('mariadb')->table('products')->where('id', $product->id)->update([
                    'quantity' => $product->quantity - $validatedData['quantity'],
                    'updated_at' => now(),
                ]);

                \Log::info('Product stock updated in MariaDB', [
                    'product_id' => $product->id,
                    'remaining_quantity' => $product->quantity - $validatedData['quantity'],
                ]);

                // Perbarui inventori di MySQL
                $existingInventory = DB::connection('mysql')->table('inventory')
                    ->where('user_id', $userId)
                    ->where('product_id', $validatedData['productId'])
                    ->first();

                if ($existingInventory) {
                    DB::connection('mysql')->table('inventory')
                        ->where('id', $existingInventory->id)
                        ->update([
                            'quantity' => $existingInventory->quantity + $validatedData['quantity'],
                            'last_updated' => now(),
                        ]);
                } else {
                    DB::connection('mysql')->table('inventory')->insert([
                        'product_id' => $validatedData['productId'],
                        'user_id' => $userId,
                        'quantity' => $validatedData['quantity'],
                        'status' => 'progress',
                        'reason' => 'Awaiting confirmation from supplier',
                        'last_updated' => now(),
                    ]);
                }

                \Log::info('Inventory updated for user', ['user_id' => $userId]);

                // Perbarui carts di MySQL
                $existingCart = DB::connection('mysql')->table('carts')
                    ->where('user_id', $userId)
                    ->where('product_id', $validatedData['productId'])
                    ->where('status', 'active')
                    ->first();

                if ($existingCart) {
                    DB::connection('mysql')->table('carts')
                        ->where('id', $existingCart->id)
                        ->update([
                            'quantity' => $existingCart->quantity + $validatedData['quantity'],
                            'updated_at' => now(),
                        ]);
                } else {
                    DB::connection('mysql')->table('carts')->insert([
                        'product_id' => $validatedData['productId'],
                        'user_id' => $userId,
                        'quantity' => $validatedData['quantity'],
                        'status' => 'active',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                \Log::info('Cart updated for user', ['user_id' => $userId]);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Item added to inventory and cart successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error Adding to Inventory and Cart', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function showCart()
    {
        try {
            $cartData = $this->getCart(request());

            return view('cart', [
                'cartItems' => $cartData['cartItems'],
                'totalPrice' => $cartData['totalPrice'],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in showCart: ' . $e->getMessage());
            return view('cart', [
                'cartItems' => collect(),
                'totalPrice' => 0,
                'error' => 'Failed to load cart items',
            ]);
        }
    }

    public function getCart(Request $request)
    {
        try {
            $token = session('user');
            if (!$token) {
                throw new \Exception('Session expired. Please log in.');
            }

            $response = $this->authService->getUserProfile($token);
            if (!isset($response['data']['email'])) {
                throw new \Exception('Invalid user data received');
            }

            $user = DB::connection('mariadb')->table('users')->where('email', $response['data']['email'])->first();
            if (!$user) {
                throw new \Exception('User not found');
            }

            $cartItems = DB::connection('mysql')->table('carts')
                ->where('carts.user_id', $user->id)
                ->where('carts.status', 'active')
                ->select('carts.id', 'carts.product_id', 'carts.quantity')
                ->get()
                ->map(function ($item) {
                    try {
                        $productResponse = Http::withHeaders([
                            'X-Api-Key' => 'secret',
                            'Accept' => 'application/json',
                        ])->get("https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products/{$item->product_id}");

                        if ($productResponse->successful()) {
                            $product = $productResponse->json()['data'];
                            return [
                                'id' => $item->id,
                                'product_id' => $item->product_id,
                                'quantity' => $item->quantity,
                                'price' => $product['price'] ?? 0,
                                'product_name' => $product['name'] ?? 'Unknown Product',
                                'subtotal' => ($product['price'] ?? 0) * $item->quantity,
                                'image_url' => $product['imageUrl'] ?? null,
                            ];
                        }

                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'price' => 0,
                            'product_name' => 'Unknown Product',
                            'subtotal' => 0,
                            'image_url' => null,
                        ];
                    } catch (\Exception $e) {
                        \Log::error('Error fetching product data: ' . $e->getMessage());

                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'price' => 0,
                            'product_name' => 'Unknown Product',
                            'subtotal' => 0,
                            'image_url' => null,
                        ];
                    }
                });

            $totalPrice = $cartItems->sum('subtotal');

            return [
                'cartItems' => $cartItems,
                'totalPrice' => $totalPrice,
            ];
        } catch (\Exception $e) {
            \Log::error('Error in getCart: ' . $e->getMessage());
            return [
                'cartItems' => collect(),
                'totalPrice' => 0,
            ];
        }
    }


//    public function updateCartItem(Request $request, $cartItemId)
//    {
//        try {
//            // Validasi input
//            $validated = $request->validate([
//                'quantity' => 'required|integer|min:1',
//            ]);
//
//            // Cari item keranjang berdasarkan ID
//            $cartItem = Cart::findOrFail($cartItemId);
//
//            // Perbarui kuantitas
//            $cartItem->quantity = $validated['quantity'];
//            $cartItem->save();
//
//            return response()->json([
//                'status' => 'success',
//                'message' => 'Cart item updated successfully',
//            ]);
//        } catch (\Exception $e) {
//            \Log::error('Error in updateCartItem: ' . $e->getMessage());
//            return response()->json([
//                'status' => 'error',
//                'message' => 'Failed to update cart item',
//            ], 500);
//        }
//    }
//

    public function updateCartItem(Request $request, $cartItemId)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            // Cari item keranjang
            $cartItem = Cart::findOrFail($cartItemId);

            // Cari item inventaris berdasarkan product_id
            $inventoryItem = Inventory::where('product_id', $cartItem->product_id)->firstOrFail();

            // Update jumlah di inventaris
            $inventoryItem->quantity = $validated['quantity'];
            $inventoryItem->save();

            // Update jumlah di keranjang
            $cartItem->quantity = $validated['quantity'];
            $cartItem->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Cart item and inventory updated successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in updateCartItem:', ['message' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update cart item',
            ], 500);
        }
    }


    public function removeFromCart($cartItemId)
    {
        try {
            Cart::findOrFail($cartItemId)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Item removed from cart successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in removeFromCart: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove item from cart'
            ], 500);
        }
    }
}

