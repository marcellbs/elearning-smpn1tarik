@extends('layout.main')

@section('content')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin">Home</a></li>
      <li class="breadcrumb-item"><a href="/admin/admin">Administrator</a></li>
      <li class="breadcrumb-item"><a href="/admin">Edit Admin</a></li>
    </ol>
  </nav>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <form action="/admin/editadmin/{{ $admin->kode_admin }}" method="post">
            @csrf
            @method('patch')

            {{-- nama --}}
            <div class="mb-3">
              <label for="nama" class="form-label fw-bold">Nama</label>
              {{-- select --}}
              <input type="text" name="nama" id="nama" placeholder="Nama Admin" class="form-control" value="{{ $admin->nama }}">
              @error('nama')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
              @enderror
            </div>

            {{-- email --}}
            <div class="mb-3">
              <label for="email" class="form-label fw-bold">Email</label>
              <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" value="{{ $admin->email }}">
              @error('email')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
              @enderror
            </div>

            {{-- password --}}
            <div class="mb-3">
              <label for="password" class="form-label fw-bold">Kata Sandi</label>
              <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Kata Sandi">
              @error('password')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
              @enderror
            </div>

            {{-- password confirmation --}}
            <div class="mb-3">
              <label for="password_confirmation" class="form-label fw-bold">Ulangi Kata Sandi</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Ulangi Kata Sandi">
              @error('password_confirmation')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
              @enderror
            </div>

            <div class="mb-3 d-flex">
              <a href="/admin/admin" class="btn ms-auto me-1" style="border: 1px solid orange; color: orange;">Kembali</a>
              <button type="submit" class="btn text-white" style="background-color:orange;">Ubah Data</button>
            </div>


          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection