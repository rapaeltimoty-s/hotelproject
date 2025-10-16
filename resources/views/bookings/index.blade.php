@extends('layouts.app')
@section('title','Booking Saya')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-10">
  <h1 class="text-2xl font-bold mb-5">Riwayat Booking</h1>

  @if(count($bookings))
  <div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 text-gray-600">
        <tr>
          <th class="text-left p-3">Hotel</th>
          <th class="text-left p-3">Kamar</th>
          <th class="text-left p-3">Check-in</th>
          <th class="text-left p-3">Check-out</th>
          <th class="text-left p-3">Total</th>
          <th class="text-left p-3">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($bookings as $b)
          <tr class="border-t">
            <td class="p-3">{{ $b->room->hotel->name ?? '-' }}</td>
            <td class="p-3">{{ $b->room->name ?? '-' }}</td>
            <td class="p-3">{{ \Illuminate\Support\Carbon::parse($b->check_in)->format('d M Y') }}</td>
            <td class="p-3">{{ \Illuminate\Support\Carbon::parse($b->check_out)->format('d M Y') }}</td>
            <td class="p-3 font-semibold">Rp {{ number_format($b->total_price,0,',','.') }}</td>
            <td class="p-3">
              <span class="px-2 py-1 rounded text-xs
                @class([
                  'bg-yellow-50 text-yellow-700'=> $b->status==='pending',
                  'bg-emerald-50 text-emerald-700'=> $b->status==='confirmed',
                  'bg-rose-50 text-rose-700'=> $b->status==='cancelled'
                ])">
                {{ ucfirst($b->status) }}
              </span>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @else
    <div class="bg-white rounded-xl p-6 text-center text-gray-600">Belum ada booking.</div>
  @endif
</section>
@endsection
