@extends('layouts.app')
@section('title','HotelApp — Temukan Hotel Terbaik, Harga Transparan, Booking Kilat')

@section('content')
<section class="hero py-5">
  <div class="container py-4">
    <div class="row align-items-center">
      <div class="col-lg-7 text-white fade-in">
        <div class="float-chip d-inline-flex align-items-center gap-2 mb-3">
          <i class="bi bi-stars"></i> Rilis UI Baru — lebih mulus & cepat
        </div>
        <h1 class="display-5 fw-800 mb-3">Liburan dimulai dari <span class="text-warning">pencarian</span> yang tepat</h1>
        <p class="lead text-white-75 mb-4">Kurasi hotel berkualitas, harga jujur, proses instan. Tinggal pilih tanggal—sisanya biar kami yang bereskan.</p>
        <div class="d-flex gap-2">
          <a class="btn btn-light btn-pill" href="{{ route('hotels.index') }}"><i class="bi bi-search me-1"></i> Cari Hotel</a>
          <a class="btn btn-outline-light btn-pill" href="#destinasi">Lihat Destinasi</a>
        </div>
      </div>
      <div class="col-lg-5 mt-4 mt-lg-0 fade-in">
        <div class="glass p-3">
          <img class="w-100 rounded-4" src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1200" alt="Ilustrasi hotel modern" style="height:320px;object-fit:cover">
          <div class="p-3 text-white">
            <div class="d-flex flex-wrap align-items-center gap-3">
              <div class="float-chip"><i class="bi bi-shield-check"></i> 100% Terpercaya</div>
              <div class="float-chip"><i class="bi bi-lightning-charge-fill"></i> Super Cepat</div>
              <div class="float-chip"><i class="bi bi-award"></i> Kurasi Terbaik</div>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>
</section>

<section class="py-4">
  <div class="container">
    <div class="card card-soft p-3 p-md-4">
      <form method="GET" action="{{ route('hotels.index') }}" class="row g-2 g-md-3">
        <div class="col-md-4">
          <input class="form-control rounded-4" name="q" placeholder="Cari kota atau nama hotel (cth: Bali, Jakarta)" aria-label="Kata kunci hotel atau kota">
        </div>
        <div class="col-md-3">
          <select class="form-select rounded-4" name="stars" aria-label="Filter bintang hotel">
            <option value="">Semua bintang</option>
            <option value="5">★★★★★ Bintang 5</option>
            <option value="4">★★★★ Bintang 4</option>
            <option value="3">★★★ Bintang 3</option>
          </select>
        </div>
        <div class="col-md-3">
          <select class="form-select rounded-4" name="sort" aria-label="Urutkan">
            <option value="">Urutkan</option>
            <option value="price_asc">Harga termurah</option>
            <option value="rating">Rating tertinggi</option>
            <option value="name">Nama A–Z</option>
          </select>
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-brand btn-pill"><i class="bi bi-search me-1"></i> Jelajahi</button>
        </div>
      </form>
    </div>
  </div>
</section>

<section id="destinasi" class="py-5">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h2 class="h4 fw-bold mb-0">Destinasi Favorit</h2>
      <a href="{{ route('hotels.index') }}" class="text-decoration-none fw-semibold" style="color: var(--primary);">Lihat semua <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="row g-3">
      @php
        $dest = [
          ['city'=>'Bali','img'=>'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=1200','desc'=>'Deal terbaik minggu ini'],
          ['city'=>'Jakarta','img'=>'https://images.unsplash.com/photo-1542051841857-5f90071e7989?q=80&w=1200','desc'=>'Hotel bisnis terbaik'],
          ['city'=>'Yogyakarta','img'=>'https://images.unsplash.com/photo-1589308078050-9721a45a49d3?q=80&w=1200','desc'=>'Wisata budaya & kuliner'],
          ['city'=>'Bandung','img'=>'https://images.unsplash.com/photo-1613985540643-6f6f9a3db3df?q=80&w=1200','desc'=>'Hotel dengan pemandangan'],
        ];
      @endphp
      @foreach($dest as $d)
      <div class="col-6 col-md-3">
        <a class="card card-lift card-media text-decoration-none" href="{{ route('hotels.index',['q'=>$d['city']]) }}">
          <img src="{{ $d['img'] }}" class="w-100 rounded-top-4" style="height:160px;object-fit:cover" alt="Kota {{ $d['city'] }}">
          <div class="p-3">
            <div class="fw-semibold">{{ $d['city'] }}</div>
            <div class="small text-muted-ink">{{ $d['desc'] }}</div>
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section class="section-muted py-5">
  <div class="container">
    <div class="row g-4 align-items-center">
      <div class="col-lg-6">
        <img src="https://images.unsplash.com/photo-1551776235-dde6d4829808?q=80&w=1200" class="w-100 rounded-4" style="height:320px;object-fit:cover" alt="Fasilitas hotel pilihan">
      </div>
      <div class="col-lg-6">
        <h3 class="h4 fw-bold mb-3">Kenapa pilih HotelApp?</h3>
        <ul class="list-unstyled mt-3">
          <li class="d-flex align-items-start gap-2 mb-3">
            <i class="bi bi-check-circle-fill text-success mt-1"></i>
            <div>
              <span class="fw-semibold">Harga transparan</span>
              <p class="mb-0 text-muted">Tanpa biaya tersembunyi, semua sudah termasuk pajak & biaya layanan.</p>
            </div>
          </li>
          <li class="d-flex align-items-start gap-2 mb-3">
            <i class="bi bi-check-circle-fill text-success mt-1"></i>
            <div>
              <span class="fw-semibold">Kurasi berkualitas</span>
              <p class="mb-0 text-muted">Hotel dengan rating tinggi dan fasilitas terjamin.</p>
            </div>
          </li>
          <li class="d-flex align-items-start gap-2 mb-3">
            <i class="bi bi-check-circle-fill text-success mt-1"></i>
            <div>
              <span class="fw-semibold">Konfirmasi instan</span>
              <p class="mb-0 text-muted">Pembayaran fleksibel dengan konfirmasi booking dalam hitungan menit.</p>
            </div>
          </li>
        </ul>
        <a class="btn btn-brand btn-pill mt-2" href="{{ route('hotels.index') }}">Mulai cari hotel</a>
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <h2 class="h4 fw-bold mb-4">Apa kata tamu?</h2>
    <div class="row g-3">
      @php
        $reviews = [
          ['name'=>'Dewi','text'=>'Proses cepat, kamar sesuai foto. Worth it banget! Pelayanannya juga ramah dan profesional.','rate'=>5],
          ['name'=>'Irfan','text'=>'UI-nya enak dipakai, cari hotel jadi gampang. Filter dan pencariannya sangat membantu.','rate'=>5],
          ['name'=>'Rika','text'=>'Harga jujur, tanpa biaya aneh. Rekomendasi! Pengalaman booking yang menyenangkan.','rate'=>4],
        ];
      @endphp
      @foreach($reviews as $r)
      <div class="col-md-4">
        <div class="card card-soft h-100 card-lift">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <div class="fw-semibold">{{ $r['name'] }}</div>
              <div class="stars" aria-label="Rating {{ $r['rate'] }} dari 5">
                @for($i=0;$i<$r['rate'];$i++)<i class="bi bi-star-fill"></i>@endfor
                @for($i=$r['rate'];$i<5;$i++)<i class="bi bi-star"></i>@endfor
              </div>
            </div>
            <div class="text-muted">{{ $r['text'] }}</div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<style>
  /* Hero Section */
  .hero {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    position: relative;
    overflow: hidden;
  }
  
  .hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  }
  
  .float-chip {
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 500;
    backdrop-filter: blur(10px);
  }
  
  .glass {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: var(--border-radius);
    border: 1px solid rgba(255, 255, 255, 0.2);
  }
  
  .text-white-75 {
    color: rgba(255, 255, 255, 0.85);
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .display-5 {
      font-size: 2rem;
    }
    
    .hero {
      padding-top: 2rem;
      padding-bottom: 2rem;
    }
  }
</style>
@endsection
