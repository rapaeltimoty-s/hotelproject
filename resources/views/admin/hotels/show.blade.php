@extends('layouts.app')
@section('title', $hotel->name.' — Detail Hotel')

@section('content')
<div class="container py-4">
  <div class="row g-3">
    <div class="col-lg-8">
      @php
        $img = $hotel->cover_url ?? $hotel->cover_path ? ( $hotel->cover_url ?: asset('storage/'.$hotel->cover_path) ) : 'https://picsum.photos/seed/h'.$hotel->id.'/1200/600';
      @endphp
      <div class="card card-soft mb-3">
        <img class="img-fluid w-100 rounded-top-4" style="height:320px;object-fit:cover" src="{{ $img }}" alt="{{ $hotel->name }}">
        <div class="card-body">
          <h1 class="h4 fw-bold mb-1">{{ $hotel->name }}</h1>
          <div class="d-flex align-items-center gap-2 text-muted-ink">
            <span><i class="bi bi-geo"></i> {{ $hotel->city }}</span>
            <span>•</span>
            <span class="stars">
              @for($i=0;$i<$hotel->stars;$i++) ★ @endfor
            </span>
          </div>
          <hr>
          <p class="mb-0">{{ $hotel->description }}</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card card-soft sticky-cta">
        <div class="card-body">
          <div class="small text-muted-ink mb-1">Kisaran harga</div>
          @if($minPrice)
            <div class="h5 fw-bold text-primary">Rp {{ number_format($minPrice,0,',','.') }} <span class="small text-muted-ink">/ malam</span></div>
            @if($maxPrice && $maxPrice > $minPrice)
              <div class="small text-muted-ink">Hingga Rp {{ number_format($maxPrice,0,',','.') }}</div>
            @endif
          @else
            <div class="text-muted-ink small">Harga belum tersedia</div>
          @endif
          <hr>
          <a class="btn btn-brand btn-pill w-100" href="{{ route('rooms.index',$hotel->id) }}"><i class="bi bi-door-open"></i> Lihat Kamar</a>
          <a class="btn btn-outline-brand btn-pill w-100 mt-2" href="{{ route('hotels.index') }}"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
