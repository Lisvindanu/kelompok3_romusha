<?php


namespace App\Http\Controllers\Auth;

use App\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Users;


class AuthentikasiController extends Controller
{
    protected $authService;
    protected $httpOptions;
    protected $baseUrl;
    protected $apiKey;

    public function __construct(AuthService $authService)
    {

        $this->authService = $authService;
        $this->apiKey = env('api_key', 'secret');
        $this->baseUrl = env('SPRING_API_URL_AUTH', 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/auth');

        $this->httpOptions = [
//            'verify' => 'C:\laragon\bin\php\php-8.3.12-Win32-vs16-x64\extras\ssl\cacert.pem',
            'verify' => false,
        ];
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
            'username' => 'required|string',
        ]);

        try {
            $apiKey = $this->apiKey;
            // Prepare data for registration
            $registerData = [
                'email' => $data['email'],
                'password' => $data['password'],
                'username' => $data['username'],
                'password_confirmation' => $data['password_confirmation'],
            ];

            // Log payload for debugging
            Log::info('Register Payload:', $registerData);

            // Call Spring Boot API
            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Api-Key' => $apiKey,
                ])
                ->post("{$this->baseUrl}/register", $registerData);


            // Log response for debugging
            Log::info('Register Response:', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->successful()) {
                // Save email to session before redirect to OTP form
                session(['email' => $data['email']]);
                return redirect()->route('auth.otp')
                    ->with('status', 'Please verify your OTP to complete the registration.');
            } else {
                return back()->withErrors(['register' => 'Registration failed: ' . $response->body()]);
            }
        } catch (\Exception $e) {
            Log::error('Register Exception:', ['message' => $e->getMessage()]);
            return back()->withErrors(['register' => 'Error occurred: ' . $e->getMessage()]);
        }
    }


//    public function register(Request $request)
//    {
//        $data = $request->validate([
//            'email' => 'required|email',
//            'password' => 'required|string|min:6',
//            'password_confirmation' => 'required|same:password',
//            'username' => 'required|string',
//        ]);
//
//        try {
//            $apiKey = $this->apiKey;
//            // Prepare data for registration
//            $registerData = [
//                'email' => $data['email'],
//                'password' => $data['password'],
//                'username' => $data['username'],
//                'password_confirmation' => $data['password_confirmation'],
//            ];
//
//            // Log payload for debugging
//            Log::info('Register Payload:', $registerData);
//
//            // Call Spring Boot API
//            $response = Http::withOptions($this->httpOptions)
//                ->withHeaders([
//                    'Content-Type' => 'application/json',
//                    'X-Api-Key' => $apiKey,
//                ])
//                ->post("{$this->baseUrl}/register", $registerData);
//
//            // Log response for debugging
//            Log::info('Register Response:', [
//                'status' => $response->status(),
//                'body' => $response->body(),
//            ]);
//
//            if ($response->successful()) {
//                // Save data to local database
//                $user = new Users();
//                $user->email = $data['email'];
//                $user->username = $data['username'];
//                $user->password = bcrypt($data['password']); // Encrypt password before saving
//                $user->save();
//
//                // Save email to session before redirect to OTP form
//                session(['email' => $data['email']]);
//
//                return redirect()->route('auth.otp')
//                    ->with('status', 'Please verify your OTP to complete the registration.');
//            } else {
//                return back()->withErrors(['register' => 'Registration failed: ' . $response->body()]);
//            }
//        } catch (\Exception $e) {
//            Log::error('Register Exception:', ['message' => $e->getMessage()]);
//            return back()->withErrors(['register' => 'Error occurred: ' . $e->getMessage()]);
//        }
//    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $response = $this->authService->login($data['email'], $data['password']);

            if (is_array($response) && isset($response['status'])) {
                if ($response['status'] === 'success') {
                    session(['user' => $response['data']['token']]);
                    return redirect()->intended('/dashboard');
                } else {
                    return back()->withErrors(['error' => $response['message'] ?? 'Login failed.']);
                }
            } else {
                return back()->withErrors(['error' => 'Invalid response format.']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Login failed: ' . $e->getMessage()]);
        }
    }









    public function showOtpForm()
    {
        return view('register.otp');
    }



    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'otp' => 'required|string',
        ]);

        $email = session('email');
        if (!$email) {
            return back()->withErrors(['otp' => 'Email session is missing. Please try again.']);
        }

        try {
            $apiKey = $this->apiKey;


            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Api-Key' => $apiKey,
                ])
                ->post("{$this->baseUrl}/verify-otp-regis", [
                    'email' => session('email'),
                    'otp' => $data['otp'],
                ]);

            // Log OTP verification response
            \Log::info('OTP Verification Response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'json' => $response->json()
            ]);

            $responseData = $response->json();

            if ($response->successful() && $responseData['code'] == 200) {

                \Log::info('OTP Verification Successful', [
                    'email' => $email,
                    'redirect_route' => 'login'
                ]);


                $request->session()->forget('email');

                return redirect()->route('login')->with('status', 'OTP Verified Successfully. Please login to continue.');
            } else {
                \Log::error('OTP Verification Failed', [
                    'response' => $response->body(),
                    'code' => $responseData['code'] ?? 'No code',
                    'status' => $responseData['status'] ?? 'No status'
                ]);

                return back()->withErrors(['otp' => $responseData['status'] ?? 'Invalid OTP or expired. Please try again.']);
            }
        } catch (\Exception $e) {
            \Log::error('OTP Verification Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['otp' => 'Error occurred: ' . $e->getMessage()]);
        }
    }




    public function sendOtp(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $response = Http::withOptions($this->httpOptions)
                ->post("{$this->baseUrl}/send-otp", [
                    'email' => $data['email'],
                ]);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }




    public function getUserData($token)
    {
        $decodedBytes = $this->base64_url_decode($token);

        $decodedString = json_decode($decodedBytes, true);

        if (!$decodedString) {
            return response()->json(['error' => 'Invalid token data'], 400);
        }

        $userData = [
            'sub' => $decodedString['sub'],
            'username' => $decodedString['username'],
        ];

        return $userData;
    }

    private function base64_url_decode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }



    public function requestPasswordReset(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        try {
            // Kirim permintaan reset password ke layanan backend
            $response = $this->authService->requestPasswordReset($data['email']);

            // Debug respons untuk memastikan struktur datanya
            \Log::info('Response from Password Reset API:', $response);

            if (isset($response['status']) && $response['status'] === 'success') {
                // Berikan pesan konfirmasi kepada pengguna
                return redirect()->route('login')
                    ->with('status', $response['message'] ?? 'Password reset email sent.');
            } else {
                throw new \Exception($response['message'] ?? 'Failed to send reset email.');
            }
        } catch (\Exception $e) {
            \Log::error('Password Reset Request Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }



    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'token' => 'required|string',
            'newPassword' => 'required|string|min:6|confirmed'

        ]);

        try {
            $response = $this->authService->resetPassword($data['token'], $data['newPassword']);
            return redirect('/login')->with('status', 'Successfully logged out');
        } catch (\Exception $e) {

            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Password reset failed',
                'data' => $e->getMessage()
            ], 400);
        }
    }



    public function showResetPasswordForm($token)
    {

        return view('.forgot-password.reset-password', compact('token'));
    }

    public function logout(Request $request)
    {
        $token = session('user', 'token');

        $response = Http::withOptions($this->httpOptions)
            ->withHeaders([
                'X-API-KEY' => env('API_KEY', 'secret'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])
//            ->post('https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/auth/logout');
            ->post("{$this->baseUrl}/logout");

        \Log::info('Spring Boot logout request:', [
            'token' => $token,
            'response_status' => $response->status(),
            'response_body' => $response->body(),
        ]);

        if ($response->successful()) {
            auth()->logout();
            session()->flush();
            return redirect('/login')->with('status', 'Successfully logged out');
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to logout',
                'response_body' => $response->body(),
            ], 400);
        }
    }



}



