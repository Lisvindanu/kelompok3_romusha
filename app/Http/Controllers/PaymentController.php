<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }


    public function showPaymentForm(Request $request)
    {
        try {
            $token = session('user');
            $response = $this->authService->getUserProfile($token);

            // Get user from database
            $user = DB::connection('mariadb')->table('users')
                ->where('email', $response['data']['email'])
                ->first();

            if (!$user) {
                throw new \Exception('User not found');
            }

            // Get user data
            $userData = [
                'fullname' => $response['data']['fullname'] ?? '',
                'phoneNumber' => $response['data']['phoneNumber'] ?? '',
                'address' => $response['data']['address'] ?? '',
                'email' => $response['data']['email'] ?? ''
            ];

            // Get cart IDs from URL
            $cartIds = explode(',', $request->query('items', ''));

            // Get selected cart items
            $cartItems = DB::connection('mysql')
                ->table('carts')
                ->whereIn('id', $cartIds)
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->get();

            // Create selected items collection
            $selectedItems = collect();
            $totalPrice = 0;

            foreach ($cartItems as $cartItem) {
                $productResponse = Http::withHeaders([
                    'X-Api-Key' => 'secret',
                    'Accept' => 'application/json',
                ])->get("https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products/{$cartItem->product_id}");

                if ($productResponse->successful()) {
                    $product = $productResponse->json()['data'];
                    $subtotal = ($product['price'] ?? 0) * $cartItem->quantity;

                    $selectedItems->push([
                        'id' => $cartItem->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $product['price'],
                        'product_name' => $product['name'],
                        'subtotal' => $subtotal,
                        'image_url' => $product['imageUrl']
                    ]);

                    $totalPrice += $subtotal;
                }
            }

            $shippingCost = 50000;

            return view('payment.form-payment', compact(
                'userData',
                'selectedItems',
                'totalPrice',
                'shippingCost'
            ));

        } catch (\Exception $e) {
            \Log::error('Error in showPaymentForm: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load payment form. Please try again.');
        }
    }

    public function processPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                'alamat' => 'required|string'
            ]);

            $token = session('user');
            $userProfile = $this->authService->getUserProfile($token);
            $userEmail = $userProfile['data']['email'];

            // Get user ID from Spring Boot
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Api-Key' => 'secret',
                'Authorization' => "Bearer {$token}",
            ])->get("http://virtual-realm-b8a13cc57b6c.herokuapp.com/api/auth/check-email?email=", [
                'email' => $userEmail,
            ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to get user ID');
            }

            $checkEmailResponse = $response->json();
            $userId = $checkEmailResponse['data']['id'] ?? $checkEmailResponse['data']['uuid'];

            // Update user profile in Spring Boot
            $updateResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Api-Key' => 'secret',
                'Authorization' => "Bearer {$token}",
            ])->put("https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/users/profile/{$userId}", [
                'username' => $userProfile['data']['username'],
                'fullname' => $validated['name'],
                'password' => null,
                'address' => $validated['alamat'],
                'phoneNumber' => $validated['phone'],
            ]);

            if (!$updateResponse->successful()) {
                throw new \Exception($updateResponse->json()['message'] ?? 'Failed to update profile');
            }

            // Get local user data
            $user = DB::connection('mariadb')->table('users')
                ->where('email', $userEmail)
                ->first();

            DB::beginTransaction();

            try {
                // Update local user information
                DB::connection('mariadb')->table('users')
                    ->where('id', $user->id)
                    ->update([
                        'fullname' => $validated['name'],
                        'nomer_hp' => $validated['phone'],
                        'alamat' => $validated['alamat']
                    ]);

                // Get cart IDs from form
                $cartIds = explode(',', $request->input('items', ''));

                // Cek data cart sebelum update
                $existingCart = DB::connection('mysql')->table('carts')
                    ->whereIn('id', $cartIds) // Menggunakan cart ID
                    ->where('user_id', $user->id)
                    ->where('status', 'active')
                    ->get();

                // Ambil product_ids dari cart yang ditemukan
                $productIds = $existingCart->pluck('product_id')->toArray();

                // Cek data inventory berdasarkan product_id dari cart
                $existingInventory = DB::connection('mysql')->table('inventory')
                    ->where('user_id', $user->id)
                    ->whereIn('product_id', $productIds)
                    ->where('status', 'progress')
                    ->get();

                // DD 9: Data check before updates
//                dd([
//                    'Step 9 - Data Check Before Updates:' => [
//                        'user_id' => $user->id,
//                        'cart_ids' => $cartIds,
//                        'existing_cart' => [
//                            'data' => $existingCart,
//                            'count' => $existingCart->count(),
//                            'product_ids' => $productIds
//                        ],
//                        'existing_inventory' => [
//                            'data' => $existingInventory,
//                            'count' => $existingInventory->count()
//                        ]
//                    ]
//                ]);

                // Throw exception jika data tidak ditemukan
                if ($existingCart->isEmpty()) {
                    throw new \Exception('No active cart items found for the selected products.');
                }

                if ($existingInventory->isEmpty()) {
                    throw new \Exception('No progress inventory items found for the selected products.');
                }

                // Update cart and inventory status
                foreach ($existingCart as $cart) {  // Iterasi dari cart yang ditemukan
                    $cartUpdate = DB::connection('mysql')->table('carts')
                        ->where('id', $cart->id)  // Update berdasarkan cart ID
                        ->where('status', 'active')
                        ->update([
                            'status' => 'completed',
                            'updated_at' => now()
                        ]);

                    $inventoryUpdate = DB::connection('mysql')->table('inventory')
                        ->where('user_id', $user->id)
                        ->where('product_id', $cart->product_id)  // Update inventory berdasarkan product_id dari cart
                        ->where('status', 'progress')
                        ->update([
                            'status' => 'pending',
                            'reason' => 'Order is being processed',
                            'last_updated' => now()
                        ]);

                    // DD 10: Update results for each item
//                    dd([
//                        'Step 10 - Update Results:' => [
//                            'cart_id' => $cart->id,
//                            'product_id' => $cart->product_id,
//                            'cart_update_result' => $cartUpdate,
//                            'inventory_update_result' => $inventoryUpdate
//                        ]
//                    ]);
                }

                // Final check before commit
                $finalCartStatus = DB::connection('mysql')->table('carts')
                    ->whereIn('id', $cartIds)
                    ->get();

                $finalInventoryStatus = DB::connection('mysql')->table('inventory')
                    ->where('user_id', $user->id)
                    ->whereIn('product_id', $productIds)
                    ->get();

//                dd([
//                    'Step 11 - Final Status Check:' => [
//                        'cart_status' => $finalCartStatus,
//                        'inventory_status' => $finalInventoryStatus
//                    ]
//                ]);

                DB::commit();
                return redirect()->route('history-order')
                    ->with('success', 'Order placed successfully!');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Transaction Error: ' . $e->getMessage());
                return redirect()->back()
                    ->with('error', $e->getMessage())
                    ->withInput();
            }

        } catch (\Exception $e) {
            \Log::error('Error in processPayment: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to process payment. Please try again.')
                ->withInput();
        }
    }
}

