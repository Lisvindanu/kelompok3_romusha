<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckUser
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('user')) {
            try {
                $token = session('user');
                $response = Http::withToken($token)
                    ->withHeaders([
                        'X-Api-Key' => 'secret', // Tambahkan API Key
                    ])
                    ->get('https://virtual-realm-b8a13cc57b6c.herokuapp.com/api/auth/user'); // Ubah endpoint


                if ($response->successful()) {
                    $userData = $response->json()['data'];
                    view()->share('user', $userData);
                } else {
                    session()->forget('user');
                    return redirect('/login');
                }
            } catch (\Exception $e) {
                session()->forget('user');
                return redirect('/login')->withErrors(['error' => 'Error verifying user: ' . $e->getMessage()]);
            }
        }

        return $next($request);
    }



}

