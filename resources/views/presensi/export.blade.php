@extends('layout.guru')

@section('content')

<!-- resources/views/presensi/export.blade.php -->

<table>
  <thead>
      <tr>
          <th>NIS</th>
          <th>Nama Siswa</th>
          <!-- Tambahkan kolom presensi sesuai dengan periode -->
          @foreach ($presensiData as $presensi)
              <th>{{ $presensi->tanggal_presensi }}</th>
          @endforeach
      </tr>
  </thead>
  <tbody>
      @foreach ($siswaData as $siswa)
          <tr>
              <td>{{ $siswa->nis }}</td>
              <td>{{ $siswa->nama_siswa }}</td>
              <!-- Tambahkan data presensi sesuai dengan periode -->
              @foreach ($presensiData as $presensi)
                  <td>{{ $presensi->getStatusPresensi($siswa->id) }}</td>
              @endforeach
          </tr>
      @endforeach
  </tbody>
</table>

@endsection
