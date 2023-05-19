@extends('layout.siswa')

@section('content')
@include('partials.page-title', ['title' => 'Detail Tugas'])

{{-- menampilkan judul tugas --}}

<div class="row">
  <div class="col-lg-7">
    {{-- {{ $jawaban->id }} --}}
    <div class="card">
      <div class="card-header p-0 ">
        <h2 class="text-dark fw-bold ms-3 mt-2">{{ $tugas->judul_tugas }}</h2>
      </div>
      <div class="card-body table-responsive mt-3">
        <h6 class="fw-bold">Keterangan</h6>
        <p class="fs-6 ms-3">{{ $tugas->keterangan }}</p>

        <h6 class="fw-bold">Mata Pelajaran</h6>
        <p class="fs-6 ms-3">{{ $tugas->mapel->nama_pelajaran }}</p>
    
        <h6 class="fw-bold">Batas Waktu</h6>
        <p class="fs-6 ms-3">{{ $tgl_indonesia }}</p>

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
  <div class="col-lg-5">
    
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <p>{{ session()->get('success') }}</p>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
      <div class="card-header p-0">
        <h4 class="text-dark fw-bold ms-3 mt-2">Tugas Anda</h4>
      </div>
      <div class="card-body table-responsive mt-3">
        {{-- status mengumpulkan, terlambat, belum mengumpulkan --}}
        {{ $jawaban }}

        <p class="mb-0">Catatan</p>
        {{-- cek apakah keterangan kosong atau tidak --}}
        @if($jawaban && $jawaban->keterangan != null)
          <p class="fs-6 ms-3"> {{ $jawaban->keterangan }} </p>
        @else
          <p class="fs-6 ms-3">Tidak ada catatan</p>
        @endif

        <p class="mb-0">Lampiran</p>
        <div class="card d-flex">
            <div class="row d-flex">
              <div class="col-10">
                @if($jawaban && $jawaban->berkas != null)
                  <p class="fs-6 ms-3 m-2"> {{ $jawaban->berkas }} </p>
                @else
                  <p class="fs-6 ms-3 m-2">Tidak ada lampiran</p>
                @endif
              </div>
              <div class="col-2 m-auto">
                @if($jawaban)
                  <a href="{{ asset('jawaban/'.$jawaban->berkas) }}" download class=""><i class="bi bi-download"></i></a>
                @endif
              </div>
            </div>
        </div>

        {{-- cek apakah sudah ada berkas yang dikirim oleh user yang login jika ada, maka ganti tombol kumpulkan tugas dengan tombol edit tugas--}}
        @if ($jawaban)
          <div class="d-grid gap-4 col-12 mx-auto">
            <a href="/siswa/jawabantugas/{{ $jawaban->id }}/edit" class="btn btn-primary">Edit Tugas</a>
          </div>
        @else
          <div class="d-grid gap-4 col-12 mx-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" type="button">Kumpulkan Tugas</button>
          </div>
        @endif

      </div>
    </div>
  </div>
</div>

{{-- modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $tugas->judul_tugas }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/siswa/jawabantugas" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="kdtugas" value="{{ $tugas->kode_tugas }}">
          <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control" name="catatan" id="catatan" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="lampiran" class="form-label">Lampiran</label>
            <input class="form-control" name="lampiran" type="file" id="lampiran">
          </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> --}}
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>






@endsection