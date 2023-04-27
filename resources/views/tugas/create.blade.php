@extends('layout.guru')

@section('content')

@include('partials.page-title', ['title' => $title])

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <form action="" method="post">
            
            @csrf

            {{-- judul tugas --}}
            <div class="form-group">
              <label for="judul_tugas">Judul Tugas</label>
              <input type="text" name="judul_tugas" id="judul_tugas" class="form-control" placeholder="Masukkan judul tugas" value="{{ old('judul_tugas') }}">
              @error('judul_tugas')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>
              
            {{-- deskripsi tugas --}}
            <div class="form-group">
              <label for="deskripsi_tugas">Deskripsi Tugas</label>
              <textarea name="deskripsi_tugas" id="deskripsi_tugas" class="form-control" placeholder="Masukkan deskripsi tugas" rows="3">{{ old('deskripsi_tugas') }}</textarea>
              @error('deskripsi_tugas')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>

            {{-- kelas --}}
            <div class="form-group">
              <label for="kelas">Kelas</label>
              <select name="kelas" id="kelas" class="form-control">
                <option value="">-- Pilih Kelas (Mapel)--</option>
                @foreach ($kelasYangDiajar as $item)
                  <option value="{{ $item->kode_kelas }}">{{ $item->kelas->tingkat->nama_tingkat . $item->kelas->nama_kelas .' '. '('.$item->mapel->nama_pelajaran.')' }}</option>
                @endforeach
              </select>
              @error('kelas')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>

            {{-- deadline --}}
            <div class="form-group">
              <label for="deadline">Deadline</label>
              <input type="datetime-local" name="deadline" id="deadline" class="form-control" value="{{ old('deadline') }}">
              @error('deadline')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>

            {{-- berkas --}}
            {{-- drag and drop files --}}
            
            

            


          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection