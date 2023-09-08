@extends('layout.guru')

@section('content')
<div class="pagetitle">
  <h1><?=$title;?></h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/guru">Home</a></li>
      <li class="breadcrumb-item"><a href="/guru/video">Video Pembelajaran</a></li>
      <li class="breadcrumb-item active"> <a href="/guru/video/create"></a><?=$title;?></li>
    </ol>
  </nav>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body table-responsive">

        <form action="/guru/video" method="post">
          @csrf
          <div class="mb-3">
            <label for="judul" class="form-label mt-3">Judul Video</label>
            <input type="text" class="form-control" id="judul" name="judul" required>
          </div>
          <div class="mb-3">
            <label for="link" class="form-label">Tautan Video</label>
            <input type="text" class="form-control" id="link" name="link" required>
          </div>
          <div class="mb-3">
            <label for="mapel" class="form-label">Mata Pelajaran</label>
            <select class="form-select" name="mapel" id="mapel" required>
              <option selected disabled value="">Pilih Mata Pelajaran</option>
              @foreach ($mapel as $item)
                <option value="{{ $item->kode_pelajaran}}">{{ $item->nama_pelajaran }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="tingkat" class="form-label">Kelas</label>
            <select class="form-select" name="tingkat" id="tingkat" required>
              <option selected disabled value="">Pilih Kelas</option>
              <option value="7">Kelas 7</option>
              <option value="8">Kelas 8</option>
              <option value="9">Kelas 9</option>
            </select>
          </div>
          <div class="d-flex">
            <a href="/guru/video" class="btn mt-2 ms-auto" style="color:orange;border: 1px solid orange;">Kembali</a> 
            <button type="submit" class="btn mt-2 ms-2" style="background-color: orange;color:white;">Tambah Video</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

@endsection