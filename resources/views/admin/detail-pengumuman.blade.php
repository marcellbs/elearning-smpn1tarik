@extends('layout.main')

@section('content')

  @include('partials.page-title', ['title' => 'Detail Pengumuman'])

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">
            <h5 class="fw-bold text-dark">Judul</h5>
            <h3 class="ms-4">{{ $pengumuman->judul_pengumuman }}</h3>

            <h5 class="fw-bold text-dark">Deskripsi</h5>
            <p class="ms-4">{!! $pengumuman->deskripsi !!}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection