@extends('layout.main')

@section('content')
<div class="pagetitle">
  <h1>{{$title}}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item active">Pengguna Guru</li>
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





<div class="row">
  <div class="col-lg-12">
    <div class="alert alert-info" role="alert">
      <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Menambahkan Data Guru</h4>
      <ul>
        <li>untuk menambahkan data secara individu atau perorangan gunakan tombol <span class="btn btn-sm text-white" style="background-color: orangered">Tambah Data</span></li>
        <li>
          anda dapat menambahkan data guru dalam jumlah banyak menggunakan file Excel dengan ekstensi <strong>.xls</strong> atau <strong>.xlsx</strong>
        </li> 
        <li>gunakan template file untuk menyesuaikan dengan susunan tabel database</li>
        
      
      </ul>
      <hr>

      <div class="row">
        <form action="/admin/uploadguru" method="post" enctype="multipart/form-data">
          @csrf
            <div class="form-group mb-3">
              <div class="row">
                <label for="file" class="form-label fw-bold"><i class="bi bi-upload"></i> Upload File Excel</label>
                <div class="col-md-8">
                  <input type="file" name="file" id="file" class="form-control mb-1 @error('file') is-invalid @enderror">
                  @error('file')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
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
          <a href="/admin/tambahguru" class="btn text-white mb-1" style="background-color: orangered">Tambah Data</a>
        
          {{-- template file excel --}}
          <a href="{{ asset('file/excel/template_upload_data_guru.xlsx') }}" class="btn btn-success">Template Excel</a>
          {{-- siswa kelas 9 lama --}}
          <button class="btn btn-danger hps">Kosongkan Data Guru</button>
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
                <th>NIP</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($guru as $g)
              <tr>
                <td>{{$loop->iteration}}</td>
                @php
                  $nip = $g->nip;
                  $kodeProvinsi = substr($nip, 0, 8);
                  $tanggalLahir = substr($nip, 8, 6);
                  $kodeJenisKelamin = substr($nip, 14, 1);
                  $nomorUrut = substr($nip, 15);

                  $formattedNIP = $kodeProvinsi . ' ' . $tanggalLahir . ' ' . $kodeJenisKelamin . ' ' . $nomorUrut;

                @endphp
                @if ($g->nip == null)
                  <td><span class="badge bg-danger">Belum ada NIP</span></td>
                @else
                  <td>{{$formattedNIP}}</td>
                @endif
                <td>{{$g->nama}}</td>
                <td>{{$g->username}}</td>
                <td>
                  <a href="/admin/guru/{{$g->kode_guru}}/edit" class="btn btn-sm btn-warning mb-2"><i class="bi bi-pen"></i></a>

                  <form action="/admin/guru/{{$g->kode_guru}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger mb-2" onclick="return confirm('Yakin ingin menghapus data ini {!!  $g->nama  !!} ? ')"><i class="bi bi-trash"></i></button>
                  </form>

                  <a href="/admin/detailguru/{{ $g->kode_guru }}" class="btn btn-info btn-sm mb-2"><i class="bi bi-eye"></i></a>
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