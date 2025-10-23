<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegisterForm(){ return view('auth.register'); }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                  => ['required','string','max:255'],
            'email'                 => ['required','email','unique:users,email'],
            'password'              => ['required','min:6','confirmed'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'user',
        ]);

        auth()->login($user);
        return redirect()->route('home')->with('status','Pendaftaran berhasil. Selamat datang!');
    }
}
