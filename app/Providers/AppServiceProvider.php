<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View; // Tambahkan ini
use Illuminate\Support\Facades\Http; // Untuk HTTP Request
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


    public function boot()
    {
        View::composer('*', function ($view) {
            if (session()->has('user')) {
                $token = session('user');

                // Cek cache terlebih dahulu
                $userData = Cache::remember("user_data_$token", now()->addMinutes(10), function () use ($token) {
                    try {
                        $response = Http::withToken($token)
                            ->withHeaders([
                                'X-Api-Key' => 'secret',
                            ])
                            ->get('https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/auth/user');

                        if ($response->successful()) {
                            return $response->json()['data'];
                        } else {
                            session()->forget('user');
                            return null;
                        }
                    } catch (\Exception $e) {
                        session()->forget('user');
                        return null;
                    }
                });

                if ($userData) {
                    $view->with('user', $userData); // Bagikan data pengguna ke view
                }
            }
        });
    }
}

