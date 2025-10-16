@extends('layouts.app')
@section('title','Kelola Kamar')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-10">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Kamar</h1>
    <a href="{{ route('admin.rooms.create') }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Tambah Kamar</a>
  </div>

  <div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 text-gray-600"><tr>
        <th class="p-3 text-left">Hotel</th>
        <th class="p-3 text-left">Nama</th>
        <th class="p-3 text-left">Tipe</th>
        <th class="p-3 text-left">Kapasitas</th>
        <th class="p-3 text-left">Harga</th>
        <th class="p-3 text-left">Status</th>
        <th class="p-3 text-left">Aksi</th>
      </tr></thead>
      <tbody>
        @foreach($rooms as $r)
        <tr class="border-t">
          <td class="p-3">{{ $r->hotel->name ?? '-' }}</td>
          <td class="p-3">{{ $r->name }}</td>
          <td class="p-3">{{ $r->type }}</td>
          <td class="p-3">{{ $r->capacity }}</td>
          <td class="p-3">Rp {{ number_format($r->price_per_night,0,',','.') }}</td>
          <td class="p-3">
            <span class="px-2 py-1 rounded text-xs {{ $r->status==='available'?'bg-emerald-50 text-emerald-700':'bg-rose-50 text-rose-700' }}">{{ $r->status }}</span>
          </td>
          <td class="p-3 flex gap-2">
            <a href="{{ route('admin.rooms.edit',$r->id) }}" class="px-3 py-1 rounded bg-amber-100 text-amber-800">Edit</a>
            <form method="POST" action="{{ route('admin.rooms.destroy',$r->id) }}" onsubmit="return confirm('Hapus?')">
              @csrf @method('DELETE')
              <button class="px-3 py-1 rounded bg-rose-100 text-rose-800">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if(method_exists($rooms,'links'))
    <div class="mt-6">{{ $rooms->links() }}</div>
  @endif
</section>
@endsection
