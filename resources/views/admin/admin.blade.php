@extends('layout.main')

@section('content')

@include('partials.page-title-pengguna', ['title' => $title])

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              {{-- menampilkan data admin dari method admin --}}
              @foreach ($admin as $a)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $a['nama'] }}</td>
                  <td>{{ $a['email'] }}</td>
                  <td>
                    <a href="/admin/editadmin/{{ $a['kode_guru'] }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="/admin/deleteadmin/{{ $a['kode_guru'] }}" class="btn btn-danger btn-sm">Hapus</a>
                  </td>
                </tr>
              @endforeach



            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection