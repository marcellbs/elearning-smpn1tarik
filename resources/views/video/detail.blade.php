@extends('layout.guru')

@section('content')

<div class="card bg-white">
  <div class="card-body mt-3">
    <table class="table table-borderless">
      <tr>
        <th>Judul</th>
        <td>:</td>
        <td>{{ $video->judul }}</td>
      </tr>
      <tr>
        <th>Tautan</th>
        <td>:</td>
        <td>
          {{ $video->link }} <a href="{{ $video->link }}"><i class="bi bi-link"></i></a> 
        </td>
      </tr>
      <tr>
        <th>Dibuat oleh</th>
        <td>:</td>
        @if ($video->kode_guru != '' || $video->kode_guru != null)
          <td>{{ $video->guru->nama }}</td>
        @else
          <td>Administrator</td>
        @endif
      </tr>
      <tr>
        <th>Tanggal Upload</th>
        <td>:</td>
        <td>{{ $video->created_at }}</td>
      </tr>
      <tr>
        <th>Mata Pelajaran</th>
        <td>:</td>
        <td>{{ $video->mapel->nama_pelajaran }}</td>
      </tr>
      <tr>
        <th>Kelas</th>
        <td>:</td>
        <td>{{ $video->tingkat }}</td>
      </tr>
    </table>
  </div>
</div>

<div class="card">
  <h5 class="card-header">{{ $video->judul }}</h5>
  <div class="card-body">

    @php
      $link = explode('=', $video->link);
    @endphp
    <iframe width="100%" height="500px" src="https://www.youtube.com/embed/{{ end($link) }}" frameborder="0" allowfullscreen></iframe>

    <div class="d-flex">
      <a href="/guru/video" class="btn mt-2 ms-auto" style="color:orange;border: 1px solid orange;">Kembali</a> 
    </div>
  </div>
</div>



@endsection