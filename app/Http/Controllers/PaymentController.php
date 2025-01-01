<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Midtrans\Snap;
use Midtrans\Config;
use App\Mail\PaymentNotification;
use App\Services\AuthService;
use App\Models\User;
use App\Models\Payment;

class PaymentController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }


    public function createPayment(Request $request)
{
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $user = Auth::user(); // Mengambil pengguna yang sedang login
    if (!$user) {
        return response()->json(['message' => 'User not authenticated'], 401);
    }
    $amount = $request->amount;

    $params = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . uniqid(),
            'gross_amount' => $amount,
        ],
        'customer_details' => [
            'first_name' => $user->fullname,
            'email' => $user->email,
            'phone' => $user->nomer_hp,
        ],
    ];

    try {
        $snapToken = Snap::getSnapToken($params);

        // Simpan transaksi ke tabel `payments`
        Payment::create([
            'amount' => $amount,
            'status' => 'pending',
            'purchase_id' => $request->purchase_id,
        ]);

        return response()->json(['token' => $snapToken]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    /**
     * Show payment form
     */
    public function showPaymentForm(Request $request)
    {
        try {
            $token = session('user');
            $response = $this->authService->getUserProfile($token);

            // Fetch user data from database
            $user = DB::table('users')->where('email', $response['data']['email'])->first();

            if (!$user) {
                throw new \Exception('User not found.');
            }

            $userData = [
                'fullname' => $response['data']['fullname'] ?? '',
                'phoneNumber' => $response['data']['phoneNumber'] ?? '',
                'address' => $response['data']['address'] ?? '',
                'email' => $response['data']['email'] ?? ''
            ];

            // Fetch cart items
            $cartIds = explode(',', $request->query('items', ''));
            $cartItems = DB::table('carts')
                ->whereIn('id', $cartIds)
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->get();

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

    /**
     * Process payment
     */
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

            // Update user profile in remote system
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
                throw new \Exception('Failed to update profile.');
            }

            // Update user data locally
            $user = DB::table('users')->where('email', $userEmail)->first();
            if (!$user) {
                throw new \Exception('Local user not found.');
            }

            DB::beginTransaction();

            DB::table('users')->where('id', $user->id)->update([
                'fullname' => $validated['name'],
                'nomer_hp' => $validated['phone'],
                'alamat' => $validated['alamat']
            ]);

            $cartIds = explode(',', $validated['items']);
            $cartItems = DB::table('carts')
                ->whereIn('id', $cartIds)
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('No active cart items found.');
            }

            foreach ($cartItems as $cart) {
                DB::table('carts')->where('id', $cart->id)->update([
                    'status' => 'completed',
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            return redirect()->route('history-order')
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in processPayment: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to process payment. Please try again.')
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

}
