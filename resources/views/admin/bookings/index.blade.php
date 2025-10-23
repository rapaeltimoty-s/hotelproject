@extends('layouts.admin')
@section('title','Kelola Bookings')
@section('page_title','Bookings')
@section('content')
<div class="container-fluid">
  <div class="card card-soft p-3">
    <div class="table-responsive">
      <table class="table align-middle">
        <thead class="table-light">
          <tr><th>#</th><th>Pemesan</th><th>Hotel/Kamar</th><th>Tanggal</th><th>Malam</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          @forelse($bookings as $b)
          <tr>
            <td>{{ $b->id }}</td>
            <td>
              <div class="fw-semibold">{{ $b->user->name ?? '-' }}</div>
              <div class="small text-secondary">{{ $b->user->email ?? '' }}</div>
            </td>
            <td>
              <div class="fw-semibold">{{ $b->room->hotel->name ?? '-' }}</div>
              <div class="small text-secondary">{{ $b->room->name ?? '-' }}</div>
            </td>
            <td>
              <div>{{ $b->check_in->format('d M Y') }} → {{ $b->check_out->format('d M Y') }}</div>
            </td>
            <td>{{ $b->nights }}</td>
            <td>Rp {{ number_format($b->total_price,0,',','.') }}</td>
            <td>
              @php $s=$b->status; @endphp
              <span class="status-badge {{ $s==='pending'?'status-pending':($s==='confirmed'?'status-confirmed':'status-cancelled') }}">{{ ucfirst($s) }}</span>
            </td>
            <td class="d-flex gap-2">
              @if($b->status==='pending')
                <form method="POST" action="{{ route('admin.bookings.confirm',$b->id) }}">@csrf @method('PATCH')
                  <button class="btn btn-sm btn-success"><i class="bi bi-check2-circle"></i></button>
                </form>
                <form method="POST" action="{{ route('admin.bookings.cancel',$b->id) }}">@csrf @method('PATCH')
                  <button class="btn btn-sm btn-danger"><i class="bi bi-x-circle"></i></button>
                </form>
              @else
                <span class="text-secondary small">—</span>
              @endif
            </td>
          </tr>
          @empty
            <tr><td colspan="8" class="text-center text-muted-ink">Belum ada booking.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if(method_exists($bookings,'links')) <div class="p-2">{{ $bookings->links() }}</div> @endif
  </div>
</div>
@endsection
