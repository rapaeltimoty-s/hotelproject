@extends('layouts.admin')
@section('title','Admin • Rooms')
@section('page_title','Rooms')

@section('content')
<div class="container-fluid">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <div></div>
    <a class="btn btn-outline-brand btn-pill" href="{{ route('admin.rooms.create') }}"><i class="bi bi-plus-circle me-1"></i> Tambah Room</a>
  </div>

  <div class="table-responsive card card-soft">
    <table class="table align-middle mb-0">
      <thead class="table-light">
        <tr><th>#</th><th>Hotel</th><th>Nama</th><th>Tipe</th><th>Kapasitas</th><th>Harga</th><th>Status</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        @forelse($rooms as $r)
        <tr>
          <td>{{ $r->id }}</td>
          <td>{{ $r->hotel->name ?? '-' }}</td>
          <td>{{ $r->name }}</td>
          <td>{{ $r->type }}</td>
          <td>{{ $r->capacity }}</td>
          <td>Rp {{ number_format($r->price_per_night,0,',','.') }}</td>
          <td><span class="status-badge {{ $r->status==='available'?'status-confirmed':'status-cancelled' }}">{{ ucfirst($r->status) }}</span></td>
          <td class="d-flex gap-2">
            <a class="btn btn-ghost btn-sm" href="{{ route('admin.rooms.edit',$r->id) }}"><i class="bi bi-pencil"></i></a>
            <form method="POST" action="{{ route('admin.rooms.destroy',$r->id) }}">@csrf @method('DELETE')
              <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus kamar ini?')"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center text-muted-ink">Belum ada kamar.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    @if(method_exists($rooms,'links')) {{ $rooms->links() }} @endif
  </div>
</div>
@endsection
