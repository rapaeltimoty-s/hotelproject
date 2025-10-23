@extends('layouts.app')
@section('title','Cari Hotel — HotelApp')

@section('content')
<div class="container py-4">
  <div class="card card-soft mb-3">
    <div class="card-body">
      <form class="row g-2 g-md-3 align-items-end" method="GET">
        <div class="col-md-3">
          <label class="form-label">Kata kunci</label>
          <input class="form-control" name="q" value="{{ $q }}" placeholder="Nama hotel / alamat / kota">
        </div>
        <div class="col-md-3">
          <label class="form-label">Kota</label>
          <select class="form-select" name="city">
            <option value="">(Semua)</option>
            @foreach($cities as $c)
              <option value="{{ $c }}" @selected($city === $c)>{{ $c }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Bintang</label>
          <select class="form-select" name="stars">
            <option value="">(Semua)</option>
            <option value="5" @selected($stars==5)>5</option>
            <option value="4" @selected($stars==4)>4</option>
            <option value="3" @selected($stars==3)>3</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Urutkan</label>
          <select class="form-select" name="sort">
            <option value="">Terbaru</option>
            <option value="price_asc"  @selected($sort==='price_asc')>Harga termurah</option>
            <option value="price_desc" @selected($sort==='price_desc')>Harga termahal</option>
            <option value="rating"     @selected($sort==='rating')>Rating tertinggi</option>
            <option value="name"       @selected($sort==='name')>Nama (A-Z)</option>
          </select>
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-brand btn-pill"><i class="bi bi-search"></i> Terapkan</button>
        </div>
      </form>
    </div>
  </div>

  @if($hotels->count() === 0)
    <div class="alert alert-info rounded-4">Belum ada hasil. Coba ganti kata kunci/penyaring.</div>
  @endif

  <div class="row g-3">
    @foreach($hotels as $h)
      <div class="col-md-4">
        <div class="card card-soft card-lift h-100">
          @php
            $img = $h->cover_url ?? $h->cover_path ? ( $h->cover_url ?: asset('storage/'.$h->cover_path) ) : 'https://picsum.photos/seed/'.$h->id.'/600/360';
          @endphp
          <div class="card-media">
            <img src="{{ $img }}" alt="{{ $h->name }}" class="img-fluid w-100" style="height:180px;object-fit:cover;">
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <h5 class="mb-1">{{ $h->name }}</h5>
              <div class="stars">
                @for($i=0;$i<$h->stars;$i++) ★ @endfor
              </div>
            </div>
            <div class="small text-muted-ink mb-2"><i class="bi bi-geo"></i> {{ $h->city }}</div>
            <div class="fw-semibold text-primary">
              @if($h->min_price)
                Mulai Rp {{ number_format($h->min_price,0,',','.') }} <span class="small text-muted-ink">/ malam</span>
              @else
                <span class="text-muted-ink small">Harga belum tersedia</span>
              @endif
            </div>
          </div>
          <div class="card-footer bg-white border-0 d-flex gap-2">
            <a class="btn btn-outline-brand btn-pill w-100" href="{{ route('hotels.show',$h->id) }}"><i class="bi bi-info-circle"></i> Detail</a>
            <a class="btn btn-brand btn-pill w-100" href="{{ route('rooms.index',$h->id) }}"><i class="bi bi-door-open"></i> Lihat Kamar</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-3">
    {{ $hotels->links() }}
  </div>
</div>
@endsection
