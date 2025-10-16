@extends('layouts.app')
@section('title','HotelApp — Menginap Nyaman & Harga Jujur')

@section('content')
{{-- HERO --}}
<section class="hero-gradient text-white relative">
  <div class="absolute inset-0 opacity-[.18]" style="background: radial-gradient(900px 400px at 80% 0%, #fff, transparent 60%);"></div>
  <div class="container-max relative py-18 md:py-24">
    <div class="grid lg:grid-cols-2 gap-10 items-center">
      <div class="space-y-6">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-sm ring-1 ring-white/20">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 017 7c0 7-7 13-7 13S5 16 5 9a7 7 0 017-7Z"/></svg>
          120+ Kota • 2.000+ Properti
        </span>
        <h1 class="display text-4xl md:text-6xl font-extrabold leading-tight">
          Menginap Nyaman,<br class="hidden md:block"> Harga Jujur,<br class="hidden md:block"> Booking Kilat
        </h1>
        <p class="text-white/90 text-lg max-w-xl">Bandingkan harga, filter fasilitas, dan pesan tanpa biaya tersembunyi. Tampilan premium, proses super cepat.</p>

        {{-- SEARCH --}}
        <div id="cari" class="glass p-4 md:p-5 text-slate-800">
          <form action="{{ route('hotels.index') }}" method="GET" class="grid lg:grid-cols-12 gap-3">
            <div class="lg:col-span-5">
              <label class="block text-sm font-medium muted">Kota / Nama Hotel</label>
              <input name="q" class="input mt-1" placeholder="Jakarta • Bali • Bandung • Aston">
            </div>
            <div>
              <label class="block text-sm font-medium muted">Bintang</label>
              <select name="stars" class="select mt-1">
                <option value="">Semua</option>
                <option value="5">★★★★★</option>
                <option value="4">★★★★☆</option>
                <option value="3">★★★☆☆</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium muted">Harga Min (Rp)</label>
              <input type="number" name="min_price" class="input mt-1" placeholder="200000">
            </div>
            <div>
              <label class="block text-sm font-medium muted">Harga Max (Rp)</label>
              <input type="number" name="max_price" class="input mt-1" placeholder="2000000">
            </div>
            <div class="lg:col-span-2">
              <label class="block text-sm font-medium muted">Urutkan</label>
              <select name="sort" class="select mt-1">
                <option value="name_asc">Nama (A-Z)</option>
                <option value="price_asc">Harga termurah</option>
                <option value="stars_desc">Bintang tertinggi</option>
              </select>
            </div>
            <div class="lg:col-span-12 flex flex-wrap gap-2">
              <button class="btn-primary">Cari Hotel</button>
              @guest <a href="{{ route('register') }}" class="btn-soft">Daftar Gratis</a> @endguest
            </div>
          </form>
        </div>
      </div>

      <div class="hidden lg:block relative">
        <div class="rounded-[28px] overflow-hidden ring-1 ring-white/20 shadow-2xl animate-float">
          <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?q=80&w=1600&auto=format&fit=crop"
               class="h-[440px] w-full object-cover" alt="Hotel Hero">
        </div>
        <div class="absolute -bottom-6 -left-6 glass px-4 py-3 flex items-center gap-3">
          <div class="p-3 rounded-xl bg-emerald-100 text-emerald-700 ring-1 ring-black/5">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
          </div>
          <div>
            <div class="font-semibold">Harga Transparan</div>
            <div class="text-sm muted">Tanpa biaya tersembunyi</div>
          </div>
        </div>
      </div>
    </div>

    {{-- Stats --}}
    <div class="mt-10 grid sm:grid-cols-3 gap-4">
      <div class="glass px-5 py-4 text-slate-800">
        <div class="text-3xl font-extrabold">98%</div>
        <div class="text-sm muted">Tamu puas & mau balik lagi</div>
      </div>
      <div class="glass px-5 py-4 text-slate-800">
        <div class="text-3xl font-extrabold">4.9/5</div>
        <div class="text-sm muted">Rata-rata rating properti</div>
      </div>
      <div class="glass px-5 py-4 text-slate-800">
        <div class="text-3xl font-extrabold">30 detik</div>
        <div class="text-sm muted">Rata-rata waktu booking</div>
      </div>
    </div>
  </div>
</section>

{{-- Destinasi Populer --}}
<section class="py-12">
  <div class="container-max">
    <div class="flex items-end justify-between">
      <h2 class="text-2xl md:text-3xl font-extrabold">Destinasi Populer</h2>
      <a href="{{ route('hotels.index') }}" class="text-indigo-600 hover:text-indigo-700">Lihat semua →</a>
    </div>
    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
      @php
        $cities = [
          ['Jakarta','https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=800&auto=format&fit=crop'],
          ['Bandung','https://images.unsplash.com/photo-1548013146-72479768bada?q=80&w=800&auto=format&fit=crop'],
          ['Yogyakarta','https://images.unsplash.com/photo-1567371469510-2913f76b4b32?q=80&w=800&auto=format&fit=crop'],
          ['Bali','https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=800&auto=format&fit=crop'],
        ];
      @endphp
      @foreach($cities as [$name,$img])
        <a href="{{ route('hotels.index',['q'=>$name]) }}" class="group relative rounded-2xl overflow-hidden border border-black/5 shadow hover:shadow-lg transition">
          <img src="{{ $img }}" class="w-full h-40 object-cover group-hover:scale-105 transition" alt="{{ $name }}">
          <div class="absolute inset-0 bg-gradient-to-t from-black/55 to-transparent"></div>
          <div class="absolute bottom-3 left-4 text-white font-semibold text-lg">{{ $name }}</div>
        </a>
      @endforeach
    </div>
  </div>
</section>

{{-- Fasilitas Populer --}}
<section class="py-6">
  <div class="container-max">
    <h3 class="font-semibold mb-3">Fasilitas Populer</h3>
    <div class="flex flex-wrap gap-2">
      @foreach(['Kolam Renang','Sarapan','Parkir','Wifi Kencang','View Laut','Gym','Bathtub','Rooftop'] as $f)
        <span class="chip">{{ $f }}</span>
      @endforeach
    </div>
  </div>
</section>

{{-- Testimoni --}}
<section class="py-12 bg-white">
  <div class="container-max">
    <div class="text-center max-w-2xl mx-auto">
      <h2 class="text-2xl md:text-3xl font-extrabold">Apa kata tamu kami</h2>
      <p class="muted mt-2">Pengalaman nyata, hotel pilihan, liburan makin berkesan.</p>
    </div>
    <div class="mt-8 grid md:grid-cols-3 gap-6">
      @php
        $quotes = [
          ['Mega Pratiwi','Jakarta','“UI-nya cakep dan gampang dipakai. Proses booking literally kurang dari semenit.”','https://i.pravatar.cc/100?img=5'],
          ['Rafi Kurnia','Bandung','“Harga total langsung kelihatan. Nggak ada biaya tiba-tiba saat bayar.”','https://i.pravatar.cc/100?img=12'],
          ['Nadia Putri','Yogyakarta','“Filter kamar detail. Dapet bathtub & view sunrise ✨.”','https://i.pravatar.cc/100?img=32'],
        ];
      @endphp
      @foreach($quotes as [$name,$city,$q,$avatar])
        <article class="card p-6 hover:shadow-lg transition">
          <div class="flex items-center gap-3">
            <img src="{{ $avatar }}" class="h-10 w-10 rounded-full" alt="{{ $name }}">
            <div>
              <div class="font-semibold">{{ $name }}</div>
              <div class="text-xs muted">{{ $city }}</div>
            </div>
          </div>
          <p class="mt-4 text-slate-700">{{ $q }}</p>
          <div class="mt-3 text-yellow-400">★★★★★</div>
        </article>
      @endforeach
    </div>
  </div>
</section>

{{-- FAQ --}}
<section class="py-12">
  <div class="container-max">
    <div class="text-center max-w-2xl mx-auto">
      <h2 class="text-2xl md:text-3xl font-extrabold">Pertanyaan yang sering ditanya</h2>
      <p class="muted mt-2">Semua jawaban yang kamu butuhkan sebelum memesan.</p>
    </div>
    <div class="mt-8 grid md:grid-cols-2 gap-4">
      @php
        $faq = [
          ['Apakah ada biaya tersembunyi?', 'Tidak. Total harga sudah termasuk pajak/biaya layanan (jika ada) sebelum kamu membayar.'],
          ['Bagaimana jika jadwal berubah?', 'Hubungi hotel untuk penyesuaian. Jika kebijakan fleksibel, ubah tanggal tanpa biaya.'],
          ['Apakah aman memasukkan kartu?', 'Sangat aman. Kami menggunakan enkripsi dan mitra pembayaran tersertifikasi PCI-DSS.'],
          ['Bisa pesan untuk orang lain?', 'Bisa. Isi nama tamu pada catatan atau form tamu saat checkout.'],
        ];
      @endphp
      @foreach($faq as [$q,$a])
        <details class="card px-5 py-4">
          <summary class="cursor-pointer font-semibold">{{ $q }}</summary>
          <div class="mt-2 muted">{{ $a }}</div>
        </details>
      @endforeach
    </div>
  </div>
</section>
@endsection
