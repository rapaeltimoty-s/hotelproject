@extends('layouts.app')
@section('title','Status Pembayaran — HotelApp')

@section('content')
<div class="container py-5">
  <div class="card card-soft mx-auto" style="max-width:760px;">
    <div class="card-body p-4">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <div class="small text-muted-ink">Order ID</div>
          <div class="fw-semibold">{{ $payment->order_id }}</div>
          <div class="small text-muted-ink mt-1">Nama: {{ $payment->booking->user->name ?? '-' }}</div>
        </div>
        <div>
          @php $map=['success'=>'status-confirmed','pending'=>'status-pending','failed'=>'status-cancelled','expired'=>'status-cancelled','refunded'=>'status-pending']; @endphp
          <span class="status-badge {{ $map[$payment->status] ?? 'status-pending' }}">{{ ucfirst($payment->status) }}</span>
        </div>
      </div>
      <hr>
      <div class="row g-3">
        <div class="col-md-6">
          <div class="small text-muted-ink">Hotel</div>
          <div class="fw-semibold">{{ $payment->booking->room->hotel->name ?? '-' }}</div>
          <div class="small text-muted-ink">{{ $payment->booking->room->hotel->city ?? '-' }}</div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted-ink">Total</div>
          <div class="fw-semibold">Rp {{ number_format($payment->amount,0,',','.') }}</div>
          <div class="small text-muted-ink">Metode: {{ strtoupper($payment->method ?? '-') }}</div>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <a class="btn btn-primary btn-pill" href="{{ route('bookings.index') }}"><i class="bi bi-journal-check me-1"></i> Booking Saya</a>
        <a class="btn btn-outline-secondary btn-pill" href="{{ route('home') }}"><i class="bi bi-house me-1"></i> Beranda</a>
      </div>
    </div>
  </div>
</div>
@endsection
