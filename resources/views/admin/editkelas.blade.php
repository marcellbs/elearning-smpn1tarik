@extends('layout.main')

@section('content')
  <div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin/kelas">Kelas</a></li>
        <li class="breadcrumb-item active"><a href="/admin/kelas/edit">Edit Kelas</a></li>
      </ol>
    </nav>
  </div>


  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">
            <form action="/admin/kelas/{{ $kelas->kode_kelas }}" method="post">
              @csrf
              @method('patch')

              {{-- kode kelas --}}
              <div class="mb-3">
                <label for="kode_kelas" class="form-label fw-bold">Kode Kelas</label>
                <input type="text" name="kode_kelas" id="kode_kelas" class="form-control @error('kode_kelas') is-invalid @enderror" placeholder="Masukkan Kode Kelas" value="{{ $kelas->kode_kelas }}">
                @error('kode_kelas')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror
              </div>

              {{-- tingkat kelas --}}
              <div class="mb-3">
                <label for="tingkat" class="form-label fw-bold">Tingkat Kelas</label>
                <select name="tingkat" id="tingkat" class="form-select @error('tingkat') is-invalid @enderror">
                  @foreach($tingkat as $t)
                    <option value="{{ $t->kode_tingkat }}" {{ $t->kode_tingkat == $kelas->kode_tingkat ? 'selected' : '' }}>{{ $t->nama_tingkat }}</option>
                  @endforeach
                </select>
                @error('tingkat')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror

              </div>

              <div class="mb-3">
                <label for="nama_kelas" class="form-label fw-bold">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" placeholder="A - Z" value="{{ $kelas->nama_kelas }}">
                @error('nama_kelas')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                @enderror
              </div>
              
              <div class="mb-3 d-flex">
                <a href="/admin/kelas" class="btn ms-auto me-1" style="border: 1px solid orange; color: orange;">Kembali</a>
                <button type="submit" class="btn text-white" style="background-color: orange;">Edit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection