@extends('layout.main')
@section('content')


<div class="pagetitle">
  <h1><?=$title;?></h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active"><?=$title;?></li>
    </ol>
  </nav>
</div>

@if (session()->has('sukses'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {!! session('sukses') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <form action="/admin/createpengumuman" method="post">
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

  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          
          <table class="table table-striped table-bordered datatable mt-3" id="datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Tanggal Upload</th>
                <th>Penulis</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pengumuman as $p)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$p->judul_pengumuman}}</td>
                <td>{{$p->tgl_upload}}</td>
                <td>{{ 
                  // cek apakah kode admin dan kode guru tidak null
                  $p->kode_admin != null ? $p->admin->nama : $p->guru->nama
                }}</td>
                <td>
                  <a href="/admin/pengumuman/{{$p->id}}/edit" class="btn btn-warning">Edit</a>
                  <form action="/admin/pengumuman/{{$p->id}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection