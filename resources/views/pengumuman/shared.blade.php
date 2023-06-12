@extends('layout.guru')

@section('content')
  <div class="row">
    <div class="col-md-4">
      @include ('partials.page-title', ['title' => 'Pengumuman yang dibuat'])
    </div>

    <div class="col-md-8 d-flex my-auto">
      <a href="/guru/pengumuman" class="ms-auto btn btn-primary">Kembali</a>
    </div>
  </div>

  <div class="row">
    {{-- Alert --}}
    @if (session('status'))
      <div class="col-lg-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle"></i> {{ session('status') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif

    @if($pengumuman->count() <= 0)
      <div class="col-lg-12">
        <div class="alert alert-info" role="alert">
          <h4 class="alert-heading">Tidak ada pengumuman yang dibuat!</h4>
          <p>Silahkan buat pengumuman terlebih dahulu.</p>
          <hr>
          <a href="/guru/pengumuman" class="btn btn-primary">Kembali ke halaman pengumuman</a>
        </div>
      </div>
    @endif

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

              $tgl_indo = $hari.', '.$tgl.' '.$bln.' '.$thn.' '.$jam.' WIB';

          @endphp
          <br>
          <i class="text-muted">Diterbitkan {{ $tgl_indo }}</i>

          <div class="d-flex justify-content-end">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $p->id }}">
              Edit
            </button>

            <form action="/guru/pengumuman/{{ $p->id }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </div>

        </div>
      </div>
    </div>
    @endforeach
  </div>

  

<!-- Modal -->
@if($pengumuman->count() > 0)
  <div class="modal fade" id="exampleModal{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit {{ $p->judul_pengumuman }}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/guru/pengumuman/{{ $p->id }}" method="post">
          <div class="modal-body">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="judul_pengumuman">Judul Pengumuman</label>
              <input type="text" name="judul_pengumuman" id="judul_pengumuman" class="form-control @error('judul_pengumuman') is-invalid @enderror" value="{{ $p->judul_pengumuman }}">
              @error('judul_pengumuman')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <label for="mytextarea">Deskripsi Pengumuman</label>
              <textarea name="deskripsi" id="mytextarea" cols="30" rows="10" class="form-control @error('deskripsi') is-invalid @enderror">
                {{ $p->deskripsi }}
              </textarea>
              @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endif



@endsection