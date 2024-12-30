<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleAccess
{
    public function handle(Request $request, Closure $next, $role)
    {
        $userRole = session('role', 'USER'); // Ambil role dari session

        if ($userRole !== $role) {
            return redirect('/unauthorized'); // Arahkan ke halaman unauthorized jika role tidak cocok
        }

        return $next($request);
    }


}
