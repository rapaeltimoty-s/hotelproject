@extends('layouts.app')
@section('title','Daftar')

@section('content')
<div class="max-w-md mx-auto mt-12">
  <div class="bg-white rounded-2xl shadow p-6">
    <h1 class="text-2xl font-bold mb-1">Buat Akun</h1>
    <p class="text-gray-500 mb-6">Mulai pesan hotel favoritmu ✨</p>

    @if ($errors->any())
      <div class="mb-4 rounded-lg bg-rose-50 text-rose-700 px-3 py-2">
        <ul class="list-disc list-inside text-sm">
          @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium">Nama</label>
        <input name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
      </div>
      <div>
        <label class="block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
      </div>
      <div>
        <label class="block text-sm font-medium">Password</label>
        <input type="password" name="password" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
      </div>
      <div>
        <label class="block text-sm font-medium">Ulangi Password</label>
        <input type="password" name="password_confirmation" required class="mt-1 w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
      </div>
      <button class="w-full rounded-lg bg-indigo-600 text-white py-2.5 hover:bg-indigo-700">Daftar</button>
    </form>

    <p class="mt-6 text-sm text-gray-600">Sudah punya akun?
      <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a>
    </p>
  </div>
</div>
@endsection
