@extends('layout.main')

@section('content')

<div class="pagetitle">
  <h1>{{$title}}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
      <li class="breadcrumb-item"><a href="/admin/siswa">Siswa</a></li>
      <li class="breadcrumb-item active">Edit Siswa</li>
    </ol>
  </nav>
</div>

{{-- {{ $siswa }} --}}

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <div class="table table-responsive mt-3">
          
          <form action="/admin/siswa/{{ $siswa->kode_siswa }}" method="post">
            @csrf
            @method('patch')

            <div class="mb-3">
              <label for="nis" class="form-label fw-bold p-0">Nomor Induk Siswa (NIS)</label>
              <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" value="{{ $siswa->nis }}">
              
              @error('nis')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="nama" class="form-label fw-bold p-0">Nama Lengkap</label>
              <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $siswa->nama_siswa }}">
              
              @error('nama')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="kelas" class="form-label fw-bold p-0">Kelas</label>
              <select class="form-select @error('kelas') is-invalid @enderror" id="kelas" name="kelas">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $k)
                  <option value="{{ $k->kode_kelas }}" {{ $k->kode_kelas == $siswa->kode_kelas ? 'selected' : '' }}>{{$k->nama_kelas }}</option>
                @endforeach
              </select>
              
              @error('kelas')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            {{-- kata sandi dapat diubah secara langsung oleh admin --}}
            <div class="mb-3">
              <label for="password" class="form-label fw-bold p-0">Kata Sandi</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
              
              @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
              
            {{-- konfirmasi kata sandi dapat diubah secara langsung oleh admin --}}
            <div class="mb-3">
              <label for="password_confirmation" class="form-label fw-bold p-0">Konfirmasi Kata Sandi</label>
              <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
              
              @error('password_confirmation')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">Ubah Data</button>

          </form>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection