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
                <th>Mata Pelajaran</th>
                <td>:</td>
                <td>{{ $pengampu->mapel->nama_pelajaran }}</td>
              </tr>
              <tr>
                <th>Kelas</th>
                <td>:</td>
                <td>{{ $pengampu->kelas->tingkat->nama_tingkat }}{{ $pengampu->kelas->nama_kelas }}</td>
              </tr>
              
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection