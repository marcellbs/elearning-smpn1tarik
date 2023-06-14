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

<form action="" method="get">
  <select name="kode_kelas" id="kode_kelas">
    <option value="">Pilih Kelas</option>
    @foreach($kelas as $k)
      <option value="{{ $k->kode_kelas }}">{{ $k->tingkat->nama_tingkat . $k->nama_kelas }}</option>
    @endforeach
  </select>

  <select name="kode_pelajaran" id="kode_pelajaran">
    <option value="">Pilih Mapel</option>
    @foreach($mapel as $m)
      <option value="{{ $m->kode_pelajaran }}">{{ $m->nama_pelajaran }}</option>
    @endforeach
  </select>

  <button type="submit">Submit</button>

</form>

{{ $tugas }}

@endsection