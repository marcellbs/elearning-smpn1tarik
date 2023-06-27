@extends('layout.guru')

@section('content')

@include('partials.page-title', ['title' => $title])

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <form action="/guru/tugas" method="post" enctype="multipart/form-data">
            
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
              <select name="kelas" id="kelas" class="form-select">
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $item)
                  <option value="{{ $item['kode_kelas'] }}" {{ old('kelas') == $item['kode_kelas'] ? 'selected' : '' }}>{{ $item['nama_kelas'] }}</option>
                @endforeach
              </select>
              @error('kelas')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>

            {{-- mapel --}}
            <div class="form-group">
              <label for="mapel">Mata Pelajaran</label>
              <select name="mapel" id="mapel" class="form-select">
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach ($mapel as $item)
                  <option value="{{ $item['kode_pelajaran'] }}" {{ old('mapel') == $item['kode_pelajaran'] ? 'selected' : '' }}>{{ $item['nama_pelajaran'] }}</option>
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
              <input type="datetime-local" name="deadline" id="deadline" class="form-control" value="{{ old('deadline') }}">
              @error('deadline')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>

            {{-- berkas --}}
            <div class="form-group">
              <label for="berkas">Berkas</label>
              <input type="file" name="berkas" id="berkas" class="form-control @error('berkas') is-invalid @enderror">
              <div id="file-name"></div>
              @error('berkas')
              <div class="text-danger mt-1">
                {{ $message }}
              </div>
              @enderror
            </div>

            {{-- tombol submit --}}
            <div class="form-group mt-2">
              <button type="submit" class="btn btn-primary">Tambah</button>
              <a href="/guru/tugas" class="">Kembali</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
  $(document).ready(function(){
    $('#pelajaran').on('change', function(){
      let pelajaran = $(this).val();
      if(pelajaran){
        $.ajax ({
          url: '/guru/tugas/create/'+ pelajaran,
          type: 'GET',
          dataType: 'json',
          success: function(data){
            // console.log(data);
            $('#kelas').empty();
            $.each(data, function(key, value){
              $('#kelas').append('<option value="'+value.kode_kelas+'">'+value.kelas.tingkat.nama_tingkat+value.kelas.nama_kelas+'</option>');
            });
          }
        });
      }else{
        $('#kelas').empty();
      }
    });
  });
</script> --}}

<script>
  // Mendapatkan elemen input file
  var fileInput = document.getElementById('berkas');

  // Menambahkan event listener untuk mendeteksi perubahan pada input file
  fileInput.addEventListener('change', function() {
      // Mendapatkan nama file yang diunggah
      var fileName = fileInput.files[0].name;

      // Menampilkan nama file di elemen dengan id "file-name"
      var fileNameElement = document.getElementById('file-name');
      fileNameElement.textContent = fileName;
  });
</script>

@endsection