<?php
//namespace App\Http\Controllers\Auth;
//
//use App\Services\AuthService;
//use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use \Firebase\JWT\JWT;
//use Illuminate\Support\Facades\Http;
//
//class AuthentikasiController extends Controller
//{
//    protected $authService;
//
//    public function __construct(AuthService $authService)
//    {
//        $this->authService = $authService;
//    }
//
//    public function login(Request $request)
//    {
//
//        if (session('otp_verified') === true) {
//            return redirect()->route('dashboard');
//        }
//
//        $data = $request->validate([
//            'email' => 'required|email',
//            'password' => 'required|string',
//        ]);
//
//        try {
//            $response = $this->authService->login($data['email'], $data['password']);
//
//            if (is_array($response) && isset($response['status'])) {
//                if ($response['status'] === 'success') {
//                    // Cek apakah OTP sudah diverifikasi
//                    if (session()->has('otp_verified') && session('otp_verified') === true) {
//                        // Jika OTP sudah diverifikasi, langsung login
//                        session(['user' => $response['data']['token']]);
//                        return redirect()->intended('/dashboard');
//                    } else {
//                        // Jika OTP belum diverifikasi, arahkan ke halaman OTP
//                        session(['email' => $data['email'], 'password' => $data['password']]);
//                        return redirect()->route('auth.otp');
//                    }
//                } elseif ($response['status'] === 'otp_required') {
//                    session(['email' => $data['email'], 'password' => $data['password']]);
//                    return redirect()->route('auth.otp');
//                } else {
//                    return back()->withErrors(['error' => $response['message'] ?? 'Login failed.']);
//                }
//            } else {
//                return back()->withErrors(['error' => 'Invalid response format.']);
//            }
//        } catch (\Exception $e) {
//            return back()->withErrors(['error' => 'Login failed: ' . $e->getMessage()]);
//        }
//    }
//
//
//
//
//    public function verifyOtp(Request $request)
//    {
//        // Validate OTP
//        $data = $request->validate([
//            'otp' => 'required|string',
//        ]);
//
//        try {
//
//            $response = $this->authService->login(session('email'), session('password'), $data['otp']);
//
//
//            session(['user' => $response['data']['token']]);
//            session(['otp_verified' => true]);
//
//            return redirect()->route('dashboard');
//        } catch (\Exception $e) {
//            // Jika verifikasi OTP gagal
//            return back()->withErrors(['otp' => 'Invalid OTP or expired. Please try again.']);
//        }
//    }
//
//
//
//    public function logout(Request $request)
//    {
//        $token = session('user', 'token');
//
//
//        $response = Http::withHeaders([
//            'X-API-KEY' => env('API_KEY'),
//            'Content-Type' => 'application/json',
//            'Accept' => 'application/json',
//            'Authorization' => 'Bearer ' . $token,
//        ])->post('https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/auth/logout');
//
//
//        \Log::info('Spring Boot logout request:', [
//            'token' => $token,
//            'response_status' => $response->status(),
//            'response_body' => $response->body(),
//        ]);
//
//
//        if ($response->successful()) {
//
//            auth()->logout();
//
//            // Clear session data
//            session()->flush();
//
//
//            return redirect('/login')->with('status', 'Successfully logged out');
//        } else {
//
//            return response()->json([
//                'status' => 'error',
//                'message' => 'Failed to logout',
//                'response_body' => $response->body(),
//            ], 400);
//        }
//    }
//
//
//
//
//
//
//    public function register(Request $request)
//    {
//        $data = $request->validate([
//            'username' => 'required|string|max:255',
//            'email' => 'required|email|max:255',
//            'password' => 'required|string|confirmed|min:6',
//            'password_confirmation' => 'required|string|min:6'
//        ]);
//
//        if ($data['password'] !== $data['password_confirmation']) {
//            return back()->withErrors(['password_confirmation' => 'The password confirmation does not match.']);
//        }
//
//        $registerData = [
//            'username' => $data['username'],
//            'email' => $data['email'],
//            'password' => $data['password'],
//            'password_confirmation' => $data['password'],
//        ];
//
//        try {
//            $response = $this->authService->register($registerData);
//            return redirect('/login')->with('success', 'Account created successfully! Please login.');
//        } catch (\Exception $e) {
//            return back()->withErrors(['error' => $e->getMessage()]);
//        }
//    }
//
//    public function sendOtp(Request $request)
//    {
//        $data = $request->validate([
//            'email' => 'required|email',
//        ]);
//
//        try {
//            $response = $this->authService->sendOtp($data['email']);
//            return response()->json($response);
//        } catch (\Exception $e) {
//            return response()->json(['error' => $e->getMessage()], 400);
//        }
//    }
//
//
//
//    public function showOtpForm()
//    {
//        return view('login.otp'); // Mengarahkan ke tampilan form OTP
//    }
//
//    public function getUserData($token)
//    {
//
//        $decodedBytes = $this->base64_url_decode($token);
//
//
//
//        $decodedString = json_decode($decodedBytes, true);
//
//        if (!$decodedString) {
//            return response()->json(['error' => 'Invalid token data'], 400);
//        }
//
//        $userData = [
//            'sub' => $decodedString['sub'],
//            'username' => $decodedString['username'],
//        ];
//
//        return $userData;
//    }
//
//
//    private function base64_url_decode($input) {
//        $remainder = strlen($input) % 4;
//        if ($remainder) {
//            $padlen = 4 - $remainder;
//            $input .= str_repeat('=', $padlen);
//        }
//        return base64_decode(strtr($input, '-_', '+/'));
//    }
//
//}


namespace App\Http\Controllers\Auth;

use App\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthentikasiController extends Controller
{
    protected $authService;
    protected $httpOptions;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->httpOptions = [
            'verify' => 'D:/LearnPHP/kelompok3_romusha/resources/cacert.pem', // Path ke sertifikat
        ];
    }

    public function login(Request $request)
    {
        if (session('otp_verified') === true) {
            return redirect()->route('dashboard');
        }

        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $response = $this->authService->login($data['email'], $data['password']);

            if (is_array($response) && isset($response['status'])) {
                if ($response['status'] === 'success') {
                    if (session('otp_verified') === true) {
                        session(['user' => $response['data']['token']]);
                        return redirect()->intended('/dashboard');
                    } else {
                        session(['email' => $data['email'], 'password' => $data['password']]);
                        return redirect()->route('auth.otp');
                    }
                } elseif ($response['status'] === 'otp_required') {
                    session(['email' => $data['email'], 'password' => $data['password']]);
                    return redirect()->route('auth.otp');
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

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'otp' => 'required|string',
        ]);

        try {
            $response = $this->authService->login(session('email'), session('password'), $data['otp']);

            session(['user' => $response['data']['token'], 'otp_verified' => true]);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => 'Invalid OTP or expired. Please try again.']);
        }
    }

    public function logout(Request $request)
    {
        $token = session('user', 'token');

        $response = Http::withOptions($this->httpOptions)
            ->withHeaders([
                'X-API-KEY' => env('API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])
            ->post('https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/auth/logout');

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

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|confirmed|min:6',
            'password_confirmation' => 'required|string|min:6'
        ]);

        if ($data['password'] !== $data['password_confirmation']) {
            return back()->withErrors(['password_confirmation' => 'The password confirmation does not match.']);
        }

        $registerData = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'password_confirmation' => $data['password'],
        ];

        try {
            $response = $this->authService->register($registerData);
            return redirect('/login')->with('success', 'Account created successfully! Please login.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function sendOtp(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $response = $this->authService->sendOtp($data['email']);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function showOtpForm()
    {
        return view('login.otp');
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
}
