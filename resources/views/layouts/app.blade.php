<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','HotelApp — Booking Hotel Premium')</title>
  <meta name="description" content="Reservasi hotel premium: UI modern, harga transparan, proses super cepat.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  {{-- [PAYMENT HOOK] Halaman pembayaran bisa push script di head (contoh: Midtrans Snap) --}}
  @stack('payment_head')

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1d4ed8;
      --primary-light: #dbeafe;
      --secondary: #64748b;
      --accent: #f59e0b;
      --success: #10b981;
      --light: #f8fafc;
      --dark: #1e293b;
      --border-radius: 12px;
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    body {
      font-family: 'Inter', sans-serif;
      color: var(--dark);
      background-color: #ffffff;
      line-height: 1.6;
    }
    
    h1, h2, h3, h4, h5, h6 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 700;
    }
    
    /* Header Styles */
    .header-blur {
      backdrop-filter: blur(10px);
      background-color: rgba(255, 255, 255, 0.9);
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .brand-badge {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      border-radius: 10px;
      font-weight: 800;
      font-size: 18px;
    }
    
    .nav-ink a {
      color: var(--secondary);
      text-decoration: none;
      font-weight: 500;
      padding: 8px 12px;
      border-radius: 8px;
      transition: all 0.2s ease;
    }
    
    .nav-ink a:hover, .nav-ink a.active {
      color: var(--primary);
      background-color: var(--primary-light);
    }
    
    .btn-pill {
      border-radius: 50px;
      padding: 8px 16px;
      font-weight: 500;
    }
    
    .btn-brand {
      background-color: var(--primary);
      border-color: var(--primary);
      color: white;
    }
    
    .btn-brand:hover {
      background-color: var(--primary-dark);
      border-color: var(--primary-dark);
      color: white;
    }
    
    .btn-outline-brand {
      border-color: var(--primary);
      color: var(--primary);
    }
    
    .btn-outline-brand:hover {
      background-color: var(--primary);
      border-color: var(--primary);
      color: white;
    }
    
    .btn-ghost {
      color: var(--secondary);
      background-color: transparent;
    }
    
    .btn-ghost:hover {
      background-color: rgba(0, 0, 0, 0.05);
      color: var(--dark);
    }
    
    /* Card Styles */
    .card-soft {
      background-color: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      border: none;
    }
    
    .card-lift {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card-lift:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
    }
    
    .card-media {
      overflow: hidden;
    }
    
    /* Section Styles */
    .section-muted {
      background-color: #f8fafc;
    }
    
    /* Form Styles */
    .form-control, .form-select {
      border-radius: var(--border-radius);
      padding: 12px 16px;
      border: 1px solid #e2e8f0;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    /* Footer */
    .footer-muted {
      color: var(--secondary);
      font-size: 0.875rem;
    }
    
    /* Stars */
    .stars {
      color: var(--accent);
    }
    
    /* Utilities */
    .rounded-top-4 {
      border-top-left-radius: var(--border-radius);
      border-top-right-radius: var(--border-radius);
    }
    
    .text-muted-ink {
      color: var(--secondary);
    }
    
    .fw-800 {
      font-weight: 800;
    }
    
    /* Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .fade-in {
      animation: fadeIn 0.5s ease forwards;
    }
  </style>
</head>
<body>
  <header class="header-blur sticky-top">
    <div class="container py-2">
      <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center gap-2">
          <span class="brand-badge">H</span>
          <span class="fw-semibold text-dark">HotelApp</span>
        </a>
        <nav class="d-none d-md-flex gap-3 nav-ink">
          <a href="{{ route('hotels.index') }}" class="{{ request()->routeIs('hotels.index')?'active':'' }}">Jelajahi</a>
          <a href="{{ route('hotels.index',['stars'=>5]) }}">Bintang 5</a>
          <a href="{{ route('hotels.index',['sort'=>'price_asc']) }}">Termurah</a>
        </nav>
        <div class="d-flex gap-2">
          @auth
            <a class="btn btn-ghost btn-pill" href="{{ route('bookings.index') }}"><i class="bi bi-journal-check me-1"></i> Booking Saya</a>
            @if(auth()->user()->role === 'admin')
              <a class="btn btn-outline-brand btn-pill" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i> Admin</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="d-inline">@csrf
              <button class="btn btn-outline-danger btn-pill"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
            </form>
          @else
            <a class="btn btn-ghost btn-pill" href="{{ route('login') }}">Login</a>
            <a class="btn btn-brand btn-pill" href="{{ route('register') }}">Daftar</a>
          @endauth
        </div>
      </div>
    </div>
  </header>

  {{-- [PAYMENT HOOK] Optional: progress bar/step khusus halaman pembayaran --}}
  @yield('payment_bar')

  {{-- Global payment alert (opsional): set via session(['payment_alert' => ['type'=>'success|danger|info', 'text'=>'...']]) --}}
  @if(session('payment_alert'))
    <div class="container mt-3">
      @php $pa = session('payment_alert'); @endphp
      <div class="alert alert-{{ $pa['type'] ?? 'info' }} mb-0 rounded-4 shadow-sm">
        {{ $pa['text'] ?? '' }}
      </div>
    </div>
  @endif

  @if(session('status'))
    <div class="container mt-3"><div class="alert alert-success mb-0 rounded-4 shadow-sm">{{ session('status') }}</div></div>
  @endif

  <main>@yield('content')</main>

  <footer class="mt-5">
    <div class="container">
      <div class="card card-soft rounded-4 p-4 p-md-5">
        <div class="row g-4">
          <div class="col-md-4">
            <div class="fw-semibold mb-2">HotelApp</div>
            <div class="footer-muted">Reservasi hotel <span class="fw-semibold text-dark">cepat</span>, <span class="fw-semibold text-dark">mudah</span>, dan <span class="fw-semibold text-dark">transparan</span>.</div>
          </div>
          <div class="col-md-4">
            <div class="fw-semibold mb-2">Jelajah</div>
            <ul class="list-unstyled footer-muted">
              <li><a class="link-secondary text-decoration-none" href="{{ route('hotels.index') }}">Cari Hotel</a></li>
              <li><a class="link-secondary text-decoration-none" href="{{ route('hotels.index',['stars'=>5]) }}">Bintang 5</a></li>
              <li><a class="link-secondary text-decoration-none" href="{{ route('hotels.index',['sort'=>'price_asc']) }}">Termurah</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <div class="fw-semibold mb-2">Langganan promo</div>
            <form class="d-flex gap-2">
              <input class="form-control rounded-pill" placeholder="Email kamu">
              <button class="btn btn-brand btn-pill" type="button">Ikuti</button>
            </form>
            <div class="footer-muted mt-2">Kabar flash sale tiap minggu.</div>
          </div>
        </div>
      </div>
      <div class="text-center footer-muted py-4">© {{ date('Y') }} HotelApp. All rights reserved.</div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- [PAYMENT HOOK] Halaman pembayaran bisa push script di footer (init Snap / mock handler) --}}
  @stack('payment_scripts')

  @stack('scripts')
</body>
</html>
