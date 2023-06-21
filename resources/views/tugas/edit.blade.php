@extends('layout/guru')

@section('content')

@include('partials.page-title', ['title' => 'Edit Tugas'])

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <form action="/guru/tugas/{{ $tugas->kode_tugas }}" method="post" enctype="multipart/form-data">
            @method('patch')
            @csrf

            {{-- judul tugas --}}
            <div class="form-group">
              <label for="judul_tugas">Judul Tugas</label>
              <input type="text" name="judul_tugas" id="judul_tugas" class="form-control" placeholder="Masukkan judul tugas" value="{{ $tugas->judul_tugas }}">
              @error('judul_tugas')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>

            {{-- keterangan --}}
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Masukkan keterangan" rows="3">{{ $tugas->keterangan }}</textarea>
              @error('keterangan')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>

            {{-- kelas --}}
            {{-- <div class="form-group">
              <label for="kelas">Kelas</label>
              <select name="kelas" id="kelas" class="form-control">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $item)
                  <option value="{{ $item['kode_kelas'] }}">{{ $item['nama_tingkat'].$item['nama_kelas'] }}</option>
                @endforeach
              </select>
              @error('kelas')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div> --}}
            <div class="form-group">
              <label for="kelas">Kelas</label>
              <select name="kelas" id="kelas" class="form-select">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $item)
                  <option value="{{ $item['kode_kelas'] }}" {{ $item['kode_kelas'] == $tugas->kode_kelas ? 'selected' : '' }}>{{ $item['nama_tingkat'].$item['nama_kelas'] }}</option>
                @endforeach
              </select>
              @error('kelas')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>

            {{-- mapel --}}
            {{-- <div class="form-group">
              <label for="mapel">Mata Pelajaran</label>
              <select name="mapel" id="mapel" class="form-control">
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach ($mapel as $item)
                  <option value="{{ $item['kode_pelajaran'] }}  ">{{ $item['nama_pelajaran'] }}</option>
                @endforeach
              </select>
              @error('mapel')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div> --}}

            <div class="form-group">
              <label for="mapel">Mata Pelajaran</label>
              <select name="mapel" id="mapel" class="form-select">
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach ($mapel as $item)
                  <option value="{{ $item['kode_pelajaran'] }}" {{ $item['kode_pelajaran'] == $tugas->kode_pelajaran ? 'selected' : '' }}>{{ $item['nama_pelajaran'] }}</option>
                @endforeach
              </select>
              @error('mapel')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>

            {{-- deadline --}}
            <div class="form-group">
              <label for="deadline">Deadline</label>
              <input type="datetime-local" name="deadline" id="deadline" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($tugas->deadline)) }}">
              @error('deadline')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>

            {{-- berkas --}}
            <div class="form-group">
              <label for="berkas">Berkas</label>
              <input type="file" name="berkas" id="berkas" class="form-control" value="{{ $tugas->berkas }}">
              @error('berkas')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>

            {{-- tombol submit --}}
            <div class="form-group mt-3">
              <button type="submit" class="btn btn-primary">Ubah Tugas</button>
              <a href="/guru/tugas">Kembali</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection