@extends('layout.ruangkelas')

@section('content')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/guru">Home</a></li>
        <li class="breadcrumb-item"><a href="/guru/detail/{{ $hash->encode($pengampu->id) }}">Ruang Kelas</a></li>
        <li class="breadcrumb-item active"><a href="/guru/rekap-tugas-kelas/{{ $hash->encode($pengampu->id) }}">Tugas {{ $pengampu->mapel->nama_pelajaran }}</a></li>
      </ol>
  </nav>
</div>

<div class="row mt-3">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive my-3">

          <a href="{{ route('tugas.export-excel', [
              'kode_kelas' => $pengampu->kelas->kode_kelas, 
              'kode_pelajaran' => $pengampu->mapel->kode_pelajaran, 
              'tahun_ajaran' => $pengampu->tahunAjaran->id,
              ]) }}" class="btn btn-success mt-3">Export Excel</a>

          <table class="table table-borderless">
            <tr>
              <td style="width: 150px">Nama Guru</td>
              <td>:</td>
              <td class="fw-bold">{{ $pengampu->guru->nama }}</td>
            </tr>
            <tr>
              <td style="width: 150px">Mata Pelajaran</td>
              <td>:</td>
              <td class="fw-bold">{{ $pengampu->mapel->nama_pelajaran }}</td>
            </tr>
            <tr>
              <td style="width: 150px">Kelas</td>
              <td>:</td>
              <td class="fw-bold">{{ $pengampu->kelas->nama_kelas }}</td>
            </tr>
            <tr>
              <td style="width: 150px">Tahun Ajaran</td>
              <td>:</td>
              <td class="fw-bold">{{ $pengampu->tahunAjaran->tahun_ajaran }}</td>
            </tr>
            <tr>
              <td style="width: 150px">Jumlah Siswa</td>
              <td>:</td>
              <td class="fw-bold">{{ $jumlahSiswaKelas }} orang</td>
            </tr>

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


          <table class="table table-bordered">
            <thead>
              <tr>
                <th rowspan="2" class="text-center my-auto" style="width: 30px; white-space: nowrap;">NIS</th>
                <th rowspan="2" class="text-center my-auto" style="width: 70px; white-space: nowrap;">Nama Siswa</th>
                <th colspan="{{ $tugas->count() }}" class="text-center">Tugas</th>
              </tr>
              <tr>
                @foreach ($tugas as $item)
                  <th class="text-center" style="width: 30px;">{{ $item->judul_tugas }}</th>
                @endforeach
            </thead>
            <tbody>
              @foreach ($siswa as $s)
                <tr>
                  <td class="text-center">{{ $s->nis }}</td>
                  <td>{{ $s->nama_siswa }}</td>
                  @foreach ($tugas as $t)
                    
                    @php 
                      $jawaban = $t->jawaban->where('kode_siswa', $s->kode_siswa)->first();
                      $status = $jawaban ? '&#10004;' : '&#10008;';
                      $statusClass = $jawaban ? 'bg-success text-white' : 'bg-danger text-white';
                      $deadline = \Carbon\Carbon::parse($t->deadline);
                      $tglUpload = $jawaban ? \Carbon\Carbon::parse($jawaban->created_at) : null;
                      $telat = $jawaban && $tglUpload->greaterThan($deadline) ? 'telat' : '';
                      $terlambatClass = $jawaban && $jawaban->terlambat ? 'bg-warning text-white' : '';
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
        </div>
      </div>
    </div>
  </div>
</div>

@endsection