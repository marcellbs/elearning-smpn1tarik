@extends('layout.guru')

@section('content')

@include('partials.page-title', ['title' => $title])

{{-- <form action="{{ '/guru/tugas' }}" method="GET" class="mb-3">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
          <select name="kode_kelas" id="kode_kelas" class="form-select">
              <option value="">Pilih Kelas</option>
              @foreach($kelasOptions as $kodeKelas)
                <option value="{{ $kodeKelas->kode_kelas }}" {{ request('kode_kelas') == $kodeKelas->kode_kelas ? 'selected' : '' }}>{{ $kodeKelas->nama_kelas }}</option>
              @endforeach
          </select>
      </div>
    </div>

    <div class="col-md-3">
      <button type="submit" class="btn btn-primary">Filter</button>
    </div>
  </div>
  
</form> --}}

<form method="GET" action="/guru/tugas" id="filter-form" class="mb-3">
  <div class="row">
    <p>Filter Tugas</p>
    <div class="col">
      {{-- <label for="tahun_ajaran">Tahun Ajaran:</label> --}}
      <div class="form-group">
        <select name="tahun_ajaran" id="tahun_ajaran" class="form-select">
            <option value="">-- Pilih Tahun Ajaran --</option>
            {{-- selected --}}
            @foreach($tahunAjaranOptions as $tahunAjaranId => $tahunAjaran)
                <option value="{{ $tahunAjaranId }}">
                    {{ $tahunAjaran }}
                </option>
            @endforeach
        </select>
      </div>
    </div>
    <div class="col">
      {{-- <label for="kode_kelas">Kelas:</label> --}}
      <div class="form-group">
        <select name="kode_kelas" id="kode_kelas" class="form-select">
            <option value="">-- Pilih Kelas --</option>
        </select>
      </div>
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary">Filter</button>
    </div>
  </div>
</form>

@if (session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {!! session('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<a href="/guru/tugas/create" class="btn text-white mb-3" style="background-color: #33ff00">Buat tugas baru</a>
<a href="/guru/tugas/report" class="btn btn-primary mb-3">Report tugas</a>
<div class="row">
    @if (count($tugas) == 0)
      <div class="col-lg-12">
        <div class="alert alert-warning">
          <p class="mb-0">Tidak ada tugas yang dibuat</p>
        </div>  
      </div>
    @else    
      @foreach ($tugas as $t)
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex mt-2">
                <span class="badge text-bg-primary ms-auto ">{{ $t->mapel->nama_pelajaran }}</span>
              </div>
              <a href="/guru/tugas/{{ $t->kode_tugas }}">
                <h5 class="mt-2"><strong>{{ $t->judul_tugas }} - {{$t->kelas->nama_kelas}}</strong></h5>
              </a>

              <p>{{ $t->keterangan }}</p>
              
              @php
                $deadline = $t->deadline;
                \Carbon\Carbon::setLocale('id');
                $deadline = \Carbon\Carbon::parse($deadline)->translatedFormat('l, d F Y');
              @endphp
              <p class="mb-2">Batas pengumpulan : {{ $deadline }}</p>

              <p class="mb-2">
                Mengumpulkan : {{ $t->getJumlahSiswaMengumpulkanAttribute() }} / {{ $t->jumlahSiswaKelas  }}
              </p>
              
              <div class="d-flex">
                <div class="mt-2">
                  <span class="badge text-bg-success"> <p class="mb-0">{{ $t->kelas->nama_kelas}}</p></span>
                </div>
                
                @if($t->berkas != null)
                <div class="mt-2 ms-1">
                  <span class="badge text-bg-warning"> <p class="mb-0"> <i class="bi bi-link-45deg"></i> Lampiran</p></span>
                </div>
                @endif

                {{-- delete --}}
                <form action="/guru/tugas/{{ $t->kode_tugas }}" method="post" class="d-inline ms-auto">
                  @csrf
                  @method('delete')
                  <button type="submit" onclick="return confirm('Apakah anda yakin menghapus tugas ini?')" class="btn btn-sm btn-danger ms-auto">Hapus Tugas</button>
                </form>

                <a href="/guru/tugas/{{ $t->kode_tugas }}/edit" class="btn btn-sm ms-2" style="background-color: orange;">Edit Tugas</a>

              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif
</div>
{{-- paginate --}}
<div class="d-flex justify-content-center">
  {{ $tugas->links() }}
</div>

{{-- <div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex mt-2">
          <span class="badge text-bg-primary ms-auto">Bahasa Inggris</span>
        </div>
        <h5 class="mb-2"> <strong>Tugas 1</strong> </h5>

        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
        <p class="mb-1">Batas pengumpulan : 14 Desember 2022 - 15:00</p>
        <p>Mengumpulkan : 28/36</p>
    
        <div class="d-flex">
          
          <span class="badge text-bg-success"> <p class="mb-0">9A</p></span>
          <a href="#" class="btn btn-danger ms-auto">Hapus Tugas</a>
          <a href="#" class="btn ms-2" style="background-color: orange;">Hapus Tugas</a>
        </div>
      </div>
    </div>
  </div>
</div> --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

<!-- Script Ajax untuk mengubah dropdown kelas -->
<script>
  $(document).ready(function() {
      var kodeKelasTerpilih = '{{ $kodeKelasTerpilih }}';
      var tahunAjaranTerpilih = '{{ $tahunAjaranTerpilih }}';

      $('#tahun_ajaran').on('change', function() {
          var tahunAjaranId = $(this).val();
          if (tahunAjaranId) {
              $.ajax({
                  url: '{{ route("kelas.getByTahunAjaran") }}',
                  type: 'GET',
                  data: {
                      tahun_ajaran_id: tahunAjaranId
                  },
                  dataType: 'json',
                  success: function(data) {
                      $('#kode_kelas').empty();
                      $('#kode_kelas').append('<option value="">-- Pilih Kelas --</option>');
                      $.each(data, function(key, value) {
                          $('#kode_kelas').append('<option value="' + key + '">' + value + '</option>');
                      });

                      // Set kelas terpilih jika sudah dipilih sebelumnya
                      if (tahunAjaranId === tahunAjaranTerpilih && kodeKelasTerpilih) {
                          $('#kode_kelas').val(kodeKelasTerpilih);
                      }
                  },
                  error: function(xhr, status, error) {
                      console.log(xhr.responseText);
                  }
              });
          } 
      });
  });

</script>

@endsection