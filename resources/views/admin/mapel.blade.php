@extends('layout.main')
@section('content')

@include('partials.page-title', ['title' => $title])

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {!! session('success') !!}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {!! session('error') !!}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="alert alert-info mb-0" role="alert">
        <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Informasi</h4>
        <ul>
          <li>Anda dapat menambahkan mata pelajaran yang dibutuhkan dalam proses belajar mengajar</li>
          <li>Anda cukup menambahkan nama mata pelajaran saja, maka mata pelajaran yang anda inputkan akan masuk ke dalam database</li>
          <li>Contoh : Matematika, Bahasa Inggris, dsb.</li>
          <li>Anda dapat mengunggah data mata pelajaran secara massal sesuaikan dengan template yang disediakan</li>
          <li>File yang dapat diunggah berformat <strong>.xls</strong> atau <strong>.xlsx</strong></li>
        </ul>
        
        <hr>

        <div class="col-md-12">
          <form action="/admin/uploadmapel" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
              <div class="row">
                <label for="file" class="form-label fw-bold"><i class="bi bi-upload"></i> Upload File Excel</label>
                <div class="col-md-8">
                  <input type="file" name="file" id="file" class="form-control mb-1">
                </div>
                <div class="col-sm-1">
                  <button type="submit" class="btn btn-primary">Upload</button>
                  
                </div>
                <div class="col-sm-1">
                  
                  <a href="{{ asset('file/excel/template_upload_mapel.xlsx') }}" class="btn btn-success">Template</a>
                </div>
              </div>
          </form>
        </div>

        <div class="col-md-8">
          <form action="/admin/mapel" method="post">
            @csrf
              <div class="form-group">
                <div class="row">
                    <label class="form-label fw-bold" for="pelajaran">Mata Pelajaran</label>
                    <div class="col-md-8">
                      <input type="text" name="pelajaran" id="pelajaran" class="form-control @error('pelajaran')is-invalid @enderror" placeholder="Matematika">
                      @error('pelajaran')
                        <div class="invalid-feedback">
                          {{$message}}
                        </div>
                      @enderror
                    </div>
                    <div class="col-sm-1">
                      <button type="submit" class=" btn text-white" style="background-color:orange;">Tambah </button>
                    </div>
                  
                </div>
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
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($mapel as $m)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$m->nama_pelajaran}}</td>
                <td>          
                  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $m->kode_pelajaran }}">
                    <i class="bi bi-pencil-square"></i>
                  </button>

                  {{-- form edit data di dalam modal --}}
                  <div class="modal fade" id="exampleModal{{ $m->kode_pelajaran }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Mata Pelajaran</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="/admin/mapel/{{ $m->kode_pelajaran }}" method="post">
                            @method('patch')
                            @csrf
                            <div class="mb-3">
                              <label for="pelajaran" class="form-label">Mata Pelajaran</label>
                              <input type="text" class="form-control" id="pelajaran" name="pelajaran" value="{{ $m->nama_pelajaran }}">
                            </div>

                              <button type="button" class="btn btn-white" style="color:orange; border:1px solid orange;" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn text-white" style="background-color:orange;">Ubah</button>
                            
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <form action="/admin/mapel/{{$m->kode_pelajaran}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini ?')"><i class="bi bi-trash"></i></button>
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


@endsection