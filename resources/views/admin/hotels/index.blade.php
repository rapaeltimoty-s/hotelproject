@extends('layouts.app')
@section('title','Kelola Hotel')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-10">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Hotel</h1>
    <a href="{{ route('admin.hotels.create') }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Tambah Hotel</a>
  </div>

  <div class="bg-white rounded-2xl shadow overflow-hidden">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 text-gray-600">
        <tr>
          <th class="text-left p-3">Nama</th>
          <th class="text-left p-3">Kota</th>
          <th class="text-left p-3">Bintang</th>
          <th class="text-left p-3">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($hotels as $h)
        <tr class="border-t">
          <td class="p-3">{{ $h->name }}</td>
          <td class="p-3">{{ $h->city }}</td>
          <td class="p-3">{{ $h->stars }}</td>
          <td class="p-3 flex items-center gap-2">
            <a href="{{ route('admin.hotels.edit',$h->id) }}" class="px-3 py-1 rounded bg-amber-100 text-amber-800">Edit</a>
            <form method="POST" action="{{ route('admin.hotels.destroy',$h->id) }}" onsubmit="return confirm('Hapus?')">
              @csrf @method('DELETE')
              <button class="px-3 py-1 rounded bg-rose-100 text-rose-800">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  @if(method_exists($hotels,'links'))
    <div class="mt-6">{{ $hotels->links() }}</div>
  @endif
</section>
@endsection
