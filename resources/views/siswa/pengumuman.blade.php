@extends('layout.siswa')

@section('content')

  @include ('partials.page-title', ['title' => $title])

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

@endsection