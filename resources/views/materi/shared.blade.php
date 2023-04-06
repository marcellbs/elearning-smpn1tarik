@extends('layout.guru')

@section('content')
@include('partials.page-title', ['title' => $title])

{{-- menampilkan materi yang dibagikan --}}

<div class="row">
  <div class="col-md-4">
    @foreach ($materi as $m)
      <div class="card mb-3 rounded-2">
        <div class="card-header-shared">
          <h5 class="card-title-shared">{{$m->judul_materi}}</h5>
          <h6 class="card-subtitle text-muted"><i>{{$m->mapel->nama_pelajaran}}</i></h6>
        </div>
        <hr class="hr">
        <div class="card-body">
          <p class="card-text">{{$m->keterangan}}</p>
          <a href="/guru/materi/{{$m->kode_materi}}" class="card-link">Lihat Materi</a>
        </div>
      </div>
    @endforeach
  </div>
</div>


@endsection