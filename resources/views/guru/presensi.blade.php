@extends('layout.guru')

@section('content')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/guru">Home</a></li>
        <li class="breadcrumb-item active"><a href="/guru">Rekap Presensi</a></li>
    </ol>
  </nav>
</div>

<div class="alert alert-info" role="alert">
    <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Data Presensi dan Rekap Presensi</h4>
    <ul>
        <li>Pada halaman ini anda dapat melakukan export presensi untuk tahun ajaran ini, dan anda dapat mengekspor presensi beberapa tahun sebelumnya</li>
        <li>Untuk mengekspor presensi anda harus mengisi, tahun ajaran , kelas, dan mata pelajaran yang anda ampu</li>
        <li>Selain itu anda dapat melakukan operasi ubah data pada presensi pernah anda buat sebelumnya</li>
        <li>Anda dapat melakukan filter berdasarkan tahun ajaran untuk mencari presensi terkait, sehingga baik presensi tahun ini dan histori tahun lalu dapat dilacak
        </li>
    </ul>
    <h5 class="fw-bold">Export Rekap Presensi</h5>
    <form action="/guru/rekappresensi" method="get">
        <div class="row">
            <div class="col">
                <!-- Tahun Ajaran Dropdown -->
                <div class="mb-3">
                    <label for="tahunAjaranDropdown" class="form-label">Tahun Ajaran:</label>
                    <select id="tahunAjaranDropdown" class="form-select" onchange="loadKelasMapelOptions(this.value)">
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach ($tahunAjaranOptions as $id => $tahunAjaran)
                            <option value="{{ $id }}">{{ $tahunAjaran }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                    <!-- Kelas Dropdown -->
                    <div class="mb-3">
                        <label for="kelasDropdown" class="form-label">Kelas:</label>
                        <select id="kelasDropdown" name="kode_kelas" class="form-select"></select>
                    </div>
            </div>
            <div class="col">
                <!-- Mapel Dropdown -->
                <div class="mb-3">
                    <label for="mapelDropdown" class="form-label">Mata Pelajaran:</label>
                    <select id="mapelDropdown" name="kode_pelajaran" class="form-select"></select>
                </div>
            </div>
            <div class="col">
                <!-- Submit Button -->
                <div class="mb-3">
                    <label for="submitBtn" class="form-label">&nbsp;</label>
                    <button id="submitBtn" type="submit" class="btn btn-success form-control">Export Excel</button>
                </div>
            </div>
        </div>

    </form>

</div>

<hr>

<form action="{{ route('presensi') }}" method="GET" class="mb-2">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="tahun_ajaran" class="fw-bold">Filter</label>
                <select name="tahun_ajaran" id="tahun_ajaran" class="form-select">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach ($tahunAjaranOptions as $tahunAjaranId => $tahunAjaran)
                        <option value="{{ $tahunAjaranId }}">{{ $tahunAjaran }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-1">
            {{-- button --}}
            <div class="form-group">
                <label for="submitBtn">&nbsp;</label>
                <button id="submitBtn" type="submit" class="btn btn-success form-control">Filter</button>
            </div>
        </div>
    </div>
</form>

<h5 class="fw-bold">Semua Presensi yang pernah dilakukan</h5>

{{-- hampir benar --}}
{{-- <div class="row">
    @php
        $displayedDates = []; // Menyimpan tanggal presensi yang telah ditampilkan sebelumnya
    @endphp
    @foreach ($groupedPresensi as $tanggalPresensi => $kelasMapel)
        @php
            $formattedDate = \Carbon\Carbon::parse($tanggalPresensi)->translatedFormat('l, d F Y');
        @endphp
        @if (!in_array($formattedDate, $displayedDates))
            @php
                $displayedDates[] = $formattedDate; // Tambahkan tanggal presensi saat ini ke array displayedDates
            @endphp
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header-guru">
                        <h5 class="fw-bold">Tanggal: {{ $formattedDate }}</h5>
                        <hr>
                    </div>
                    <div class="card-body">
                        @foreach ($kelasMapel as $kelas => $mapelTahun)
                            @foreach ($mapelTahun as $mapel => $tahunPresensi)
                                @foreach ($tahunPresensi as $tahun => $presensi)
                                    <h5 class="fw-bold">{{ $kelas }}</h5>
                                    <p class="m-0">{{ $mapel }}</p>
                                    <p class="m-0">{{ $tahun }}</p>
                                    @php
                                        $statusCounts = [
                                            'S' => 0,
                                            'H' => 0,
                                            'I' => 0,
                                            'A' => 0,
                                            'K' => 0,
                                        ];
                                        foreach ($presensi as $data) {
                                            $statusCounts[$data['status']]++;
                                        }
                                    @endphp
                                    <p>S: {{ $statusCounts['S'] }}, H: {{ $statusCounts['H'] }}, I: {{ $statusCounts['I'] }}, A: {{ $statusCounts['A'] }}, K: {{ $statusCounts['K'] }}</p>
                                    <p>Total: {{ count($presensi) }}</p>
                                    <hr>
                                    <!-- Tombol Ubah Data -->
                                    @php
                                        $kodeKelas = $data['kode_kelas'];
                                        $kodePelajaran = $data['kode_pelajaran'];
                                    @endphp
                                    <a href="/guru/presensi/{{ $data['tanggal_presensi'] }}/edit/{{ $kodeKelas }}/{{ $kodePelajaran }}" class="btn btn-primary">Ubah Data</a>
                                @endforeach
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div> --}}
@if(count($groupedPresensi) > 0) 
    <div class="row">
        @php
            $displayedCards = []; // Menyimpan informasi card yang telah ditampilkan sebelumnya (tanggal presensi dan kelas)
        @endphp
        @foreach ($groupedPresensi as $tanggalPresensi => $kelasMapel)
            @foreach ($kelasMapel as $kelas => $mapelTahun)
                @php
                    \Carbon\Carbon::setLocale('id');
                    $formattedDate = \Carbon\Carbon::parse($tanggalPresensi)->translatedFormat('l, d F Y');
                    $cardIdentifier = $formattedDate . '-' . $kelas;
                @endphp
                @if (!in_array($cardIdentifier, $displayedCards))
                    @php
                        $displayedCards[] = $cardIdentifier; // Tambahkan informasi card saat ini ke array displayedCards
                    @endphp
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header-guru">
                                <h5 class="fw-bold">{{ $formattedDate }}</h5>
                                <h5 class="fw-bold">{{ $kelas }}</h5>
                                <hr>
                            </div>
                            <div class="card-body">
                                @foreach ($mapelTahun as $mapel => $tahunPresensi)
                                    @foreach ($tahunPresensi as $tahun => $presensi)
                                        <p class="m-0">{{ $mapel }}</p>
                                        <p class="m-0">{{ $tahun }}</p>
                                        @php
                                            $statusCounts = [
                                                'S' => 0,
                                                'H' => 0,
                                                'I' => 0,
                                                'A' => 0,
                                                'K' => 0,
                                            ];
                                            foreach ($presensi as $data) {
                                                $statusCounts[$data['status']]++;
                                            }
                                        @endphp
                                        <p>S: {{ $statusCounts['S'] }}, H: {{ $statusCounts['H'] }}, I: {{ $statusCounts['I'] }}, A: {{ $statusCounts['A'] }}, K: {{ $statusCounts['K'] }}</p>
                                        <p>Total: {{ count($presensi) }}</p>
                                        <hr>
                                        <!-- Tombol Ubah Data -->
                                        @php
                                            $kodeKelas = $data['kode_kelas'];
                                            $kodePelajaran = $data['kode_pelajaran'];
                                        @endphp
                                        <a href="/guru/presensi/{{ $data['tanggal_presensi'] }}/edit/{{ $kodeKelas }}/{{ $kodePelajaran }}" class="btn btn-primary">Ubah Data</a>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endforeach

        {{-- links --}}
        <div class="col-md-12">
            <div class="d-flex justify-content-center">
                {{ $groupedPresensi->links() }}
            </div>
        </div>
    </div>


@else
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Tidak ada data presensi!</h4>
        <p>Silakan lakukan presensi terlebih dahulu.</p>
    </div>
@endif




    {{-- <div class="row">
        @foreach ($groupedPresensi as $kelas => $mapel)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header-guru">
                        <h5 class="fw-bold">{{ $kelas }}</h5>
                        @foreach ($mapel as $namaMapel => $tahunAjaran)
                            @foreach ($tahunAjaran as $tahun => $presensi)
                                @if ($loop->first)
                                    <p class="m-0">{{ $tahun }}</p>
                                    @php 
                                        $tanggalPresensi = $presensi[0]['tanggal_presensi'];
                                        \Carbon\Carbon::setLocale('id');
                                        $tanggalPresensi = \Carbon\Carbon::parse($tanggalPresensi)->translatedFormat('l, d F Y');
                                    @endphp
                                    <h5 class="fw-bold">{{ $tanggalPresensi}}</h5>
                                    <hr>
                                @endif
                            @endforeach
                            @break
                        @endforeach
                    </div>
                    <div class="card-body">
                        @foreach ($mapel as $namaMapel => $tahunAjaran)
                            @foreach ($tahunAjaran as $presensi)
                                
                                    <p class="m-0">{{ $namaMapel }}</p>
                                    @php
                                        $statusCounts = [
                                            'S' => 0,
                                            'H' => 0,
                                            'I' => 0,
                                            'A' => 0,
                                            'K' => 0,
                                        ];
                                    @endphp
                                    @foreach ($presensi as $data)
                                        @php
                                            $statusCounts[$data['status']]++;
                                        @endphp
                                    @endforeach
                                    <p>S: {{ $statusCounts['S'] }}, H: {{ $statusCounts['H'] }}, I: {{ $statusCounts['I'] }}, A: {{ $statusCounts['A'] }}, K: {{ $statusCounts['K'] }}</p>
                                    <p>Total: {{ count($presensi) }}</p>
                                    <hr>

                                    <!-- Tombol Ubah Data -->
                                    @php
                                        $tanggalPresensi = $presensi[0]['tanggal_presensi'];
                                        $kodeKelas = $presensi[0]['kode_kelas'];
                                        $kodePelajaran = $presensi[0]['kode_pelajaran'];
                                    @endphp
                                    <a href="/guru/presensi/{{ $tanggalPresensi }}/edit/{{  $kodeKelas }}/{{ $kodePelajaran }}" class="btn btn-primary">Ubah Data</a>
                                    <hr>
                                
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-md-12">
            <div class="d-flex justify-content-center">
                {{ $groupedPresensi->links() }}
            </div>
        </div>

    </div> --}}

    {{-- <div class="row">
        @foreach ($groupedPresensi as $kelas => $mapel)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header-guru">
                        <h5 class="fw-bold">{{ $kelas }}</h5>
                        @foreach ($mapel as $namaMapel => $tahunAjaran)
                            @foreach ($tahunAjaran as $tahun => $presensi)
                                @foreach ($presensi as $data)
                                    @php
                                        $tanggalPresensi = \Carbon\Carbon::parse($data['tanggal_presensi'])->translatedFormat('l, d F Y');
                                        $statusCounts = [
                                            'S' => 0,
                                            'H' => 0,
                                            'I' => 0,
                                            'A' => 0,
                                            'K' => 0,
                                        ];
                                        foreach ($presensi as $item) {
                                            $statusCounts[$item['status']]++;
                                        }
                                    @endphp
                                    <p class="m-0">{{ $tahun }}</p>
                                    <h5 class="fw-bold">{{ $tanggalPresensi }}</h5>
                                    <hr>
                                    <p class="m-0">{{ $namaMapel }}</p>
                                    <p>S: {{ $statusCounts['S'] }}, H: {{ $statusCounts['H'] }}, I: {{ $statusCounts['I'] }}, A: {{ $statusCounts['A'] }}, K: {{ $statusCounts['K'] }}</p>
                                    <p>Total: {{ count($presensi) }}</p>
                                    <hr>
                                    <!-- Tombol Ubah Data -->
                                    @php
                                        $kodeKelas = $data['kode_kelas'];
                                        $kodePelajaran = $data['kode_pelajaran'];
                                    @endphp
                                    <a href="/guru/presensi/{{ $data['tanggal_presensi'] }}/edit/{{ $kodeKelas }}/{{ $kodePelajaran }}" class="btn btn-primary">Ubah Data</a>
                                    <hr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    
        <div class="col-md-12">
            <div class="d-flex justify-content-center">
                {{ $groupedPresensi->links() }}
            </div>
        </div>
    </div> --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script>
        function loadKelasMapelOptions(tahunAjaranId) {
            // Hapus pilihan kelas dan mapel yang ada
            $('#kelasDropdown').empty();
            $('#mapelDropdown').empty();
    
            // Jika tidak ada tahun ajaran yang dipilih, hentikan eksekusi
            if (!tahunAjaranId) {
                return;
            }
    
            // Kirim permintaan AJAX untuk mendapatkan opsi kelas dan mapel
            $.ajax({
                url: "{{ route('loadOptions') }}",
                method: "GET",
                data: {
                    tahun_ajaran: tahunAjaranId
                },
                success: function (response) {
                    // Tambahkan opsi kelas ke dropdown
                    var kelasDropdown = $('#kelasDropdown');
                    kelasDropdown.append('<option value="">Pilih Kelas</option>');
                    $.each(response.kelasOptions, function (index, kelasOption) {
                        kelasDropdown.append('<option value="' + kelasOption.kode_kelas + '">' + kelasOption.nama_kelas + '</option>');
                    });
    
                    // Tambahkan opsi mapel ke dropdown
                    var mapelDropdown = $('#mapelDropdown');
                    mapelDropdown.append('<option value="">Pilih Mata Pelajaran</option>');
                    $.each(response.mapelOptions, function (index, mapelOption) {
                        mapelDropdown.append('<option value="' + mapelOption.kode_pelajaran + '">' + mapelOption.nama_pelajaran + '</option>');
                    });
                },
                error: function (xhr, status, error) {
                    console.log(error);
                }
            });
        }
    </script>


@endsection