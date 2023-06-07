@extends('layout.guru')

@section('content')

@include('partials.page-title', ['title' => $title])

@if (session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {!! session('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<a href="/guru/tugas/create" class="btn text-white mb-3" style="background-color: #33FF00">Buat tugas baru</a>

<div class="row">
    @if (count($tugas) == 0)
      <div class="alert alert-warning">
        <p class="mb-0">Tidak ada tugas yang dibuat</p>
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
                <h5 class="mt-2"><strong>{{ $t->judul_tugas }}</strong></h5>
              </a>

              <p>{{ $t->keterangan }}</p>
              {{-- batas pengumpulan dimana angka bulan diganti dengan nama bulan dalam bahasa indonesia--}}
              <p class="mb-2">Batas pengumpulan : {{ date('d F Y - H:i', strtotime($t->deadline)) }}</p>
              {{-- <p class="mb-1">Batas pengumpulan : {{ $t->deadline }}</p> --}}
              
          
              <div class="d-flex">
                <div class="mt-2">
                  <span class="badge text-bg-success"> <p class="mb-0">{{ $t->kelas->tingkat->nama_tingkat . $t->kelas->nama_kelas}}</p></span>
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
                  <button type="submit" onclick="return confirm('Apakah anda yakin menghapus tugas ini?')" class="btn btn-danger ms-auto">Hapus Tugas</button>
                </form>

                <a href="/guru/tugas/{{ $t->kode_tugas }}/edit" class="btn ms-2" style="background-color: orange;">Edit Tugas</a>

              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif
</div>

{{-- <div class="row">
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
</div> --}}


@endsection