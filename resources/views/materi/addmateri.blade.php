@extends((Auth::guard('webadmin')->check()) ? 'layout.main' : 'layout.guru')
@section('content')
@include('partials.page-title', ['title' => $title])

@if (session()->has('sukses'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {!! session('sukses') !!}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form method="post" action="{{(Auth::guard('webadmin')->check()) ? '/admin/materi' : '/guru/materi'}} " enctype="multipart/form-data">
  @csrf 

  <div class="form-group">
    <label for="judul">Judul</label>
    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{old('judul')}}">
    @error('judul')
    <div class="invalid-feedback">
      {{$message}}
    </div>
    @enderror
  </div>

  <div class="form-group">
    <label for="deskripsi">Deskripsi</label>
    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{old('deskripsi')}}</textarea>
    @error('deskripsi')
    <div class="invalid-feedback">
      {{$message}}
    </div>
    @enderror
  </div>

  <div class="form-group">
    <label for="kelas">Kelas</label>
    <select class="form-select @error('kelas') is-invalid @enderror" name="kelas" id="kelas">
      <option value="">Pilih Kelas</option>
      <option value="7" {{ old('kelas') == '7' ? 'selected' : '' }}>7</option>
      <option value="8" {{ old('kelas') == '8' ? 'selected' : '' }}>8</option>
      <option value="9" {{ old('kelas') == '9' ? 'selected' : '' }}>9</option>
    </select>
      @error('kelas')
      <div class="invalid-feedback">
        {{$message}}
      </div>
      @enderror
  </div>

  <div class="form-group">
    <label for="mapel">Mata Pelajaran</label>
    <select class="form-select @error('mapel') is-invalid @enderror" name="mapel" id="mapel">
      <option value="">Pilih Mata Pelajaran</option>
      @foreach ($mapel as $m)
      <option value="{{$m->kode_pelajaran}}" {{ old('mapel') == $m->kode_pelajaran ? 'selected' : '' }} >{{$m->nama_pelajaran}}</option>
      @endforeach
    </select>
    @error('mapel')
    <div class="invalid-feedback">
      {{$message}}
    </div>
    @enderror
  </div>

  <div class="form-group">
    <label for="file">File</label>
    <input class="form-control @error('file') is-invalid @enderror" type="file" id="file" name="file">
    @error('file')
    <div class="invalid-feedback">
      {{$message}}
    </div>
    @enderror
  </div>
  <div class="row mt-3 d-flex">
    <div class="col d-flex">
      <button type="submit" class="ms-auto btn text-white" style="background-color: orange;">Tambah</button>
      
      <a href=' {{(Auth::guard('webadmin')->check()) ? '/admin/materi' : '/guru/materi'}} ' class="btn mx-2" style="color:orange; border: 1px solid orange">Kembali</a>

    </div>
  </div>
</form>

@endsection