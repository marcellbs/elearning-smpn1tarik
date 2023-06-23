@extends('layout.guru')

@section('content')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/guru">Home</a></li>
      <li class="breadcrumb-item"><a href="/guru/tugas"></a>Tugas</li>
      <li class="breadcrumb-item active">Report Tugas</li>
    </ol>
  </nav>
</div>

<form action="/guru/tugas/report" method="get">
  <div class="row">
    <p class="mb-0">Pilih Kelas dan Mata Pelajaran</p>
    <div class="row">
      <div class="col mt-1">
        <!-- Dropdown Tahun Ajaran -->
        <select id="tahun_ajaran" class="form-select" name="tahun_ajaran" onchange="populateKelas()">
          <option value="">Pilih Tahun Ajaran</option>
          {{-- selected dropdown--}}
          @foreach($tahunAjaranOptions as $tahunAjaranId => $tahunAjaran)
              <option value="{{ $tahunAjaranId }}">
                  {{ $tahunAjaran }}
              </option>
          @endforeach
        </select>
      </div>
      <div class="col mt-1">
        <!-- Dropdown Kelas -->
        <select id="kode_kelas" class="form-select" name="kode_kelas" onchange="populateMapel()">
          <option value="">Pilih Kelas</option>
          <!-- Opsi kelas akan diisi melalui permintaan AJAX -->
        </select>
      </div>
      <div class="col mt-1">
        <!-- Dropdown Mata Pelajaran -->
        <select id="kode_pelajaran" class="form-select" name="kode_pelajaran">
          <option value="">Pilih Mata Pelajaran</option>
          <!-- Opsi mata pelajaran akan diisi melalui permintaan AJAX -->
        </select>
      </div>
      <div class="col-md-2 mt-1">  
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</form>


<div class="row mt-3">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive my-3">

          @if($kodeKelas && $kodePelajaran && $selectedTahunAjaran)
            
            <h4 class="header-title fw-bold">Summary Tugas</h4>

            <a href="{{ route('tugas.export-excel', [
              'kode_kelas' => $kodeKelas, 
              'kode_pelajaran' => $kodePelajaran, 
              'tahun_ajaran' => $selectedTahunAjaran,
              ]) }}" class="btn btn-success mt-3">Export Excel</a>

            <table class="table table-borderless">
              <tr>
                <td style="width: 150px">Nama Guru</td>
                <td>:</td>
                <td class="fw-bold">{{ $namaGuru }}</td>
              </tr>
              <tr>
                <td style="width: 150px">Mata Pelajaran</td>
                <td>:</td>
                <td class="fw-bold">{{ $namaMapel}}</td>
              </tr>
              <tr>
                <td style="width: 150px">Kelas</td>
                <td>:</td>
                <td class="fw-bold">{{ $kelas->where('kode_kelas', $kodeKelas)->first()->nama_kelas }}</td>
              </tr>
              <tr>
                <td style="width: 150px">Tahun Ajaran</td>
                <td>:</td>
                <td class="fw-bold">{{ $tahunAjaranOptions[$selectedTahunAjaran] }}</td>
              </tr>

            </table>

            <table class="table table-bordered">
              <thead>
                  <tr>
                      <th rowspan="2" class="text-center my-auto" style="width: 30px; white-space: nowrap;">NIS</th>
                      <th rowspan="2" class="text-center my-auto"  style="width: 70px; white-space: nowrap;">Nama Siswa</th>
                      @php
                          $totalTugas = count($tugas);
                      @endphp
                      <th colspan="{{ $totalTugas }}" class="text-center">Tugas</th>
                  </tr>
                  <tr>
                      @foreach ($tugas as $t)
                          <th class="text-center" style="width: 30px;">{{ $t->judul_tugas }}</th>
                      @endforeach
                  </tr>
              </thead>
              <tbody>
                  @foreach ($siswa as $sis)
                      <tr>
                          <td class="text-center">{{ $sis->nis }}</td>
                          <td>{{ $sis->nama_siswa }}</td>
                          @foreach ($tugas as $t)
                          @php
                              $jawaban = $t->jawaban->where('kode_siswa', $sis->kode_siswa)->first();
                              $status = $jawaban ? '&#10004;' : '&#10008;';
                              $statusClass = $jawaban ? 'bg-success text-white' : 'bg-danger text-white';
                              $deadline = \Carbon\Carbon::parse($t->deadline);
                              $tglUpload = $jawaban ? \Carbon\Carbon::parse($jawaban->tgl_upload) : null;
                              $isTerlambat = $jawaban && $tglUpload->greaterThan($deadline);
                              $terlambatClass = $isTerlambat ? 'bg-warning text-white' : '';
                          @endphp
                          <td class="text-center">
                            <button class="btn {{ $statusClass }} {{ $terlambatClass }}">
                              {!! $status !!}
                            </button>
                          </td>
                          @endforeach
                      </tr>
                  @endforeach
              </tbody>
            </table>
            <div class="col">
              <button class="btn btn-success d-inline"></button>
              <p class="d-inline ms-1">Mengumpulkan Tepat Waktu</p>
            </div>
            <div class="col">
              <button class="btn btn-warning"></button>
              <p class="d-inline ms-1">Mengumpulkan Terlambat</p>
            </div>
            <div class="col">
              <button class="btn btn-danger d-inline"></button>
              <p class="d-inline ms-1">Tidak mengumpulkan</p>
            </div>
          @else
            <h4 class="header-title fw-bold">Summary Tugas</h4>
            <p>Pilih Kelas dan Mata Pelajaran terlebih dahulu</p>
          @endif
        </div>
        <div class="col d-flex">
          <a href="/guru/tugas" class="btn btn-primary ms-auto">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<script>
   // Fungsi untuk mengisi opsi kelas berdasarkan tahun ajaran yang dipilih
  function populateKelas() {
        var selectedTahunAjaran = $("#tahun_ajaran").val();

        $.ajax({
            url: "/get-kelas",
            type: "GET",
            data: { 
              tahun_ajaran: selectedTahunAjaran 
            },
            success: function(data) {
                console.log(data);
                // Bersihkan opsi kelas sebelumnya
                $("#kode_kelas").empty();
                $("#kode_kelas").append('<option value="">Pilih Kelas</option>');

                // Tambahkan opsi kelas dari data yang diterima
                $.each(data, function(key, value) {
                    $("#kode_kelas").append('<option value="' + value.kode_kelas + '">' + value.nama_kelas + '</option>');
                });

                populateMapel(); 
            }
        });
    }

    function populateMapel() {
        var selectedTahunAjaran = $("#tahun_ajaran").val();
        var selectedKelas = $("#kode_kelas").val();

        $.ajax({
            url: "/get-mapel",
            type: "GET",
            data: { 
              tahun_ajaran: selectedTahunAjaran, 
              kelas: selectedKelas 
            },
            success: function(data) {
                console.log(data); 
                // Bersihkan opsi mata pelajaran sebelumnya
                $("#kode_pelajaran").empty();
                $("#kode_pelajaran").append('<option value="">Pilih Mata Pelajaran</option>');

                // Tambahkan opsi mata pelajaran dari data yang diterima
                $.each(data, function(key, value) {
                    $("#kode_pelajaran").append('<option value="' + value.kode_pelajaran + '">' + value.nama_pelajaran + '</option>');
                });
            }
            
        });
    }

</script>



@endsection