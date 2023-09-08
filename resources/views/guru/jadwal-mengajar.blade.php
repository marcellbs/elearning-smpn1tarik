@extends('layout.guru')

@section('content')
  <div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/guru">Home</a></li>
        <li class="breadcrumb-item active"><a href="/guru/jadwal-mengajar">Jadwal Mengajar</a></li>
      </ol>
    </nav>
  </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Jadwal Mengajar</h4>
                <ul>
                    <li>Jadwal mengajar yang tersedia adalah jadwal yang terbaru berdasarkan tahun ajaran ini</li>
                    <li>Jadwal ini dapat berubah sewaktu-waktu apabila diperlukan</li>
        
                </ul>
            </div>
        </div>

        @php
            $hariHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
            $backgroundColor = ['#007bff', '#6610f2', '#6f42c1', '#e83e8c', '#dc3545', '#fd7e14']
        @endphp

        @foreach ($hariHari as $hari)
            <div class="col-md-4 mb-3">
                <div class="card">
                    {{-- background color --}}
                    @php
                        // warna urut sesuai hari
                        $randomColor = $backgroundColor[array_search($hari, $hariHari)];
                    @endphp
                    <div class="card-header fw-bold" style="background-color: {{ $randomColor }}; color: white">
                        {{ Str::ucfirst($hari) }}
                    </div>
                    <div class="card-body mt-3">
                        @php
                            $jadwalHariIni = $jadwal->where('hari', Str::ucfirst($hari));
                        @endphp

                        @if ($jadwalHariIni->count() > 0)
                            @foreach ($jadwalHariIni as $j)
                                <div class="mb-3">
                                    <h6 class="card-subtitle fw-bold">{{ $j->nama_pelajaran }}</h6>
                                    <p class="card-text">Kelas: {{ $j->nama_kelas }}</p>
                                    <p class="card-text">Jam: {{ $j->jam_mulai }} - {{ $j->jam_berakhir }}</p>
                                </div>
                                <hr>
                            @endforeach
                        @else
                            <p class="card-text">Tidak ada jadwal mengajar</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div>


@endsection