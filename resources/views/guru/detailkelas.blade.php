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
            <tr>
              <td>Tautan</td>
              <td>:</td>
              <td>
                {{ $pengampu->link . " " }}
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $pengampu->id }}">
                  <i class="bi bi-pencil-square"></i>
              </button>
            </td>
            </tr>
          </table>

          <div class="card-footer">
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
            <h5><strong>Materi yang dibagikan</strong> </h5>
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
                
                @foreach ($materi as $m)  
                <tr>
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
                </tr>
                  @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- nama siswa --}}
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
                  <th>Jenis Kelamin</th>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal{{ $pengampu->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/guru/detail/{{ $hash->encode($pengampu->id) }}" method="post">
              @csrf
              @method('put')
              <div class="mb-3">
                <label for="link" class="form-label">Link</label>
                <input type="text" class="form-control" id="link" name="link" value="{{ $pengampu->link }}">
              </div>

              <input type="hidden" name="id" value="{{ $pengampu->id }}">
              <input type="hidden" name="kode_guru" value="{{ $pengampu->kode_guru }}">
              
              
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
        </div>
      </div>
    </div>
</div>

@endsection