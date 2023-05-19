@extends('layout.siswa')
@section('content')
  <div class="card bg-white">
    <div class="card-body mt-3">
      <table class="table table-borderless">
        <tr>
          <th>Judul Materi</th>
          <td>:</td>
          <td>{{ $materi->judul_materi }}</td>
        </tr>
        <tr>
          <th>Deskripsi</th>
          <td>:</td>
          <td>
            @php 
              if($materi->keterangan != '-'){
                echo $materi->keterangan;
              }else{
                echo 'Tidak ada keterangan';
              }
            @endphp
          </td>
        </tr>
        <tr>
          <th>Tanggal Upload</th>
          <td>:</td>
          <td>{{ $materi->created_at }}</td>
        </tr>
        <tr>
          <th>Mata Pelajaran</th>
          <td>:</td>
          <td>{{ $materi->mapel->nama_pelajaran }}</td>
        </tr>
      </table>
    </div>
  </div>
  <div class="card">
    <h5 class="card-header">{{ $materi->berkas }}</h5>
    <div class="card-body">
      {{-- cek ekstensi file apakah docx,pptx,xlsx --}}

      @php
        $ekstensi = explode('.',$materi->berkas);
        $ekstensi = end($ekstensi);
      @endphp

      @if ($ekstensi == 'docx' || $ekstensi == 'pptx' || $ekstensi == 'xlsx')
        {{-- google docs --}}
        <embed src="https://docs.google.com/gview?url={{ asset('file/materi/'.$materi->berkas) }}&embedded=true" style="width:100%; height:500px;" frameborder="0">
      @elseif($ekstensi == 'pdf')
        <embed src="{{ asset('file/materi/'.$materi->berkas) }}" type="application/pdf" width="100%" height="500px">
      @else
        <img src="{{ asset('file/materi/'.$materi->berkas) }}" alt="" width="100%" height="500px">
      @endif


      {{-- download materi --}}
      <div class="col d-flex">
        <a href="{{ asset('file/materi/'.$materi->berkas) }}" class="ms-auto text-white btn mt-2 mx-2" style="background-color:orange;" download>Download</a> 
        <a href="/siswa/materi" class="btn mt-2" style="color:orange;border: 1px solid orange;">Kembali</a> 
      </div>

    </div>
  </div>
@endsection