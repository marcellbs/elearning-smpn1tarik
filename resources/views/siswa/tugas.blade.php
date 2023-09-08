@extends('layout.siswa')

@section('content')
  @include ('partials.page-title', ['title' => 'Tugas'])

  <div class="alert alert-info" role="alert">
      <h4 class="alert-heading"><i class="bi bi-info-circle"></i> Tugas Siswa</h4>
      <ul>
          <li>Anda dapat melihat semua tugas yang dibuat oleh guru pengampu di kelas anda</li>
          <li>Anda juga dapat melihat histori tugas yang pernah anda kerjakan melalui filter</li>
          <li>Manfaatkan filter tersebut berdasarkan tahun dan mata pelajaran, atau salah satu</li>
      </ul>
  </div>

  <form action="{{ '/siswa/tugas' }}" method="GET" class="mb-3">
    <div class="row">
        <div class="col-md-4">
          <div class="form-group">
                  <label for="kode_pelajaran">Filter berdasarkan Mata Pelajaran:</label>
                  <select name="kode_pelajaran" id="kode_pelajaran" class="form-select">
                      <option value="">Semua Mata Pelajaran</option>
                      @foreach ($pelajaranOptions as $kodePelajaran => $namaPelajaran)
                          <option value="{{ $kodePelajaran }}" {{ $kodePelajaran == Request::get('kode_pelajaran') ? 'selected' : '' }}>
                              {{ $namaPelajaran }}
                          </option>
                      @endforeach
                  </select>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="form-group">
                <label for="tahun_ajaran">Filter berdasarkan Tahun Ajaran:</label>
                <select name="tahun_ajaran" id="tahun_ajaran" class="form-select">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach ($listTahunAjaran as $id => $nama)
                        <option value="{{ $nama }}" {{ $tahun_ajaran_id == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
          </div>
        </div>
        <div class="col-1">
          <label for="submitButton">&nbsp;</label>
          <button type="submit" id="submitButton" class="btn btn-primary">Filter</button>
        </div>
    </div>
  </form>




<div class="row">
    {{-- {{ $tgs->guru }} --}}
    @if (count($tugas) == 0)
      <div class="col-lg-12">
        <div class="alert alert-warning">
          <p class="mb-0 alert-heading text-center">Belum ada tugas yang diberikan</p>
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

{{-- pagination --}}
<div class="d-flex justify-content-center">
  {{ $tugas->links('pagination::bootstrap-4') }}
</div>


@endsection