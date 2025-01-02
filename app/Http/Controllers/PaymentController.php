<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

//    private function mapCartItemToProduct($cartItem)
//    {
//        try {
//            // Fetch product details
//            $productResponse = Http::withHeaders([
//                'X-Api-Key' => 'secret',
//                'Accept' => 'application/json',
//            ])->get("https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products/{$cartItem->product_id}");
//
//            if ($productResponse->successful()) {
//                $product = $productResponse->json()['data'];
//                return [
//                    'id' => $cartItem->id,
//                    'product_id' => $cartItem->product_id,
//                    'quantity' => $cartItem->quantity,
//                    'price' => $product['price'] ?? 0,
//                    'product_name' => $product['name'] ?? 'Unknown Product',
//                    'subtotal' => ($product['price'] ?? 0) * $cartItem->quantity,
//                    'image_url' => $product['imageUrl'] ?? null,
//                ];
//            }
//
//            throw new \Exception('Failed to fetch product data');
//        } catch (\Exception $e) {
//            \Log::error('Error mapping cart item to product:', [
//                'item_id' => $cartItem->id,
//                'error' => $e->getMessage(),
//            ]);
//            return null;
//        }
//    }

    private function mapCartItemToProduct($cartItem, $productData)
    {
        return [
            'id' => $cartItem->id ?? null,
            'product_id' => $cartItem->product_id ?? $productData['id'],
            'quantity' => $cartItem->quantity ?? 1,
            'price' => $productData['price'] ?? 0,
            'product_name' => $productData['name'] ?? 'Unknown Product',
            'subtotal' => ($productData['price'] ?? 0) * ($cartItem->quantity ?? 1),
            'image_url' => $productData['imageUrl'] ?? null,
        ];
    }

    public function showPaymentForm(Request $request)
    {
        try {
            \Log::info('Starting showPaymentForm', [
                'items' => $request->query('items'),
                'type' => $request->query('type')
            ]);

            // Get and validate user token
            $token = session('user');
            if (!$token) {
                throw new \Exception('No user token found in session');
            }

            // Get user data
            $userData = $this->authService->getUserProfile($token);
            if (!isset($userData['data']) || !is_array($userData['data'])) {
                throw new \Exception('Invalid user data received');
            }

            $isBuyNow = $request->query('type') === 'buy_now';

            // For "Buy Now" flow, fetch product details directly
            if ($isBuyNow) {
                $itemIds = explode(',', $request->query('items', ''));
                if (empty($itemIds)) {
                    throw new \Exception('No items selected');
                }

                $products = collect($itemIds)->map(function ($itemId) {
                    try {
                        $productResponse = Http::withHeaders([
                            'X-Api-Key' => 'secret',
                            'Accept' => 'application/json',
                        ])->get("https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/products/{$itemId}");

                        if ($productResponse->successful()) {
                            $productData = $productResponse->json()['data'];
                            return $this->mapCartItemToProduct(null, $productData);
                        } else {
                            throw new \Exception("Failed to fetch product data for ID: {$itemId}");
                        }
                    } catch (\Exception $e) {
                        \Log::error('Error processing buy now item:', [
                            'item_id' => $itemId,
                            'error' => $e->getMessage()
                        ]);
                        return null;
                    }
                })->filter();

                if ($products->isEmpty()) {
                    throw new \Exception('No items could be processed');
                }

                $totalPrice = $products->sum('subtotal');
                $shippingCost = 1;

                return view('payment.form-payment', [
                    'selectedItems' => $products,
                    'totalPrice' => $totalPrice,
                    'shippingCost' => $shippingCost,
                    'userData' => $userData['data'],
                    'isBuyNow' => $isBuyNow
                ]);
            }

            throw new \Exception('Invalid payment type');
        } catch (\Exception $e) {
            \Log::error('Error in showPaymentForm:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function showPaymentFormCarts(Request $request)
    {
        try {
            // Log start of function
            \Log::info('Starting showPaymentForm', [
                'items' => $request->query('items')
            ]);

            // Get and validate item IDs
            $itemIds = explode(',', $request->query('items'));
            if (empty($itemIds)) {
                throw new \Exception('No items selected');
            }
            \Log::info('Processing items', ['itemIds' => $itemIds]);

            // Get and validate user token
            $token = session('user');
            if (!$token) {
                throw new \Exception('No user token found in session');
            }
            \Log::info('User token found');

            // Get user data
            $userData = $this->authService->getUserProfile($token);
            if (!isset($userData['data']) || !is_array($userData['data'])) {
                throw new \Exception('Invalid user data received');
            }
            \Log::info('User data retrieved');

            // Get user from database
            $user = DB::connection('mariadb')
                ->table('users')
                ->where('email', $userData['data']['email'])
                ->first();

            if (!$user) {
                throw new \Exception('User not found in database');
            }

            // Get cart items
            $selectedItems = DB::connection('mysql')
                ->table('carts')
                ->whereIn('id', $itemIds)
                ->where('user_id', $user->id)
                ->where('status', 'active')
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
                        throw new \Exception('Failed to fetch product data');
                    } catch (\Exception $e) {
                        \Log::error('Error fetching product:', [
                            'item_id' => $item->id,
                            'error' => $e->getMessage()
                        ]);
                        return null;
                    }
                })
                ->filter();

            if ($selectedItems->isEmpty()) {
                throw new \Exception('No active cart items found');
            }

            $totalPrice = $selectedItems->sum('subtotal');
            $shippingCost = 1;

            \Log::info('Payment form data prepared successfully', [
                'itemCount' => $selectedItems->count(),
                'totalPrice' => $totalPrice
            ]);

            return view('payment.form-payment', [
                'selectedItems' => $selectedItems,
                'totalPrice' => $totalPrice,
                'shippingCost' => $shippingCost,
                'userData' => $userData['data']
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in showPaymentForm:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }






    public function createPayment(Request $request)
    {
        try {
            \Log::info('Payment Request Data:', $request->all());

            // Set Midtrans Configuration
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = true;
            Config::$isSanitized = true;
            Config::$is3ds = true;


            // Ambil token dari sesi
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

            // Validasi user di MySQL
            $userMysql = DB::connection('mysql')->table('users')->where('id', $userId)->first();
            if (!$userMysql) {
                // Sinkronisasi user ke MySQL jika tidak ditemukan
                DB::connection('mysql')->table('users')->insert([
                    'id' => $userId,
                    'fullname' => $user->fullname ?? 'Unknown',
                    'email' => $user->email,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                \Log::info('User synchronized to MySQL database', ['user_id' => $userId]);
            }

            // Generate unique order ID
            $orderId = 'ORDER-' . time() . '-' . uniqid();

            // Siapkan item details
            $itemDetails = [];
            foreach ($request->items as $item) {
                $itemDetails[] = [
                    'id' => $item['product_id'],
                    'price' => (int)$item['price'],
                    'quantity' => (int)$item['quantity'],
                    'name' => substr($item['product_name'], 0, 50), // Midtrans has 50 char limit
                ];
            }

            // Tambahkan biaya pengiriman
            $itemDetails[] = [
                'id' => 'SHIPPING',
                'price' => 1,
                'quantity' => 1,
                'name' => 'Shipping Cost',
            ];

            // Siapkan parameter transaksi
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int)$request->amount, // Ensure amount is integer
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $user->fullname ?? 'Customer',
                    'email' => $user->email ?? '',
                    'phone' => $user->nomer_hp ?? '',
                    'billing_address' => [
                        'first_name' => $user->fullname ?? 'Customer',
                        'email' => $user->email ?? '',
                        'phone' => $user->nomer_hp ?? '',
                        'address' => $user->alamat ?? '',
                    ],
                    'shipping_address' => [
                        'first_name' => $user->fullname ?? 'Customer',
                        'email' => $user->email ?? '',
                        'phone' => $user->nomer_hp ?? '',
                        'address' => $user->alamat ?? '',
                    ],
                ],
                'enabled_payments' => [
                    'credit_card',
                    'mandiri_clickpay',
                    'cimb_clicks',
                    'bca_klikbca',
                    'bca_klikpay',
                    'bri_epay',
                    'echannel',
                    'permata_va',
                    'bca_va',
                    'bni_va',
                    'bri_va',
                    'other_va',
                    'gopay',
                    'indomaret',
                    'danamon_online',
                    'akulaku',
                    'shopeepay',
                ],
                'credit_card' => [
                    'secure' => true,
                    'channel' => 'migs',
                    'bank' => 'bca',
                    'save_card' => true,
                ],
            ];

            // Simpan detail transaksi ke database
            DB::connection('mysql')->table('transactions')->insert([
                'order_id' => $orderId,
                'user_id' => $userId, // Menggunakan user_id yang sudah divalidasi
                'amount' => $request->amount,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Buat Snap Token Midtrans
            $snapToken = Snap::getSnapToken($params);

            \Log::info('Snap Token created successfully', [
                'order_id' => $orderId,
                'token' => $snapToken,
            ]);

            return response()->json([
                'token' => $snapToken,
                'order_id' => $orderId,
            ]);
        } catch (\Exception $e) {
            \Log::error('Payment creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function processPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string',
                'alamat' => 'required|string',
                'items' => 'required|string'
            ]);

            $token = session('user');
            $userProfile = $this->authService->getUserProfile($token);
            $userEmail = $userProfile['data']['email'];

            // Update remote profile
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Api-Key' => 'secret',
                'Authorization' => "Bearer {$token}",
            ])->put("https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/users/profile/{$userEmail}", [
                'fullname' => $validated['name'],
                'address' => $validated['alamat'],
                'phoneNumber' => $validated['phone'],
            ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to update profile');
            }

            // Start database transaction
            DB::beginTransaction();

            // Update local user
            $user = DB::connection('mariadb')
                ->table('users')
                ->where('email', $userEmail)
                ->first();

            if (!$user) {
                throw new \Exception('Local user not found');
            }

            DB::connection('mariadb')
                ->table('users')
                ->where('id', $user->id)
                ->update([
                    'fullname' => $validated['name'],
                    'nomer_hp' => $validated['phone'],
                    'alamat' => $validated['alamat']
                ]);

            // Process cart items
            $cartIds = explode(',', $validated['items']);
            $cartItems = DB::connection('mysql')
                ->table('carts')
                ->whereIn('id', $cartIds)
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('No active cart items found');
            }

            foreach ($cartItems as $cart) {
                DB::connection('mysql')
                    ->table('carts')
                    ->where('id', $cart->id)
                    ->update([
                        'status' => 'completed',
                        'updated_at' => now()
                    ]);
            }

            DB::commit();

            return redirect()->route('history-order')
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in processPayment:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Failed to process payment: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();

            \Log::info('Payment notification received', $request->all());

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $fraudStatus = $notification->fraud_status;

            // Get transaction from database
            $transaction = DB::connection('mysql')
                ->table('transactions')
                ->where('order_id', $orderId)
                ->first();

            if (!$transaction) {
                throw new \Exception('Transaction not found: ' . $orderId);
            }

            $status = null;

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $status = 'challenge';
                } else if ($fraudStatus == 'accept') {
                    $status = 'success';
                }
            } else if ($transactionStatus == 'settlement') {
                $status = 'success';
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $status = 'failure';
            } else if ($transactionStatus == 'pending') {
                $status = 'pending';
            }

            // Update transaction status
            DB::connection('mysql')
                ->table('transactions')
                ->where('order_id', $orderId)
                ->update([
                    'status' => $status,
                    'updated_at' => now()
                ]);

            // If payment is successful, update inventory status
            if ($status === 'success') {
                \Log::info('Updating inventory and cart status for successful transaction.');

                // Get inventory items related to this transaction
                $inventoryItems = DB::connection('mysql')
                    ->table('inventory')
                    ->where('transaction_id', $transaction->id)
                    ->where('status', 'progress') // Update only if status is 'progress'
                    ->get();

                foreach ($inventoryItems as $item) {
                    DB::connection('mysql')
                        ->table('inventory')
                        ->where('id', $item->id)
                        ->update([
                            'status' => 'completed',
                            'last_updated' => now()
                        ]);
                }

                // Update related carts to 'completed'
                DB::connection('mysql')
                    ->table('carts')
                    ->where('transaction_id', $transaction->id)
                    ->update([
                        'status' => 'completed',
                        'updated_at' => now()
                    ]);
            }

            return response()->json(['status' => 'OK']);
        } catch (\Exception $e) {
            \Log::error('Notification handling failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
