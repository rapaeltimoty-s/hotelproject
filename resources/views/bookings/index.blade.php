@extends('layouts.app')
@section('title','Booking Saya — HotelApp')

@section('content')
<div class="container py-3">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h5 fw-bold">Booking Saya</h1>
    <a href="{{ route('hotels.index') }}" class="btn btn-outline-secondary btn-pill"><i class="bi bi-search"></i> Cari Hotel</a>
  </div>

  <div class="card card-soft">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Kode</th>
            <th>Hotel / Kamar</th>
            <th>Tanggal</th>
            <th class="text-end">Total</th>
            <th>Status</th>
            <th>Pembayaran</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        @forelse($bookings as $b)
          <tr>
            <td>#{{ $b->id }}</td>
            <td class="small">
              <div class="fw-semibold">{{ $b->room->hotel->name ?? '-' }}</div>
              <div class="text-muted-ink">{{ $b->room->name ?? '' }} • {{ $b->room->type ?? '' }}</div>
            </td>
            <td class="small">
              <div>Check-in: {{ $b->check_in->format('d M Y') }}</div>
              <div>Check-out: {{ $b->check_out->format('d M Y') }}</div>
              <div class="text-muted-ink">Malam: {{ $b->nights }}</div>
            </td>
            <td class="text-end fw-semibold">Rp {{ number_format($b->grand_total ?? $b->total_price,0,',','.') }}</td>
            <td>
              @php $map=['confirmed'=>'status-confirmed','pending'=>'status-pending','cancelled'=>'status-cancelled']; @endphp
              <span class="status-badge {{ $map[$b->status] ?? 'status-pending' }}">{{ ucfirst($b->status) }}</span>
            </td>
            <td>
              @php $pmap=['paid'=>'status-confirmed','pending'=>'status-pending','failed'=>'status-cancelled','expired'=>'status-cancelled','refunded'=>'status-pending']; @endphp
              <span class="status-badge {{ $pmap[$b->payment_status] ?? 'status-pending' }}">{{ ucfirst($b->payment_status ?? 'pending') }}</span>
            </td>
            <td class="d-flex gap-2">
              @if(($b->payment_status ?? 'pending')==='pending')
                <a class="btn btn-primary btn-sm btn-pill" href="{{ route('checkout.show',$b->id) }}"><i class="bi bi-credit-card"></i> Bayar</a>
              @else
                <a class="btn btn-outline-secondary btn-sm btn-pill" href="{{ route('checkout.show',$b->id) }}"><i class="bi bi-receipt"></i> Rincian</a>
              @endif
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted-ink">Belum ada booking.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    @if(method_exists($bookings,'links')) {{ $bookings->links() }} @endif
  </div>
</div>
@endsection
