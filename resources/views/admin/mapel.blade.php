@extends('layout.main')
@section('content')

@include('partials.page-title', ['title' => $title])

<div class="row">
  <div class="col-lg-12">
    @if (session()->has('sukses'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {!! session('sukses') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
      <div class="card-body">
        <form action="/admin/mapel" method="post">
          @csrf
          <div class="row">
            <div class="col-md-6">

                <label class="mt-3" for="pelajaran">Mata Pelajaran</label>
                <div class="form-group">
                  <input type="text" name="pelajaran" id="pelajaran" class="form-control @error('pelajaran')is-invalid @enderror" placeholder="Matematika">
                  @error('pelajaran')
                  <div class="invalid-feedback">
                    {{$message}}
                  </div>
                  @enderror
                </div>

                  <button type="submit" class="ms-auto mt-2 btn text-white" style="background-color:orange;"><i class="bi bi-plus"></i> Tambah </button>

            </div>

          </div>
        </form>

        <div class="table-responsive mt-3">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($mapel as $m)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$m->nama_pelajaran}}</td>
                <td>          
                  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $m->kode_pelajaran }}">
                    <i class="bi bi-pencil-square"></i>
                  </button>

                  {{-- form edit data di dalam modal --}}
                  <div class="modal fade" id="exampleModal{{ $m->kode_pelajaran }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="/admin/mapel/{{ $m->kode_pelajaran }}" method="post">
                            @method('patch')
                            @csrf
                            <div class="mb-3">
                              <label for="pelajaran" class="form-label">Mata Pelajaran</label>
                              <input type="text" class="form-control" id="pelajaran" name="pelajaran" value="{{ $m->nama_pelajaran }}">
                            </div>

                              <button type="button" class="btn btn-white" style="color:orange; border:1px solid orange;" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn text-white" style="background-color:orange;">Ubah</button>
                            
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <form action="/admin/mapel/{{$m->kode_pelajaran}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


@endsection