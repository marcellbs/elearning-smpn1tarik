@extends('layout.guru')

@section ('content')
<div class="row">
  <div class="col-lg-10">
    <div class="pagetitle">
      <h1>{{ $title }}</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/guru">Home</a></li>
          <li class="breadcrumb-item">Detail Kelas</li>
          <li class="breadcrumb-item active">Presensi</li>
        </ol>
      </nav>
    </div>
  </div>
  
</div>

{{-- alert --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {!! session('success') !!}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {!! session('error') !!}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- card --}}

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body mt-3">
        
        <div class="table-responsive mt-3">
          <form action="{{ route('presensi.store') }}" method="POST">
            @csrf
            
            <div class="row">
              <div class="col-md-3">  
                <label class="form-label" for="kode_guru">Guru : </label>
                <select name="kode_guru" id="kode_guru" class="form-control mb-3">
                  <option value="{{ $pengampu->guru->kode_guru  }}" selected>{{ $pengampu->guru->nama }}</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="kode_pelajaran" class="form-label">Mata Pelajaran : </label>
                <select name="kode_pelajaran" id="kode_pelajaran" class="form-control mb-3">
                  <option value="{{ $pengampu->mapel->kode_pelajaran }}" selected>{{ $pengampu->mapel->nama_pelajaran }}</option>
                </select>
              </div>
              
              <div class="col-md-3">
                <label for="kode_kelas" class="form-label">Kelas : </label>
                <select name="kode_kelas" id="kode_kelas" class="form-control mb-3">
                  <option value="{{ $pengampu->kelas->kode_kelas  }}" selected> 
                    {{ $pengampu->kelas->nama_kelas }}
                  </option>
                </select>
              </div>

            </div>
            

            <table class="table table-bordered">
              <tr>
                <th>NIS</th>
                <th>Nama Siswa</th>
                
              </tr>
              @foreach ($siswa as $s)
              <tr>
                <td rowspan="2">{{ $s->nis }}</td>
                <td>
                  {{ $s->nama_siswa }}
                </td>
              </tr>
              <tr>
                <td>
                  {{-- radio button --}}
                  <input type="radio" class="form-check-input ms-3" name="presensi[{{ $s->kode_siswa }}]" value="H" id="hadir_{{ $s->kode_siswa }}" checked>
                  <label class="form-check-label" for="hadir_{{ $s->kode_siswa }}">Hadir</label>
                
                  <input type="radio" class="form-check-input ms-3" name="presensi[{{ $s->kode_siswa }}]" value="I" id="izin_{{ $s->kode_siswa }}">
                  <label class="form-check-label" for="izin_{{ $s->kode_siswa }}">Izin</label>

                  <input type="radio" class="form-check-input ms-3" name="presensi[{{ $s->kode_siswa }}]" value="S" id="sakit_{{ $s->kode_siswa}}">
                  <label class="form-check-label" for="sakit_{{ $s->kode_siswa }}">Sakit</label>

                  <input type="radio" class="form-check-input ms-3" name="presensi[{{ $s->kode_siswa }}]" value="A" id="alfa_{{ $s->kode_siswa }}">
                  <label class="form-check-label" for="alfa_{{ $s->kode_siswa }}">Alfa</label>
                  
                  <input type="radio" class="form-check-input ms-3" name="presensi[{{ $s->kode_siswa }}]" value="K" id="keluar_{{ $s->kode_siswa }}">
                  <label class="form-check-label" for="keluar_{{ $s->kode_siswa }}">Keluar Kelas Tanpa Keterangan</label>
                
                </td>
              </tr>
              @endforeach
            </table>
            
            <div class="col d-flex">
              <a href="/guru/detail/{{ $hash->encode($pengampu->id)}}" class="btn btn-primary ms-auto me-2">Kembali</a>
              <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
        </form>
        
        </div>
      </div>
    </div>
  </div>
</div>
@endsection