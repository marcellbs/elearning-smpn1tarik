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
        <h5 class="mt-3"> <i class="bi bi-exclamation-diamond"></i> <strong class="ms-2">Informasi</strong></h5>
        <p class="text-muted">Halaman ini digunakan untuk mengelola data kelas.</p>
        <ul>
          <li>untuk menambahkan kelas pilih tingkat kelas antara 7, 8, dan 9</li>
          <li>untuk menambahkan nama kelas gunakan huruf kapital antara A - Z</li>
        </ul>
      </div>
    </div>

    <form action="/admin/kelas" method="post" class="mb-3">
      @csrf
      <div class="row">
        <div class="col-md-4">
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
        </div>
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
        <div class="col-md-5 mt-4 d-flex">
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
                <th>Tingkat Kelas</th>
                <th>Nama Kelas</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($kelas as $k)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $k->tingkat->nama_tingkat }}</td>
                <td>{{$k->nama_kelas}}</td>
                <td>
                  <a href="/admin/kelas/{{$k->kode_kelas}}/edit" class="btn btn-warning"><i class="bi bi-pen
                    "></i></a>
                  <form action="/admin/kelas/{{$k->kode_kelas}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('apakah anda yakin untuk menghapus data ini ? '. $k->kode_kelas) }}')"><i class="bi bi-trash
                      "></i></button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          
        </div>
      </div>
      <div class="d-flex justify-content-end">
        {{ $kelas->links() }}
      </div>
    </div>
  </div>
</div>

@endsection