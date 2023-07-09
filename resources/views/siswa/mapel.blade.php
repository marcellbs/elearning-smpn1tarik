@extends('layout.siswa')

@section('content')
  @include ('partials.page-title', ['title' => $title])

        @if (session()->has('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {!! session('error') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
  <div class="row mt-3">
    <div class="alert alert-info" role="alert">
      <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Data Mata Pelajaran</h4>
      <ul>
        <li>Anda dapat melihat mata pelajaran tahun ajaran yang aktif dan dapat melihat histori tahun lalu</li>
        <li>
          Mata pelajaran yang anda lihat adalah mata pelajaran yang anda ikuti pada tahun ajaran yang aktif
        </li> 
        <li>Gunakan filter berdasarkan tahun dibawah ini untuk melihat histori mata pelajaran</li>
      </ul>
    </div>
    

    <form action="/siswa/mapel" method="GET" class="mb-3">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
              <label for="tahun_ajaran">Tahun Ajaran:</label>
              <select name="tahun_ajaran" id="tahun_ajaran" class="form-select">
                  <option value="">-- Pilih Tahun Ajaran --</option>
                  @foreach ($listTahunAjaran as $id => $nama)
                      <option value="{{ $nama }}" {{ $tahun_ajaran_id == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                  @endforeach
              </select>
          </div>
        </div>
        <div class="col-1">
          <label for="submitButton">&nbsp;</label>
          <button type="submit" id="submitButton" class="btn btn-primary">Filter</button>
        </div>
      </div>
    </form>
  

    @foreach ($pengampu as $p)
      <div class="col-md-4 mb-3">
        @php
          $colo = array('#FFB3BA','#FFDFBA','#BAFFC9','#BAE1FF', '#E2BAFF', '#FFBAF2', '#FFBABA', '#e9ff7d');
          $color = $colo[array_rand($colo)];
        @endphp
        <div class="card card-guru h-100" style="border: 1px solid rgb(218, 218, 218); background-color: {{ $color }};">
          <div class="card-body p-0 ps-4">
            <h5 class="mt-3"><strong>{{$p->mapel->nama_pelajaran}}</strong></h5>
            <h6 class="card-text text-muted">{{ $p->guru->nama }}</h6>
            <ul>
              @foreach ($p->jadwal as $j)
                <li class="card-text">{{ $j->hari }}, {{ $j->jam_mulai }} - {{ $j->jam_berakhir }}</li>
              @endforeach
            </ul>
          </div>
          <div class="card-footer p-2 m-0 d-flex border-0 me-2" style="background-color: transparent;">
            <a href="/siswa/detail/{{ $p->id}}" class="m-0 ms-auto text-dark">Akses Kelas <i class="bi bi-box-arrow-in-right"></i></a>
          </div>
        </div>
      </div>
    @endforeach

  </div>

@endsection