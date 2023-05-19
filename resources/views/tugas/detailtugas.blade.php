@extends('layout.guru')

@section('content')
@include('partials.page-title', ['title' => 'Detail Tugas'])

{{-- menampilkan judul tugas --}}

<div class="row">
  <div class="col-lg-7">
    <div class="card">
      <div class="card-header p-0 ">
        <h4 class="text-dark fw-bold ms-3 mt-2">{{ $tugas->judul_tugas }}</h4>
      </div>
      <div class="card-body table-responsive mt-3">
        <h6 class="fw-bold">Keterangan</h6>
        <p class="fs-6 ms-3">{{ $tugas->keterangan }}</p>

        <h6 class="fw-bold">Mata Pelajaran</h6>
        <p class="fs-6 ms-3">{{ $tugas->mapel->nama_pelajaran }}</p>
    
        <h6 class="fw-bold">Deadline</h6>
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
    <div class="card">
      <div class="card-body table-responsive mt-3">
        <table class="table table-borderless">
          <tr>
            <th>Mengumpulkan</th>
            <td>{{ $tugas->deskripsi_tugas}}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- menampilkan siswa yang mengumpulkan tugas --}}
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header p-0 ">
        {{-- menampilkan jumlah yang mengumpulkan tugas --}}
        <h4 class="text-dark fw-bold ms-3 mt-2">Siswa yang mengumpulkan ({{ $jawaban->count() }}/36)</h4>
        {{-- <h4 class="text-dark fw-bold ms-3 mt-2">Siswa yang mengumpulkan </h4> --}}
      </div>
      <div class="card-body">
        <div class="table-responsive mt-2">
          <table class="table table-striped datatable" id="datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Tanggal Upload</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($jawaban as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->siswa->nis }}</td>
                <td>{{ ucwords($item->siswa->nama_siswa) }}</td>
                <td>{{ $item->tgl_upload }}</td>
                <td>
                  @if($item->tgl_upload > $item->tugas->deadline)
                    <span class="badge bg-danger">Terlambat</span>
                  @else
                    <span class="badge bg-success">Tepat Waktu</span>
                  @endif
                </td>
                <td>
                  <a href="#" class="btn btn-sm btn-primary">Download</a>
                  <a href="#" class="btn btn-sm btn-warning">Beri Nilai</a>
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