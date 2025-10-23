@extends('layouts.app')
@section('title','Simulasi Pembayaran — HotelApp')

@section('content')
<div class="container py-5">
  <div class="card card-soft mx-auto" style="max-width:760px;">
    <div class="card-body p-4">
      <h1 class="h5 fw-bold">Simulasi Payment</h1>
      <div class="small text-muted-ink">Order: {{ $payment->order_id }} • Total: Rp {{ number_format($payment->amount,0,',','.') }}</div>
      <hr>
      <form method="POST" action="{{ route('payments.mock.notify') }}" class="d-flex flex-wrap gap-2">
        @csrf
        <input type="hidden" name="order_id" value="{{ $payment->order_id }}">
        <button name="status" value="settlement" class="btn btn-brand btn-pill">Setel ke SUCCESS</button>
        <button name="status" value="expire" class="btn btn-outline-brand btn-pill">Setel ke EXPIRED</button>
        <button name="status" value="deny" class="btn btn-outline-danger btn-pill">Setel ke FAILED</button>
      </form>
      <div class="small text-muted mt-3">Ini simulasi lokal saat belum mengisi Midtrans Server Key di <code>.env</code>.</div>
    </div>
  </div>
</div>
@endsection
