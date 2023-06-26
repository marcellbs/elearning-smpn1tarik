@extends('layout.main')

@section('content')
  <div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin/guru">Guru</a></li>
        <li class="breadcrumb-item active">Tambah Data Guru</li>
      </ol>
    </nav>
  </div>


  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">

            <form action="/admin/tambahguru" method="post">
              @csrf

              <div class="mb-3">
                <label for="nip" class="form-label fw-bold p-0">Nomor Induk Pegawai (NIP)</label>
                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip') }}">
                
                @error('nip')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              <div class="mb-3">
                
                <label for="nama" class="form-label fw-bold p-0">Nama Lengkap <span class="fw-normal fst-italic fs-6">(dengan gelar)</span></label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
                
                @error('nama')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>

              {{-- kata sandi --}}
              <div class="mb-3">
                <label for="password" class="form-label fw-bold p-0">Kata Sandi</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                
                @error('password')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror

              </div>

              {{-- konfirmasi kata sandi --}}
              <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-bold p-0">Konfirmasi Kata Sandi</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                
                @error('password_confirmation')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              {{-- button --}}
              <div class="mb-3 d-flex">
                <a href="/admin/guru" class="btn ms-auto me-1" style="border: 1px solid orange; color: orange;">Batal</a> 
                <button type="submit" class="btn text-white" style="background-color:orange;">Tambah Data</button>
              </div>

            </form>
            
            

            

            

          </div>
        </div>
      </div>
    </div>
  </div>

@endsection