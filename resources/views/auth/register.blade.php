@extends('layouts.app')
@section('title','Daftar — HotelApp')
@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card card-soft">
        <div class="card-body p-4">
          <h1 class="h5 fw-bold mb-3">Buat akun HotelApp</h1>
          @if ($errors->any()) <div class="alert alert-danger rounded-4">{{ $errors->first() }}</div> @endif
          <form method="POST" action="{{ route('register.store') }}" class="d-grid gap-3">
            @csrf
            <div><label class="form-label">Nama</label><input class="form-control rounded-4" name="name" value="{{ old('name') }}" required></div>
            <div><label class="form-label">Email</label><input class="form-control rounded-4" type="email" name="email" value="{{ old('email') }}" required></div>
            <div><label class="form-label">Password</label><input class="form-control rounded-4" type="password" name="password" required></div>
            <div><label class="form-label">Konfirmasi Password</label><input class="form-control rounded-4" type="password" name="password_confirmation" required></div>
            <button class="btn btn-brand btn-pill w-100">Daftar</button>
          </form>
          <div class="text-center small text-muted mt-3">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
