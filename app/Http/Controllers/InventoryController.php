<?php

namespace App\Http\Controllers;

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



    public function addToInventory(Request $request)
    {
        try {
            $token = session('user'); // Token dari sesi
            \Log::info('Session token retrieved', ['token' => $token]);

            $userData = $this->authService->getUserProfile($token);
            $userEmail = $userData['data']['email'];
            \Log::info('User email retrieved', ['email' => $userEmail]);

            $user = DB::connection('mariadb')->table('users')->where('email', $userEmail)->first();

            if (!$user) {
                throw new \Exception('User not found in external database');
            }

            $userId = $user->id;
            \Log::info('User ID retrieved', ['user_id' => $userId]);

            // Validasi input
            $validatedData = $request->validate([
                'productId' => 'required|integer',
                'quantity' => 'required|integer|min:1'
            ]);
            \Log::info('Input validated', ['validated_data' => $validatedData]);

            // Gunakan transaksi untuk memastikan atomicity
            DB::transaction(function () use ($validatedData, $userId) {
                // Periksa stok produk di MariaDB
                $product = DB::connection('mariadb')->table('products')->where('id', $validatedData['productId'])->lockForUpdate()->first();

                if (!$product) {
                    throw new \Exception('Product not found');
                }

                if ($product->quantity < $validatedData['quantity']) {
                    throw new \Exception('Insufficient product stock');
                }

                \Log::info('Product retrieved from MariaDB', [
                    'product_id' => $product->id,
                    'current_quantity' => $product->quantity,
                ]);

                // Kurangi stok produk di MariaDB
                $updatedRows = DB::connection('mariadb')->table('products')->where('id', $product->id)->update([
                    'quantity' => $product->quantity - $validatedData['quantity'],
                    'updated_at' => now(),
                ]);

                if ($updatedRows === 0) {
                    throw new \Exception('Failed to update product stock');
                }

                \Log::info('Product stock updated in MariaDB', [
                    'product_id' => $product->id,
                    'remaining_quantity' => $product->quantity - $validatedData['quantity'],
                ]);

                // Periksa item di inventori di MySQL
                $existingItem = DB::connection('mysql')->table('inventory')
                    ->where('user_id', $userId)
                    ->where('product_id', $validatedData['productId'])
                    ->first();

                if ($existingItem) {
                    // Tambahkan kuantitas item yang sudah ada
                    DB::connection('mysql')->table('inventory')->where('id', $existingItem->id)->update([
                        'quantity' => $existingItem->quantity + $validatedData['quantity'],
                        'last_updated' => now(),
                    ]);
                } else {
                    // Buat item baru di inventori
                    DB::connection('mysql')->table('inventory')->insert([
                        'product_id' => $validatedData['productId'],
                        'user_id' => $userId,
                        'quantity' => $validatedData['quantity'],
                        'last_updated' => now(),
                    ]);
                }
            });


            return response()->json([
                'status' => 'success',
                'message' => 'Item added to inventory successfully',
            ]);
        } catch (\Exception $e) {
            // Logging untuk debugging
            \Log::error('Error Adding to Inventory', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


//    public function getOrderHistory(Request $request)
//    {
//        try {
//            $token = session('user');
//            $response = $this->authService->getUserProfile($token);
//
//            // Get user from database
//            $user = DB::connection('mariadb')->table('users')->where('email', $response['data']['email'])->first();
//
//            if (!$user) {
//                throw new \Exception('User not found');
//            }
//
//            $orders = Inventory::where('user_id', $user->id)
//                ->orderBy('last_updated', 'desc')
//                ->get()
//                ->map(function ($item) {
//                    $product = $this->productService->getProduct($item->product_id);
//                    return [
//                        'id' => $item->id,
//                        'product_name' => $product['name'] ?? 'Unknown Product',
//                        'quantity' => $item->quantity,
//                        'last_updated' => $item->last_updated,
//                        'image_url' => $product['imageUrl'] ?? null,
//                        'price' => $product['price'] ?? 0,
//                        'status' => $item->status ?? 'processing'
//                    ];
//                });
//
//            return view('profile-users.history-order', [
//                'userData' => $response['data'],  // Kirim response['data'] langsung
//                'orders' => $orders,
//                'activePage' => 'history'
//            ]);
//
//        } catch (\Exception $e) {
//            \Log::error('Error in getOrderHistory: ' . $e->getMessage());
//            return view('profile-users.history-order', [
//                'userData' => [
//                    'fullname' => 'User',
//                    'username' => 'User',
//                    'email' => ''
//                ],
//                'orders' => [],
//                'activePage' => 'history',
//                'error' => 'Failed to load order history'
//            ]);
//        }
//    }

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
                            'Accept' => 'application/json'
                        ])->get("https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products/{$item->product_id}");

                        if ($productResponse->successful()) {
                            $product = $productResponse->json()['data'];
                            return [
                                'id' => $item->id,
                                'product_name' => $product['name'] ?? 'Unknown Product',
                                'quantity' => $item->quantity,
                                'last_updated' => $item->last_updated,
                                'image_url' => $product['imageUrl'] ?? null,
                                'price' => $product['price'] ?? 0,
                                'status' => $item->status ?? 'processing'
                            ];
                        }

                        return [
                            'id' => $item->id,
                            'product_name' => 'Unknown Product',
                            'quantity' => $item->quantity,
                            'last_updated' => $item->last_updated,
                            'image_url' => null,
                            'price' => 0,
                            'status' => $item->status ?? 'processing'
                        ];
                    } catch (\Exception $e) {
                        \Log::error('Error fetching product: ' . $e->getMessage());
                        return [
                            'id' => $item->id,
                            'product_name' => 'Unknown Product',
                            'quantity' => $item->quantity,
                            'last_updated' => $item->last_updated,
                            'image_url' => null,
                            'price' => 0,
                            'status' => $item->status ?? 'processing'
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
}

