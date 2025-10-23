@extends('layouts.app')
@section('title', $hotel->name . ' — ' . $hotel->city)

@section('content')
<div class="container py-4">
    <!-- Hotel Header -->
    <div class="row mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}" class="text-decoration-none">Hotel</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('hotels.index', ['city' => $hotel->city]) }}" class="text-decoration-none">{{ $hotel->city }}</a></li>
                    <li class="breadcrumb-item active">{{ $hotel->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Hero Image & Gallery -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="position-relative">
                    <img src="{{ $hotel->cover_url }}" class="card-img-top rounded-top-3" style="height: 400px; object-fit: cover;" alt="{{ $hotel->name }}">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-success bg-opacity-90 text-white px-3 py-2">
                            <i class="bi bi-star-fill me-1"></i>{{ $hotel->stars }} Bintang
                        </span>
                    </div>
                </div>
                
                @if(is_array($hotel->gallery) && count($hotel->gallery))
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Galeri Hotel</h6>
                    <div class="row g-2">
                        @foreach(array_slice($hotel->gallery, 0, 6) as $g)
                        <div class="col-4 col-md-2">
                            <img src="{{ Storage::url($g) }}" class="w-100 rounded-2" style="height: 80px; object-fit: cover; cursor: pointer;" 
                                 onclick="openImageModal('{{ Storage::url($g) }}')">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Hotel Details -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div>
                            <h1 class="h3 fw-bold text-dark mb-2">{{ $hotel->name }}</h1>
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i class="bi bi-geo-alt me-2"></i>
                                <span>{{ $hotel->address }}, {{ $hotel->city }}</span>
                            </div>
                            <div class="stars text-warning">
                                @for($i=0;$i<$hotel->stars;$i++)<i class="bi bi-star-fill"></i>@endfor
                                @for($i=$hotel->stars;$i<5;$i++)<i class="bi bi-star"></i>@endfor
                                <span class="text-muted ms-2">({{ $hotel->stars }} bintang)</span>
                            </div>
                        </div>
                    </div>

                    @if($hotel->description)
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-3">Deskripsi Hotel</h5>
                        <p class="text-muted mb-0">{{ $hotel->description }}</p>
                    </div>
                    @endif

                    <!-- Features -->
                    @if($hotel->features && count($hotel->features) > 0)
                    <div>
                        <h5 class="fw-semibold mb-3">Fasilitas Unggulan</h5>
                        <div class="row g-2">
                            @foreach(array_chunk($hotel->features, 2) as $chunk)
                            <div class="col-md-6">
                                @foreach($chunk as $feature)
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <span class="text-muted">{{ $feature }}</span>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Location Map (Placeholder) -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">Lokasi</h5>
                    <div class="bg-light rounded-3 p-4 text-center">
                        <i class="bi bi-map display-4 text-muted mb-3"></i>
                        <p class="text-muted mb-0">Peta lokasi untuk {{ $hotel->name }}, {{ $hotel->city }}</p>
                        <small class="text-muted">Fitur peta akan segera hadir</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Booking Card -->
            <div class="card border-0 shadow-lg rounded-3 sticky-top" style="top: 100px;">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="text-muted small">Harga mulai dari</div>
                        <div class="h2 fw-bold text-primary">Rp {{ number_format($hotel->base_price,0,',','.') }}</div>
                        <div class="text-muted small">per malam • termasuk pajak</div>
                    </div>

                    <a href="{{ route('rooms.index',$hotel->id) }}" class="btn btn-primary btn-lg rounded-pill w-100 mb-3">
                        <i class="bi bi-door-open me-2"></i>Lihat Kamar Tersedia
                    </a>

                    <div class="text-center">
                        <a href="{{ route('hotels.index',['city'=>$hotel->city]) }}" class="btn btn-outline-primary rounded-pill w-100">
                            <i class="bi bi-buildings me-2"></i>Hotel Lain di {{ $hotel->city }}
                        </a>
                    </div>

                    <hr class="my-4">

                    <!-- Quick Info -->
                    <div class="quick-info">
                        <div class="info-item d-flex align-items-center mb-3">
                            <div class="info-icon bg-primary bg-opacity-10 p-2 rounded-2 me-3">
                                <i class="bi bi-check-circle text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-semibold small">Konfirmasi Instan</div>
                                <div class="text-muted small">Booking langsung dikonfirmasi</div>
                            </div>
                        </div>
                        <div class="info-item d-flex align-items-center mb-3">
                            <div class="info-icon bg-success bg-opacity-10 p-2 rounded-2 me-3">
                                <i class="bi bi-credit-card text-success"></i>
                            </div>
                            <div>
                                <div class="fw-semibold small">Pembayaran Aman</div>
                                <div class="text-muted small">Multiple payment methods</div>
                            </div>
                        </div>
                        <div class="info-item d-flex align-items-center">
                            <div class="info-icon bg-warning bg-opacity-10 p-2 rounded-2 me-3">
                                <i class="bi bi-headset text-warning"></i>
                            </div>
                            <div>
                                <div class="fw-semibold small">Support 24/7</div>
                                <div class="text-muted small">Customer service siap membantu</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card border-0 shadow-sm rounded-3 mt-4">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-lightbulb text-warning me-2"></i>Tips Hemat
                    </h6>
                    <p class="text-muted small mb-0">
                        Booking di hari kerja (Senin-Kamis) biasanya lebih murah 10-20% dibanding akhir pekan. 
                        Pesan minimal 2 minggu sebelum check-in untuk mendapatkan harga terbaik.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid rounded-3" alt="">
            </div>
        </div>
    </div>
</div>

<script>
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>

<style>
.sticky-top {
    position: sticky;
    z-index: 1020;
}

.bg-opacity-90 {
    background-color: rgba(var(--bs-success-rgb), 0.9) !important;
}

.bg-opacity-10 {
    background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
}

.quick-info .info-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.rounded-top-3 {
    border-top-left-radius: 1rem !important;
    border-top-right-radius: 1rem !important;
}

.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
@endsection