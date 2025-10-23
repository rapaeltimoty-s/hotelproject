<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Admin • HotelApp')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body{background:#f7f8fa}
    .admin-shell{display:grid;grid-template-columns:260px 1fr;min-height:100vh}
    .admin-aside{background:#0d6efd; color:#fff}
    .admin-aside .brand{padding:16px 20px;font-weight:700;display:flex;gap:10px;align-items:center}
    .admin-aside .nav-link, .admin-aside a.link{display:block;color:#cfe2ff;padding:10px 18px;text-decoration:none;border-radius:10px;margin:4px 10px}
    .admin-aside .nav-link.active,.admin-aside a.link.active,.admin-aside a.link:hover{background:#0b5ed7;color:#fff}
    .card-soft{border:0;border-radius:16px;box-shadow:0 6px 24px rgba(10,25,41,.06)}
    .status-badge{padding:.35rem .6rem;border-radius:999px;font-size:.75rem;font-weight:600}
    .status-confirmed{background:#e8f7ef;color:#137a3a}
    .status-pending{background:#fff4e6;color:#a04900}
    .status-cancelled{background:#fdecea;color:#b42318}
    .btn-pill{border-radius:999px}
    .text-muted-ink{color:#6b7280}
  </style>
</head>
<body>
<div class="admin-shell">
  <aside class="admin-aside">
    <div class="brand"><i class="bi bi-speedometer2"></i> Admin Panel</div>
    <nav class="p-2">
      <a class="link {{ request()->routeIs('admin.dashboard')?'active':'' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a class="link {{ request()->routeIs('admin.hotels.*')?'active':'' }}" href="{{ route('admin.hotels.index') }}"><i class="bi bi-buildings"></i> Hotels</a>
      <a class="link {{ request()->routeIs('admin.rooms.*')?'active':'' }}" href="{{ route('admin.rooms.index') }}"><i class="bi bi-door-open"></i> Rooms</a>
      <a class="link {{ request()->routeIs('admin.bookings.*')?'active':'' }}" href="{{ route('admin.bookings.index') }}"><i class="bi bi-journal-check"></i> Bookings</a>
      <!-- ⬇️ Tambahkan ini -->
      <a class="link {{ request()->routeIs('admin.payments.*')?'active':'' }}" href="{{ route('admin.payments.index') }}"><i class="bi bi-credit-card"></i> Payments</a>
    </nav>
  </aside>
  <main class="p-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h1 class="h4 m-0">@yield('page_title','Dashboard')</h1>
      <form method="POST" action="{{ route('logout') }}">@csrf
        <button class="btn btn-outline-light text-dark btn-sm btn-pill"><i class="bi bi-box-arrow-right"></i> Logout</button>
      </form>
    </div>
    @yield('content')
  </main>
</div>
</body>
</html>
