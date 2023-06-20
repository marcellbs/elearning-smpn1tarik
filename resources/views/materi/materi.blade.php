{{-- cek menggunakan layout main atau guru --}}
@extends((Auth::guard('webguru')->check()) ? 'layout.guru' : 'layout.main')

{{-- title --}} 

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
            <form action="{{ Auth::guard('webguru')->check() ? '/guru/materi' : '/admin/materi'}}" method="get">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari Materi" name="search" aria-label="Cari Materi" aria-describedby="button-addon2">
                <button class="btn text-white" style="background-color: orange;" type="submit" id="button-addon2">Cari</button>
              </div>
            </form>
          </div>

          <div class="col-xxl-6 col-md-6">

            @if (Auth::guard('webguru')->check())
              <a href="/guru/materi/create" class="btn text-light mb-2" style="background-color:orange;">Tambah Materi</a>
              <a href="/guru/materi/shared" class="btn text-light mb-2" style="background-color:orange;">Materi yang dibagikan</a>
            @elseif(Auth::guard('webadmin')->check())
              <a href="/admin/materi/create" class="btn text-light mb-2" style="background-color:orange;">Tambah Materi</a>
            @endif

          </div>

          <form action="{{ Auth::guard('webguru')->check() ? '/guru/materi' : '/admin/materi'}}" method="get">
            <div class="row">
              {{-- <div class="col-xxl-4 col-md-4">
                <div class="input-group mb-3">
                  <select class="form-select" name="kode_tingkat" id="inputGroupSelect02">
                    <option value="" selected>Pilih Kelas</option>
                    @foreach ($tingkatOptions as $kodeTingkat => $namaTingkat)
                        <option value="{{$kodeTingkat}}" {{ $kodeTingkat == request('kode_tingkat') ? 'selected' : '' }}>
                            {{ $namaTingkat }}
                        </option>
                    @endforeach
                  </select>
                  
                </div>
              </div> --}}
  
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

        @if (session()->has('sukses'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! session('sukses') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        
        <div class="row">
          @if($materi->isEmpty())
            <div class="col-md-12">
              <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Tidak ada materi</h4>
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
      </div>
    </div>
  </section>
</div>

@endsection
