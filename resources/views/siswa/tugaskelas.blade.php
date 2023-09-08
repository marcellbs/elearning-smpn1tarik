@extends('layout.ruangkelassiswa')

@section('content')

  <div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/siswa">Home</a></li>
          <li class="breadcrumb-item"><a href="/siswa/detail/{{ $hash->encode($pengampu->id) }}">Ruang Kelas</a></li>
          <li class="breadcrumb-item active"><a href="/siswa/tugas-kelas/{{ $hash->encode($pengampu->id) }}">Tugas {{ $pengampu->mapel->nama_pelajaran }}</a></li>
        </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="row">

        @if(count($tugas) == 0 )
          <div class="col-md-12">
            <div class="alert alert-warning" role="alert">
              <h4 class="alert-heading text-center">Belum tugas yang dibuat</h4>
            </div>
          </div>
        @else
          
          @foreach ($tugas as $t)
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex mt-2">
                    <span class="badge text-bg-primary ms-auto">{{ $t->mapel->nama_pelajaran }}</span>
                  </div>
                  <a href="/siswa/tugas/{{ $t->kode_tugas }}">
                    <h5 class="my-2"><strong>{{ $t->judul_tugas }}</strong></h5>
                  </a>

                  <p>{{ $t->keterangan }}</p>
                  {{-- batas pengumpulan dimana angka bulan diganti dengan nama bulan dalam bahasa indonesia--}}
                  <p class="mb-1">Batas pengumpulan : {{ date('d F Y - H:i', strtotime($t->deadline)) }}</p>
                  <p>Mengumpulkan : 
                    @php
                    $jawaban = $t->jawaban->where('kode_tugas', $t->kode_tugas)->where('kode_siswa', auth()->user()->kode_siswa)->first();
                    @endphp

                    @if ($jawaban)
                      {{ date('d F Y - H:i', strtotime($jawaban->tgl_upload)) }}
                    @else
                      {{ 'Belum Mengumpulkan' }}
                    @endif

                  </p>
                  <p>
                    Nilai : {{ $jawaban->nilai ?? 'Belum dinilai' }}
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
                    
                    @php
                      
                      // $siswa = \App\Models\Siswa::where('kode_siswa', auth()->user()->kode_siswa)->first();
                      $jawaban = $t->jawaban->where('kode_tugas', $t->kode_tugas)->where('kode_siswa', auth()->user()->kode_siswa)->first();
                      $deadline = \Carbon\Carbon::parse($t->deadline);
                      $terlambat = false;
                      if ($jawaban) {
                          $tgl_pengumpulan = \Carbon\Carbon::parse($jawaban->tgl_upload);
                          if ($tgl_pengumpulan->isAfter($deadline)) {
                              $terlambat = true;
                          }
                      }
                    @endphp
                    @if ($jawaban)
                        @if ($terlambat)
                        <div class="mt-2 ms-1 ms-auto">
                          <span class="badge text-light" style="background-color: orange;">
                            Terlambat Mengumpulkan
                          </span>
                        </div>
                        @else
                        <div class="mt-2 ms-1 ms-auto">
                          <span class="badge text-bg-success">
                            Sudah Mengumpulkan
                          </span>
                        </div>
                        @endif
                    @else
                      <div class="mt-2 ms-1 ms-auto">
                        <span class="badge text-bg-danger">
                          Belum Mengumpulkan
                        </span>
                      </div>
                    @endif
                    

                  </div>
                </div>
              </div>
            </div>
          @endforeach
          
        @endif
      </div>
    </div>
  </div>

  <p class="mb-0">Halaman : {{ $tugas->currentPage(); }}</p>
  <p class="mb-0">Jumlah Tugas  : {{ $tugas->total(); }}</p>
  <p class="mb-0">Data Per Halaman : {{ $tugas->perPage(); }}</p>

  <div class="d-flex justify-content-center mt-3">
    {{ $tugas->links() }}
  </div>

@endsection