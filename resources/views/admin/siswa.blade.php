@extends('layout.main')
@section('content')

<div class="pagetitle">
  <h1>{{$title}}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item active">Pengguna Siswa</li>
    </ol>
  </nav>
</div>

{{-- alert --}}
@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {!! session('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
@if (session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {!! session('error') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

{{-- menampilkan data siswa --}}

<div class="row">
  {{-- button untuk tambah data melalui file upload excel --}}
  <div class="col-lg-12">
    <div class="alert alert-info" role="alert">
      <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Menambahkan Data Siswa ?</h4>
      <ul>
        <li>untuk menambahkan data secara individu atau perorangan gunakan tombol <span class="btn btn-sm text-white" style="background-color: orangered">Tambah Data</span></li>
        <li>
          anda dapat menambahkan data siswa dalam jumlah banyak menggunakan file Excel dengan ekstensi <strong>.xls</strong> atau <strong>.xlsx</strong>
        </li> 
        <li>gunakan template file untuk menyesuaikan dengan susunan tabel database</li>
      </ul>
      <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Tahun Ajaran Baru</h4>
        <ul>
          <li>Anda dapat melakukan operasi naik kelas pada siswa dengan menekan tombol Naik Kelas</li>
          <li>Sebelum menjalankan tombol naik kelas, pastikan tahun ajaran sudah diperbaharui dan diaktifkan</li>
          <li>Berhati - hatilah dalam menggunakan tombol naik kelas, apabila telah tombol di-klik maka operasi tidak akan bisa dibatalkan</li>
        </ul>
      </div>
      <hr>

      <div class="row">
        <form action="/admin/uploadsiswa" method="post" enctype="multipart/form-data">
          @csrf
            <div class="form-group mb-3">
              <div class="row">
                <label for="file" class="form-label fw-bold"><i class="bi bi-info-circle"></i> Upload File Excel</label>
                <div class="col-md-8">
                  <input type="file" name="file" id="file" class="form-control mb-1">
                </div>
                <div class="col-sm-1">
                  <button type="submit" class="btn btn-primary">Upload</button>
                </div>
                
              </div>
            </div>
        </form>
      </div>

      {{-- tambah data, perorangan --}}
      <div class="row">
        <div class="col">
          <div class="row">
            <div class="col-md-6">
              
              <a href="/admin/tambahsiswa" class="btn text-white mb-1" style="background-color: orangered">Tambah Data</a>
              
              {{-- template file excel --}}
              <a href="{{ asset('file/excel/template_upload_data_siswa.xlsx') }}" class="btn btn-success mb-1">Template Excel</a>
              
              <form method="POST" action="{{ route('naik-kelas') }}" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-primary mb-1">Naik Kelas</button>
              </form>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>

  
  <div class="col-lg-12">
    <div class="card">
      
      {{-- {{ $siswa }} --}}
      <div class="card-body">
        <div class="table-responsive mt-3">
          <table class="table table-striped" id="datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Kelas</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($siswa as $s)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$s->nis}}</td>
                <td>{{ucwords($s->nama_siswa)}}</td>  
                  
                <td>
                  @if ($s->status === 1 )
                    <span class="badge bg-success">Aktif</span>
                  @else
                    <span class="badge bg-danger">Nonaktif</span>
                  @endif
                </td>
                <td>{{$s->nama_kelas}}</td>
                <td>
                  <a href="/admin/siswa/{{$s->kode_siswa}}/edit" class="btn btn-warning btn-sm mb-1"><i class="bi bi-pen"></i></a>

                  <form action="/admin/siswa/{{$s->kode_siswa}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Yakin ingin menghapus data ini {!!  $s->nama_siswa  !!} ? ')"><i class="bi bi-trash"></i></button>
                  </form>

                  <a href="/admin/detailsiswa/{{ $s->kode_siswa }}" class="btn btn-info btn-sm mb-1"><i class="bi bi-eye"></i></a>
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