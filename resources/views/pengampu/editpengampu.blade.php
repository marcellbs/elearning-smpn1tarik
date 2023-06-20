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

              {{-- select untuk nama kelas --}}
              <div class="col-md-6 mt-2 mb-2">
                <label for="kelas">Kelas</label>
                <select name="kelas" class="form-select  @error('kelas') is-invalid @enderror"  id="kelas">
                  <option value="">Pilih Kelas</option>
                  @foreach ($kelas as $k)
                  <option value="{{$k->kode_kelas}}" {{ $k->kode_kelas == $pengampu->kelas->kode_kelas ? 'selected' : '' }}>{{$k->nama_kelas}}</option>
                  @endforeach
                </select>
                @error('kelas')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>

              <div class="col-md-6 mt-2 mb-2">
                <label for="hari">Hari</label>
                <select name="hari" class="form-select  @error('hari') is-invalid @enderror"  id="hari">
                  <option value="">Pilih Hari</option>
                  <option value="Senin" {{ $pengampu->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                  <option value="Selasa" {{ $pengampu->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                  <option value="Rabu" {{ $pengampu->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                  <option value="Kamis" {{ $pengampu->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                  <option value="Jumat" {{ $pengampu->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                  <option value="Sabtu" {{ $pengampu->hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                </select>
                @error('hari')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>

              <div class="row">
                <div class="col-md-2 mt-2 mb-2 me-1">
                  <label for="jam_mulai">Jam Mulai</label>
                  <input type="text" name="jam_mulai" id="jam_mulai" value="{{ $pengampu->jam_mulai }}" class="form-control">
                </div>
                <div class="col-md-2 mt-2 mb-2">
                  <label for="jam_berakhir">Jam Berakhir</label>
                  <input type="text" name="jam_berakhir" id="jam_berakhir" value="{{ $pengampu->jam_berakhir }}" class="form-control">
                </div>
              </div>

              <div class="d-flex">
                <a href="/admin/pengampu" class="btn btn-white mt-2 ms-auto me-1" style="color:orange; border:1px solid orange;">Kembali</a>
                
                <button type="submit" class="btn text-white mt-2" style="background-color: orange;">Ubah</button>
              </div>



          </form>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection