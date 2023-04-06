@extends('layout.guru')

@section('content')

@include('partials.page-title', ['title' => $title])

<a href="#" class="btn text-white mb-3" style="background-color: #33FF00">Buat tugas baru</a>

<div class="row">
  <div class="col-md-6">
  {{-- cek apakah ada atau tidak tugas yang dibuat oleh guru yang login --}}
  @if (count($tugas) == 0)
    <div class="alert alert-warning">
      <p class="mb-0">Tidak ada tugas yang dibuat</p>
    </div>
  @else
    @foreach ($tugas as $t)
      <div class="card">
        <div class="card-body">
          <div class="d-flex mt-2">
            <span class="badge text-bg-primary ms-auto">{{ $t->pengampu->mapel->nama_pelajaran }}</span>
          </div>
          <h5 class="mb-2"><strong>{{ $t->judul_tugas }}</strong></h5>

          <p>{{ $t->keterangan }}</p>
          <p class="mb-1">Batas pengumpulan : {{ $t->deadline }}</p>
          <p>Mengumpulkan : 28/36</p>
      
          <div class="d-flex">
            
            <span class="badge text-bg-success"> <p class="mb-0">{{ $t->pengampu->kelas->tingkat->nama_tingkat . $t->pengampu->kelas->nama_kelas }}</p></span>
            <a href="#" class="btn btn-danger ms-auto">Hapus Tugas</a>
            <a href="#" class="btn ms-2" style="background-color: orange;">Hapus Tugas</a>
          </div>
        </div>
      </div>
    @endforeach
  @endif
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex mt-2">
          <span class="badge text-bg-primary ms-auto">Bahasa Inggris</span>
        </div>
        <h5 class="mb-2"> <strong>Tugas 1</strong> </h5>

        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
        <p class="mb-1">Batas pengumpulan : 14 Desember 2022 - 15:00</p>
        <p>Mengumpulkan : 28/36</p>
    
        <div class="d-flex">
          
          <span class="badge text-bg-success"> <p class="mb-0">9A</p></span>
          <a href="#" class="btn btn-danger ms-auto">Hapus Tugas</a>
          <a href="#" class="btn ms-2" style="background-color: orange;">Hapus Tugas</a>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection