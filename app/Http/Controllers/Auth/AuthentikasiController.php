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
        $this->baseUrl = env('spring_api_url_auth', 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/auth');

        $this->httpOptions = [
            //            'verify' => 'C:\laragon\bin\php\php-8.3.12-Win32-vs16-x64\extras\ssl\cacert.pem',
            'verify' => false,
            'timeout' => 120,
            'connect_timeout' => 120
        ];
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
            'username' => 'required|string',
            'fullname' => 'required|string',
            'imageUrl' => 'nullable|string',
        ]);

        try {
            $apiKey = $this->apiKey;
            // Prepare data for registration
            $registerData = [
                'email' => $data['email'],
                'password' => $data['password'],
                'username' => $data['username'],
                'password_confirmation' => $data['password_confirmation'],
                'fullname' => $data['fullname'],
                'imageUrl' => $data['imageUrl'] ?? null,
                'isGoogle' => false
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


    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $response = $this->authService->login($data['email'], $data['password']);

            // Simpan token dan role ke dalam session
            session([
                'user' => $response['token'], // Simpan token
                'role' => $response['role'],  // Simpan role
            ]);

            //            dd([
            //                'Location' => 'login method',
            //                'Response' => $response,
            //                'Session Data' => session()->all(),
            //                'Token' => session('user'),
            //                'Role' => session('role')
            //            ]);


            // Arahkan pengguna berdasarkan role
            if ($response['role'] === 'ADMIN') {
                return redirect('/dashboard');
            }

            return redirect('/profile-users');
        } catch (\Exception $e) {
            Log::error('Login error:', [
                'email' => $data['email'],
                'error' => $e->getMessage(),
            ]);
            return back()->withErrors(['error' => 'Login failed: Invalid email or password.']);
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

    public function showChangePasswordForm()
    {
        try {
            $token = session('user');
            $response = $this->authService->getUserProfile($token);

            return view('profile-users.change-password', [
                'userData' => $response['data'],
                'username' => $response['data']['username']
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in showChangePasswordForm:', [
                'error' => $e->getMessage()
            ]);
            return redirect()->route('login')
                ->withErrors(['error' => 'Please login to continue']);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        try {
            $token = session('user');
            $userProfile = $this->authService->getUserProfile($token);
            $userEmail = $userProfile['data']['email'];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Api-Key' => $this->apiKey,
                'Authorization' => "Bearer {$token}",
            ])
                ->get("{$this->baseUrl}/check-email", [
                    'email' => $userEmail,
                ]);

            if (!$response->successful()) {
                throw new \Exception("Failed to get user ID");
            }

            $checkEmailResponse = $response->json();
            $userId = $checkEmailResponse['data']['id'] ?? $checkEmailResponse['data']['uuid'];

            $updateResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Api-Key' => $this->apiKey,
                'Authorization' => "Bearer {$token}",
            ])
                ->post("{$this->baseUrl}/users/{$userId}/change-password", [
                    'currentPassword' => $request->current_password,
                    'newPassword' => $request->new_password,
                    'confirmPassword' => $request->confirm_password,
                ]);

            if (!$updateResponse->successful()) {
                throw new \Exception($updateResponse->json()['message'] ?? 'Failed to update password');
            }

            // Clear session immediately after successful update
            auth()->logout();
            session()->flush();

            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil diubah!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Password update error:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

//    public function updateProfile(Request $request)
//    {
//        $request->validate([
//            'fullname' => 'required|string',
//            'address' => 'nullable|string',
//            'phoneNumber' => 'nullable|string'
//        ]);
//
//        try {
//            $token = session('user');
//
//            // Ambil email pengguna menggunakan AuthService
//            $userProfile = $this->authService->getUserProfile($token);
//            $userEmail = $userProfile['data']['email'];
//
//            // Dapatkan user ID dari Spring Boot melalui endpoint `/check-email`
//            $response = Http::withHeaders([
//                'Content-Type' => 'application/json',
//                'X-Api-Key' => $this->apiKey,
//                'Authorization' => "Bearer {$token}",
//            ])
//                ->get("{$this->baseUrl}/check-email", [
//                    'email' => $userEmail,
//                ]);
//
//            $checkEmailResponse = $response->json();
//            $userId = $checkEmailResponse['data']['id'] ?? $checkEmailResponse['data']['uuid'];
//
//
//            $updateResponse = Http::withHeaders([
//                'Content-Type' => 'application/json',
//                'X-Api-Key' => $this->apiKey,
//                'Authorization' => "Bearer {$token}",
//            ])->put("https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/users/profile/{$userId}", [
//                'username' => $userProfile['data']['username'],
//                'fullname' => $request->fullname,
//                'password' => null,
//                'address' => $request->address,
//                'phoneNumber' => $request->phoneNumber,
//            ]);
//
//            //             Debug semua langkah
//            //            dd([
//            //                'Step' => 'Complete Debug Information',
//            //                'Token' => $token,
//            //                'User Profile' => $userProfile,
//            //                'Email' => $userEmail,
//            //                'Check Email Response' => $checkEmailResponse,
//            //                'User ID' => $userId,
//            //                'Request Data' => $request->all(),
//            //                'Update Profile Response' => [
//            //                    'Status' => $updateResponse->status(),
//            //                    'Body' => $updateResponse->json(),
//            //                ]
//            //            ]);
//
//            if ($updateResponse->successful()) {
//                return redirect()
//                    ->back()
//                    ->with('success', 'Profile has been updated successfully');
//            } else {
//                throw new \Exception($updateResponse->json()['message'] ?? 'Failed to update profile');
//            }
//        } catch (\Exception $e) {
//            \Log::error('Profile update error:', ['error' => $e->getMessage()]);
//            return redirect()
//                ->back()
//                ->withErrors(['error' => $e->getMessage()]);
//        }
//    }

    public function updateProfile(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phoneNumber' => 'nullable|string|max:20',
            'imageUrl' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $token = session('user'); // Ambil token dari sesi
            $userProfile = $this->authService->getUserProfile($token);
            $userEmail = $userProfile['data']['email'];

            // Dapatkan userId dari endpoint check-email
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Api-Key' => 'secret',
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->baseUrl}/check-email", ['email' => $userEmail]);

            $checkEmailResponse = $response->json();
            if (!isset($checkEmailResponse['data']['id']) && !isset($checkEmailResponse['data']['uuid'])) {
                throw new \Exception('User ID not found in the response');
            }

            $userId = $checkEmailResponse['data']['id'] ?? $checkEmailResponse['data']['uuid'];

            // Siapkan body data untuk dikirim
            $bodyData = [
                'username' => $userProfile['data']['username'],
                'fullname' => $validatedData['fullname'],
                'address' => $validatedData['address'] ?? null,
                'phoneNumber' => $validatedData['phoneNumber'] ?? null,
            ];

            $file = null;

            // Jika ada file yang diupload
            if ($request->hasFile('imageUrl')) {
                $file = $request->file('imageUrl');
            }

            // Kirim request ke API Spring Boot
            $updateResponse = $this->sendUpdateProfileRequest($userId, $bodyData, $file, $token);
//            dd($updateResponse->body());  // Memeriksa body yang diterima

            if ($updateResponse->successful()) {
                return redirect()->back()->with('success', 'Profile updated successfully.');
            } else {
                $errorMessage = $updateResponse->json()['message'] ?? 'Failed to update profile';
                throw new \Exception($errorMessage);
            }
        } catch (\Exception $e) {
            \Log::error('Profile update error:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Kirim data ke API Spring Boot
     */
//    private function sendUpdateProfileRequest($userId, $bodyData, $file, $token)
//    {
//        $requestData = [
//            'body' => json_encode($bodyData),
//        ];
//        if ($file) {
//            // Jika ada file, gunakan attach
//            return Http::attach(
//                'file',
//                file_get_contents($file->getPathname()),
//                $file->getClientOriginalName()
//            )->withHeaders([
//                'X-Api-Key' => $this->apiKey,
//                'Authorization' => "Bearer {$token}",
//            ])->put("http://virtual-realm-b8a13cc57b6c.herokuapp.com/api/users/profile/{$userId}", $requestData);
//        }
//
//        // Jika tidak ada file, hanya kirim data JSON
//        return Http::withHeaders([
//            'X-Api-Key' => $this->apiKey,
//            'Authorization' => "Bearer {$token}",
//        ])->put("http://virtual-realm-b8a13cc57b6c.herokuapp.com/api/users/profile/{$userId}", $requestData);
//    }


    private function sendUpdateProfileRequest($userId, $bodyData, $file, $token)
    {
        if ($file) {
            return Http::withHeaders([
                'X-Api-Key' => $this->apiKey,
                'Authorization' => "Bearer {$token}",
            ])->attach(
                'file',
                file_get_contents($file->getPathname()),
                $file->getClientOriginalName()
            )->attach(
                'body',
                json_encode($bodyData)
            )->put("http://virtual-realm-b8a13cc57b6c.herokuapp.com/api/users/profile/{$userId}");
        }

        return Http::withHeaders([
            'X-Api-Key' => $this->apiKey,
            'Authorization' => "Bearer {$token}",
        ])->attach(
            'body',
            json_encode($bodyData)
        )->put("http://virtual-realm-b8a13cc57b6c.herokuapp.com/api/users/profile/{$userId}");
    }




    public function showProfileForm()
    {
        try {
            $token = session('user');
            $response = $this->authService->getUserProfile($token);

            return view('profile-users.profile', [
                'userData' => $response['data'],

                'username' => $response['data']['username']
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in showProfileForm:', [
                'error' => $e->getMessage()
            ]);
            return redirect()->route('login')
                ->withErrors(['error' => 'Please login to continue']);
        }
    }




    public function showOrderHistory()
    {
        try {
            $token = session('user');
            $response = $this->authService->getUserProfile($token);

            return view('profile-users.history-order', [
                'userData' => $response['data'],
                'username' => $response['data']['username']
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in showOrderHistory:', [
                'error' => $e->getMessage()
            ]);
            return redirect()->route('login')
                ->withErrors(['error' => 'Please login to continue']);
        }
    }
}
