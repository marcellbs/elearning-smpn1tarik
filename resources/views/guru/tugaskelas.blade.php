@extends('layout.ruangkelas')

@section('content')

  <div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/guru">Home</a></li>
          <li class="breadcrumb-item"><a href="/guru/detail/{{ $hash->encode($pengampu->id) }}">Ruang Kelas</a></li>
          <li class="breadcrumb-item active"><a href="/guru/tugas-kelas/{{ $hash->encode($pengampu->id) }}">Tugas {{ $pengampu->mapel->nama_pelajaran }}</a></li>
        </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-md-12 text-end">
          <button type="button" class="btn text-light mb-3" style="background-color:orange;" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-plus-circle"></i> Tambah Tugas
          </button>
        </div>

        {{-- modal tambah tugas --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Buat Tugas Baru | {{ $pengampu->kelas->nama_kelas }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <form action="/guru/tugas" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                  {{-- judul tugas --}}
                  <div class="form-group">
                    <label for="judul_tugas">Judul Tugas</label>
                    <input type="text" name="judul_tugas" id="judul_tugas" class="form-control" placeholder="Masukkan judul tugas" value="{{ old('judul_tugas') }}">
                    @error('judul_tugas')
                    <div class="text-danger mt-1">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>

                  {{-- deskripsi tugas --}}
                  <div class="form-group">
                    <label for="deskripsi_tugas">Deskripsi Tugas</label>
                    <textarea name="deskripsi_tugas" id="deskripsi_tugas" class="form-control" placeholder="Masukkan deskripsi tugas" rows="3">{{ old('deskripsi_tugas') }}</textarea>
                    @error('deskripsi_tugas')
                    <div class="text-danger mt-1">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>

                  {{-- kelas --}}
                  <div class="row">
                    <div class="col-3">
                      <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select name="kelas" id="kelas" class="form-select">
                          <option value="{{ $pengampu->kelas->kode_kelas }}" selected>{{ $pengampu->kelas->nama_kelas }}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-9">
                      <div class="form-group">
                        <label for="mapel">Mata Pelajaran</label>
                        <select name="mapel" id="mapel" class="form-select">
                          <option value="{{ $pengampu->mapel->kode_pelajaran }}" selected>{{ $pengampu->mapel->nama_pelajaran }}</option>
                        </select>
                      </div>
                    </div>
                  </div>
                    
                  {{-- deadline --}}
                  <div class="form-group">
                    <label for="deadline">Deadline</label>
                    <input type="datetime-local" name="deadline" id="deadline" class="form-control" value="{{ old('deadline') }}">
                    @error('deadline')
                    <div class="text-danger mt-1">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>

                  {{-- berkas --}}
                  <div class="form-group">
                    <label for="berkas">Berkas</label>
                    <input type="file" name="berkas" id="berkas" class="form-control @error('berkas') is-invalid @enderror">
                    <div id="file-name"></div>
                    @error('berkas')
                    <div class="text-danger mt-1">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                  <button type="submit" class="btn btn-primary">Buat Tugas</button>
                </div>
              </form>


            </div>
          </div>
        </div>

        @if(count($tugas) == 0 )
          <div class="col-md-12">
            <div class="alert alert-warning" role="alert">
              <h4 class="alert-heading text-center">Belum tugas yang dibuat</h4>
            </div>
          </div>
        @else
  
          @foreach ($tugas as $t)
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex mt-2">
                    <span class="badge text-bg-primary ms-auto ">{{ $t->mapel->nama_pelajaran }}</span>
                  </div>
                  <a href="/guru/tugas/{{ $t->kode_tugas }}">
                    <h5 class="mt-2"><strong>{{ $t->judul_tugas }} - {{$t->kelas->nama_kelas}}</strong></h5>
                  </a>
  
                  <p>{{ $t->keterangan }}</p>
                  
                  @php
                    $deadline = $t->deadline;
                    \Carbon\Carbon::setLocale('id');
                    $deadline = \Carbon\Carbon::parse($deadline)->translatedFormat('l, d F Y');
                  @endphp
                  <p class="mb-2">Batas pengumpulan : {{ $deadline }}</p>
  
                  <p class="mb-2">
                    Mengumpulkan : {{ $t->getJumlahSiswaMengumpulkanAttribute() }} / {{ $jumlahSiswaKelas  }}
                  </p>
                  
                  <div class="d-flex">
                    <div class="mt-2">
                      <span class="badge text-bg-success"> <p class="mb-0">{{ $t->kelas->nama_kelas}}</p></span>
                    </div>
                    
                    @if($t->berkas != null)
                    <div class="mt-2 ms-1">
                      <span class="badge text-bg-warning"> <p class="mb-0"> <i class="bi bi-link-45deg"></i> Lampiran</p></span>
                    </div>
                    @endif
  
                    {{-- delete --}}
                    <form action="/guru/tugas/{{ $t->kode_tugas }}" method="post" class="d-inline ms-auto">
                      @csrf
                      @method('delete')
                      <button type="submit" onclick="return confirm('Apakah anda yakin menghapus tugas ini?')" class="btn btn-sm btn-danger ms-auto">Hapus Tugas</button>
                    </form>
  
                    <a href="/guru/tugas/{{ $t->kode_tugas }}/edit" class="btn btn-sm ms-2" style="background-color: orange;">Edit Tugas</a>
  
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>

  <p class="mb-0">Halaman : {{ $tugas->currentPage(); }}</p>
  <p class="mb-0">Jumlah Tugas  : {{ $tugas->total(); }}</p>
  <p class="mb-0">Data Per Halaman : {{ $tugas->perPage(); }}</p>

  <div class="d-flex justify-content-center mt-3">
    {{ $tugas->links() }}
  </div>

@endsection