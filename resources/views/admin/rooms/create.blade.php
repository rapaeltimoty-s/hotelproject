@extends('layouts.admin')
@section('title','Tambah Room')
@section('page_title','Tambah Room')

@section('content')
<div class="container-fluid">
  <div class="card card-soft">
    <div class="card-body">
      @if ($errors->any()) <div class="alert alert-danger rounded-4">{{ $errors->first() }}</div> @endif
      <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data" class="row g-3">
        @csrf
        <div class="col-md-6">
          <label class="form-label">Hotel</label>
          <select class="form-select rounded-4" name="hotel_id" required>
            <option value="">Pilih hotel</option>
            @foreach($hotels as $h)
              <option value="{{ $h->id }}">{{ $h->name }} ({{ $h->city }})</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Nama Kamar</label>
          <input class="form-control rounded-4" name="name" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Tipe</label>
          <select class="form-select rounded-4" name="type" required>
            @foreach(['Standard','Deluxe','Suite'] as $t)<option value="{{ $t }}">{{ $t }}</option>@endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Kapasitas</label>
          <input type="number" class="form-control rounded-4" name="capacity" min="1" value="2" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Harga per Malam</label>
          <input type="number" class="form-control rounded-4" name="price_per_night" min="0" value="300000" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Foto URL (opsional)</label>
          <input type="url" class="form-control rounded-4" name="photo_url" placeholder="https://...">
        </div>
        <div class="col-md-6">
          <label class="form-label">Upload Foto (opsional)</label>
          <input type="file" class="form-control rounded-4" name="photo_file" accept="image/*">
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-brand btn-pill"><i class="bi bi-save me-1"></i> Simpan</button>
          <a class="btn btn-ghost btn-pill" href="{{ route('admin.rooms.index') }}">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
