<?php



namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showPaymentForm(Request $request)
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
            $shippingCost = 10000;

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
    $payload = $request->all();
    $orderId = $payload['order_id'];
    $status = $payload['transaction_status'];

    $payment = Payment::where('id', $orderId)->first();

    if ($payment) {
        if ($status === 'settlement') {
            $payment->update(['status' => 'completed']);
        } elseif ($status === 'pending') {
            $payment->update(['status' => 'pending']);
        } elseif (in_array($status, ['cancel', 'expire'])) {
            $payment->update(['status' => 'failed']);
        }

        // Kirim notifikasi email ke user
        Mail::to($payment->user->email)->send(new PaymentNotification($payment));
    }

    return response()->json(['status' => 'success']);
}

//    public function createPayment(Request $request)
//    {
//        Config::$serverKey = config('services.midtrans.server_key');
//        Config::$isProduction = config('services.midtrans.is_production');
//        Config::$isSanitized = true;
//        Config::$is3ds = true;
//
//        try {
//            $amount = $request->amount;
//            $token = session('user');
//            $userData = $this->authService->getUserProfile($token);
//
//            $params = [
//                'transaction_details' => [
//                    'order_id' => 'ORDER-' . time(),
//                    'gross_amount' => $amount,
//                ],
//                'customer_details' => [
//                    'first_name' => $userData['data']['fullname'],
//                    'email' => $userData['data']['email'],
//                    'phone' => $userData['data']['phoneNumber'],
//                ],
//            ];
//
//            $snapToken = Snap::getSnapToken($params);
//            return response()->json(['token' => $snapToken]);
//        } catch (\Exception $e) {
//            return response()->json(['error' => $e->getMessage()], 500);
//        }
//    }

    public function createPayment(Request $request)
    {
        try {
            Config::$serverKey = config('services.midtrans.server_key');
            Config::$isProduction = config('services.midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $amount = $request->amount;
            $token = session('user');
            $userData = $this->authService->getUserProfile($token);

            $params = [
                'transaction_details' => [
                    'order_id' => 'ORDER-' . time(),
                    'gross_amount' => $amount,
                ],
                'customer_details' => [
                    'first_name' => $userData['data']['fullname'],
                    'email' => $userData['data']['email'],
                    'phone' => $userData['data']['phoneNumber'],
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            \Log::error('Payment creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
