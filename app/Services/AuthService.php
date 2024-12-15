<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class AuthService
{
    protected $baseUrl;
    protected $httpOptions;
    protected $apikey;

    public function __construct()
    {
        $this->apiKey = env('api_key', 'secret');
        $this->baseUrl = env('spring_api_url_auth', 'https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/auth');
        $this->httpOptions = [
            'verify' => false,
//            'verify' => 'C:\laragon\bin\php\php-8.3.12-Win32-vs16-x64\extras\ssl\cacert.pem',
        ];
    }


    public function login($email, $password)
    {
        $payload = [
            'email' => $email,
            'password' => $password,
        ];


        try {
            $response = Http::withOptions($this->httpOptions)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Api-Key' => $this->apiKey,
                ])
                ->post("{$this->baseUrl}/login", $payload);

            if ($response->successful()) {
                return $response->json();
            } else {
                $errorData = $response->json();
                $errorMessage = isset($errorData['message']) ? $errorData['message'] : $response->body();
                throw new \Exception("API Error: {$response->status()} - {$errorMessage}");
            }
        } catch (\Exception $e) {
            throw new \Exception("Login failed: " . $e->getMessage());
        }
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

            // Debug log untuk response
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


//    public function requestPasswordReset($email)
//    {
//        try {
//            $response = Http::withOptions($this->httpOptions)
//                ->withHeaders([
//                    'X-Api-Key' => $this->apiKey,,
//                    'Content-Type' => 'application/json',
//                    'Accept' => 'application/json',
//                ])
//                ->post("{$this->baseUrl}/request-reset", [
//                    'email' => $email,
//                ]);
//
//            if ($response->successful()) {
//                return $response->json();
//
//                throw new \Exception($response->body());
//            } else {
//                throw new \Exception("Failed to request password reset: " . $response->body());
//            }
//        } catch (\Exception $e) {
//            throw new \Exception("Error: " . $e->getMessage());
//        }
//    }
//
//
//    public function resetPassword($token, $newPassword)
//    {
//        try {
//            // Melakukan request ke API atau memproses reset password
//            $response = Http::withOptions($this->httpOptions)
//                ->withHeaders([
//                    'X-Api-Key' => $this->apiKey,,
//                    'Content-Type' => 'application/json',
//                ])
//                ->post("{$this->baseUrl}/reset-password", [
//                    'token' => $token,
//                    'newPassword' => $newPassword,
//                ]);
//
//            if ($response->successful()) {
//                return $response->json();
//            } else {
//                throw new \Exception("Failed to reset password: " . $response->body());
//            }
//        } catch (\Exception $e) {
//            throw new \Exception("Error: " . $e->getMessage()); // Menangani exception dan mengembalikan pesan error
//        }
//    }


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

}