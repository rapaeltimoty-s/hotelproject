<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(){ return view('auth.login'); }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);
        $remember = (bool)$request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return (auth()->user()->role === 'admin')
                ? redirect()->route('admin.dashboard')->with('status','Selamat datang, Admin!')
                : redirect()->route('home')->with('status','Login berhasil.');
        }
        return back()->withErrors(['email'=>'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('status','Anda telah logout.');
    }
}
