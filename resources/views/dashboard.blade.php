<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-1">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-muted mb-0">Selamat datang di panel HotelApp</p>
            </div>
            <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                <i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name }}
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card card-hover border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                        <i class="bi bi-building text-primary fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="card-title text-muted mb-1">Total Hotel</h5>
                                    <h3 class="fw-bold text-dark mb-0">24</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-hover border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                        <i class="bi bi-calendar-check text-success fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="card-title text-muted mb-1">Booking Aktif</h5>
                                    <h3 class="fw-bold text-dark mb-0">8</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-hover border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                        <i class="bi bi-star text-warning fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="card-title text-muted mb-1">Rating Rata-rata</h5>
                                    <h3 class="fw-bold text-dark mb-0">4.8</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-hover border-0 shadow-sm rounded-3 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                        <i class="bi bi-graph-up text-info fs-4"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="card-title text-muted mb-1">Pendapatan</h5>
                                    <h3 class="fw-bold text-dark mb-0">Rp 12.5Jt</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="card-title mb-0">Aksi Cepat</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <a href="{{ route('hotels.index') }}" class="card card-hover border-0 bg-light h-100 text-decoration-none">
                                        <div class="card-body text-center p-4">
                                            <div class="bg-primary bg-opacity-10 p-3 rounded-3 d-inline-block mb-3">
                                                <i class="bi bi-search text-primary fs-2"></i>
                                            </div>
                                            <h6 class="fw-semibold text-dark">Cari Hotel</h6>
                                            <p class="text-muted small mb-0">Temukan hotel terbaik</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('bookings.index') }}" class="card card-hover border-0 bg-light h-100 text-decoration-none">
                                        <div class="card-body text-center p-4">
                                            <div class="bg-success bg-opacity-10 p-3 rounded-3 d-inline-block mb-3">
                                                <i class="bi bi-journal-check text-success fs-2"></i>
                                            </div>
                                            <h6 class="fw-semibold text-dark">Booking Saya</h6>
                                            <p class="text-muted small mb-0">Lihat riwayat pemesanan</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="card-title mb-0">Status Akun</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-2">
                                        <i class="bi bi-shield-check text-primary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-semibold mb-1">Verifikasi Email</h6>
                                    <p class="text-success mb-0 small">Terverifikasi</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="bg-warning bg-opacity-10 p-2 rounded-2">
                                        <i class="bi bi-coin text-warning"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fw-semibold mb-1">Points Reward</h6>
                                    <p class="text-dark mb-0 small">1,250 Points</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        }
        .bg-opacity-10 {
            background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
        }
    </style>
</x-app-layout>