@extends('layout.siswa')
@section('content')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/siswa">Home</a></li>
        <li class="breadcrumb-item"><a href="/siswa/video">Video Pembelajaran</a></li>
      </ol>
  </nav>
</div>

<div class="row">
  <div class="container">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <div class="row">
      {{-- input untuk pencarian video --}}
      <div class="row">
        <div class="col-xxl-4 col-md-4">
            <form action="/siswa/video" method="get">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari Video" name="search" aria-label="Cari Video" aria-describedby="button-addon2">
                <button class="btn text-white" style="background-color: orange;" type="submit" id="button-addon2">Cari</button>
              </div>
            </form>
        </div>
      </div>
      

      @foreach ($video as $item)
        <div class="col-md-4 mb-3">
          <div class="card rounded">
            <div class="card-body mt-3">
              {{-- di database link disimpan seperti ini https://www.youtube.com/watch?v=B1J6Ou4q8vE --}}
              {{-- maka kita ambil id videonya saja dengan explode --}}
              @php
                  $link = explode('=', $item->link);
              @endphp
              <iframe width="100%" height="150px" src="https://www.youtube.com/embed/{{ end($link) }}" frameborder="0" allowfullscreen></iframe>
              
              <hr>
    
              <p class="fw-bold">{{ $item->judul }}</p>
              @if($item->kode_guru != '' || $item->kode_guru != null)
                <p class="m-0">{{ $item->guru->nama }}</p>
              @else
                <p class="m-0">Administrator</p>
              @endif

              <p class="m-0">Kelas {{ $item->tingkat}}</p>
              <p>{{ $item->mapel->nama_pelajaran }}</p>

              <small>Dibuat pada : {{ Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}</small>
              
              <hr class="m-1">
              
              <div class="d-flex">
                <a href="/siswa/video/{{ $item->id }}" class="btn btn-sm text-white ms-auto" style="background-color: orange;">Detail</a>
              </div>
              
    
            </div>
          </div>
        </div>
      @endforeach

    </div>

    <p class="mb-0">Halaman : {{ $video->currentPage(); }}</p>
    <p class="mb-0">Jumlah Video : {{ $video->total(); }}</p>
    <p class="mb-0">Data Per Halaman : {{ $video->perPage(); }}</p>
    <div class="d-flex justify-content-center">
      {{ $video->links() }}
    </div>

  </div>
</div>

@endsection