@extends('layout.siswa')

@section('content')
  <div class="row">
    <div class="col-md-10">
      @include('partials.page-title', ['title' => 'Detail Tugas'])
    </div>
    <div class="col-md-2 d-grid my-auto">
      <a href="/siswa/tugas" class="btn btn-block gap-2 btn-primary">Kembali</a>
    </div>
  </div>

  {{-- {{ $tugas->kode_tugas_jawaban }} --}}

  <div class="row mt-3">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header p-0">
          <h4 class="text-dark fw-bold mx-3 mt-2">{{ $tugas->judul_tugas }}</h4>
        </div>
        <div class="card-body table-responsive mt-3">
          <h6 class="fw-bold">Keterangan</h6>
          <p class="fs-6 ms-3">{{ $tugas->keterangan }}</p>
          
          <h6 class="fw-bold">Guru</h6>
          <p class="fs-6 ms-3">{{ $tugas->guru->nama }}</p>
          
          <h6 class="fw-bold">Mata Pelajaran</h6>
          <p class="fs-6 ms-3">{{ $tugas->mapel->nama_pelajaran }}</p>
          
          <h6 class="fw-bold">Batas Waktu</h6>
          <p class="fs-6 ms-3">{{ date('d F Y - H:i', strtotime($tugas->deadline)) }}</p>
          
          <h6 class="fw-bold">File</h6>
          @if ($tugas->berkas == null)
            <p class="fs-6 ms-3">Tidak ada file lampiran</p>
          @else
            <div class="row">
              <div class="col-sm-12 col-md-10 col-lg-10">

                <div class="card">
                  <div class="card-body p-2 m-1">

                    <div class="row">

                      <div class="col-2 p-0 d-flex">
                        <h4 class="mx-auto my-auto">
                          <i class="bi bi-paperclip"></i>
                        </h4>
                          
                      </div>
                      <div class="col-8 p-0">
                        <p class="m-0">{{ $tugas->berkas }}</p>
                      </div>
                      
                      <div class="col-2 p-0 d-flex">
                        <h4 class="m-auto">
                          <a href="{{ asset('tugas/'.$tugas->berkas) }}" download class=""><i class="bi bi-download"></i></a>
                        </h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div> 
            </div> 
          @endif

        </div>
      </div>
    </div>
    <div class="col-lg-4">
      {{-- alerts --}}
      @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <p>{{ session()->get('success') }}</p>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      {{-- card --}}
      
        <div class="card">
          <div class="card-header p-0">
            <h4 class="text-dark fw-bold mx-3 mt-2">
              Tugas Anda
            </h4>
          </div>
          <div class="card-body table-responsive mt-3">
            {{-- status --}}
            @if($jawaban == null)
              <p class="fs-6 text-danger"> <i class="bi bi-x-circle"></i> Belum Mengumpulkan</p>
            @elseif($jawaban->tgl_upload > $tugas->deadline)
              <p class="fs-6" style="color: orangered;"><i class="bi bi-exclamation-triangle"></i> Terlambat</p>
            @elseif($jawaban->tgl_upload <= $tugas->deadline)
              <p class="fs-6 text-success"><i class="bi bi-check-all"></i> Sudah Mengumpulkan</p>
            @endif

            {{-- catatan --}}
            @if($jawaban == null)
              <h6 class="fw-bold">Catatan</h6>
              <p class="fs-6 ms-3">Tidak ada catatan</p>
            @elseif($jawaban->keterangan == null)
              <h6 class="fw-bold">Catatan</h6>
              <p class="fs-6 ms-3">Tidak ada catatan</p>
            @elseif($jawaban->keterangan != null)
              <h6 class="fw-bold">Catatan</h6>
              <p class="fs-6 ms-3">{{ $jawaban->keterangan }}</p>
            @endif

            {{-- file --}}
            <h6 class="fw-bold">Lampiran</h6>

            <div class="card d-flex mb-1">
              <div class="row d-flex">
                <div class="col-10">
                  @if($jawaban == null)
                    <p class="fs-6 ms-3 m-2">tidak ada lampiran</p>
                  @else
                    <p class="fs-6 ms-3 m-2">{{ $jawaban->berkas }}</p>
                  @endif
                </div>
              </div>
            </div>
            
          </div>
          @if($jawaban != null)
            <div class="d-grid gap-4 col-12 mx-auto mb-2 px-2">
              <a href="{{ asset('jawaban/'.$jawaban->berkas) }}" download class="btn btn-primary">Download</a>
            </div>
            <div class="d-grid gap-4 col-12 mx-auto mb-3 px-2">
              <button type="button" class="btn text-white" style="background-color: orange;" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $jawaban->id }}">
                Ubah Tugas
              </button>
            </div>
          @else
            <div class="d-grid gap-4 col-12 mx-auto mb-3 px-2">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Kumpulkan Tugas
              </button>
            </div>
          @endif
        </div>
      

    </div>
  </div>

  {{-- modal --}}
  @if($jawaban == null)
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Kumpulkan Tugas</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
          <form action="/siswa/tugas" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div class="alert alert-primary" role="alert">
                  <h4 class="alert-heading">Perhatian!</h4>
                  <ul>
                    <li>Wajib untuk mengunggah berkas.</li>
                    <li>Format berkas yang diizinkan adalah pdf, doc/docx, xls/xlsx, ppt/pptx, txt</li>
                  </ul>
                </div>
              {{-- form --}}
                <input type="hidden" name="kdtugas" value="{{ $tugas->kode_tugas }}">
                <div class="mb-3">
                  <label for="keterangan" class="form-label">Catatan</label>
                  <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                </div>
                <div class="mb-3">
                  <label for="berkas" class="form-label">Lampiran</label>
                  <input class="form-control @error('berkas') is-invalid @enderror" type="file" id="berkas" name="berkas">
                  @error('berkas')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Kumpulkan</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  @elseif($jawaban)
    <div class="modal fade" id="exampleModal{{ $jawaban->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Tugas</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
          <form action="/siswa/tugas/{{ $jawaban->id }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="modal-body">
                <div class="alert alert-primary" role="alert">
                  <h4 class="alert-heading">Perhatian!</h4>
                  <ul>
                    <li>Wajib untuk mengunggah berkas.</li>
                    <li>Format berkas yang diizinkan adalah pdf, doc/docx, xls/xlsx, ppt/pptx, txt</li>
                  </ul>
                </div>
              {{-- form --}}
                <input type="hidden" name="kdtugas" value="{{ $tugas->kode_tugas }}">
                <div class="mb-3">
                  <label for="keterangan" class="form-label">Catatan</label>
                  <textarea class="form-control" id="keterangan" name="keterangan" rows="3">
                    @php 
                      echo $jawaban->keterangan;
                    @endphp
                  </textarea>
                </div>
                <div class="mb-3">
                  <label for="berkas" class="form-label">Lampiran</label>
                  <input class="form-control @error('berkas') is-invalid @enderror" type="file" id="berkas" name="berkas" value="{{ $jawaban->berkas }}">
                  @error('berkas')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Ubah</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  @endif



  {{-- cek apakah ada jawaban atau tidak --}}

  

@endsection