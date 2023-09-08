@extends('layout.ruangkelassiswa')

@section('content')
  <div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/siswa">Home</a></li>
          <li class="breadcrumb-item"><a href="/siswa/detail/{{ $hash->encode($pengampu->id) }}">Ruang Kelas</a></li>
          <li class="breadcrumb-item"><a href="/siswa/video/{{ $hash->encode($pengampu->id) }}">Video Pembelajaran</a></li>
        </ol>
    </nav>
  </div>

  {{-- alert --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>{{session('status')}}</strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>{{session('error')}}</strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- cek apakah video ada atau tidak --}}
  @if($video->count() == 0)
    <div class="col-md-12">
      <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading text-center">Belum ada video yang dibagikan</h4>
      </div>
    </div>
  @else
    <div class="row">
      @foreach ($video as $item)
        <div class="col-md-4 mb-3">
          <div class="card rounded">
            <div class="card-body mt-3">
              @php
                  $link = explode('=', $item->link);
              @endphp
              <iframe width="100%" height="150px" src="https://www.youtube.com/embed/{{ end($link) }}" frameborder="0" allowfullscreen></iframe>
              
              <hr>
    
              <p class="fw-bold">{{ $item->judul }}</p>

              @if ($item->kode_guru != null)
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
    <p class="mb-0">Jumlah Tugas  : {{ $video->total(); }}</p>
    <p class="mb-0">Data Per Halaman : {{ $video->perPage(); }}</p>
    <div class="d-flex justify-content-center">
      {{ $video->links() }}
    </div>
  @endif
@endsection