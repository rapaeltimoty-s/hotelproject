@extends('layouts.app')
@section('title','Kelola Booking')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-10">
  <h1 class="text-2xl font-bold mb-4">Booking</h1>

  <div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 text-gray-600">
        <tr>
          <th class="p-3 text-left">User</th>
          <th class="p-3 text-left">Hotel/Kamar</th>
          <th class="p-3 text-left">Tanggal</th>
          <th class="p-3 text-left">Total</th>
          <th class="p-3 text-left">Status</th>
          <th class="p-3 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($bookings as $b)
        <tr class="border-t">
          <td class="p-3">{{ $b->user->name ?? '-' }}</td>
          <td class="p-3">
            {{ $b->room->hotel->name ?? '-' }} — <span class="text-gray-600">{{ $b->room->name ?? '-' }}</span>
          </td>
          <td class="p-3">
            {{ \Illuminate\Support\Carbon::parse($b->check_in)->format('d M Y') }}
            – {{ \Illuminate\Support\Carbon::parse($b->check_out)->format('d M Y') }}
          </td>
          <td class="p-3 font-semibold">Rp {{ number_format($b->total_price,0,',','.') }}</td>
          <td class="p-3">
            <span class="px-2 py-1 rounded text-xs
              @class([
                'bg-yellow-50 text-yellow-700'=> $b->status==='pending',
                'bg-emerald-50 text-emerald-700'=> $b->status==='confirmed',
                'bg-rose-50 text-rose-700'=> $b->status==='cancelled'
              ])">{{ ucfirst($b->status) }}</span>
          </td>
          <td class="p-3 flex gap-2">
            @if($b->status==='pending')
              <form method="POST" action="{{ route('admin.bookings.confirm',$b->id) }}">
                @csrf @method('PATCH')
                <button class="px-3 py-1 rounded bg-emerald-100 text-emerald-800">Konfirmasi</button>
              </form>
              <form method="POST" action="{{ route('admin.bookings.cancel',$b->id) }}">
                @csrf @method('PATCH')
                <button class="px-3 py-1 rounded bg-rose-100 text-rose-800">Batalkan</button>
              </form>
            @else
              <span class="text-gray-400">—</span>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if(method_exists($bookings,'links'))
    <div class="mt-6">{{ $bookings->links() }}</div>
  @endif
</section>
@endsection
