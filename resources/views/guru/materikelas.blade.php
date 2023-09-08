@extends('layout.ruangkelas')

@section('content')
  <div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/guru">Home</a></li>
          <li class="breadcrumb-item"><a href="/guru/detail/{{ $hash->encode($pengampu->id) }}">Ruang Kelas</a></li>
          <li class="breadcrumb-item active"><a href="/guru/materi/{{ $hash->encode($pengampu->id) }}">Materi Pelajaran {{ $pengampu->mapel->nama_pelajaran }}</a></li>
        </ol>
    </nav>
  </div>

  <div class="row">
    
    @if(Auth::guard('webguru')->check())
      <div class="col-md-12 text-end">
        <button type="button" class="btn text-light mb-3" style="background-color:orange;" data-bs-toggle="modal" data-bs-target="#exampleModal">
          <i class="bi bi-plus-circle"></i> Tambah Materi
        </button>

        <a href="/guru/materi/shared" class="btn text-light mb-3" style="background-color:orange;"><i class="bi bi-pen"></i> Ubah Materi</a>
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
            <form method="post" action="{{(Auth::guard('webadmin')->check()) ? '/admin/materi' : '/guru/materi'}} " enctype="multipart/form-data">
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
                  <label for="deskripsi">Deskripsi</label>
                  <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{old('deskripsi')}}</textarea>
                  @error('deskripsi')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                  @enderror
                </div>
                
                <div class="row">
                  <div class="col-3">
                    <div class="form-group">
                      <label for="kelas">Kelas</label>
                      <select class="form-select @error('kelas') is-invalid @enderror" name="kelas" id="kelas">
                      
                        <option value="{{$pengampu->kelas->nama_kelas[0]}}" selected>{{$pengampu->kelas->nama_kelas[0]}}</option>
                      </select>
                      @error('kelas')
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
              
                <div class="form-group">
                  <label for="file">File</label>
                  <input class="form-control @error('file') is-invalid @enderror" type="file" id="file" name="file">
                  @error('file')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                  @enderror
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

    @if($materi->isEmpty())
      <div class="col-md-12">
        <div class="alert alert-warning" role="alert">
          <h4 class="alert-heading text-center">Belum ada materi yang dibagikan</h4>
        </div>
      </div>
    @endif

    @foreach ($materi as $m)
      <div class="col-md-4 mb-3">

        <div class="card rounded h-100">
          <div class="card-body m-1 p-2">
            <span class="badge rounded-pill" style="background-color: orange;">{{ $m->mapel->nama_pelajaran }}</span>
            <span class="badge rounded-pill" style="background-color: orange;">{{ 'kelas '. $m->tingkat }}</span>
            <h5 class="card-title">{{ $m->judul_materi }}</h5>
            {{-- tanggal dibuat dengan format tanggal, bulan tahun jam:menit--}}
            <p class="card-text"><small class="text-muted fst-italic">Dibuat pada {{ Carbon\Carbon::parse($m->created_at)->format('d M Y, H:i') }}</small></p>
          </div>

          <div class="row">
            {{-- Edit --}}
            
            @if(Auth::guard('webadmin')->check())
            <div class="col-2">
                <a href="/admin/materi/{{$m->kode_materi}}/edit" class="btn mx-2 mb-2" style="background-color: white; color:orange; border: 1px solid orange;"><i class="bi bi-pen"></i></a>
            </div>
            @endif

            {{-- View --}}
            <div class="col-2">
              
              @if(Auth::guard('webguru')->check())
                <a href="/guru/materi/{{ $m->kode_materi }}" class="btn mx-2 mb-2" style="background-color: white; color: orange; border: 1px solid orange;"><i class="bi bi-eye"></i></a>
              @elseif(Auth::guard('webadmin')->check())
                <a href="/admin/materi/{{ $m->kode_materi }}" class="btn mx-2 mb-2" style="background-color: white; color: orange; border: 1px solid orange;"><i class="bi bi-eye"></i></a>
              @endif

            </div>

            {{-- Download --}}
            <div class="col-2">
              @if(Auth::guard('websiswa')->check() || Auth::guard('webguru')->check())
                <a href="/file/materi/{{ $m->berkas}}" class="btn mx-2 mb-2" style="background-color: white; color: orange; border: 1px solid orange;" download><i class="bi bi-download"></i></a>
              @endif
              
            
              {{-- Hapus --}}
              @if(Auth::guard('webadmin')->check())
                <form action="/admin/materi/{{$m->kode_materi}}" method="post" class="d-inline">
                  
                  @method('delete')
                  @csrf
                  <button type="submit" class="btn mx-2 mb-2" style="background-color: white; color: orange; border: 1px solid orange;" onclick="return confirm('{{ __('apakah anda yakin untuk menghapus data ini ?') }}')"><i class="bi bi-trash"></i></button>
                </form>
              @endif
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

  <p class="mb-0">Halaman : {{ $materi->currentPage(); }}</p>
  <p class="mb-0">Jumlah  : {{ $materi->total(); }}</p>
  <p class="mb-0">Data Per Halaman : {{ $materi->perPage(); }}</p>
  <div class="d-flex justify-content-center">
    {{ $materi->links() }}
  </div>
  
@endsection