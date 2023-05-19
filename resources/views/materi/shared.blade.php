@extends('layout.guru')

@section('content')
@include('partials.page-title', ['title' => $title])

{{-- menampilkan materi yang dibagikan --}}

<div class="row">
  {{-- jika tidak ada materi yang bagikan --}}
  @if (count($materi) == 0)
    <div class="alert alert-light" role="alert">
      <h4 class="alert-heading">Tidak ada materi yang dibagikan</h4>
      <p>Silahkan tambahkan materi terlebih dahulu</p>
      <hr>
      <a href="/guru/materi/create" class="btn btn-primary">Tambah Materi</a>
    </div>
  @endif
  
  @foreach ($materi as $m)
    <div class="col-md-4">
      <div class="card mb-3 rounded-2">
        <div class="card-header-shared">
          <h5 class="card-title-shared">{{$m->judul_materi}}</h5>
          <h6 class="card-subtitle text-muted"><i>{{$m->mapel->nama_pelajaran}}</i></h6>
        </div>
        <hr class="hr">
        <div class="card-body">
          <p class="card-text">{{$m->keterangan}}</p>
          <a href="/guru/materi/{{$m->kode_materi}}" class="card-link btn text-white" style="background-color: orange;"><i class="bi bi-eye"></i></a>
          {{-- delete --}}
          <form action="/guru/materi/{{$m->kode_materi}}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="bi bi-trash"></i></button>
          </form>
        </div>
      </div>
    </div>
  @endforeach
  
</div>


@endsection