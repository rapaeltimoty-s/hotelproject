@extends('layouts.app')
@section('title','Login')

@section('content')
<div class="max-w-md mx-auto mt-12">
  <div class="bg-white rounded-2xl shadow p-6">
    <h1 class="text-2xl font-bold mb-1">Masuk</h1>
    <p class="text-gray-500 mb-6">Selamat datang kembali 👋</p>

    @error('email')
      <div class="mb-4 rounded-lg bg-rose-50 text-rose-700 px-3 py-2">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
      </div>
      <div>
        <label class="block text-sm font-medium">Password</label>
        <input type="password" name="password" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
      </div>
      <label class="inline-flex items-center gap-2 text-sm">
        <input type="checkbox" name="remember" class="rounded border-gray-300"> Ingat saya
      </label>
      <button class="w-full rounded-lg bg-indigo-600 text-white py-2.5 hover:bg-indigo-700">Login</button>
    </form>

    <p class="mt-6 text-sm text-gray-600">Belum punya akun?
      <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar</a>
    </p>
  </div>
</div>
@endsection
