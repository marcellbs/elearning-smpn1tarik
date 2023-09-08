@extends('layout.main')

@section('content')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
      <li class="breadcrumb-item"><a href="/admin/Guru">Guru</a></li>
      <li class="breadcrumb-item active">Detail Guru</li>
    </ol>
  </nav>
</div>

<section class="section profile">
  <div class="row">
    <div class="col-xl-4 mb-3">
      <div class="card mb-2">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
          {{-- cek di folder /img/siswa ada atau tidak --}}
          @if( file_exists( public_path().'/img/guru/'.$guru->foto ))
            <img src="/img/guru/{{ $guru->foto }}" alt="profil-{{ $guru->nama }}" class="rounded-circle img-thumbnail">
          @else
            <img src="/img/{{ $guru->foto }}" alt="profil-{{ $guru->nama }}" class="rounded-circle img-thumbnail">
          @endif
          @php
            $nip = $guru->nip;
            $kodeProvinsi = substr($nip, 0, 8);
            $tanggalLahir = substr($nip, 8, 6);
            $kodeJenisKelamin = substr($nip, 14, 1);
            $nomorUrut = substr($nip, 15);
            $formattedNIP = $kodeProvinsi . ' ' . $tanggalLahir . ' ' . $kodeJenisKelamin . ' ' . $nomorUrut;
          @endphp

          <h5 class="mt-2 mb-0 pb-0 text-center"><strong>{{ ucwords($guru->nama) }}</strong></h5>
          <p class="mt-2 mb-0">Guru / Pengajar</p>
          <p class="mt-1">{{ $formattedNIP }}</p>
          
        </div>
      </div>
      <div class="d-grid gap-4 mt-0">
        <a href="/admin/guru" class="btn text-white" style="background-color: orange">Kembali</a>
      </div>
    </div>

    <div class="col-xl-8">
      <div class="col-lg-12">
        <div class="card">
          <h4 class="mx-3 mt-3 fw-bold">Overview</h4>
          <div class="card-body">
            <div class="table-responsive mt-3">
              <hr>
              <table class="table table-bordered">
                <tr>
                  <td colspan="3" class="text-center">Data Guru</td>
                </tr>
                <tr>
                  <td>Nomor Induk Pegawai (NIP)</td>
                  <td >:</td>
                  <td>
                    @if($guru->nip == null)
                      <span class="badge bg-danger">Belum ada NIP</span>
                    @else
                      {{ $formattedNIP }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>Nama Lengkap</td>
                  <td>:</td>
                  <td>{{ $guru->nama }}</td>
                </tr>
                <tr>
                  <td>Username</td>
                  <td>:</td>
                  <td>{{ $guru->username }}</td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td>:</td>
                  <td>{!! $guru->email != null ? $guru->email : '<i>Belum ada informasi</i>' !!}</i>
                </tr>
                <tr>
                  <td>Telepon</td>
                  <td>:</td>
                  <td>{!! $guru->telepon != null ? $guru->telepon : '<i>Belum ada informasi</i>' !!}</i>
                </tr>
                <tr>
                  <td>Agama</td>
                  <td>:</td>
                  <td>{!! $guru->agama != null ? $guru->agama : '<i>Belum ada informasi</i>' !!}</i>
                </tr>
                <tr>
                  <td>Jenis Kelamin</td>
                  <td>:</td>
                  <td>{!! $guru->jenis_kelamin != null ? $guru->jenis_kelamin : '<i>Belum ada informasi</i>' !!}</i>
                </tr>
                <tr>
                  <td>Alaamat</td>
                  <td>:</td>
                  <td>{!! $guru->alamat != null ? $guru->alamat : '<i>Belum ada informasi</i>' !!}</i>
                </tr>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- <div class="row mt-2">
  <div class="col-lg-4 col-md-4">Nomor Induk Pegawai (NIP)</div>
  <div class="col-lg-1 col-md-1">:</div>
  <div class="col-lg-7 col-md-7 fw-bold">{{ $formattedNIP }}</div>
</div>
<div class="row mt-2">
  <div class="col-lg-4 col-md-4">Nama Lengkap</div>
  <div class="col-lg-1 col-md-1">:</div>
  <div class="col-lg-7 col-md-7 fw-bold">{{ $guru->nama }}</div>
</div>
<div class="row mt-2">
  <div class="col-lg-4 col-md-4">Email</div>
  <div class="col-lg-1 col-md-1">:</div>
  <div class="col-lg-7 col-md-7 fw-bold">{{ $guru->email }}</div>
</div>
<div class="row mt-2">
  <div class="col-lg-4 col-md-4">Username</div>
  <div class="col-lg-1 col-md-1">:</div>
  <div class="col-lg-7 col-md-7 fw-bold">{{ $guru->username }}</div>
</div>
<div class="row mt-2">
  <div class="col-lg-4 col-md-4">Telepon</div>
  <div class="col-lg-1 col-md-1">:</div>
  <div class="col-lg-7 col-md-7 fw-bold">{{ $guru->telepon }}</div>
</div>
<div class="row mt-2">
  <div class="col-lg-4 col-md-4">Agama</div>
  <div class="col-lg-1 col-md-1">:</div>
  <div class="col-lg-7 col-md-7 fw-bold">{{ $guru->agama }}</div>
</div>
<div class="row mt-2">
  <div class="col-lg-4 col-md-4">Jenis Kelamin</div>
  <div class="col-lg-1 col-md-1">:</div>
  <div class="col-lg-7 col-md-7 fw-bold">{{ $guru->jenis_kelamin }}</div>
</div>
<div class="row mt-2">
  <div class="col-lg-4 col-md-4">Alamat</div>
  <div class="col-lg-1 col-md-1">:</div>
  <div class="col-lg-7 col-md-7 fw-bold">{{ $guru->alamat }}</div>
</div> --}}

@endsection