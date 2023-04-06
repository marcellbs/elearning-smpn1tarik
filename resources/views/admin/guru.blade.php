@extends('layout.main')

@section('content')
@include('partials.page-title-pengguna', ['title' => $title])

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($guru as $g)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$g->nip}}</td>
                <td>{{$g->nama}}</td>
                <td>{{$g->email}}</td>
                <td>
                  <a href="/admin/guru/{{$g->kode_guru}}/edit" class="btn btn-warning">Edit</a>
                  <form action="/admin/guru/{{$g->id}}" method="post" class="d-inline">
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