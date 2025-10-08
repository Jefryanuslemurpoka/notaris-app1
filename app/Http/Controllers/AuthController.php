<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 🔹 Tampilkan form login
    public function showLogin()
    {
        return view('auth.login'); // gunakan auth/login.blade.php
    }

    // 🔹 Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'staff') {
                return redirect()->route('staff.dashboard');
            }

            // Jika role tidak dikenali
            Auth::logout();
            return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali.');
        }

        return redirect()->back()->with('error', 'Email atau Password salah!');
    }

    // 🔹 Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
