@extends('layout.guru')

@section('content')
    <h1>Detail Tugas</h1>

    <h2>{{ $tugas->judul_tugas }}</h2>
    <p>Tanggal Deadline: {{ $tgl_indonesia }}</p>

    <h3>Siswa yang Mengumpulkan:</h3>
    @if ($jumlahMengumpulkan > 0)
        <ul>
            @foreach ($siswaMengumpulkan as $siswa)
                <li>{{ $siswa->nis }} - {{ $siswa->nama_siswa }} ({{ $siswa->nama_kelas }})</li>
            @endforeach
        </ul>
    @else
        <p>Tidak ada siswa yang mengumpulkan tugas.</p>
    @endif

    <h3>Siswa yang Belum Mengumpulkan:</h3>
    @if ($jumlahBelumMengumpulkan > 0)
        <ul>
            @foreach ($siswaBelumMengumpulkan as $siswa)
                <li>{{ $siswa->nis }} - {{ $siswa->nama_siswa }} ({{ $siswa->nama_kelas }})</li>
            @endforeach
        </ul>
    @else
        <p>Semua siswa telah mengumpulkan tugas.</p>
    @endif

@endsection