@extends('layouts.app')
@section('title','Kamar — ' . $hotel->name)

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="row align-items-center mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}" class="text-decoration-none">Hotel</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('hotels.show', $hotel->id) }}" class="text-decoration-none">{{ $hotel->name }}</a></li>
                    <li class="breadcrumb-item active">Kamar</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h3 fw-bold text-dark mb-1">{{ $hotel->name }}</h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-geo-alt me-1"></i>{{ $hotel->city }} • 
                        <span class="stars">
                            @for($i=0;$i<$hotel->stars;$i++)<i class="bi bi-star-fill text-warning"></i>@endfor
                            @for($i=$hotel->stars;$i<5;$i++)<i class="bi bi-star text-warning"></i>@endfor
                        </span>
                    </p>
                </div>
                <a class="btn btn-outline-primary btn-pill" href="{{ route('hotels.show',$hotel->id) }}">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Rooms Grid -->
    <div class="row g-4">
        @forelse($rooms as $r)
        <div class="col-lg-6">
            <div class="card card-hover border-0 shadow-sm rounded-3 h-100">
                <div class="row g-0 h-100">
                    <div class="col-md-5">
                        <div class="position-relative h-100">
                            <img src="{{ $r->photo_url }}" class="w-100 h-100 rounded-start" style="object-fit: cover;" alt="{{ $r->name }}">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-success bg-opacity-90 text-white px-2 py-1">
                                    <i class="bi bi-check-circle me-1"></i>Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body d-flex flex-column h-100 p-3">
                            <div class="flex-grow-1">
                                <h5 class="card-title fw-bold text-dark mb-2">{{ $r->name }}</h5>
                                <div class="d-flex align-items-center text-muted small mb-2">
                                    <i class="bi bi-people me-1"></i>
                                    <span>Kapasitas {{ $r->capacity }} orang</span>
                                </div>
                                <div class="d-flex align-items-center text-muted small mb-3">
                                    <i class="bi bi-grid-3x3 me-1"></i>
                                    <span>{{ $r->type }}</span>
                                </div>
                                
                                @if($r->facilities && count($r->facilities) > 0)
                                <div class="mb-3">
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach(array_slice($r->facilities, 0, 3) as $facility)
                                        <span class="badge bg-light text-dark border small">
                                            <i class="bi bi-check me-1"></i>{{ $facility }}
                                        </span>
                                        @endforeach
                                        @if(count($r->facilities) > 3)
                                        <span class="badge bg-light text-muted border small">
                                            +{{ count($r->facilities) - 3 }} lainnya
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <div class="border-top pt-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted small">Mulai dari</div>
                                        <div class="h4 fw-bold text-primary mb-0">Rp {{ number_format($r->price_per_night,0,',','.') }}</div>
                                        <div class="text-muted small">per malam</div>
                                    </div>
                                    <div>
                                        @auth
                                        <a class="btn btn-primary btn-pill px-3" href="{{ route('bookings.create',['room_id'=>$r->id]) }}">
                                            <i class="bi bi-calendar2-check me-1"></i>Pesan
                                        </a>
                                        @else
                                        <a class="btn btn-outline-primary btn-pill px-3" href="{{ route('login') }}">
                                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                                        </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body text-center py-5">
                    <div class="text-muted mb-3">
                        <i class="bi bi-door-closed display-4"></i>
                    </div>
                    <h4 class="text-dark mb-2">Belum Ada Kamar Tersedia</h4>
                    <p class="text-muted mb-4">Maaf, saat ini tidak ada kamar yang tersedia di hotel ini.</p>
                    <a href="{{ route('hotels.index') }}" class="btn btn-primary btn-pill">
                        <i class="bi bi-search me-1"></i>Cari Hotel Lain
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Additional Info -->
    @if($rooms->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 bg-light rounded-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="fw-bold text-dark mb-2">Butuh Bantuan Memilih Kamar?</h5>
                            <p class="text-muted mb-0">Hubungi customer service kami untuk konsultasi pemilihan kamar yang tepat untuk kebutuhan Anda.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="tel:+628123456789" class="btn btn-outline-primary btn-pill">
                                <i class="bi bi-telephone me-1"></i>Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.card-hover {
    transition: all 0.3s ease;
}
.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
.bg-opacity-90 {
    background-color: rgba(var(--bs-success-rgb), 0.9) !important;
}
.stars {
    font-size: 0.9em;
}
</style>
@endsection