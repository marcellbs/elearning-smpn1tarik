@extends('layout.ruangkelassiswa')

@section('content')
  <div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/siswa">Home</a></li>
          <li class="breadcrumb-item"><a href="/siswa/detail/{{ $hash->encode($pengampu->id) }}">Ruang Kelas</a></li>
          <li class="breadcrumb-item active"><a href="/siswa/materi/{{ $hash->encode($pengampu->id) }}">Materi Pelajaran {{ $pengampu->mapel->nama_pelajaran }}</a></li>
        </ol>
    </nav>
  </div>

  <div class="row">

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

            {{-- Download --}}
            <div class="col-2">
                {{-- <a href="/file/materi/{{ $m->berkas}}" class="btn mx-2 mb-2" style="background-color: white; color: orange; border: 1px solid orange;" download><i class="bi bi-download"></i></a> --}}

                <div class="col-2">
                  <a href="/siswa/materi/{{ $m->kode_materi }}" class="btn mx-2 mb-2" style="background-color: white; color: orange; border: 1px solid orange;"><i class="bi bi-eye"></i></a>
              </div>
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