<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('SPRING_API_URL', 'http://localhost:8080/api/auth');
    }

    public function login($email, $password, $otp = null)
    {
        $payload = [
            'email' => $email,
            'password' => $password,
        ];

        if ($otp) {
            $payload['otp'] = $otp;
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Api-Key' => env('API_KEY')
            ])->post("{$this->baseUrl}/login", $payload);

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
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Api-Key' => env('API_KEY')
        ])->post("{$this->baseUrl}/register", $data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception($response->body());
    }

    public function sendOtp($email)
    {
        $response = Http::post("{$this->baseUrl}/send-otp", [
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
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Api-Key' => env('API_KEY'),
                'Authorization' => "Bearer {$token}"
            ])->post("{$this->baseUrl}/logout", [
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception("Failed to log out: " . $response->body());
            }
        } catch (\Exception $e) {
            throw new \Exception("Logout failed: " . $e->getMessage());
        }
    }
}
