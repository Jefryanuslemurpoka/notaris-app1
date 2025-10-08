<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // Jika belum login, redirect ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Jika sudah login tapi role tidak sesuai
        if (Auth::user()->role !== $role) {
            // Redirect ke dashboard sesuai role-nya
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'staff') {
                return redirect()->route('staff.dashboard');
            }

            // Jika role tidak dikenali
            Auth::logout();
            return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali.');
        }

        return $next($request);
    }
}
