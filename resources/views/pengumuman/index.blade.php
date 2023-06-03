@extends('layout.guru')

@section('content')

  @include('partials.page-title', ['title' => $title])

  {{-- <a href="/guru/pengumuman/create" class="btn mb-2 text-white" style="background-color:#33FF00;">Tambah Pengumuman</a> --}}
  
  <button type="button" class="btn mb-2 text-white" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color:#33FF00;" >
    Tambah Pengumuman
  </button>
  <a href="/guru/pengumuman/shared" class="btn mb-2 text-white" style="background-color:#ffbb00;">Pengumuman yang dibuat</a>

  <div class="row">
      @foreach ($pengumuman as $p)
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header fw-bold text-dark pb-0">
            <h5 class="fw-bold"> {!! $p->judul_pengumuman !!} </h5>
          </div>
          <div class="card-body">
            <div class="table-responsive mt-3">
              <p class="text-muted"> {!! $p->deskripsi !!} </p>
            </div>
            
            @php
              // tanggal indonesia
              $hari = date('D', strtotime($p->tgl_upload));
              $tgl = date('d', strtotime($p->tgl_upload));
              $bln = date('F', strtotime($p->tgl_upload));
              $thn = date('Y', strtotime($p->tgl_upload));
              $jam = date('H:i', strtotime($p->tgl_upload));
              
              switch ($hari) {
                case 'Sun':
                $hari = 'Minggu';
                break;
                case 'Mon':
                  $hari = 'Senin';
                  break;
                case 'Tue':
                  $hari = 'Selasa';
                  break;
                case 'Wed':
                  $hari = 'Rabu';
                  break;
                  case 'Thu':
                  $hari = 'Kamis';
                  break;
                  case 'Fri':
                  $hari = 'Jumat';
                  break;
                  case 'Sat':
                  $hari = 'Sabtu';
                  break;
                }
                
                switch ($bln) {
                  case 'January':
                  $bln = 'Januari';
                  break;
                  case 'February':
                  $bln = 'Februari';
                  break;
                case 'March':
                  $bln = 'Maret';
                  break;
                  case 'April':
                  $bln = 'April';
                  break;
                  case 'May':
                  $bln = 'Mei';
                  break;
                  case 'June':
                  $bln = 'Juni';
                  break;
                  case 'July':
                  $bln = 'Juli';
                  break;
                  case 'August':
                  $bln = 'Agustus';
                  break;
                  case 'September':
                  $bln = 'September';
                  break;
                  case 'October':
                  $bln = 'Oktober';
                  break;
                  case 'November':
                  $bln = 'November';
                  break;
                  case 'December':
                  $bln = 'Desember';
                  break;
                }
                
                $tgl_indo = $hari.', '.$tgl.' '.$bln.' '.$thn.' - '.$jam;
                
                
                @endphp
            <i class="text-muted">Diterbitkan {{ $tgl_indo }}</i>
          </div>
          
          <div class="card-footer py-1 d-flex">
            
            {{-- Dibuat oleh admin atau guru--}}
            @if($p->kode_guru == null)
            <i class="ms-0">Admin</i>
            @else
            <i class="ms-0">{{ $p->guru->nama }}</i>
            @endif
    
    
          </div>
        </div>
      </div>
      @endforeach

  </div>
  <!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pengumuman Baru</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/guru/pengumuman" method="post">
          @csrf
          <div class="modal-body">
            @csrf
            <div class="form-group">
              <label for="judul_pengumuman">Judul Pengumuman</label>
              <input type="text" name="judul_pengumuman" id="judul_pengumuman" class="form-control @error('judul_pengumuman') is-invalid @enderror">
              @error('judul_pengumuman')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <label for="mytextarea">Deskripsi Pengumuman</label>
              <textarea name="deskripsi" id="mytextarea" cols="30" rows="10" class="form-control @error('deskripsi') is-invalid @enderror"></textarea>
              @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            {{-- <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary mt-2">Tambah</button>
            </div> --}}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>

      </div>
    </div>
  </div>

@endsection