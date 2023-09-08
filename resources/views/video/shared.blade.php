@extends('layout.guru')

@section('content')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/guru">Home</a></li>
        <li class="breadcrumb-item"><a href="/guru/video">Video Pembelajaran</a></li>
        <li class="breadcrumb-item active"><a href="/guru/video/shared">Manajemen Video</a></li>
      </ol>
  </nav>
</div>

<div class="row">

  {{-- alert --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <p class="m-0">{{ session('success') }}</p>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
    <div class="col-lg-12">
      <div class="d-flex">
        <a href="/guru/video" class="btn text-white ms-auto mb-3" style="background-color: orange;">Kembali</a>
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
            {{-- @if($item->kode_guru !== '' || $item->kode_guru !== null)
              <p class="m-0">{{ $item->guru->nama }}</p>
            @else
              <p class="m-0">Administrator</p>
            @endif --}}
            <p class="m-0">Kelas {{ $item->tingkat}}</p>
            <p>{{ $item->mapel->nama_pelajaran }}</p>

            <small class="fst-italic">Dibuat pada : {{ Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}</small>
            
            <div class="d-flex">
              <a href="/guru/video/{{ $item->id }}" class="btn text-white ms-auto" style="background-color: orange;"><i class="bi bi-eye"></i></a>
              <a href="/guru/video/{{ $item->id }}/edit" class="btn btn-warning ms-1 text-light"><i class="bi bi-pen"></i></a>

              {{-- delete --}}
              <form action="/guru/video/{{ $item->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger ms-1" onclick="return confirm('Apakah anda yakin untuk menghapus video ini?')"><i class="bi bi-trash"></i></button>
              </form>
              
            </div>
            
  
          </div>
        </div>
      </div>
    @endforeach

    <p class="mb-0">Halaman : {{ $video->currentPage(); }}</p>
    <p class="mb-0">Jumlah Video : {{ $video->total(); }}</p>
    <p class="mb-0">Data Per Halaman : {{ $video->perPage(); }}</p>
    <div class="d-flex justify-content-center">
      {{ $video->links() }}
    </div>
</div>

@endsection