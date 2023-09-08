@extends('layout.main')

@section('content')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin/video">Video Pembelajaran</a></li>
        {{-- <li class="breadcrumb-item"><a href="/admin/video/shared">Manajemen Video</a></li> --}}
        <li class="breadcrumb-item active"><a href="/admin/video/{{ $video->id }}/edit">Edit</a></li>
      </ol>
  </nav>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body table-responsive">

        {{-- form --}}
        <form action="/admin/video/{{ $video->id }}" method="post" class="mt-3">
          @method('patch')
          @csrf

          <input type="hidden" name="updated_at" value="{{ $video->updated_at }}">

          <div class="form-group mb-2">
            <label for="judul">Judul Video</label>
            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ $video->judul }}">
            @error('judul')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group mb-2">
            <label for="link">Tautan Video</label>
            <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ $video->link }}">
            @error('link')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group mb-2">
            <label for="mapel">Mata Pelajaran</label>
            <select class="form-select @error('mapel') is-invalid @enderror" name="mapel" id="mapel">
              <option selected disabled value="">Pilih Mata Pelajaran</option>
              @foreach ($mapel as $item)
                <option value="{{ $item->kode_pelajaran}}" {{ $video->kode_pelajaran == $item->kode_pelajaran ? 'selected' : '' }}>{{ $item->nama_pelajaran }}</option>
              @endforeach
            </select>
            @error('mapel')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group mb-2">
            <label for="tingkat">Kelas</label>
            <select class="form-select @error('tingkat') is-invalid @enderror" name="tingkat" id="tingkat">
              <option selected disabled value="">Pilih Kelas</option>
              <option value="7" {{ $video->tingkat == 7 ? 'selected' : '' }}>Kelas 7</option>
              <option value="8" {{ $video->tingkat == 8 ? 'selected' : '' }}>Kelas 8</option>
              <option value="9" {{ $video->tingkat == 9 ? 'selected' : '' }}>Kelas 9 </option>
            </select>
            @error('tingkat')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="d-flex">
            <a href="/admin/video/" class="btn mt-2 ms-auto" style="color:orange;border: 1px solid orange;">Kembali</a> 
            <button type="submit" class="btn mt-2 ms-2" style="background-color: orange;color:white;">Edit Video</button>
          </div>
          

        </form>
      </div>
    </div>
  </div>
</div>

@endsection