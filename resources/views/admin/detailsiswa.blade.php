@extends('layout.main')

@section('content')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
      <li class="breadcrumb-item"><a href="/admin/siswa">Siswa</a></li>
      <li class="breadcrumb-item active">Detail Siswa</li>
    </ol>
  </nav>
</div>

<section class="section profile">
  <div class="row">
    <div class="col-xl-4">
      <div class="card mb-2">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
          {{-- cek di folder /img/siswa ada atau tidak --}}
          @if( file_exists( public_path().'/img/siswa/'.$siswa->foto ))
            <img src="/img/siswa/{{ $siswa->foto }}" alt="profil-{{ $siswa->nama_siswa }}" class="rounded-circle img-thumbnail">
          @else
            <img src="/img/{{ $siswa->foto }}" alt="profil-{{ $siswa->nama_siswa }}" class="rounded-circle img-thumbnail">
          @endif

          <h5 class="mt-2 mb-0 pb-0"><strong>{{ ucwords($siswa->nama_siswa) }}</strong></h5>
          <p class="mt-2 mb-0">Siswa</p>
          <p class="mt-1">{{ $siswa->nis }} | {{ $siswa->nama_tingkat . $siswa->nama_kelas }}</p>
          
        </div>
      </div>
      <div class="d-grid gap-4 mt-0">
        <a href="/admin/siswa" class="btn text-white" style="background-color: orange">Kembali</a>
      </div>
    </div>

    <div class="col-xl-8">
      <div class="col-lg-12">
        <div class="card">
          <h4 class="mx-3 mt-3 fw-bold">Overview</h4>
          <div class="card-body">
            <hr>
            <div class="row mt-2">
              <div class="col-lg-4 col-md-4">Nomor Induk Siswa</div>
              <div class="col-lg-1 col-md-1">:</div>
              <div class="col-lg-7 col-md-7 fw-bold">{{ $siswa->nis }}</div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4 col-md-4">Nama Siswa</div>
              <div class="col-lg-1 col-md-1">:</div>
              <div class="col-lg-7 col-md-7 fw-bold">{{ $siswa->nama_siswa }}</div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4 col-md-4">Email</div>
              <div class="col-lg-1 col-md-1">:</div>
              <div class="col-lg-7 col-md-7 fw-bold">{{ $siswa->email }}</div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4 col-md-4">Username</div>
              <div class="col-lg-1 col-md-1">:</div>
              <div class="col-lg-7 col-md-7 fw-bold">{{ $siswa->username }}</div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4 col-md-4">Kelas</div>
              <div class="col-lg-1 col-md-1">:</div>
              <div class="col-lg-7 col-md-7 fw-bold">{{ $siswa->nama_tingkat . $siswa->nama_kelas }}</div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4 col-md-4">Telepon</div>
              <div class="col-lg-1 col-md-1">:</div>
              <div class="col-lg-7 col-md-7 fw-bold">{{ $siswa->telepon }}</div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4 col-md-4">Agama</div>
              <div class="col-lg-1 col-md-1">:</div>
              <div class="col-lg-7 col-md-7 fw-bold">{{ $siswa->agama }}</div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4 col-md-4">Jenis Kelamin</div>
              <div class="col-lg-1 col-md-1">:</div>
              <div class="col-lg-7 col-md-7 fw-bold">{{ $siswa->jenis_kelamin }}</div>
            </div>
            <div class="row mt-2">
              <div class="col-lg-4 col-md-4">Alamat</div>
              <div class="col-lg-1 col-md-1">:</div>
              <div class="col-lg-7 col-md-7 fw-bold">{{ $siswa->alamat }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

@endsection