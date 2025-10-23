@extends('layouts.app')
@section('title','Buat Booking')
@section('content')
<div class="container py-4">
  <h1 class="h4 fw-bold mb-3">Booking: {{ $room->hotel->name }} — {{ $room->name }}</h1>
  <div class="row g-3">
    <div class="col-lg-7">
      <div class="card card-soft">
        <img src="{{ $room->photo_url }}" class="w-100 rounded-top-4" style="height:240px;object-fit:cover">
        <div class="card-body">
          <div class="small text-secondary">{{ $room->type }} • Kapasitas {{ $room->capacity }} org</div>
          <div class="fw-semibold text-primary fs-5">Rp {{ number_format($room->price_per_night,0,',','.') }}/malam</div>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card card-soft">
        <div class="card-body">
          @if ($errors->any()) <div class="alert alert-danger rounded-4">{{ $errors->first() }}</div> @endif
          <form method="POST" action="{{ route('bookings.store') }}" class="d-grid gap-3">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">
            <div>
              <label class="form-label">Check-in</label>
              <input type="date" class="form-control rounded-4" name="check_in" required>
            </div>
            <div>
              <label class="form-label">Check-out</label>
              <input type="date" class="form-control rounded-4" name="check_out" required>
            </div>
            <button class="btn btn-brand btn-pill w-100">Buat Booking</button>
            <div class="small text-secondary"><span class="kbd">i</span> Admin akan mengonfirmasi dalam 24 jam.</div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
