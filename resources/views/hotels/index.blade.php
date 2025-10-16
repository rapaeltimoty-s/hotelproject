@extends('layouts.app')
@section('title','Cari Hotel')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-10">
  <h1 class="text-2xl font-bold mb-5">Cari Hotel</h1>

  {{-- FILTERS --}}
  <form method="GET" class="bg-white rounded-xl shadow p-4 grid md:grid-cols-6 gap-3 mb-6">
    <input name="q" value="{{ request('q') }}" placeholder="Kota / Nama" class="md:col-span-2 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    <select name="stars" class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
      <option value="">Bintang</option>
      @for($i=5;$i>=1;$i--)
        <option value="{{ $i }}" @selected(request('stars')==$i)>{{ str_repeat('★',$i) }}</option>
      @endfor
    </select>
    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Harga min" class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Harga max" class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    <select name="sort" class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
      <option value="">Urutkan</option>
      <option value="name_asc" @selected(request('sort')==='name_asc')>Nama A-Z</option>
      <option value="price_asc" @selected(request('sort')==='price_asc')>Harga termurah</option>
      <option value="stars_desc" @selected(request('sort')==='stars_desc')>Bintang tertinggi</option>
    </select>
    <button class="md:col-span-6 md:justify-self-end px-5 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Terapkan</button>
  </form>

  {{-- GRID --}}
  @php($items = $hotels ?? [])
  @if(count($items))
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($items as $h)
      <a href="{{ route('hotels.show',$h->id) }}" class="bg-white rounded-2xl overflow-hidden shadow group">
        <div class="relative">
          <img src="{{ $h->cover_url ?? 'https://picsum.photos/seed/h'.$h->id.'/800/500' }}" class="w-full h-44 object-cover group-hover:scale-[1.02] transition">
          <div class="absolute top-3 left-3 px-2 py-1 rounded-md bg-black/60 text-white text-xs">{{ $h->city }}</div>
          <div class="absolute top-3 right-3 text-yellow-400">{{ str_repeat('★', (int)$h->stars) }}</div>
        </div>
        <div class="p-4">
          <div class="font-semibold">{{ $h->name }}</div>
          <div class="text-sm text-gray-500 line-clamp-2">{{ $h->address }}</div>
          <div class="mt-3 text-indigo-700 font-semibold">Mulai Rp {{ number_format($h->min_price ?? 200000,0,',','.') }}/malam</div>
        </div>
      </a>
    @endforeach
  </div>
  @else
    <div class="bg-white rounded-xl p-6 text-center text-gray-600">Tidak ada hotel yang cocok.</div>
  @endif

  {{-- PAGINATION (jika pakai paginate) --}}
  @if(method_exists($items,'links'))
    <div class="mt-6">{{ $items->withQueryString()->links() }}</div>
  @endif
</section>
@endsection
