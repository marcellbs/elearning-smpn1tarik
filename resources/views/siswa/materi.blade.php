@extends('layout.siswa')

@section('content')
<div class="container">
  <div class="pagetitle">
    <h1><?=$title;?></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active"><?=$title;?></li>
      </ol>
    </nav>
  </div>

  <div class="alert alert-info" role="alert">
      <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Materi Pelajaran</h4>
      <ul>
          <li>Anda dapat melihat semua materi yang ada.</li>
          <li>Gunakan pencarian, atau fiter yang ada untuk menemukan materi yang anda inginkan.</li>
      </ul>
  </div>

  <section class="section material">
    <div class="row">
      <div class="col-12">
        {{-- search dan kategori --}}
        <div class="row">

          @if(session()->has('gagal'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {!! session('gagal') !!}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          
          <div class="col-xxl-6 col-md-6">
            <div class="input-group mb-1">
              <form action="/siswa/materi" method="get">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Cari Materi" name="search" aria-label="Cari Materi" aria-describedby="button-addon2">
                  <button class="btn text-white" style="background-color: orange;" type="submit" id="button-addon2">Cari</button>
                </div>
              </form>
            </div>
          </div>

          <form action="/siswa/materi" method="get">
            <div class="row">
              <div class="col-xxl-4 col-md-4">
                <div class="input-group mb-3">
                  <select class="form-select" name="tingkat" id="inputGroupSelect02">
                    <option value="" selected>Pilih Kelas</option>
                    <option value="7" {{ Request::get('tingkat') == '7' ? 'selected' : '' }}>Kelas 7</option>
                    <option value="8" {{ Request::get('tingkat') == '8' ? 'selected' : '' }}>Kelas 8</option>
                    <option value="9" {{ Request::get('tingkat') == '9' ? 'selected' : '' }}>Kelas 9</option>
                  </select>
                  
                </div>
              </div>
  
              <div class="col-xxl-4 col-md-4">
                <div class="input-group mb-3">
                  <select class="form-select" name="kode_pelajaran" id="inputGroupSelect02">
                    <option value="" selected>Pilih Pelajaran</option>
                    @foreach ($pelajaranOptions as $kodePelajaran => $namaPelajaran)
                        <option value="{{ $kodePelajaran }}" {{ $kodePelajaran == request('kode_pelajaran') ? 'selected' : '' }}>
                            {{ $namaPelajaran }}
                        </option>
                    @endforeach
                  </select>
                  
                </div>
              </div>
              <div class="col">
                <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </div>
          </form>

        </div>
        
        <div class="row">
          @if($materi->isEmpty())
            <div class="col-md-12">
              <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading text-center">Belum ada materi yang dibagikan</h4>
              </div>
            </div>
          @endif

          @foreach($materi as $m)
            <div class="col-md-4 mb-3">

              <div class="card rounded h-100">
                <div class="card-body m-1 p-2">
                  <span class="badge rounded-pill" style="background-color: orange;">{{ $m->mapel->nama_pelajaran }}</span>
                  <span class="badge rounded-pill" style="background-color: orange;">{{ 'kelas '. $m->tingkat }}</span>
                  <h5 class="card-title">{{ $m->judul_materi }}</h5>
                </div>

                <div class="row">
                  <div class="col-2">
                      <a href="/siswa/materi/{{ $m->kode_materi }}" class="btn mx-2 mb-2" style="background-color: white; color: orange; border: 1px solid orange;"><i class="bi bi-eye"></i></a>
                  </div>

                  <div class="col-2 ms-auto mx-4">
                    @php
                      $ext = pathinfo($m->berkas, PATHINFO_EXTENSION);
                      if ($ext == 'pdf') {
                        echo '<p><i class="bi bi-file-earmark-pdf" style="font-size: 1.5rem; color: red;"></i></p>';
                      } else if ($ext == 'docx') {
                        echo '<i class="bi bi-file-earmark-word" style="font-size: 1.5rem; color: blue;"></i>';
                      } else if ($ext == 'pptx') {
                        echo '<i class="bi bi-file-earmark-ppt" style="font-size: 1.5rem; color: rgb(255, 94, 0);"></i>';
                      } else if ($ext == 'xlsx') {
                        echo '<i class="bi bi-file-earmark-excel" style="font-size: 1.5rem; color: green;"></i>';
                      }else if ($ext == 'zip' || $ext == 'rar'){
                        echo '<i class="bi bi-file-earmark-zip" style="font-size: 1.5rem; color: rgb(0, 0, 0);"></i>';
                      } else {
                        echo '<i class="bi bi-file-earmark" style="font-size: 1.5rem; color: black;"></i>';
                      }
                    @endphp
                  </div>

                </div>
              
              </div>
              
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  <div class="row">
    <div class="col-12">
      <div class="d-flex justify-content-center">
        {{ $materi->links() }}
      </div>
    </div>
  </div>
  
</div>


@endsection