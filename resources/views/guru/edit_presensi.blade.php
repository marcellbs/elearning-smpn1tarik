@extends('layout.guru')

@section('content')
  <div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/guru">Home</a></li>
        <li class="breadcrumb-item"><a href="/guru/presensi">Rekap Presensi</a></li>
        <li class="breadcrumb-item active">Edit Presensi</li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">
            <form action="/guru/presensi/update" method="post">
              @csrf
              @method('patch')
              <table class="table table-bordered">
                  <tr>
                      <th>NIS</th>
                      <th>Nama Siswa</th>
                  </tr>
                  @foreach ($presensi as $p)
                  <tr>
                      <td rowspan="2">{{ $p->siswa->nis }}</td>
                      <td>{{ $p->siswa->nama_siswa }}</td>
                  </tr>
                  <tr>
                    <td>
                        <!-- Tampilkan status presensi yang dapat diubah -->
                        <label>
                            <input type="radio" name="presensi[{{ $p->id }}]" value="H" {{ $p->status == 'H' ? 'checked' : '' }}> Hadir
                        </label>
                        <label>
                            <input type="radio" name="presensi[{{ $p->id }}]" value="I" {{ $p->status == 'I' ? 'checked' : '' }}> Izin
                        </label>
                        <label>
                            <input type="radio" name="presensi[{{ $p->id }}]" value="S" {{ $p->status == 'S' ? 'checked' : '' }}> Sakit
                        </label>
                        <label>
                            <input type="radio" name="presensi[{{ $p->id }}]" value="A" {{ $p->status == 'A' ? 'checked' : '' }}> Alfa
                        </label>
                        <label>
                            <input type="radio" name="presensi[{{ $p->id }}]" value="K" {{ $p->status == 'K' ? 'checked' : '' }}> Keluar Kelas Tanpa Keterangan
                        </label>
                      
                    </td>
                  </tr>
                  @endforeach
              </table>
              <div class="d-flex">
                <a href="/guru/presensi" class="btn btn-secondary ms-auto">Kembali</a>
                <button type="submit" class="btn btn-primary ms-2">Simpan</button>
              </div>
            </form>
          
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection