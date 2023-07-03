@extends('layout.siswa')

@section('content')
  <div class="pagetitle">
    <h1>Jadwal Pelajaran</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/siswa">Home</a></li>
        <li class="breadcrumb-item active"><a href="/siswa/jadwal-online">Jadwal Pelajaran</a></li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="alert alert-info" role="alert">
        <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Jadwal Pelajaran</h4>
        <ul>
            <li>Jadwal pelajaran yang tersedia adalah jadwal yang terbaru berdasarkan tahun ajaran ini</li>
            <li>Jadwal pelajaran dapat berubah sewaktu-waktu apabila diperlukan</li>

        </ul>
    </div>

    @php
        $hariHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
    @endphp

    @foreach ($hariHari as $hari)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header py-0 bg-info" style="border-bottom: 1px solid rgb(177, 177, 177);">
                    <h5 class="card-title p-2">{{ ucfirst(strtolower($hari)) }}</h5>
                </div>
                <div class="card-body mt-3">
                    @php
                        $jadwalHariIni = $jadwal->where('hari', ucfirst($hari) );
                    @endphp

                    @if ($jadwalHariIni->count() > 0)
                        @foreach ($jadwalHariIni as $j)
                            <div class="mb-3">
                                <h5 class="card-subtitle mb-3 fw-bold">{{ $j->nama_pelajaran }}</h5>
                                <p class="card-text m-0">Guru: {{ $j->nama }}</p>
                                <p class="card-text">Jam: {{ $j->jam_mulai }} - {{ $j->jam_berakhir }}</p>
                            </div>
                            <hr>
                        @endforeach
                    @else
                        <p class="card-text"><i>Tidak ada jadwal pelajaran</i></p>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection