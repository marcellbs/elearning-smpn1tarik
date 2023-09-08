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
      <h5 class="mx-3 mt-2 mb-0 fw-bold">Buat Pengumuman Baru</h5>
      <hr>
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
      <h5 class="mx-3 mt-2 mb-0 fw-bold">Daftar Pengumuman</h5>
      <hr>
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
              @if($pengumuman->count() > 0)
                @foreach ($pengumuman as $p)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$p->judul_pengumuman}}</td>
                  <td>{{$p->tgl_upload}}</td>
                  <td>{{$p->kode_admin != null ? $p->admin->nama : $p->guru->nama}}</td>
                  <td>
                    {{-- <a href="/admin/pengumuman/{{ $p->id }}" class="btn btn-primary">Detail</a> --}}
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{$p->id}}">
                      Edit
                    </button>
                    {{-- <a href="/admin/pengumuman/{{$p->id}}/edit" class="btn btn-warning">Edit</a> --}}
                    <form action="/admin/pengumuman/{{$p->id}}" method="post" class="d-inline">
                      @method('delete')
                      @csrf
                      <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('apakah anda yakin untuk menghapus data ini ?') }}')">Delete</button>
                    </form>
                  </td>
                </tr>

                <!-- Modal Edit Data -->
                <div class="modal fade" id="exampleModal{{$p->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pengumuman</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="/admin/pengumuman/{{ $p->id }}" method="post">
                          @method('patch')
                          @csrf
                          <div class="input-group">
                            <label for="judul" class="input-group">Judul Pengumuman</label>
                            <input type="text" name="judul" id="judul" class="form-control" value="{{$p->judul_pengumuman}}">
                          </div>
                          <div class="form-group">
                              <label for="mytextarea">Deskripsi Pengumuman</label>
                              <textarea name="deskripsi" id="mytextarea" cols="30" rows="10" class="form-control @error('deskripsi') is-invalid @enderror">
                              {{ $p->deskripsi  }}
                              </textarea>
                              @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                        </form>
                    </div>
                  </div>
                </div>

                @endforeach
              
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
</div>








@endsection