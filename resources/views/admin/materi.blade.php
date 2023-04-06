@extends('layout.main')

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


  <section class="section material">
    <div class="row">
      <div class="col-12">
        {{-- search dan kategori --}}
        <div class="row">

          <div class="col-xxl-4 col-md-4">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Cari Materi" aria-label="Cari Materi" aria-describedby="button-addon2">
              <button class="btn btn-outline-secondary" type="button" id="button-addon2">Cari</button>
            </div>
          </div>

          {{-- <div class="col-xxl-4 col-md-4">
            <div class="input-group mb-3">
              <select class="form-select" id="inputGroupSelect02">
                <option selected>Pilih Kelas</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
              </select>
              <button class="btn btn-outline-secondary" type="button" id="button-addon2">Cari</button>
            </div>
          </div> --}}

          <div class="col-xxl-4 col-md-4">
            <a href="/admin/materi/create" class="btn text-light mb-2" style="background-color:orange;">Tambah Materi</a>
          </div>

        </div>

        @if (session()->has('sukses'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! session('sukses') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        
        <div class="row">
          @foreach($materi as $m)
          <div class="col-md-4 mb-3">

            <div class="card rounded h-100">
              <div class="card-body m-1 p-2">
                <span class="badge rounded-pill" style="background-color: orange;">{{ $m->mapel->nama_pelajaran }}</span>
                <span class="badge rounded-pill" style="background-color: orange;">{{ 'kelas '. $m->tingkat->nama_tingkat }}</span>
                <h5 class="card-title">{{ $m->judul_materi }}</h5>
              </div>

              <div class="row">
        
                <div class="col-2">
                  <a href="/admin/materi/{{$m->kode_materi}}/edit" class="btn mx-2 mb-2" style="background-color: white; color:orange; border: 1px solid orange;"><i class="bi bi-pen"></i></a>
                </div>

                <div class="col-2">
                  <a href="/admin/materi/{{ $m->kode_materi }}" class="btn mx-2 mb-2" style="background-color: white; color: orange; border: 1px solid orange;"><i class="bi bi-eye"></i></a>
                </div>

                <div class="col-2">
                  <form action="/admin/materi/{{$m->kode_materi}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn mx-2 mb-2" style="background-color: white; color: orange; border: 1px solid orange;" onclick="return confirm('{{ __('apakah anda yakin untuk menghapus data ini ?') }}')"><i class="bi bi-trash"></i></button>
                  </form>
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
</div>

@endsection
