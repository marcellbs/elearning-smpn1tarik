@extends('layout.main')
@section('content')

@include('partials.page-title-pengguna', ['title' => $title])

{{-- alert --}}
@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {!! session('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

{{-- menampilkan data siswa --}}

<div class="row">
  {{-- button untuk tambah data melalui file upload excel --}}
  <div class="col-lg-12">
    <div class="alert alert-light" role="alert">
      <h4 class="alert-heading">Menambahkan Data Siswa ?</h4>
      <ul>
        <li>untuk menambahkan data secara individu atau perorangan gunakan tombol <span class="btn btn-sm text-white" style="background-color: orangered">Tambah Data</span></li>
        <li>
          anda dapat menambahkan data siswa dalam jumlah banyak menggunakan file Excel dengan ekstensi <strong>.xls</strong> atau <strong>.xlsx</strong>
        </li> 
        <li>gunakan template file untuk menyesuaikan dengan susunan tabel database</li>
        
      
      </ul>
      <hr>

      <div class="row">
        <form action="/admin/uploadsiswa" method="post" enctype="multipart/form-data">
          @csrf
            <div class="form-group mb-3">
              <div class="row">
                <label for="file" class="form-label">Upload File Excel</label>
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

      <a href="#" class="btn text-white" style="background-color: orangered">Tambah Data</a>
      {{-- <a href="" class="btn btn-outline-success">Template File Excel</a> --}}
      {{-- file template excel di folder /public/file/excel/ menggunakan resource --}}
      <a href="{{ asset('file/excel/template_upload_data_siswa.xlsx') }}" class="btn btn-outline-success">Template File Excel</a>


    </div>
  </div>

  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <table class="table table-striped" id="datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
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
                <td>{{$s->jenis_kelamin}}</td>           
                {{-- menampilkan kelas siswa--}}
                <td>
                  @if ($s->nama_kelas)
                    {{ $s->nama_tingkat . $s->nama_kelas }}
                  @else
                    {{ 'Kelas belum diatur' }}
                  @endif
                <td>
                  <a href="/admin/siswa/{{$s->kode_siswa}}/edit" class="btn btn-warning">Edit</a>
                  <form action="/admin/siswa/{{$s->id}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
                  <a href="#" class="btn btn-info">Detail</a>
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