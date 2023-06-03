@extends('layout.guru')

@section('content')
  @include ('partials.page-title', ['title' => 'Buat Pengumuman Baru'])

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">
            <form action="/guru/pengumuman" method="post">
              @csrf
              <div class="form-group">
                <label for="judul_pengumuman">Judul Pengumuman</label>
                <input type="text" name="judul_pengumuman" id="judul_pengumuman" class="form-control @error('judul_pengumuman') is-invalid @enderror">
                @error('judul_pengumuman')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label for="mytextarea">Deskripsi Pengumuman</label>
                <textarea name="deskripsi" id="mytextarea" cols="30" rows="10" class="form-control @error('deskripsi') is-invalid @enderror"></textarea>
                @error('deskripsi')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mt-2">Tambah</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection