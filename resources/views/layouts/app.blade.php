<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','HotelApp — Booking Premium')</title>
  <meta name="description" content="Reservasi hotel premium dengan UI modern, harga transparan, dan proses super cepat.">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='22' fill='%234f46e5'/><text x='50' y='62' text-anchor='middle' font-family='Plus Jakarta Sans' font-size='58' fill='white'>H</text></svg>">
  @vite(['resources/js/app.js'])
</head>
<body>
  {{-- NAVBAR --}}
  <header class="sticky top-0 z-50 bg-white/85 backdrop-blur border-b border-black/5">
    <div class="container-max h-16 flex items-center justify-between">
      <a href="{{ route('home') }}" class="group flex items-center gap-2">
        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-white font-extrabold shadow">{{ config('app.name','H') [0] }}</span>
        <span class="font-semibold">HotelApp</span>
      </a>
      <nav class="hidden md:flex items-center gap-1">
        <a class="nav-link" href="{{ route('hotels.index') }}">Jelajahi</a>
        <a class="nav-link" href="{{ route('hotels.index',['stars'=>5]) }}">Bintang 5</a>
        <a class="nav-link" href="{{ route('hotels.index',['sort'=>'price_asc']) }}">Termurah</a>
      </nav>
      <div class="flex items-center gap-2">
        @auth
          <a class="btn-ghost" href="{{ route('bookings.index') }}">Booking Saya</a>
          @if(auth()->user()->role === 'admin')
            <a class="btn-soft" href="{{ route('admin.dashboard') }}">Admin</a>
          @endif
          <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
            <button class="btn-ghost text-rose-700 border-rose-100 hover:bg-rose-50">Logout</button>
          </form>
        @else
          <a class="btn-ghost" href="{{ route('login') }}">Login</a>
          <a class="btn-primary" href="{{ route('register') }}">Daftar</a>
        @endauth
      </div>
    </div>
  </header>

  {{-- FLASH --}}
  @if (session('status'))
    <div class="container-max mt-4">
      <div class="rounded-2xl bg-emerald-50 text-emerald-700 px-4 py-3 shadow">{{ session('status') }}</div>
    </div>
  @endif

  <main>@yield('content')</main>

  {{-- FOOTER --}}
  <footer class="mt-16">
    <div class="container-max">
      <div class="card p-6 md:p-8">
        <div class="grid md:grid-cols-3 gap-8">
          <div>
            <div class="font-semibold mb-2">HotelApp</div>
            <p class="muted">Reservasi hotel yang <span class="font-semibold text-slate-800">cepat</span>, <span class="font-semibold text-slate-800">mudah</span>, dan <span class="font-semibold text-slate-800">transparan</span>.</p>
          </div>
          <div>
            <div class="font-semibold mb-2">Jelajah</div>
            <ul class="space-y-2 muted">
              <li><a class="hover:text-slate-800" href="{{ route('hotels.index') }}">Cari Hotel</a></li>
              <li><a class="hover:text-slate-800" href="{{ route('hotels.index',['stars'=>5]) }}">Bintang 5</a></li>
              <li><a class="hover:text-slate-800" href="{{ route('hotels.index',['sort'=>'price_asc']) }}">Termurah</a></li>
            </ul>
          </div>
          <div>
            <div class="font-semibold mb-2">Langganan promo</div>
            <form class="flex gap-2">
              <input class="input" placeholder="Email kamu">
              <button type="button" class="btn-primary">Ikuti</button>
            </form>
            <p class="text-xs muted mt-2">Kabar flash sale tiap minggu.</p>
          </div>
        </div>
      </div>
      <div class="text-center text-xs muted py-6">© {{ date('Y') }} HotelApp. All rights reserved.</div>
    </div>
  </footer>
</body>
</html>
