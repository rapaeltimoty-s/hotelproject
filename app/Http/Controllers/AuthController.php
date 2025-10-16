<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $req)
    {
        $cred = $req->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        $remember = $req->boolean('remember');

        if (Auth::attempt($cred, $remember)) {
            $req->session()->regenerate();

            // arahkan sesuai role
            return auth()->user()->role === 'admin'
                ? redirect()->route('admin.dashboard')->with('status','Selamat datang, Admin!')
                : redirect()->route('home')->with('status','Login berhasil.');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect()->route('home')->with('status','Anda telah logout.');
    }
}
