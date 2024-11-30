<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            // Ambil data user dari Google
            $socialUser = Socialite::driver('google')->user();

            // Cari user berdasarkan google_id atau email
            $registeredUser = User::where('google_id', $socialUser->id)
                ->orWhere('email', $socialUser->email)
                ->first();

            if (!$registeredUser) {
                // Jika user belum terdaftar, buat user baru
                $user = User::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'password' => Hash::make(Str::random(16)), // Password acak
                    'google_id' => $socialUser->id,
                    'google_token' => $socialUser->token,
                    'google_refresh_token' => $socialUser->refreshToken,
                ]);

                Auth::login($user);
                return redirect('/dashboard');
            }

            // Login user jika sudah terdaftar
            Auth::login($registeredUser);
            return redirect('/dashboard');
            
        } catch (\Exception $e) {
            // Tangani error
            return redirect('/login')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
