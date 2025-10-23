@extends('layouts.app')
@section('title','HotelApp — Temukan Hotel Terbaik, Harga Transparan, Booking Kilat')

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden">
    <div class="container py-5">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6 text-white">
                <div class="floating-badge d-inline-flex align-items-center gap-2 mb-4">
                    <div class="pulse-dot"></div>
                    <span><i class="bi bi-stars me-1"></i>Rilis UI Baru — lebih mulus & cepat</span>
                </div>
                <h1 class="display-4 fw-bold mb-4">Liburan Dimulai Dari <span class="text-warning">Pencarian</span> Yang Tepat</h1>
                <p class="lead mb-4 opacity-75">Kurasi hotel berkualitas, harga jujur, proses instan. Tinggal pilih tanggal—sisanya biar kami yang bereskan.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a class="btn btn-light btn-lg rounded-pill px-4" href="{{ route('hotels.index') }}">
                        <i class="bi bi-search me-2"></i>Cari Hotel
                    </a>
                    <a class="btn btn-outline-light btn-lg rounded-pill px-4" href="#destinasi">
                        Lihat Destinasi
                    </a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <div class="hero-image-container position-relative">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1200" 
                         class="img-fluid rounded-4 shadow-lg" 
                         alt="Luxury Hotel"
                         style="height: 500px; object-fit: cover;">
                    <div class="floating-cards">
                        <div class="floating-card card-1">
                            <i class="bi bi-shield-check text-success"></i>
                            <span>100% Terpercaya</span>
                        </div>
                        <div class="floating-card card-2">
                            <i class="bi bi-lightning-charge text-warning"></i>
                            <span>Super Cepat</span>
                        </div>
                        <div class="floating-card card-3">
                            <i class="bi bi-award text-primary"></i>
                            <span>Kurasi Terbaik</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
        </svg>
    </div>
</section>

<!-- Search Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-3">
                    <div class="card-body p-4">
                        <h4 class="text-center mb-4 fw-bold">Temukan Hotel Impian Anda</h4>
                        <form method="GET" action="{{ route('hotels.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Lokasi</label>
                                <input type="text" class="form-control form-control-lg rounded-pill" name="q" placeholder="Kota atau nama hotel...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Rating Bintang</label>
                                <select class="form-select form-select-lg rounded-pill" name="stars">
                                    <option value="">Semua Rating</option>
                                    <option value="5">★★★★★ Bintang 5</option>
                                    <option value="4">★★★★ Bintang 4</option>
                                    <option value="3">★★★ Bintang 3</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Urutkan</label>
                                <select class="form-select form-select-lg rounded-pill" name="sort">
                                    <option value="">Rekomendasi</option>
                                    <option value="price_asc">Harga Termurah</option>
                                    <option value="stars_desc">Rating Tertinggi</option>
                                    <option value="name_asc">Nama A-Z</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button class="btn btn-primary btn-lg rounded-pill w-100">
                                    <i class="bi bi-search me-2"></i>Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Destinations Section -->
<section id="destinasi" class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="h3 fw-bold text-dark mb-2">Destinasi Populer</h2>
                        <p class="text-muted mb-0">Temukan keindahan destinasi favorit di Indonesia</p>
                    </div>
                    <a href="{{ route('hotels.index') }}" class="btn btn-outline-primary btn-pill">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            @php
                $destinations = [
                    ['city' => 'Bali', 'img' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=1200', 'hotels' => '245+ Hotel'],
                    ['city' => 'Jakarta', 'img' => 'https://images.unsplash.com/photo-1542051841857-5f90071e7989?q=80&w=1200', 'hotels' => '189+ Hotel'],
                    ['city' => 'Yogyakarta', 'img' => 'https://images.unsplash.com/photo-1589308078050-9721a45a49d3?q=80&w=1200', 'hotels' => '156+ Hotel'],
                    ['city' => 'Bandung', 'img' => 'https://images.unsplash.com/photo-1613985540643-6f6f9a3db3df?q=80&w=1200', 'hotels' => '134+ Hotel'],
                ];
            @endphp
            
            @foreach($destinations as $destination)
            <div class="col-md-6 col-lg-3">
                <div class="destination-card card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="destination-image position-relative">
                        <img src="{{ $destination['img'] }}" class="card-img-top" alt="{{ $destination['city'] }}" style="height: 200px; object-fit: cover;">
                        <div class="destination-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end">
                            <div class="p-3 w-100 text-white">
                                <h5 class="fw-bold mb-1">{{ $destination['city'] }}</h5>
                                <p class="mb-0 opacity-75">{{ $destination['hotels'] }}</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('hotels.index',['q'=>$destination['city']]) }}" class="stretched-link"></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1551776235-dde6d4829808?q=80&w=1200" 
                     class="img-fluid rounded-3 shadow" 
                     alt="Hotel Facilities"
                     style="height: 400px; object-fit: cover;">
            </div>
            <div class="col-lg-6 ps-lg-5">
                <h2 class="h3 fw-bold text-dark mb-4">Mengapa Memilih HotelApp?</h2>
                <div class="features-list">
                    <div class="feature-item d-flex align-items-start mb-4">
                        <div class="feature-icon flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3 me-4">
                            <i class="bi bi-cash-coin text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-semibold text-dark mb-2">Harga Transparan</h5>
                            <p class="text-muted mb-0">Tidak ada biaya tersembunyi. Semua harga sudah termasuk pajak dan biaya layanan.</p>
                        </div>
                    </div>
                    <div class="feature-item d-flex align-items-start mb-4">
                        <div class="feature-icon flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3 me-4">
                            <i class="bi bi-star text-success fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-semibold text-dark mb-2">Kurasi Berkualitas</h5>
                            <p class="text-muted mb-0">Hotel dengan rating tinggi dan fasilitas terjamin untuk kenyamanan Anda.</p>
                        </div>
                    </div>
                    <div class="feature-item d-flex align-items-start">
                        <div class="feature-icon flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3 me-4">
                            <i class="bi bi-lightning text-warning fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-semibold text-dark mb-2">Konfirmasi Instan</h5>
                            <p class="text-muted mb-0">Pembayaran fleksibel dengan konfirmasi booking dalam hitungan menit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col text-center">
                <h2 class="h3 fw-bold text-dark mb-3">Apa Kata Tamu Kami?</h2>
                <p class="text-muted">Dengarkan pengalaman langsung dari pelanggan setia HotelApp</p>
            </div>
        </div>
        
        <div class="row g-4">
            @php
                $testimonials = [
                    ['name' => 'Dewi Santoso', 'text' => 'Proses cepat, kamar sesuai foto. Worth it banget! Pelayanan sangat memuaskan.', 'rate' => 5, 'avatar' => 'D'],
                    ['name' => 'Irfan Maulana', 'text' => 'UI-nya sangat user friendly, pencarian hotel jadi sangat mudah dan cepat.', 'rate' => 5, 'avatar' => 'I'],
                    ['name' => 'Rika Andini', 'text' => 'Harga kompetitif tanpa biaya tambahan. Pengalaman booking yang menyenangkan!', 'rate' => 4, 'avatar' => 'R'],
                ];
            @endphp
            
            @foreach($testimonials as $testimonial)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <span class="fw-bold">{{ $testimonial['avatar'] }}</span>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark mb-1">{{ $testimonial['name'] }}</h6>
                                <div class="stars text-warning">
                                    @for($i=0;$i<$testimonial['rate'];$i++)<i class="bi bi-star-fill"></i>@endfor
                                    @for($i=$testimonial['rate'];$i<5;$i++)<i class="bi bi-star"></i>@endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-muted mb-0">"{{ $testimonial['text'] }}"</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0;
    position: relative;
}

.min-vh-75 {
    min-height: 75vh;
}

.floating-badge {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 8px 16px;
    border-radius: 50px;
    font-weight: 500;
}

.pulse-dot {
    width: 8px;
    height: 8px;
    background: #ffd700;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(0.95); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.7; }
    100% { transform: scale(0.95); opacity: 1; }
}

.hero-image-container {
    position: relative;
}

.floating-cards {
    position: absolute;
    top: 50%;
    right: -20px;
    transform: translateY(-50%);
}

.floating-card {
    background: white;
    padding: 12px 16px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    animation: float 3s ease-in-out infinite;
}

.floating-card.card-1 { animation-delay: 0s; }
.floating-card.card-2 { animation-delay: 1s; }
.floating-card.card-3 { animation-delay: 2s; }

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.hero-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
}

.hero-wave svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 80px;
}

.hero-wave .shape-fill {
    fill: #FFFFFF;
}

.destination-card {
    transition: transform 0.3s ease;
}

.destination-card:hover {
    transform: translateY(-5px);
}

.destination-overlay {
    background: linear-gradient(transparent 40%, rgba(0,0,0,0.7) 100%);
}

.feature-icon {
    transition: transform 0.3s ease;
}

.feature-item:hover .feature-icon {
    transform: scale(1.1);
}

.avatar {
    font-size: 1.2em;
}
</style>
@endsection