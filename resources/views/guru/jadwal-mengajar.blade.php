@extends('layout.guru')

@section('content')
  <div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/guru">Home</a></li>
        <li class="breadcrumb-item active"><a href="/guru/jadwal-mengajar">Jadwal Mengajar</a></li>
      </ol>
    </nav>
  </div>

  <div class="row">
    @foreach ($hariList as $hari)
        <div class="col-md-4 p-1">
            <div class="card">
                <div class="card-header-guru bg-info">
                    <h4 class="fw-bold">{{ $hari }}</h4>
                </div>
                <hr class="m-0">
                <ul class="list-group list-group-flush m-0">
                    @if ($jadwalMengajar->has($hari))
                        @foreach ($jadwalMengajar[$hari] as $data)
                            <li class="list-group-item ">
                                <table class="table table-borderless m-0">
                                    <tr>
                                        <td><i class="bi bi-bookmarks"></i></td>
                                        <td><strong>{{ $data->mapel->nama_pelajaran }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="bi bi-building"></i></td>
                                        <td><strong>{{ $data->kelas->tingkat->nama_tingkat }}{{ $data->kelas->nama_kelas }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><i class="bi bi-alarm"></i></td>
                                        <td><strong>{{ $data->jam_mulai }} - {{ $data->jam_berakhir }}</strong></td>
                                    </tr>
                                </table>
                            </li>
                        @endforeach
                    @else
                        <li class="list-group-item">
                            <p class="text-muted">Tidak ada jam mengajar</p>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    @endforeach
</div>

@endsection