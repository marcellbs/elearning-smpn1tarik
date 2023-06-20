@extends('layout.guru')

@section('content')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/guru">Home</a></li>
      <li class="breadcrumb-item"><a href="/guru/tugas"></a>Tugas</li>
      <li class="breadcrumb-item active">Report Tugas</li>
    </ol>
  </nav>
</div>

<form action="/guru/tugas/report" method="get">
  <div class="row">
    <p class="mb-0">Pilih Kelas dan Mata Pelajaran</p>
    <div class="col-md-3">
      <select name="kode_kelas" id="kode_kelas"class="form-select">
        <option value="">Pilih Kelas</option>
        @foreach($kelas as $k)
          <option value="{{ $k->kode_kelas }}" {{ $k->kode_kelas == $kodeKelas ? 'selected' : '' }}>
            {{$k->nama_kelas }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <select name="kode_pelajaran" id="kode_pelajaran" class="form-select">
        <option value="">Pilih Mapel</option>
        @foreach($mapel as $m)
          <option value="{{ $m->kode_pelajaran }}" {{ $m->kode_pelajaran == $kodePelajaran ? 'selected' : '' }}>
            {{ $m->nama_pelajaran }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">  
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>


<div class="row mt-3">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive my-3">

          @if($kodeKelas && $kodePelajaran)
            <h4 class="header-title fw-bold">Summary Tugas</h4>
            <a href="{{ route('tugas.export-excel', ['kode_kelas' => $kodeKelas, 'kode_pelajaran' => $kodePelajaran]) }}" class="btn btn-success mt-3">Export Excel</a>
            <table class="table table-borderless">
              <tr>
                <td style="width: 150px">Nama Guru</td>
                <td>:</td>
                <td class="fw-bold">{{ $namaGuru }}</td>
              </tr>
              <tr>
                <td style="width: 150px">Mata Pelajaran</td>
                <td>:</td>
                <td class="fw-bold">{{ $namaMapel}}</td>
              </tr>
              <tr>
                <td style="width: 150px">Kelas</td>
                <td>:</td>
                <td class="fw-bold">{{ $kelas->where('kode_kelas', $kodeKelas)->first()->nama_kelas }}</td>
              </tr>

            </table>

            <table class="table table-bordered">
              <thead>
                  <tr>
                      <th rowspan="2" class="text-center my-auto" style="width: 30px; white-space: nowrap;">NIS</th>
                      <th rowspan="2" class="text-center my-auto"  style="width: 70px; white-space: nowrap;">Nama Siswa</th>
                      @php
                          $totalTugas = count($tugas);
                      @endphp
                      <th colspan="{{ $totalTugas }}" class="text-center">Tugas</th>
                  </tr>
                  <tr>
                      @foreach ($tugas as $t)
                          <th class="text-center" style="width: 30px;">{{ $t->judul_tugas }}</th>
                      @endforeach
                  </tr>
              </thead>
              <tbody>
                  @foreach ($siswa as $sis)
                      <tr>
                          <td class="text-center">{{ $sis->nis }}</td>
                          <td>{{ $sis->nama_siswa }}</td>
                          @foreach ($tugas as $t)
                          @php
                              $jawaban = $t->jawaban->where('kode_siswa', $sis->kode_siswa)->first();
                              $status = $jawaban ? '&#10004;' : '&#10008;';
                              $statusClass = $jawaban ? 'bg-success text-white' : 'bg-danger text-white';
                              $deadline = \Carbon\Carbon::parse($t->deadline);
                              $tglUpload = $jawaban ? \Carbon\Carbon::parse($jawaban->tgl_upload) : null;
                              $isTerlambat = $jawaban && $tglUpload->greaterThan($deadline);
                              $terlambatClass = $isTerlambat ? 'bg-warning text-white' : '';
                          @endphp
                          <td class="text-center">
                            <button class="btn {{ $statusClass }} {{ $terlambatClass }}">
                              {!! $status !!}
                            </button>
                          </td>
                          @endforeach
                      </tr>
                  @endforeach
              </tbody>
            </table>
            <div class="col">
              <button class="btn btn-success d-inline"></button>
              <p class="d-inline ms-1">Mengumpulkan Tepat Waktu</p>
            </div>
            <div class="col">
              <button class="btn btn-warning"></button>
              <p class="d-inline ms-1">Mengumpulkan Terlambat</p>
            </div>
            <div class="col">
              <button class="btn btn-danger d-inline"></button>
              <p class="d-inline ms-1">Tidak mengumpulkan</p>
            </div>
          @else
            <h4 class="header-title fw-bold">Summary Tugas</h4>
            <p>Pilih Kelas dan Mata Pelajaran terlebih dahulu</p>
          @endif
        </div>
        <div class="col d-flex">
          <a href="/guru/tugas" class="btn btn-primary ms-auto">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection