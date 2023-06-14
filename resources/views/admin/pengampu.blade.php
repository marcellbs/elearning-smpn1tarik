@extends('layout.main')
@section('content')

@include('partials.page-title', ['title' => $title])

@if (session()->has('sukses'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {!! session('sukses') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
  <div class="col-lg-12">
    <div class="alert alert-info" role="alert">
      <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Informasi</h4>
      <ul>
        <li>Anda dapat menambahkan guru yang akan mengampu mata pelajaran dan kelas</li>
        <li>Anda cukup menambahkan nama guru, mata pelajaran, dan kelas saja, maka data yang anda inputkan akan masuk ke dalam database</li>
        <li>Anda dapat mengisi Jam Mulai dan Jam Berakhir dengan pemisah (:) titik dua </li>
      </ul>
      <div class="mt-3 align-content-center">
        {{-- menambah data pengampu dropdown --}}
        <form action="/admin/pengampu" method="post">
          @csrf
          
          {{--  berisi mapel, guru, dan kelas --}}
          <div class="row">
            <div class="col-sm-4">
                <select class="form-select @error('guru') is-invalid @enderror" name="guru" id="guru">
                  <option value="">Pilih Guru</option>
                  @foreach ($guru as $g)
                  <option value="{{$g->kode_guru}}">{{$g->nama}}</option>
                  @endforeach
                </select>
                @error('guru')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
            </div>
            <div class="col-sm-4">
                <select class="form-select @error('mapel') is-invalid @enderror" name="mapel" id="mapel">
                  <option value="">Pilih Mata Pelajaran</option>
                  @foreach ($mapel as $m)
                  <option value="{{$m->kode_pelajaran}}">{{$m->nama_pelajaran}}</option>
                  @endforeach
                </select>
                @error('mapel')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
            </div>
            {{-- select untuk nama kelas dan kode tingkat --}}
            <div class="col-sm-4">
                <select name="kelas" class="form-select  @error('kelas') is-invalid @enderror"  id="kelas">
                  <option value="">Pilih Kelas</option>
                  @foreach ($kelas as $k)
                  <option value="{{$k->kode_kelas}}">{{$k->tingkat->nama_tingkat}}{{$k->nama_kelas}}</option>
                  @endforeach
                </select>
                @error('kelas')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
            </div>
            <div class="col-sm-4 mt-1">
                <label for="hari">Hari</label>
                <select name="hari" class="form-select  @error('hari') is-invalid @enderror"  id="kelas">
                  <option value="">Pilih Hari</option>
                  <option value="Senin">Senin</option>
                  <option value="Selasa">Selasa</option>
                  <option value="Rabu">Rabu</option>
                  <option value="Kamis">Kamis</option>
                  <option value="Jumat">Jumat</option>
                  <option value="Sabtu">Sabtu</option>
                </select>
                @error('hari')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
            </div>
            <div class="col-sm-4 mt-1">
              <label for="hari">Jam Mulai</label>
                <input type="text" name="jam_mulai" class="form-control  @error('jam_mulai') is-invalid @enderror" placeholder="08:00"  id="jam_mulai">
                @error('jam_mulai')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
            </div>
            <div class="col-sm-4 mt-1">
              <label for="hari">Jam Berakhir</label>
                <input type="text" name="jam_berakhir" class="form-control @error('jam_berakhir') is-invalid @enderror" placeholder="08:00"  id="jam_berakhir">
                @error('jam_berakhir')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
            </div>

          </div>
          <div class="d-flex">
            <button type="submit" class="btn btn-primary mt-3 ms-auto">Tambah Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <table class="table table-striped table-bordered datatable" id="datatable">
            <thead>
              <th>No</th>
              <th>Nama</th>
              <th>Mata Pelajaran</th>
              <th>Kelas</th>
              <th>Jadwal</th>
              <th>Aksi</th>
            </thead>
            <tbody>
              @foreach ($pengampu as $p)
              <tr>
                <td>{{$loop->iteration}}</td>
                {{-- cek apakah ada guru dan mapel yang sama --}}
                <td>{{$p->guru->nama}}</td>
                <td>{{$p->mapel->nama_pelajaran}}</td>
                <td>{{$p->kelas->tingkat->nama_tingkat}}{{$p->kelas->nama_kelas}}</td>
                <td>{{$p->hari }}, {{ $p->jam_mulai }} - {{ $p->jam_berakhir }}</td>
                <td>
                  <a href="/admin/pengampu/{{$p->id}}/edit" class="btn btn-warning mt-1"><i class="bi bi-pencil-square"></i></a>
                  <a href="/admin/pengampu/{{$p->id}}" class="btn btn-info mt-1"><i class="bi bi-eye"></i></a>

                  <form action="/admin/pengampu/{{$p->id}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger mt-1" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></button>
                  </form>

                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection