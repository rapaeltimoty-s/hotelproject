@extends('layouts.app')
@section('title','Masuk — HotelApp')
@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card card-soft">
        <div class="card-body p-4">
          <h1 class="h5 fw-bold mb-3">Selamat datang kembali</h1>
          @if ($errors->any()) <div class="alert alert-danger rounded-4">{{ $errors->first() }}</div> @endif
          <form method="POST" action="{{ route('login.attempt') }}" class="d-grid gap-3">
            @csrf
            <div><label class="form-label">Email</label><input class="form-control rounded-4" type="email" name="email" value="{{ old('email') }}" required></div>
            <div><label class="form-label">Password</label><input class="form-control rounded-4" type="password" name="password" required></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="remember" id="remember"><label class="form-check-label" for="remember">Ingat saya</label></div>
            <button class="btn btn-brand btn-pill w-100">Masuk</button>
          </form>
          <div class="text-center small text-muted mt-3">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
