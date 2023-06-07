@extends('layout.main')

@section('content')
  <div class="pagetitle">
    <h1>{{$title}}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin/admin">Administrator</a></li>
        <li class="breadcrumb-item"><a href="/admin/guru/tambah">Tambah Administrator</a></li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">
            <form action="/admin/tambah" method="post">
              @csrf
              <div class="mb-3">
                <label for="nama" class="form-label fw-bold">Nama</label>
                {{-- select --}}
                <select class="form-select @error('nama') is-invalid @enderror " aria-label="Default select example" name="nama">
                  <option selected>-- Pilih Nama Guru --</option>
                  @foreach ($guru as $guru)
                    <option value="{{$guru->nama}}">{{$guru->nama}}</option>
                  @endforeach
                </select>
                {{-- end select --}}
                @error('nama')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror
              </div>

              {{-- email --}}
              <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" value="{{old('email')}}">
                @error('email')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror
              </div>
              {{-- end email --}}

              {{-- password --}}
              <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password" value="{{old('password')}}">
                @error('password')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror
              </div>
              {{-- end password --}}

              {{-- konfirmasi password --}}
              <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Masukkan Konfirmasi Password" value="{{old('password_confirmation')}}">
                @error('password_confirmation')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror
              </div>
              {{-- end konfirmasi password --}}

              {{-- submit --}}
              <div class="mb-3 d-flex">
                <a href="/admin/admin" class="btn ms-auto me-2" style="border:1px solid orange; color: orange;">Kembali</a>
                <button type="submit" class="btn text-white" style="background-color: orange;">Tambah</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection