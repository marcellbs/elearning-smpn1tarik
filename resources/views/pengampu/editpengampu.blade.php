@extends('layout.main')
@section('content')

@include('partials.page-title', ['title' => $title])

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <h5>Edit Pengampu : <strong>{{ $pengampu->guru->nama }}</strong></h5>
          <form action="/admin/pengampu/{{ $pengampu->id }}" method="post">
            @method('patch')
            @csrf
            
              <div class="col-md-6 mt-2">
                <label for="guru">Nama Guru</label>
                <select class="form-select @error('guru') is-invalid @enderror" name="guru" id="guru">
                  <option value="">Pilih Guru</option>
                  @foreach ($guru as $g)
                  <option value="{{$g->kode_guru}}" {{ $g->kode_guru == $pengampu->guru->kode_guru ? 'selected' : '' }}>{{$g->nama}}</option>
                  @endforeach
                </select>
                @error('guru')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
              <div class="col-md-6 mt-2">
                <label for="mapel">Mata Pelajaran</label>
                <select class="form-select @error('mapel') is-invalid @enderror" name="mapel" id="mapel">
                  <option value="">Pilih Mata Pelajaran</option>
                  @foreach ($mapel as $m)
                  <option value="{{$m->kode_pelajaran}}" {{ $m->kode_pelajaran == $pengampu->mapel->kode_pelajaran ? 'selected' : '' }}>{{$m->nama_pelajaran}}</option>
                  @endforeach
                </select>
                @error('mapel')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              {{-- select untuk nama kelas dan kode tingkat --}}
              <div class="col-md-6 mt-2 mb-2">
                <label for="kelas">Kelas</label>
                <select name="kelas" class="form-select  @error('kelas') is-invalid @enderror"  id="kelas">
                  <option value="">Pilih Kelas</option>
                  @foreach ($kelas as $k)
                  <option value="{{$k->kode_kelas}}" {{ $k->kode_kelas == $pengampu->kelas->kode_kelas ? 'selected' : '' }}>{{$k->tingkat->nama_tingkat}}{{$k->nama_kelas}}</option>
                  @endforeach
                </select>
                @error('kelas')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>
              <a href="/admin/pengampu" class="btn btn-white mt-2" style="color:orange; border:1px solid orange;">Kembali</a>
              <button type="submit" class="btn text-white mt-2" style="background-color: orange;">Ubah</button>



          </form>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection