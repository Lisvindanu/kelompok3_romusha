<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthService
{
    protected $baseUrl;
    protected $httpOptions;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('api_key', 'secret');
        $this->baseUrl = env('spring_api_url_auth', 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/auth');
        $this->httpOptions = [
            'verify' => false,
            'timeout' => 120,
            'connect_timeout' => 120,
        ];
    }

    public function register(array $data)
    {
        try {
            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Api-Key' => $this->apiKey,
                ])
                ->post("{$this->baseUrl}/register", $data);

            Log::info('AuthService Register Response:', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception("Registration failed: " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('AuthService Register Exception:', ['message' => $e->getMessage()]);
            throw new \Exception("Error occurred during registration: " . $e->getMessage());
        }
    }

    public function login($email, $password)
    {
        $payload = [
            'email' => $email,
            'password' => $password,
            'isGoogle' => false,
        ];

        try {
            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Api-Key' => $this->apiKey,
                ])
                ->post("{$this->baseUrl}/login", $payload);

            if ($response->successful()) {
                $responseData = $response->json();
                Log::info('Login API Response:', $responseData);

                return [
                    'token' => $responseData['data']['token'],
                    'role' => $responseData['data']['role'] ?? 'USER',
                ];
            } else {
                throw new \Exception($response->body());
            }
        } catch (\Exception $e) {
            throw new \Exception("Login failed: " . $e->getMessage());
        }
    }


    public function sendOtp($email)
    {
        $response = Http::withOptions($this->httpOptions)
            ->post("{$this->baseUrl}/send-otp", [
                'email' => $email,
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception($response->body());
    }

    public function logoutToken($token)
    {
        try {
            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Api-Key' => $this->apiKey,
                    'Authorization' => "Bearer {$token}",
                ])
                ->post("{$this->baseUrl}/logout", []);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception("Failed to log out: " . $response->body());
            }
        } catch (\Exception $e) {
            throw new \Exception("Logout failed: " . $e->getMessage());
        }
    }





    public function requestPasswordReset($email)
    {
        try {
            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'X-Api-Key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post("{$this->baseUrl}/request-reset", [
                    'email' => $email,
                ]);

            if ($response->successful()) {
                return $response->json();

                throw new \Exception($response->body());
            } else {
                throw new \Exception("Failed to request password reset: " . $response->body());
            }
        } catch (\Exception $e) {
            throw new \Exception("Error: " . $e->getMessage());
        }
    }


    public function resetPassword($token, $newPassword)
    {
        try {
            // Melakukan request ke API atau memproses reset password
            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'X-Api-Key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->baseUrl}/reset-password", [
                    'token' => $token,
                    'newPassword' => $newPassword,
                ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception("Failed to reset password: " . $response->body());
            }
        } catch (\Exception $e) {
            throw new \Exception("Error: " . $e->getMessage()); // Menangani exception dan mengembalikan pesan error
        }
    }


    public function logout($token)
    {
        $response = Http::withOptions($this->httpOptions)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'X-Api-Key' => $this->apiKey,
            ])
            ->post("{$this->baseUrl}/logout");

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception("Logout failed: " . $response->body());
        }
    }


    public function updatePassword($userId, $currentPassword, $newPassword, $confirmPassword)
    {
        try {
            \Log::info('Sending password update request:', [
                'userId' => $userId
            ]);

            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Api-Key' => $this->apiKey,
                ])
                ->post("{$this->baseUrl}/users/{$userId}/change-password", [
                    'currentPassword' => $currentPassword,
                    'newPassword' => $newPassword,
                    'confirmPassword' => $confirmPassword
                ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                \Log::error('Password update failed:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                throw new \Exception($response->json()['message'] ?? 'Failed to update password');
            }
        } catch (\Exception $e) {
            \Log::error('Password update error:', ['error' => $e->getMessage()]);
            throw new \Exception($e->getMessage());
        }
    }

    public function getUserProfile($token)
    {
        try {
            \Log::info('Get User Profile Request:', [
                'token' => $token
            ]);

            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'X-Api-Key' => $this->apiKey,
                ])
                ->get("{$this->baseUrl}/user");

            \Log::info('Get User Profile Response:', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception($response->body());
            }
        } catch (\Exception $e) {
            \Log::error('Get User Profile Error:', ['error' => $e->getMessage()]);
            throw new \Exception("Failed to get user profile: " . $e->getMessage());
        }
    }

    public function getUserIdFromToken($token)
    {
        try {
            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'X-Api-Key' => $this->apiKey,
                ])
                ->get("{$this->baseUrl}/user");

            // Tambahkan logging untuk debug
            \Log::info('Get User ID Response:', [
                'response' => $response->json()
            ]);

            if ($response->successful()) {
                return $response->json()['data']['id'] ?? null;
            }
            return null;
        } catch (\Exception $e) {
            \Log::error('Error getting user ID:', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function getNumericIdByEmail($email)
    {
        try {
            // Add debug logging
            \Log::info('Attempting to get numeric ID for email:', ['email' => $email]);

            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Api-Key' => $this->apiKey,
                ])
                ->get("{$this->baseUrl}/check-email", [
                    'email' => $email
                ]);

            // Log the response for debugging
            \Log::info('Check email response:', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['data']['id'])) {
                    return $data['data']['id'];
                } else {
                    \Log::error('ID not found in response:', $data);
                    throw new \Exception('User ID not found in response');
                }
            }

            throw new \Exception('Failed to get user ID: ' . $response->body());
        } catch (\Exception $e) {
            \Log::error('Error getting numeric ID:', [
                'error' => $e->getMessage(),
                'email' => $email
            ]);
            throw new \Exception('Failed to retrieve user ID: ' . $e->getMessage());
        }
    }

    public function updateProfile($userId, $formData, $token)
    {
        try {
            \Log::info('Updating profile for user:', [
                'userId' => $userId,
                'formData' => $formData
            ]);

            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'X-Api-Key' => $this->apiKey,
                    'Authorization' => "Bearer {$token}",
                ])->put("{$this->baseUrl}/users/profile/{$userId}", $formData);

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception($response->body());
        } catch (\Exception $e) {
            \Log::error('Profile update error:', ['error' => $e->getMessage()]);
            throw new \Exception("Failed to update profile: " . $e->getMessage());
        }
    }
}
