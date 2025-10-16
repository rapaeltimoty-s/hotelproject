@extends('layouts.app')
@section('title','Kamar - '.$hotel->name)

@section('content')
<section class="max-w-7xl mx-auto px-6 py-10">
  <div class="mb-6">
    <h1 class="text-2xl font-bold">Kamar di {{ $hotel->name }}</h1>
    <div class="text-sm text-gray-600">{{ $hotel->city }}</div>
  </div>

  @if(count($rooms))
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($rooms as $r)
      <div class="bg-white rounded-2xl shadow overflow-hidden">
        <img src="{{ $r->photo_url ?? 'https://picsum.photos/seed/r'.$r->id.'/800/500' }}" class="w-full h-44 object-cover">
        <div class="p-4">
          <div class="flex items-center justify-between">
            <div class="font-semibold">{{ $r->name }}</div>
            <span class="text-xs px-2 py-1 rounded-full {{ $r->status==='available'?'bg-emerald-50 text-emerald-700':'bg-rose-50 text-rose-700' }}">
              {{ ucfirst($r->status) }}
            </span>
          </div>
          <div class="text-gray-600 text-sm">{{ $r->type }} • Kapasitas {{ $r->capacity }} org</div>
          <div class="mt-2 font-semibold text-indigo-700">Rp {{ number_format($r->price_per_night,0,',','.') }}/malam</div>
          @auth
            <a href="{{ route('bookings.create',['room_id'=>$r->id]) }}" class="mt-3 inline-flex px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Booking</a>
          @else
            <a href="{{ route('login') }}" class="mt-3 inline-flex px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Login untuk booking</a>
          @endauth
        </div>
      </div>
      @endforeach
    </div>
  @else
    <div class="bg-white rounded-xl p-6 text-center text-gray-600">Belum ada kamar.</div>
  @endif
</section>
@endsection
