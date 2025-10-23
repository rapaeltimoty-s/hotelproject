@extends('layouts.app')
@section('title','Checkout — HotelApp')

@section('content')
<div class="container py-4">
  <div class="row g-3">
    <div class="col-lg-8">
      <div class="card card-soft">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h1 class="h5 fw-bold mb-0">Ringkasan Pemesanan</h1>
            <span class="badge-soft"><i class="bi bi-clock-history"></i> Bayar sebelum: {{ $booking->payment_deadline?->format('d M Y H:i') }}</span>
          </div>
          <div class="small text-muted-ink mb-2">Kode Booking: #{{ $booking->id }}</div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <div class="fw-semibold">{{ $booking->room->hotel->name ?? 'Hotel' }}</div>
              <div class="small text-muted-ink"><i class="bi bi-geo"></i> {{ $booking->room->hotel->city ?? '-' }}</div>
              <div class="small text-muted-ink">{{ $booking->room->name }} • {{ $booking->room->type }} • Kap {{ $booking->room->capacity }}</div>
            </div>
            <div class="col-md-6">
              <div class="small text-muted-ink">Check-in</div>
              <div class="fw-semibold">{{ $booking->check_in->format('d M Y') }}</div>
              <div class="small text-muted-ink mt-2">Check-out</div>
              <div class="fw-semibold">{{ $booking->check_out->format('d M Y') }}</div>
              <div class="small text-muted-ink mt-2">Malam</div>
              <div class="fw-semibold">{{ $booking->nights }}</div>
            </div>
          </div>
          <hr>
          <div class="row align-items-center">
            <div class="col-md-6">
              <div class="small text-muted-ink">Harga / malam</div>
              <div class="fw-semibold">Rp {{ number_format($booking->price_per_night,0,',','.') }}</div>
            </div>
            <div class="col-md-6">
              <div class="small text-muted-ink">Subtotal</div>
              <div class="fw-semibold">Rp {{ number_format($booking->subtotal,0,',','.') }}</div>
            </div>
            <div class="col-md-6 mt-2">
              <div class="small text-muted-ink">Pajak (11%)</div>
              <div class="fw-semibold">Rp {{ number_format($booking->tax,0,',','.') }}</div>
            </div>
            <div class="col-md-6 mt-2">
              <div class="small text-muted-ink">Diskon</div>
              <div class="fw-semibold">- Rp {{ number_format($booking->discount,0,',','.') }}</div>
            </div>
          </div>
        </div>
      </div>

      @if(session('status'))
        <div class="alert alert-info rounded-4 mt-2">{{ session('status') }}</div>
      @endif
    </div>

    <div class="col-lg-4">
      <div class="sticky-cta">
        <div class="card card-soft">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <div class="small text-muted-ink">Total dibayar</div>
              <div class="fs-4 fw-bold text-primary">Rp {{ number_format($booking->grand_total,0,',','.') }}</div>
            </div>
            <form method="POST" action="{{ route('payments.create',$booking->id) }}" class="mt-3 d-grid gap-2">
              @csrf
              <button class="btn btn-primary btn-pill"><i class="bi bi-credit-card me-1"></i> Bayar Sekarang</button>
              <a class="btn btn-outline-secondary btn-pill" href="{{ route('bookings.index') }}">Kembali</a>
            </form>
            @if(config('services.midtrans.server_key')==='') 
              <div class="small text-muted mt-2">Mode <strong>Simulasi</strong>: kamu akan diarahkan ke halaman mock untuk memilih status (success/failed/expired).</div>
            @endif
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
