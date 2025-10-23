@extends('layouts.admin')
@section('title','Edit Hotel')
@section('page_title','Edit Hotel')

@section('content')
<div class="container-fluid">
  <div class="card card-soft">
    <div class="card-body">
      @if ($errors->any()) <div class="alert alert-danger rounded-4">{{ $errors->first() }}</div> @endif
      <form method="POST" action="{{ route('admin.hotels.update',$hotel->id) }}" enctype="multipart/form-data" class="row g-3">
        @csrf @method('PUT')
        <div class="col-md-6">
          <label class="form-label">Nama Hotel</label>
          <input class="form-control rounded-4" name="name" value="{{ old('name',$hotel->name) }}" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Kota</label>
          <input class="form-control rounded-4" name="city" value="{{ old('city',$hotel->city) }}" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Bintang</label>
          <select class="form-select rounded-4" name="stars" required>
            @foreach([5,4,3,2,1] as $s)<option value="{{ $s }}" @selected($hotel->stars==$s)>{{ $s }}</option>@endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Alamat</label>
          <input class="form-control rounded-4" name="address" value="{{ old('address',$hotel->address) }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Harga Dasar / Malam</label>
          <input type="number" class="form-control rounded-4" name="base_price" min="0" value="{{ old('base_price',$hotel->base_price) }}" required>
        </div>
        <div class="col-12">
          <label class="form-label">Deskripsi</label>
          <textarea class="form-control rounded-4" name="description" rows="3">{{ old('description',$hotel->description) }}</textarea>
        </div>
        <div class="col-md-6">
          <label class="form-label">Cover URL (opsional)</label>
          <input type="url" class="form-control rounded-4" name="cover_url" value="{{ old('cover_url',$hotel->getRawOriginal('cover_url')) }}" placeholder="https://...">
        </div>
        <div class="col-md-6">
          <label class="form-label">Upload Cover (opsional)</label>
          <input type="file" class="form-control rounded-4" name="cover_file" accept="image/*">
          @if($hotel->cover_path)
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" name="remove_cover" value="1" id="rmcover">
              <label class="form-check-label" for="rmcover">Hapus cover upload</label>
            </div>
          @endif
        </div>
        <div class="col-12">
          <label class="form-label">Galeri (multi-upload)</label>
          <input type="file" class="form-control rounded-4" name="gallery_files[]" accept="image/*" multiple>
          @if(is_array($hotel->gallery) && count($hotel->gallery))
            <div class="row g-2 mt-2">
              @foreach($hotel->gallery as $g)
                <div class="col-3"><img class="w-100 rounded-3" src="{{ Storage::url($g) }}" style="height:90px;object-fit:cover"></div>
              @endforeach
            </div>
          @endif
        </div>
        <div class="col-12">
          <label class="form-label">Fitur (pisahkan dengan koma)</label>
          <input class="form-control rounded-4" name="features" value="{{ old('features',implode(', ', $hotel->features ?? [])) }}">
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-brand btn-pill"><i class="bi bi-save me-1"></i> Simpan</button>
          <a class="btn btn-ghost btn-pill" href="{{ route('admin.hotels.index') }}">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
