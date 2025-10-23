@extends('layouts.admin')
@section('title','Edit Room')
@section('page_title','Edit Room')

@section('content')
<div class="container-fluid">
  <div class="card card-soft">
    <div class="card-body">
      @if ($errors->any()) <div class="alert alert-danger rounded-4">{{ $errors->first() }}</div> @endif
      <form method="POST" action="{{ route('admin.rooms.update',$room->id) }}" enctype="multipart/form-data" class="row g-3">
        @csrf @method('PUT')
        <div class="col-md-6">
          <label class="form-label">Hotel</label>
          <select class="form-select rounded-4" name="hotel_id" required>
            @foreach($hotels as $h)
              <option value="{{ $h->id }}" @selected($room->hotel_id==$h->id)>{{ $h->name }} ({{ $h->city }})</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Nama Kamar</label>
          <input class="form-control rounded-4" name="name" value="{{ old('name',$room->name) }}" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Tipe</label>
          <select class="form-select rounded-4" name="type" required>
            @foreach(['Standard','Deluxe','Suite'] as $t)<option value="{{ $t }}" @selected($room->type==$t)>{{ $t }}</option>@endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Kapasitas</label>
          <input type="number" class="form-control rounded-4" name="capacity" min="1" value="{{ old('capacity',$room->capacity) }}" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Harga per Malam</label>
          <input type="number" class="form-control rounded-4" name="price_per_night" min="0" value="{{ old('price_per_night',$room->price_per_night) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Foto URL (opsional)</label>
          <input type="url" class="form-control rounded-4" name="photo_url" value="{{ old('photo_url',$room->getRawOriginal('photo_url')) }}" placeholder="https://...">
        </div>
        <div class="col-md-6">
          <label class="form-label">Upload Foto (opsional)</label>
          <input type="file" class="form-control rounded-4" name="photo_file" accept="image/*">
          @if($room->photo_path)
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" name="remove_photo" value="1" id="rmphoto">
              <label class="form-check-label" for="rmphoto">Hapus foto upload</label>
            </div>
          @endif
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-brand btn-pill"><i class="bi bi-save me-1"></i> Simpan</button>
          <a class="btn btn-ghost btn-pill" href="{{ route('admin.rooms.index') }}">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
