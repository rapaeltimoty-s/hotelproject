@extends('layouts.app')
@section('title',$hotel->name)

@section('content')
<section class="max-w-7xl mx-auto px-6 py-10">
  <div class="grid lg:grid-cols-5 gap-8">
    <div class="lg:col-span-3">
      <img src="{{ $hotel->cover_url ?? 'https://picsum.photos/seed/h'.$hotel->id.'/1200/700' }}" class="rounded-2xl w-full h-72 object-cover shadow">
      <div class="mt-4 grid grid-cols-3 gap-3">
        @for($i=1;$i<=3;$i++)
          <img src="https://picsum.photos/seed/{{ $hotel->id.$i }}/500/300" class="rounded-xl w-full h-28 object-cover">
        @endfor
      </div>
    </div>
    <div class="lg:col-span-2">
      <div class="flex items-start justify-between">
        <div>
          <h1 class="text-2xl font-bold">{{ $hotel->name }}</h1>
          <div class="text-sm text-gray-600">{{ $hotel->address }}, {{ $hotel->city }}</div>
        </div>
        <div class="text-yellow-400 text-lg">{{ str_repeat('★',(int)$hotel->stars) }}</div>
      </div>
      <p class="mt-4 text-gray-700">{{ $hotel->description }}</p>

      <a href="{{ route('rooms.index',$hotel->id) }}" class="mt-6 inline-flex items-center px-5 py-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700">Lihat Kamar</a>
    </div>
  </div>
</section>
@endsection
