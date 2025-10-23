@extends('layouts.admin')
@section('title','Tambah Hotel')
@section('page_title','Tambah Hotel')

@section('content')
<div class="container-fluid">
  <div class="card card-soft">
    <div class="card-body">
      @if ($errors->any()) <div class="alert alert-danger rounded-4">{{ $errors->first() }}</div> @endif
      <form method="POST" action="{{ route('admin.hotels.store') }}" enctype="multipart/form-data" class="row g-3">
        @csrf
        <div class="col-md-6">
          <label class="form-label">Nama Hotel</label>
          <input class="form-control rounded-4" name="name" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Kota</label>
          <input class="form-control rounded-4" name="city" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Bintang</label>
          <select class="form-select rounded-4" name="stars" required>
            @foreach([5,4,3,2,1] as $s)<option value="{{ $s }}">{{ $s }}</option>@endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Alamat</label>
          <input class="form-control rounded-4" name="address">
        </div>
        <div class="col-md-6">
          <label class="form-label">Harga Dasar / Malam</label>
          <input type="number" class="form-control rounded-4" name="base_price" value="300000" min="0" required>
        </div>
        <div class="col-12">
          <label class="form-label">Deskripsi</label>
          <textarea class="form-control rounded-4" name="description" rows="3"></textarea>
        </div>
        <div class="col-md-6">
          <label class="form-label">Cover URL (opsional)</label>
          <input type="url" class="form-control rounded-4" name="cover_url" placeholder="https://...">
        </div>
        <div class="col-md-6">
          <label class="form-label">Upload Cover (opsional)</label>
          <input type="file" class="form-control rounded-4" name="cover_file" accept="image/*">
        </div>
        <div class="col-12">
          <label class="form-label">Galeri (multi-upload opsional)</label>
          <input type="file" class="form-control rounded-4" name="gallery_files[]" accept="image/*" multiple>
          <div class="small text-muted mt-1">jpg/jpeg/png/webp • max 4MB/berkas</div>
        </div>
        <div class="col-12">
          <label class="form-label">Fitur (pisahkan dengan koma)</label>
          <input class="form-control rounded-4" name="features" placeholder="WiFi, Sarapan, Kolam, Parkir">
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-brand btn-pill"><i class="bi bi-save me-1"></i> Simpan</button>
          <a class="btn btn-ghost btn-pill" href="{{ route('admin.hotels.index') }}">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
