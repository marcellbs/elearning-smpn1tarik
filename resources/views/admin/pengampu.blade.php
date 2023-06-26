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
        {{-- <li>Anda dapat mengisi Jam Mulai dan Jam Berakhir dengan pemisah (:) titik dua </li> --}}
      </ul>

      <h4 class="alert-heading">Menambahkan Pengampu Mata Pelajaran</h4>
      <div class="mt-3 align-content-center">
        {{-- menambah data pengampu dropdown --}}
        <form action="/admin/pengampu" method="post">
          @csrf
          
          {{--  berisi mapel, guru, dan kelas --}}
          <div class="row">
            <div class="col-sm-3">
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
            <div class="col-sm-3">
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
            <div class="col-sm-3">
                <select name="kelas" class="form-select  @error('kelas') is-invalid @enderror"  id="kelas">
                  <option value="">Pilih Kelas</option>
                  @foreach ($kelas as $k)
                  <option value="{{$k->kode_kelas}}">{{$k->nama_kelas}}</option>
                  @endforeach
                </select>
                @error('kelas')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
            </div>
            <div class="col-sm-3">
                <select name="tahun_ajaran" class="form-select  @error('tahun_ajaran') is-invalid @enderror" id="tahun_ajaran">
                  @foreach ($tahun_ajaran as $th)
                    <option value="{{$th->id}}" @if($th->status_aktif == 1) selected @endif>      {{$th->tahun_ajaran}} 
                    </option>
                  @endforeach
                </select>
                @error('tahun_ajaran')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
            </div>
            
            
              <div id="jadwal-container">
                <div class="jadwal-group">

                  <div class="row">
                    <div class="col-sm-3">
                      <label class="form-label">Hari:</label>
                      <select name="hari[]" id="hari" class="form-select">
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                      </select>
                    </div>
                    <div class="col-sm-4">
                      <label class="form-label">Jam Mulai:</label>
                      <input type="text" name="jam_mulai[]" class="form-control">
                    </div>
                    <div class="col-sm-4">
                      <label class="form-label">Jam Berakhir:</label>
                      <input type="text" name="jam_berakhir[]" class="form-control">
                    </div>
                    <div class="col-1">
                      <label for="remove-jadwal" class="form-label">&nbsp;</label>
                      <button type="button" class="remove-jadwal btn form-control">&times;</button>
                    </div>
                  </div>

                </div>
              </div>
            

          </div>
          <div class="d-flex">
            <button type="submit" class="btn btn-primary mt-3 ms-auto">Tambah Data</button>
            <button type="button" id="add-jadwal" class="btn btn-info mt-3 ms-1">Tambah Jadwal</button>
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
          <table class="table compact cell-border" id="datatable">
            <thead class="dt-head-justify">
              <th>No</th>
              <th>Nama</th>
              <th>Mata Pelajaran</th>
              <th>Kelas</th>
              <th>Jadwal</th>
              <th>Tahun Ajaran</th>
              <th>Aksi</th>
            </thead>
            <tbody class="dt-body-nowrap">
              @foreach ($pengampu as $p)
              <tr>
                <td>{{$loop->iteration}}</td>
                {{-- cek apakah ada guru dan mapel yang sama --}}
                <td>{{$p->guru->nama}}</td>
                <td>{{$p->mapel->nama_pelajaran}}</td>
                <td>{{$p->kelas->nama_kelas}}</td>
                <td>
                  @foreach ($p->jadwal as $jadwal)
                      {{ $jadwal->hari }}, {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_berakhir }},<br>
                  @endforeach
                </td>
                <td>
                  {{ $p->tahunAjaran->tahun_ajaran }}
                </td>
                <td>
                  <a href="/admin/pengampu/{{$p->id}}/edit" class="btn btn-sm btn-warning mt-1"><i class="bi bi-pencil-square"></i></a>
                  <a href="/admin/pengampu/{{$p->id}}" class="btn btn-sm btn-info mt-1"><i class="bi bi-eye"></i></a>

                  <form action="/admin/pengampu/{{$p->id}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger mt-1" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></button>
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

<script>
  document.getElementById('add-jadwal').addEventListener('click', function() {
    var jadwalContainer = document.getElementById('jadwal-container');
    var jadwalGroup = document.createElement('div');
    jadwalGroup.classList.add('jadwal-group');
    jadwalGroup.innerHTML = `
      <div class="row">
        <div class="col-sm-3">
          <label class="form-label">Hari:</label>
          <select name="hari[]" id="hari" class="form-select">
            <option value="Senin">Senin</option>
            <option value="Selasa">Selasa</option>
            <option value="Rabu">Rabu</option>
            <option value="Kamis">Kamis</option>
            <option value="Jumat">Jumat</option>
            <option value="Sabtu">Sabtu</option>
          </select>
        </div>
        <div class="col-sm-4">
          <label class="form-label">Jam Mulai:</label>
          <input type="text" name="jam_mulai[]" class="form-control">
        </div>
        <div class="col-sm-4">
          <label class="form-label">Jam Berakhir:</label>
          <input type="text" name="jam_berakhir[]" class="form-control">
        </div>
        <div class="col-1">
          <label for="remove-jadwal" class="form-label">&nbsp;</label>
          <button type="button" class="remove-jadwal btn form-control">&times;</button>
        </div>
      </div>
    `;
    jadwalContainer.appendChild(jadwalGroup);
  });

  // Event listener untuk tombol "Hapus Jadwal"
  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-jadwal')) {
      event.target.parentElement.parentElement.remove();
    }
  });
</script>

@endsection