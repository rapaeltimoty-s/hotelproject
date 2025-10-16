@extends('layouts.app')
@section('title','Tambah Kamar')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-10">
  <div class="bg-white rounded-2xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Kamar</h1>

    @if ($errors->any())
      <div class="mb-4 rounded-lg bg-rose-50 text-rose-700 px-3 py-2">
        <ul class="list-disc list-inside text-sm">
          @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4">
      @csrf
      <div class="md:col-span-2">
        <label class="block text-sm font-medium">Hotel</label>
        <select name="hotel_id" required class="mt-1 w-full rounded-lg border-gray-300">
          <option value="">Pilih Hotel</option>
          @foreach($hotels as $h)<option value="{{ $h->id }}">{{ $h->name }} ({{ $h->city }})</option>@endforeach
        </select>
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium">Nama Kamar</label>
        <input name="name" class="mt-1 w-full rounded-lg border-gray-300" required>
      </div>
      <div>
        <label class="block text-sm font-medium">Tipe</label>
        <select name="type" class="mt-1 w-full rounded-lg border-gray-300" required>
          <option value="Standard">Standard</option>
          <option value="Deluxe">Deluxe</option>
          <option value="Suite">Suite</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium">Kapasitas</label>
        <input type="number" name="capacity" value="2" min="1" class="mt-1 w-full rounded-lg border-gray-300" required>
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium">Harga/Malam</label>
        <input type="number" name="price_per_night" step="1" min="0" class="mt-1 w-full rounded-lg border-gray-300" required>
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium">Foto (opsional)</label>
        <input type="file" name="photo" accept="image/*" class="mt-1 w-full">
      </div>
      <div class="md:col-span-2">
        <button class="px-5 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Simpan</button>
        <a href="{{ route('admin.rooms.index') }}" class="ml-2 px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Kembali</a>
      </div>
    </form>
  </div>
</section>
@endsection
