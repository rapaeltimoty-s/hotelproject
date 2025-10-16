@extends('layouts.app')
@section('title','Edit Hotel')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-10">
  <div class="bg-white rounded-2xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Hotel</h1>

    @if ($errors->any())
      <div class="mb-4 rounded-lg bg-rose-50 text-rose-700 px-3 py-2">
        <ul class="list-disc list-inside text-sm">
          @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.hotels.update',$hotel->id) }}" enctype="multipart/form-data" class="grid md:grid-cols-2 gap-4">
      @csrf @method('PUT')
      <div class="md:col-span-2">
        <label class="block text-sm font-medium">Nama Hotel</label>
        <input name="name" value="{{ old('name',$hotel->name) }}" required class="mt-1 w-full rounded-lg border-gray-300">
      </div>
      <div>
        <label class="block text-sm font-medium">Kota</label>
        <input name="city" value="{{ old('city',$hotel->city) }}" required class="mt-1 w-full rounded-lg border-gray-300">
      </div>
      <div>
        <label class="block text-sm font-medium">Bintang</label>
        <select name="stars" class="mt-1 w-full rounded-lg border-gray-300">
          @for($i=5;$i>=1;$i--) <option value="{{ $i }}" @selected($hotel->stars==$i)>{{ $i }}</option> @endfor
        </select>
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium">Alamat</label>
        <input name="address" value="{{ old('address',$hotel->address) }}" class="mt-1 w-full rounded-lg border-gray-300">
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium">Deskripsi</label>
        <textarea name="description" rows="4" class="mt-1 w-full rounded-lg border-gray-300">{{ old('description',$hotel->description) }}</textarea>
      </div>
      <div class="md:col-span-2">
        <label class="block text-sm font-medium">Cover (opsional)</label>
        <input type="file" name="cover" accept="image/*" class="mt-1 w-full">
      </div>
      <div class="md:col-span-2">
        <button class="px-5 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Update</button>
        <a href="{{ route('admin.hotels.index') }}" class="ml-2 px-5 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Kembali</a>
      </div>
    </form>
  </div>
</section>
@endsection
