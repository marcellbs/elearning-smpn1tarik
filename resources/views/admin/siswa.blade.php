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
                <th>NIS</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Kelas</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($siswa as $s)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$s->nis}}</td>
                <td>{{ucwords($s->nama_siswa)}}</td>
                <td>{{$s->jenis_kelamin}}</td>           
                {{-- menampilkan kelas siswa--}}
                <td>
                  {{ $s->kelas_Siswa() }}
                <td>
                  <a href="/admin/siswa/{{$s->kode_siswa}}/edit" class="btn btn-warning">Edit</a>
                  <form action="/admin/siswa/{{$s->id}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
                  <a href="#" class="btn btn-info">Detail</a>
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