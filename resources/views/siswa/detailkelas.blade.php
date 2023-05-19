@extends('layout.siswa')

@section('content')

  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header card-header-guru">
          <h4><strong>{{ $pengampu->mapel->nama_pelajaran }}</strong></h4>
        </div>
        <div class="card-body">
          <div class="table-responsive mt-3">
            <table class="table table-borderless">
              <tr>
                <td>NIP</td>
                <td>:</td>
                <td>
                  {{ $pengampu->guru->nip }}
                </td>
              </tr>
              <tr>
                <td>Nama Guru</td>
                <td>:</td>
                <td>
                  {{ $pengampu->guru->nama }}
                </td>
              </tr>
              <tr>
                <td>Jadwal</td>
                <td>:</td>
                <td>
                  -
                </td>
              </tr>
              <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>
                  {{ $pengampu->kelas->tingkat->nama_tingkat }}{{ $pengampu->kelas->nama_kelas }}
                </td>
              </tr>
              <tr>
                <td>Tautan</td>
                <td>:</td>
                <td>
                  <a href="{{ $pengampu->link }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-primary">Video Conference</a>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">
            <div class="card">
              <h5><strong>Materi yang dibagikan</strong></h5>
              <hr class="hr">
              <table class="mb-3 datatable" id="datatable">
                <thead>
                  <tr>
                    <th>Judul Materi</th>
                    <th>File</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($materi as $m)
                  <tr>

                      <?php
                        $ext = pathinfo($m->berkas, PATHINFO_EXTENSION);
                      ?>
                      <td>
                        @if ($ext == 'pdf')
                          <i class="bi bi-file-earmark-pdf text-danger"></i>
                        @elseif ($ext == 'docx' || $ext == 'doc')
                          <i class="bi bi-file-earmark-word text-primary"></i>
                        @elseif ($ext == 'pptx' || $ext == 'ppt')
                          <i class="bi bi-file-earmark-ppt text-danger"></i>
                        @elseif ($ext == 'xlsx' || $ext == 'xls')
                          <i class="bi bi-file-earmark-excel text-success"></i>
                        @endif
                        {{ $m->judul_materi }}
                      </td>
                      <td>
                        <a href="{{ asset('siswa/materi/' . $m->kode_materi) }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-primary">Lihat</a>
                      </td>
                      <td>
                        <a href="{{ asset('file/materi/'.$m->berkas) }}" class="ms-auto text-white btn btn-sm mx-2" style="background-color:orange;" download>Download</a> 
                      </td>
                    </tr>
                    @endforeach


                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12 mt-3">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <div class="card">
            <h5 class="mb-0"><strong>Daftar Siswa</strong></h5>
            <p class="text-muted mb-0">Jumlah siswa : {{$siswa->count()}}</p>
            <hr class="hr">
            <table class="table table-striped datatable mb-2" id="datatable"> 
              <thead>
                <tr>
                  <th>No</th>
                  <th>NIS</th>
                  <th>Nama Siswa</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($siswa as $s) 
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$s->nis}}</td>
                  <td>{{ucwords($s->nama_siswa)}}</td>
                  <td>
                    {{ ucwords($s->jenis_kelamin) }}
                  </td>
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