@extends('layout.main')

@section('content')

@include('partials.page-title-pengguna', ['title' => $title])

{{-- alert --}}
@if(session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {!! session()->get('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(session()->has('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {!! session()->get('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="row">
  <div class="col-lg-12">
    <div class="alert alert-info" role="alert">
      <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Menambahkan Data Admin</h4>
      <ul>
        <li>
          anda dapat menambahkan data menggunakan tombol <span class="btn btn-sm text-white" style="background-color: orangered">Tambah Data</span></li>
        </li> 
        <li>anda dapat menambahkan admin dengan memilih guru untuk dijadikan admin</li>
        
      
      </ul>
      <hr>

      {{-- <div class="row">
        <form action="/admin/uploadguru" method="post" enctype="multipart/form-data">
          @csrf
            <div class="form-group mb-3">
              <div class="row">
                <label for="file" class="form-label fw-bold">Upload File Excel</label>
                <div class="col-md-8">
                  <input type="file" name="file" id="file" class="form-control mb-1">
                </div>
                <div class="col-sm-1">
                  <button type="submit" class="btn btn-primary">Upload</button>
                </div>
              </div>
            </div>
        </form>
      </div> --}}

      {{-- tambah data, perorangan --}} 
      <div class="row">
        <div class="col">
          <a href="/admin/tambah" class="btn text-white mb-1" style="background-color: orangered">Tambah Data</a>
        
          {{-- template file excel --}}
          {{-- <a href="{{ asset('file/excel/template_upload_data_guru.xlsx') }}" class="btn btn-success">Template Excel</a> --}}
          {{-- siswa kelas 9 lama --}}
          {{-- <button class="btn btn-danger hps">Kosongkan Data Guru</button> --}}
        </div>
      </div>


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
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              {{-- menampilkan data admin dari method admin --}}
              @foreach ($admin as $a)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $a['nama'] }}</td>
                  <td>{{ $a['email'] }}</td>
                  <td>
                    <a href="/admin/editadmin/{{ $a['kode_admin'] }}/edit" class="btn btn-warning btn-sm">Edit</a>
                    {{-- delete --}}
                    <form action="/admin/admin/{{ $a['kode_admin'] }}" method="post" class="d-inline">
                      @method('delete')
                      @csrf
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yakin akan menghapus data ini?')">Hapus</button>
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