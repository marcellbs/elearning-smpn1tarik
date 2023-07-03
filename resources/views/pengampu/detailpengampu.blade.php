@extends('layout.main')

@section('content')
  @include('partials.page-title', ['title' => $title])


  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">
            <table>
              <tr>
                <th>Nama Guru</th>
                <td>:</td>
                <td>{{ $pengampu->guru->nama }}</td>
              </tr>
              <tr>
                <th>Mata Pelajaran </th>
                <td>:</td>
                <td> {{ $pengampu->mapel->nama_pelajaran }}</td>
              </tr>
              <tr>
                <th>Tahun Ajaran </th>
                <td>:</td>
                <td> {{ $pengampu->tahunAjaran->tahun_ajaran }}</td>
              </tr>
              <tr>
                <th>Kelas </th>
                <td>:</td>
                <td>{{ $pengampu->kelas->nama_kelas }}</td>
              </tr>
              <tr>
                <th>Jadwal </th>
                <td>:</td>
                <td>
                  <ul>
                    @foreach ($pengampu->jadwal as $jadwal)
                      <li>{{ $jadwal->hari }} {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_berakhir }}</li>
                    @endforeach
                  </ul>
                </td>
              </tr>
              
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">
            <table class="table table-bordered">
              <tr>
                <th colspan="3" class="text-center">Daftar Siswa Kelas {{ $pengampu->kelas->nama_kelas }}</th>
              </tr>
              <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
              </tr>
              @php
                // mengurutkan siswa berdasarkan nis
                $siswas = $kelas_siswa->sortBy('nis');
              @endphp
              @foreach ($siswas as $siswa)
              <tr>

                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $siswa->nis }}</td>
                  <td>{{ $siswa->nama_siswa}}</td>
              </tr>
              @endforeach
            </table>
          </div>
          <div class="d-flex">
            <a href="/admin/pengampu" class="btn btn-primary mt-3 ms-auto">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection