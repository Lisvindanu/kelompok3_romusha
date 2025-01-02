<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();

            $response = Http::withHeaders([
                'x-api-key' => 'secret',
                'Content-Type' => 'application/json',
            ])->post('https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/auth/google', [
                'googleId' => $socialUser->id,
                'email' => $socialUser->email,
                'name' => $socialUser->name,
                'picture' => $socialUser->avatar,
                'googleToken' => $socialUser->token,
                'googleRefreshToken' => $socialUser->refreshToken ?? null,
            ]);

            if (!$response->successful()) {
                return redirect('/login')
                    ->withErrors(['error' => 'Google login failed: ' . $response->body()]);
            }

            $data = $response->json();
            if (!isset($data['data']['token'])) {
                return redirect('/login')
                    ->withErrors(['error' => 'Invalid response from server']);
            }

            session(['user' => $data['data']['token']]);

            if (isset($data['data']['role'])) {
                session(['role' => $data['data']['role']]);
            }

            return redirect('/profile-users')
                ->with('status', 'Successfully logged in with Google');

        } catch (\Exception $e) {
            return redirect('/login')
                ->withErrors(['error' => 'Login failed: ' . $e->getMessage()]);
        }
    }
}
