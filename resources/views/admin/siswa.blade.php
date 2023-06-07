@extends('layout.main')
@section('content')

<div class="pagetitle">
  <h1>{{$title}}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item active">Pengguna Siswa</li>
    </ol>
  </nav>
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

{{-- menampilkan data siswa --}}

<div class="row">
  {{-- button untuk tambah data melalui file upload excel --}}
  <div class="col-lg-12">
    <div class="alert alert-info" role="alert">
      <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Menambahkan Data Siswa ?</h4>
      <ul>
        <li>untuk menambahkan data secara individu atau perorangan gunakan tombol <span class="btn btn-sm text-white" style="background-color: orangered">Tambah Data</span></li>
        <li>
          anda dapat menambahkan data siswa dalam jumlah banyak menggunakan file Excel dengan ekstensi <strong>.xls</strong> atau <strong>.xlsx</strong>
        </li> 
        <li>gunakan template file untuk menyesuaikan dengan susunan tabel database</li>
      </ul>
      <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Tahun Ajaran Baru</h4>
        <ul>
          <li>Anda dapat melakukan operasi naik kelas pada siswa dengan menekan tombol Naik Kelas</li>
          <li>Sebelum menjalankan tombol naik kelas, pastikan siswa kelas 9 lama telah dihapus dengan menggunakan tombol <span class="btn btn-sm btn-danger">Hapus Siswa Kelas 9 Lama</span></li>
          <li>Berhati - hatilah dalam menggunakan tombol naik kelas, apabila telah tombol di-klik maka operasi tidak akan bisa dibatalkan</li>
        </ul>
      </div>
      <hr>

      <div class="row">
        <form action="/admin/uploadsiswa" method="post" enctype="multipart/form-data">
          @csrf
            <div class="form-group mb-3">
              <div class="row">
                <label for="file" class="form-label fw-bold"><i class="bi bi-info-circle"></i> Upload File Excel</label>
                <div class="col-md-8">
                  <input type="file" name="file" id="file" class="form-control mb-1">
                </div>
                <div class="col-sm-1">
                  <button type="submit" class="btn btn-primary">Upload</button>
                </div>
                
              </div>
            </div>
        </form>
      </div>

      {{-- tambah data, perorangan --}}
      <div class="row">
        <div class="col">
          <div class="row">
            <div class="col-md-12">
              
              <a href="/admin/tambahsiswa" class="btn text-white mb-1" style="background-color: orangered">Tambah Data</a>
              
              {{-- template file excel --}}
              <a href="{{ asset('file/excel/template_upload_data_siswa.xlsx') }}" class="btn btn-success mb-1">Template Excel</a>
              
              {{-- siswa kelas 9 lama --}}
              <button class="btn btn-danger hps mb-1">Hapus Siswa Kelas 9 Lama</button>
              
              <form method="POST" action="{{ route('naik-kelas') }}" class="d-inline-flex mb-1">
                @csrf
                <button type="submit" class="btn btn-warning">Naik Kelas</button>
              </form>
            </div>
          </div>
        </div>
      </div>


    </div>

    <div class="alert alert-danger hps-9 d-none" role="alert">
      <h4 class="alert-heading"><i class="bi bi-exclamation-diamond"></i> Perhatian</h4>
      <ul>
        <li>Berhati - hatilah ketika akan menghapus data siswa yang memiliki kelas 9 </li>
        <li>Setelah data siswa kelas 9 dihapus, maka data siswa tersebut akan hilang dari database, dan tidak dapat dikembalikan</li>
        <li>Untuk menghapus data siswa kelas 9, gunakan tombol <span class="btn btn-sm text-white" style="background-color: red">Hapus Siswa Kelas 9</span></li>
        <li id="jumlahData">Jumlah data kelas 9 lama ada sebanyak {{ $jumlahData }} orang</li>
      </ul>

      <hr>

      <div class="col">
        
        <form action="{{ route('siswa.hapus.kelassembilan') }}" method="post">
          @csrf
          <button type="submit" class="btn btn-danger" onclick="return confirmHapus()">Hapus Siswa Kelas 9</button>
        </form>
      </div>

    </div>
    
  </div>

  
  <div class="col-lg-12">
    <div class="card">
      
      <div class="card-body">
        <div class="table-responsive mt-3">
          <table class="table table-striped" id="datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Kelas</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($siswa as $s)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$s->nis}}</td>
                <td>{{ucwords($s->nama_siswa)}}</td>
                <td>{{$s->jenis_kelamin}}</td>           
                {{-- menampilkan kelas siswa--}}
                <td>
                  @if ($s->nama_kelas)
                    {{ $s->nama_tingkat . $s->nama_kelas }}
                  @else
                    {{ 'Kelas belum diatur' }}
                  @endif
                <td>
                  <a href="/admin/siswa/{{$s->kode_siswa}}/edit" class="btn btn-warning btn-sm">Edit</a>

                  <form action="/admin/siswa/{{$s->kode_siswa}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    {{-- konfirmasi alert onclick --}}
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini {!!  $s->nama_siswa  !!} ? ')">Hapus</button>
                  </form>

                  <a href="/admin/detailsiswa/{{ $s->kode_siswa }}" class="btn btn-info btn-sm">Detail</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  var hpsButton = document.querySelector('.hps');
  var hps9 = document.querySelector('.hps-9');

  hpsButton.addEventListener('click', function() {
      if (hps9.classList.contains('d-none')) {
          fadeIn(hps9, 300);
          hps9.classList.remove('d-none');
          this.textContent = 'Batal Hapus';
      } else {
          fadeOut(hps9, 300, function() {
              hps9.classList.add('d-none');
          });
          this.textContent = 'Hapus Siswa Kelas 9';
      }
  });

  function fadeIn(element, duration) {
      element.style.opacity = 0;
      element.style.transition = 'opacity ' + duration + 'ms';
      setTimeout(function() {
          element.style.opacity = 1;
      }, 10);
  }

  function fadeOut(element, duration, callback) {
      element.style.opacity = 1;
      element.style.transition = 'opacity ' + duration + 'ms';
      setTimeout(function() {
          element.style.opacity = 0;
          setTimeout(callback, duration);
      }, 10);
  }



  function confirmHapus() {
    let jumlahData = document.querySelector('#jumlahData').innerText;
    let konfirmasi = confirm(`Yakin ingin menghapus ${jumlahData} data siswa kelas 9 ?`);
    if (konfirmasi) {
      return true;
    } else {
      return false;
    }
  }

</script>

@endsection