@extends('layouts.app')
@section('title','Admin Dashboard')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-10">
  <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

  <div class="grid md:grid-cols-4 gap-6">
    <div class="bg-white rounded-2xl p-5 shadow border border-gray-100">
      <div class="text-sm text-gray-500">Total Hotel</div>
      <div class="text-3xl font-bold mt-1">{{ $stats['hotels'] ?? 0 }}</div>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow border border-gray-100">
      <div class="text-sm text-gray-500">Total Kamar</div>
      <div class="text-3xl font-bold mt-1">{{ $stats['rooms'] ?? 0 }}</div>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow border border-gray-100">
      <div class="text-sm text-gray-500">Booking Pending</div>
      <div class="text-3xl font-bold mt-1">{{ $stats['pending'] ?? 0 }}</div>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow border border-gray-100">
      <div class="text-sm text-gray-500">Booking Bulan Ini</div>
      <div class="text-3xl font-bold mt-1">{{ $stats['month'] ?? 0 }}</div>
    </div>
  </div>

  <div class="mt-8 grid md:grid-cols-2 gap-6">
    <a href="{{ route('admin.hotels.index') }}" class="bg-indigo-600 text-white rounded-2xl p-6 shadow hover:bg-indigo-700">Kelola Hotel</a>
    <a href="{{ route('admin.rooms.index') }}" class="bg-indigo-50 text-indigo-700 rounded-2xl p-6 shadow hover:bg-indigo-100">Kelola Kamar</a>
  </div>
</section>
@endsection
