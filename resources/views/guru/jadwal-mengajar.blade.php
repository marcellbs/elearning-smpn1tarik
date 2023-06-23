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
        @php
            $hariHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        @endphp

        @foreach ($hariHari as $hari)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header py-0 bg-info" style="border-bottom: 1px solid rgb(177, 177, 177);">
                        <h5 class="card-title p-2">{{ Str::ucfirst($hari) }}</h5>
                    </div>
                    <div class="card-body mt-3">
                        @php
                            $jadwalHariIni = $jadwal->where('hari', Str::ucfirst($hari));
                        @endphp

                        @if ($jadwalHariIni->count() > 0)
                            @foreach ($jadwalHariIni as $j)
                                <div class="mb-3">
                                    <h6 class="card-subtitle">{{ $j->nama_pelajaran }}</h6>
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