@extends('layout.main')
@section('content')

<div class="pagetitle">
  <h1><?=$title;?></h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin">Home</a></li>
      <li class="breadcrumb-item active"><?=$title;?></li>
    </ol>
  </nav>
</div>

@if (session()->has('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {!! session('status') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
  <div class="col-lg-12">

    <div class="card bg-info bg-opacity-10">
      <div class="card-body">
        <h5 class="mt-3"> <i class="bi bi-info-circle"></i> <strong class="ms-2">Informasi</strong></h5>
        <p class="text-muted">Halaman ini digunakan untuk mengelola data kelas.</p>
        <ul>
          <li>Kelas memiliki <i>id unique</i> berupa angka yang harus diinputkan langsung oleh admin</li>
          <li>Ketika membuat kelas baru, pastikan kelas dibuat dengan id berurutan</li>
          <li>Contoh : 7A, 8A, 9A id harus urut : 1, 2, 3</li>
          <li>Perhatikan juga bahwa ID Unique tidak sama dengan yang lain</li>
          <li>Untuk menambahkan nama kelas gunakan huruf kapital antara A - Z</li>
        </ul>
        
        <hr>

        <h5 class="mt-2 fw-bold"><i class="bi bi-upload"></i> Upload File</h5>
        <ul>
          <li>Anda dapat mengunggah untuk melakukan <i>insert</i> data secara massal</li>
          <li>Sesuaikan dengan file template yang disediakan</li>
          <li>File yang diperbolehkan adalah <strong>.xls</strong> atau <strong>.xlsx</strong></li>
        </ul>

        <div class="row">
          <div class="col-md-12">
            <form action="/admin/uploadkelas" method="post" enctype="multipart/form-data">
              @csrf
              <div class="form-group mb-3">

                <div class="row">
                  <div class="col-md-8">
                    <input type="file" name="file" id="file" class="form-control mb-1">
                  </div>
                  <div class="col-sm-1">
                    <button type="submit" class="btn btn-primary">Upload</button>
                  </div>
                  <div class="col-sm-1">
                    <a href="{{ asset('file/excel/template_upload_data_kelas.xlsx') }}" class="btn btn-success">Template</a>
                  </div>

                </div>
              </div>
            </form>
          </div>
        </div>
          
        
      </div>
    </div>

    <form action="/admin/kelas" method="post" class="mb-3">
      @csrf
      <div class="row">
        <div class="col-md-3">
          <label for="id">ID Unique</label>
          <div class="form-group">
            {{-- old insert--}}
            <input type="text" name="id" id="id" class="form-control @error('id')is-invalid @enderror" placeholder="angka" value="{{ old('id') }}">
            @error('id')
            <div class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
        </div>
        {{-- <div class="col-md-3">
          <label for="tingkat">Tingkat Kelas</label>
          <div class="form-group">
            <select name="tingkat" id="tingkat" class="form-select @error('tingkat')is-invalid @enderror">
              <option value="">Pilih Tingkat Kelas</option>
              @foreach ($tingkat as $t)
              <option value="{{$t->kode_tingkat}}">{{$t->nama_tingkat}}</option>
              @endforeach
            </select>
            @error('tingkat')
            <div class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
        </div> --}}
        <div class="col-md-3">
          <label for="kelas">Kelas</label>
          <div class="form-group">
            {{-- old insert--}}
            <input type="text" name="kelas" id="kelas" class="form-control @error('kelas')is-invalid @enderror" placeholder="A - Z" value="{{ old('kelas') }}">
            @error('kelas')
            <div class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
        </div>
        <div class="col-md-3 mt-4 d-flex">
          <button type="submit" class="btn text-white ms-auto" style="background-color: orange;"><i class="bi bi-plus"></i> Tambah Kelas</button>
        </div>
      </div>
      <div class="row">
      </div>
    </form>



    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <table class="table table-striped" id="datatables">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Kelas</th>
                <th>Nama Kelas</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($kelas as $k)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $k->kode_kelas }}</td>
                <td>{{$k->nama_kelas}}</td>
                <td>
                  <a href="/admin/kelas/{{$k->kode_kelas}}/edit" class="btn btn-warning"><i class="bi bi-pen
                    "></i></a>
                  <form action="/admin/kelas/{{$k->kode_kelas}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin menghapus data ini ?')"><i class="bi bi-trash"></i></button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-center">
      {{ $kelas->links() }}
    </div>

  </div>
</div>

@endsection