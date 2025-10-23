@extends('layouts.admin')
@section('title','Admin • Dashboard')
@section('page_title','Dashboard')

@section('content')
<div class="container-fluid">
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card card-soft card-lift">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="small text-muted-ink">Total Hotels</div>
              <div class="h4 fw-bold">{{ $totalHotels ?? 0 }}</div>
            </div>
            <div class="brand-badge"><i class="bi bi-buildings"></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-soft card-lift">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="small text-muted-ink">Total Rooms</div>
              <div class="h4 fw-bold">{{ $totalRooms ?? 0 }}</div>
            </div>
            <div class="brand-badge"><i class="bi bi-door-open"></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-soft card-lift">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <div class="small text-muted-ink">Pending Bookings</div>
              <div class="h4 fw-bold">{{ $pendingBookings ?? 0 }}</div>
            </div>
            <div class="brand-badge"><i class="bi bi-journal-check"></i></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card card-soft p-3 mt-3">
    <div class="d-flex align-items-center justify-content-between">
      <div class="fw-semibold">Aksi Cepat</div>
      <div class="d-flex gap-2">
        <a class="btn btn-brand btn-pill" href="{{ route('admin.hotels.create') }}"><i class="bi bi-plus-circle me-1"></i> Hotel</a>
        <a class="btn btn-outline-brand btn-pill" href="{{ route('admin.rooms.create') }}"><i class="bi bi-plus-circle me-1"></i> Room</a>
        <a class="btn btn-ghost btn-pill" href="{{ route('admin.bookings.index') }}"><i class="bi bi-list-check me-1"></i> Bookings</a>
      </div>
    </div>
  </div>
</div>
@endsection
