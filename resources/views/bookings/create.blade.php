@extends('layouts.app')
@section('title','Buat Booking')

@section('content')
<section class="max-w-3xl mx-auto px-6 py-10">
  <div class="bg-white rounded-2xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">Buat Booking</h1>

    @if ($errors->any())
      <div class="mb-4 rounded-lg bg-rose-50 text-rose-700 px-3 py-2">
        <ul class="list-disc list-inside text-sm">
          @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('bookings.store') }}" class="grid md:grid-cols-2 gap-4">
      @csrf
      <input type="hidden" name="room_id" value="{{ request('room_id') ?? $room->id ?? '' }}">

      <div>
        <label class="block text-sm font-medium">Check-in</label>
        <input type="date" name="check_in" value="{{ old('check_in') }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
      </div>
      <div>
        <label class="block text-sm font-medium">Check-out</label>
        <input type="date" name="check_out" value="{{ old('check_out') }}" required class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500">
      </div>
      <div class="md:col-span-2">
        <button class="w-full rounded-lg bg-indigo-600 text-white py-2.5 hover:bg-indigo-700">Buat Booking</button>
      </div>
    </form>
  </div>
</section>
@endsection
