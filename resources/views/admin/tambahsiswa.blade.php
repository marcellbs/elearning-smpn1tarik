@extends('layout.main')

@section('content')
  {{-- breadcrumps Home/Siswa/Tambah Siswa--}}
  <div class="pagetitle">
    <h1>{{ $title }}</h1>

    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin/siswa">Siswa</a></li>
        <li class="breadcrumb-item active"><a href="/admin/siswa/tambahsiswa">Tambah Data Siswa</a></li>
      </ol>
    </nav>

  </div>


  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">

              <form action="/admin/tambahsiswa" method="post">
                @csrf
                
                <div class="form-group mb-2">
                  <label for="nis" class="form-label fw-bold">Nomor Induk Siswa (NIS)</label>
                  <input type="text" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" required>

                  @error('nis')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror

                </div>
                <div class="form-group mb-2">
                  <label for="nama" class="form-label fw-bold">Nama Lengkap Siswa</label>
                  <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" required>

                  @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                {{-- pilih kelas --}}
                <div class="form-group mb-2">
                  <label for="kelas" class="form-label fw-bold">Kelas Siswa</label>
                  <select name="kelas" id="kelas" class="form-select @error('kelas') is-invalid @enderror" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelas as $k)
                      <option value="{{ $k->kode_kelas }}">{{ $k->tingkat->nama_tingkat ." ".$k->nama_kelas }}</option>
                    @endforeach
                  </select>

                  @error('kelas')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group mb-2">
                  <label for="password" class="form-label fw-bold">Kata Sandi</label>
                  <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>

                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group mb-2">
                  <label for="confirm-password fw-bold">Konfirmasi Kata Sandi</label>
                  <input type="password" name="confirm-password" id="confirm-password" class="form-control @error('kelas') is-invalid @enderror" required>
                  
                  @error('confirm-password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="d-flex">
                  <button type="submit" class="btn btn-primary ms-auto">Tambah Data</button>
                </div>

              </form>

          </div>
        </div>
      </div>
    </div>
  </div>

@endsection