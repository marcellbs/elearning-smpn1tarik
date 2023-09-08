@extends('layout.guru')

@section('content')
  @include('partials.page-title', ['title' => $title])

  <h5 class="fw-bold"><i>Tahun Ajaran {{ $tahunAjaran->tahun_ajaran }}</i></h5>

  <!-- Tambahkan kode berikut sebelum tabel -->
  <form action="{{ '/guru' }}" method="GET" class="mb-2">
    <div class="row">
      <div class="col-lg-3 col-md-4 mb-3">
        <div class="input-group">
          <select name="kode_kelas" id="kode_kelas" class="form-select">
            <option value="">-- Pilih Kelas --</option>
            @foreach($kelasOptions as $kodeKelas => $namaKelas)
              <option value="{{ $kodeKelas }}" {{ request('kode_kelas') == $kodeKelas ? 'selected' : '' }}>
                {{ $namaKelas }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 mb-3">
        <div class="input-group">
          <select name="kode_pelajaran" id="kode_pelajaran" class="form-select">
            <option value="">-- Pilih Pelajaran --</option>
              @foreach($pelajaranOptions as $kodePelajaran => $namaPelajaran)
                <option value="{{ $kodePelajaran }}" {{ $kodePelajaran == request('kode_pelajaran') ? 'selected' : '' }}>{{ $namaPelajaran }}</option>
              @endforeach
          </select>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 mb-3">
        <div class="input-group">
          <button type="submit" class="btn btn-primary">Filter</button>
        </div>
      </div>

    </div>
  </form>
  {{-- {{ $pengampu }} --}}
  <div class="container">
    @if($pengampu->isEmpty())
      <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading text-center">Tidak ada kelas yang diampu</h4>
      </div>
    @endif
      <p class="fst-italic text-end my-1">item dapat digeser</p>
      <section class="splide mb-3">
        <div class="row">
            <div class="splide__track">
              <ul class="splide__list">
                @foreach ($pengampu as $p)
                <div class="col-md-4 splide__slide">
                  @php
                    $colo = array('#FFB3BA','#FFDFBA','#BAFFC9','#BAE1FF', '#E2BAFF', '#FFBAF2', '#FFBABA', '#e9ff7d');
                    $color = $colo[array_rand($colo)];
                  @endphp
                  <div class="card card-guru h-100" style="border: 1px solid rgb(218, 218, 218); background-color: {{ $color }};">
                    <div class="card-body p-0 ps-4">
                      <h5 class="mt-3"><strong>{{$p->mapel->nama_pelajaran}}</strong></h5>
                      <h6 class="card-text text-muted">{{$p->kelas->nama_kelas}}</h6>
                      <ul>
                        @foreach($p->jadwal as $j)
                          <li class="card-text text-muted">{{$j->hari}} {{$j->jam_mulai}} - {{$j->jam_berakhir}}</li>
                        @endforeach
                      </ul>
                      
                    </div>
                    <div class="card-footer p-2 m-0 d-flex border-0 me-2" style="background-color: transparent;">
                      <a href="/guru/detail/{{ $hash->encode($p->id)}}" class="m-0 ms-auto text-dark">Akses Kelas <i class="bi bi-box-arrow-in-right"></i></a>
                      
                      
                    </div>
                  </div>
                </div>
                @endforeach
              </ul>
            </div>
        </div>
      </section>

      <br>
      <!-- pengumuman -->
      <div class="col-lg-12 mb-2">
        <div class="row">

            <div class="card">
              <div class="card-body">
                <div class="card-title pb-0">
                  <h5>Pengumuman Terbaru</h5>
                  <hr>
                </div>
              </div>

              <!-- carousel -->
              <div id="carouselExampleAutoplaying" class="carousel carousel-dark slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                  <div class="carousel-item active">
                    <div class="card-body px-5 mx-5">
                      <p class="mx-1 text-center">
                        Pengumuman Terbaru
                      </p>
                    </div>
                  </div>
                  
                  @foreach ($pengumuman as $p)
                  <div class="carousel-item" data-interval="20000">
                    <div class="card-body px-5 mx-5">
                      <p class="mx-1 text-center">
                        {{ $p->judul_pengumuman }}
                      </p>
                      <p class="mx-1 text-center">
                        {!! $p->deskripsi !!}
                      </p>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>           
              <!-- end carousel -->
            </div>

        </div>
      </div>
      <!-- end pengumuman -->

      <div class="row">
        <div class="card">
          <div class="card-body">
            
            <div class="card-title pb-0">
              <h5>Menu</h5>
              <hr>
            </div>

            <div class="row">
              <div class="col-6 col-sm-2 col-md-3 pt-2 rounded-2 mb-2">
                <a href="/guru/mapel">
                  <img src="/img/menu/Mapel.png" class="img mx-auto d-block" style="width: 90px;" alt="mapel">
                  <p class="text-center fw-bold text-dark">Mata Pelajaran</p>
                </a>
              </div>
              <div class="col-6 col-sm-2 col-md-3 pt-2 rounded-2 mb-2">
                <a href="/guru/jadwal-mengajar">
                  <img src="/img/menu/Jadwal.png" class="img mx-auto d-block" style="width: 90px;" alt="mapel">
                  <p class="text-center fw-bold text-dark">Jadwal Mengajar</p>
                </a>
              </div>
              <div class="col-6 col-sm-2 col-md-3 pt-2 rounded-2 mb-2">
                <a href="/guru/presensi">
                  <img src="/img/menu/Attendance.png" class="img mx-auto d-block" style="width: 90px;" alt="mapel">
                  <p class="text-center fw-bold text-dark">Rekap Presensi</p>
                </a>
              </div>
              <div class="col-6 col-sm-2 col-md-3 pt-2 rounded-2 mb-2">
                <a href="/guru/materi">
                  <img src="/img/menu/Material.png" class="img mx-auto d-block" style="width: 90px;" alt="mapel">
                  <p class="text-center fw-bold text-dark">Materi</p>
                </a>
              </div>
              <div class="col-6 col-sm-2 col-md-3 pt-2 rounded-2 mb-2">
                <a href="/guru/tugas">
                  <img src="/img/menu/Task.png" class="img mx-auto d-block" style="width: 90px;" alt="mapel">
                  <p class="text-center fw-bold text-dark">Tugas</p>
                </a>
              </div>
              <div class="col-6 col-sm-2 col-md-3 pt-2 rounded-2 mb-2">
                <a href="/guru/pengumuman">
                  <img src="/img/menu/Pengumuman.png" class="img mx-auto d-block" style="width: 90px;" alt="mapel">
                  <p class="text-center fw-bold text-dark">Pengumuman</p>
                </a>
              </div>
              <div class="col-6 col-sm-2 col-md-3 pt-2 rounded-2 mb-2">
                <a href="/guru/profile">
                  <img src="/img/menu/Profile.png" class="img mx-auto d-block" style="width: 90px;" alt="mapel">
                  <p class="text-center fw-bold text-dark">Profil</p>
                </a>
              </div>
            </div>

          </div>
          

        </div>
      </div>

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