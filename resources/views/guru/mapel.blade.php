@extends('layout/guru')

@section('content')
  @include('partials.page-title',['title' => $title])

  <i class="mb-2">Semua Mata Pelajaran yang anda ampu akan muncul di halaman ini</i>
  
  <!-- Form untuk filter -->
<form action="/guru/mapel" method="GET">
  <div class="row">
    <div class="col-md-4">
      <div class="mb-3">
        <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
        <select name="tahun_ajaran" id="tahun_ajaran" class="form-select">
          <option value="">-- Pilih Tahun Ajaran --</option>
          @foreach($tahunAjaranOptions as $tahunAjaranId => $namaTahunAjaran)
            <option value="{{ $tahunAjaranId }}" {{ request('tahun_ajaran') == $tahunAjaranId ? 'selected' : '' }}>
              {{ $namaTahunAjaran }}
            </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="col-md-1">
      {{-- button --}}
        <label for="submitBtn" class="form-label">&nbsp;</label>
        <button id="submitBtn" type="submit" class="btn btn-primary form-control">Filter</button>
    </div>
  </div>
</form>


  <div class="row mt-3">
    {{-- @foreach ($pengampu as $p)
      <div class="col-md-4 mb-3">
        @php
          $colo = array('#FFB3BA','#FFDFBA','#BAFFC9','#BAE1FF', '#E2BAFF', '#FFBAF2', '#FFBABA', '#e9ff7d');
          $color = $colo[array_rand($colo)];
        @endphp
        <div class="card card-guru h-100" style="border: 1px solid rgb(218, 218, 218); background-color: {{ $color }};">
          <div class="card-body p-0 ps-4">
            <h5 class="mt-3"><strong>{{$p->mapel->nama_pelajaran}}</strong></h5>
            <h6 class="card-text text-muted">{{$p->kelas->nama_kelas}}</h6>
          </div>
          <div class="card-footer p-2 m-0 d-flex border-0 me-2" style="background-color: transparent;">
            <a href="/guru/detail/{{ $hash->encode($p->id)}}" class="m-0 ms-auto text-dark">Akses Kelas <i class="bi bi-box-arrow-in-right"></i></a>
          </div>
        </div>
      </div>
    @endforeach --}}

    @foreach ($pengampu as $p)
        <div class="col-md-4 mb-3">
            @php
                $colo = array('#FFB3BA','#FFDFBA','#BAFFC9','#BAE1FF', '#E2BAFF', '#FFBAF2', '#FFBABA', '#e9ff7d');
                $color = $colo[array_rand($colo)];
            @endphp
            <div class="card card-guru h-100" style="border: 1px solid rgb(218, 218, 218); background-color: {{ $color }};">
                <div class="card-body p-0 ps-4">
                    <h5 class="mt-3"><strong>{{$p->mapel->nama_pelajaran}}</strong></h5>
                    <h6 class="card-text text-muted">{{$p->kelas->nama_kelas}}</h6>
                    
                    <ul>
                        @foreach ($p->jadwal as $jadwal)
                            <li>{{$jadwal->hari}}, {{$jadwal->jam_mulai}} - {{$jadwal->jam_berakhir}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer p-2 m-0 d-flex border-0 me-2" style="background-color: transparent;">
                    <a href="/guru/detail/{{ $hash->encode($p->id)}}" class="m-0 ms-auto text-dark">Akses Kelas <i class="bi bi-box-arrow-in-right"></i></a>
                </div>
            </div>
        </div>
    @endforeach


  </div>
  
@endsection