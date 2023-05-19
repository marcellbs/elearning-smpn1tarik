@extends('layout.siswa')

@section('content')
  @include ('partials.page-title', ['title' => 'Tugas'])

<div class="row">
    {{-- {{ $tgs->guru }} --}}
    @if (count($tugas) == 0)

      <div class="alert alert-warning">
        <p class="mb-0">Belum ada tugas yang diberikan</p>
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
                {{-- tgl_upload --}}
                @foreach($jawaban as $j)
                  @if($j->kode_tugas == $t->kode_tugas)
                    {{ date('d F Y - H:i', strtotime($j->tgl_upload)) }}
                  @endif
                @endforeach

              </p>
              
              
          
              <div class="d-flex">
                <div class="mt-2">
                  <span class="badge text-bg-success"> <p class="mb-0">{{ $t->kelas->tingkat->nama_tingkat . $t->kelas->nama_kelas}}</p></span>
                </div>

                @if($t->berkas != null)
                  <div class="mt-2 ms-1">
                    <span class="badge text-bg-warning"> <p class="mb-0"> <i class="bi bi-link-45deg"></i> Lampiran</p></span>
                  </div>
                @endif
                
                @foreach($jawaban as $j)
                  @if($j->kode_tugas == $t->kode_tugas)
                    @if($j->tgl_upload != null)
                      <div class="mt-2 ms-1">
                        <span class="badge text-bg-success"> <p class="mb-0"> <i class="bi bi-check-circle"></i> mengumpulkan</p></span>
                      </div>
                    @endif
                  @endif
                @endforeach

              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif
</div>


@endsection