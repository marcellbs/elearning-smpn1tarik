@extends('layout.guru')

@section('content')

{{-- @include('partials.page-title', ['title' => $title]) --}}

<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header card-header-guru">
        <h4 class="mt-2"><strong>{{ $pengampu->mapel->nama_pelajaran }}</strong></h4>
      </div>
      <div class="card-body">
        <div class="table-responsive mt-3">
          <table class="table table-borderless">
            <tr>
              <td>NIP</td>
              <td>:</td>
              <td>{{ $pengampu->guru['nip'] }}</td>
            </tr>
            <tr>
              <td>Nama Guru</td>
              <td>:</td>
              <td>{{ $pengampu->guru->nama }}</td>
            </tr>
            <tr>
              <td>Jadwal</td>
              <td>:</td>
              <td>-</td>
            </tr>
            <tr>
              <td>Kelas</td>
              <td>:</td>
              <td>{{ $pengampu->kelas->tingkat->nama_tingkat }}{{ $pengampu->kelas->nama_kelas }}</td>
            </tr>
          </table>

          <div class="card-footer">
            <div class="row">
              
              <div class="col-10 pe-0 ps-1">
              <form action="">
                @csrf
                <div class="form-group d-flex">
                  <input type="text" name="link" id="link" class="form-control" placeholder="Masukkan link video conference" value="{{ $pengampu->link }}">
                  <button type="submit" class="btn btn-primary mx-1">Simpan</button>
                </div>
              </form>
              </div>
    
              <div class="col-2 p-0">
              <form action="/guru/pengampu/{{ $pengampu->kode_pengampu }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
              </form>
              </div>

            </div>
            {{-- section mulai conference dan presensi --}}
            <div class="row mt-2">
              <div class="col-md-6 ps-1 mt-1">
                <a href="{{ $pengampu->link }}" class="btn btn-warning d-block text-white" target="_blank">Mulai</a>
              </div>
              <div class="col-md-6 mt-1 p-md-0 ps-1 ps-lg-0">
                <a href="#" class="btn btn-outline-warning disabled d-block">Presensi</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <div class="card">
            <h5>Materi yang dibagikan</h5>
            <hr class="hr">
            <table class="table table-borderless">
              <thead>
                <tr>
                  <th>Judul Materi</th>
                  <th>File</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  
                  @foreach ($materi as $m)  
                  <td>{{$m->judul_materi}}</td>
                  <td>
                    <?php 
                      $ext = pathinfo($m->berkas, PATHINFO_EXTENSION);
                    ?>
                    {{-- menampilkan ekstensi file tersebut --}}
                    @if ($ext == 'pdf')
                      <i class="bi bi-file-earmark-pdf text-danger"></i>
                    @elseif ($ext == 'docx')
                      <i class="bi bi-file-earmark-word text-primary"></i>
                    @elseif ($ext == 'pptx')
                      <i class="bi bi-file-earmark-ppt text-danger"></i>
                    @elseif ($ext == 'xlsx')
                      <i class="bi bi-file-earmark-excel text-success"></i>
                    @endif
                  </td>
                  <td>
                    <a href="/guru/materi/{{$m->kode_materi}}" class="text-primary">Lihat</a>
                  </td>
                  @endforeach

                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection