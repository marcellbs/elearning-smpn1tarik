@extends('layout.siswa')

@section('content')

@include('partials.page-title', ['title' => $title])

<h5 class="fw-bold"><i>Tahun Ajaran {{ $tahunAjaran }}</i></h5>

<form action="{{ '/siswa' }}" method="GET" class="mb-3">
  <div class="row">
    <label for="nama_pelajaran">Cari Nama Pelajaran:</label>
    <div class="col-md-4">
      <div class="form-group">
          <input type="text" name="nama_pelajaran" class="form-control" id="nama_pelajaran" value="{{ request('nama_pelajaran') }}" placeholder="Masukkan Nama Pelajaran">
      </div>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-primary">Cari</button>
    </div>
  </div>
</form>


<div class="container">
  <section class="splide">
    <div class="row">
        <div class="splide__track">
          <ul class="splide__list">
            @foreach ($pengampu as $p)
            <div class="col-md-4 splide__slide">
              {{-- random color in every card --}}
              @php
                $colo = array('#FFB3BA','#FFDFBA','#BAFFC9','#BAE1FF', '#E2BAFF', '#FFBAF2', '#FFBABA', '#e9ff7d');
                $color = $colo[array_rand($colo)];
              @endphp
              <div class="card card-guru h-100" style="border: 1px solid rgb(218, 218, 218); background-color: {{ $color }};">
                <div class="card-body p-0 ps-4">
                  <h5 class="mt-3"><strong>{{$p->mapel->nama_pelajaran}}</strong></h5>
                  <h6 class="card-text mt-3">{{$p->guru->nama}}</h6>
                  <ul>
                    @foreach ($p->jadwal as $j)
                      <li class="card-text">{{ $j->hari }}, {{ $j->jam_mulai }} - {{ $j->jam_berakhir }}</li>
                    @endforeach
                  </ul>
                </div>
                <div class="card-footer p-2 m-0 d-flex border-0 me-2" style="background-color: transparent;">
                  <a href="/siswa/detail/{{($p->id)}}" class="m-0 ms-auto text-dark">Akses Kelas <i class="bi bi-box-arrow-in-right"></i></a>
                </div>
              </div>
            </div>
            @endforeach
          </ul>
        </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
"></script>
<script>
var splide = new Splide( '.splide', {
  // type   : '',
  perPage: 3,
  perMove: 1,
  gap    : '1rem',
  arrows : false,
  breakpoints: {
      640: {
        perPage: 1,
        gap    : '1rem',
      },
      768: {
        perPage: 1,
        gap    : '1rem',
      }
    }
  });


splide.mount();
</script>

@endsection