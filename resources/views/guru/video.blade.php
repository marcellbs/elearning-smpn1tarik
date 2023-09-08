@extends('layout.ruangkelas')

@section('content')
  <div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/guru">Home</a></li>
          <li class="breadcrumb-item"><a href="/guru/detail/{{ $hash->encode($pengampu->id) }}">Ruang Kelas</a></li>
          <li class="breadcrumb-item"><a href="/guru/video/{{ $hash->encode($pengampu->id) }}">Video Pembelajaran</a></li>
        </ol>
    </nav>
  </div>

    @if(Auth::guard('webguru')->check())

      <div class="col-md-12 text-end">
        <button type="button" class="btn text-light mb-3" style="background-color:orange;" data-bs-toggle="modal" data-bs-target="#exampleModal">
          <i class="bi bi-plus-circle"></i> Tambah Video
        </button>

        <a href="/guru/materi/shared" class="btn text-light mb-3" style="background-color:orange;"><i class="bi bi-pen"></i> Ubah Video</a>
      </div>

    @endif

    {{-- modal untuk menambah materi --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Materi Kelas {{ $pengampu->kelas->nama_kelas }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            {{-- form untuk menambah materi --}}
            <form method="post" action="{{(Auth::guard('webadmin')->check()) ? '/admin/video' : '/guru/video'}}">
              @csrf 
              <div class="modal-body">
                <div class="form-group">
                  <label for="judul">Judul</label>
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{old('judul')}}">
                  @error('judul')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                  @enderror
                </div>
              
                <div class="form-group">
                  <label for="link">Tautan</label>
                  <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{old('link')}}">
                  @error('link')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                  @enderror
                </div>
                
                <div class="row">
                  <div class="col-3">
                    <div class="form-group">
                      <label for="tingkat">Kelas</label>
                      <select class="form-select @error('tingkat') is-invalid @enderror" name="tingkat" id="tingkat">
                        <option value="{{$pengampu->kelas->nama_kelas[0]}}" selected>{{$pengampu->kelas->nama_kelas[0]}}</option>
                      </select>

                      @error('tingkat')
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>
                      @enderror
    
                    </div>
                  </div>

                  <div class="col-9">
                    <div class="form-group">
                      <label for="mapel">Mata Pelajaran</label>
                      <select class="form-select @error('mapel') is-invalid @enderror" name="mapel" id="mapel">
                        <option value="{{$pengampu->mapel->kode_pelajaran}}" selected>{{$pengampu->mapel->nama_pelajaran}}</option>
                      </select>
                      @error('mapel')
                      <div class="invalid-feedback">
                        {{$message}}
                      </div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <div class="row mt-3 d-flex">
                  <div class="col d-flex">
                    <button type="submit" class="ms-auto btn text-white" style="background-color: orange;">Tambah</button>
                    
                    <button class="btn ms-2" style="color:orange; border: 1px solid orange" data-bs-dismiss="modal">Kembali</button>
              
                  </div>
                </div>
              </div>

            </form>
        </div>
      </div>
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
              @if($item->kode_guru != null)
                <p class="m-0">{{ $item->guru->nama }}</p>
              @else
                <p class="m-0">Administrator</p>
              @endif
              
              <p class="m-0">Kelas {{ $item->tingkat}}</p>
              <p>{{ $item->mapel->nama_pelajaran }}</p>
    
              <small>Dibuat pada : {{ Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}</small>
              
              <hr class="m-1">
              
              <div class="d-flex">
                <a href="/guru/video/{{ $item->id }}" class="btn btn-sm text-white ms-auto" style="background-color: orange;">Detail</a>
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