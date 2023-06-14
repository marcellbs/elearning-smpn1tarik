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
                <th>Kelas </th>
                <td>:</td>
                <td> {{ $pengampu->kelas->tingkat->nama_tingkat }}{{ $pengampu->kelas->nama_kelas }}</td>
              </tr>
              <tr>
                <th>Jadwal </th>
                <td>:</td>
                <td> {{ $pengampu->hari}}, {{ $pengampu->jam_mulai }} - {{ $pengampu->jam_berakhir }}</td>
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
                <th>NIS</th>
                <th>Nama Siswa</th>
              </tr>
              @foreach ($pengampu->kelas->siswa as $siswa)
              <tr>
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