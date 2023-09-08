@extends('layout.main') 

@section('content')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin/video">Manajemen Video</a></li>
      </ol>
  </nav>
</div>

<div class="row">

  
  
  
  <div class="col-lg-12">
    {{-- alert --}}
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p class="m-0">{{ session('success') }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @elseif (session('danger'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p class="m-0">{{ session('danger') }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="card">
      <div class="d-flex">
        {{-- button tambah --}}
        <a href="/admin/video/create" class="btn text-white ms-auto m-2" style="background-color: orange;"><i class="bi bi-plus-circle"></i> Tambah Video</a>
      </div>
      <div class="card-body mt-3">  
          <div class="table-responsive">
            <table class="table table-striped table-hover datatable" id="datatable">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Judul</th>
                  <th>Link</th>
                  <th>Mata Pelajaran</th>
                  <th>Kelas</th>
                  <th>Penerbit</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($video as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->link }}</td>
                    <td>{{ $item->mapel->nama_pelajaran }}</td>
                    <td>{{ $item->tingkat }}</td>
                    @if($item->guru !== null)
                      <td>{{ $item->guru->nama }}</td>
                    @else
                      <td>Administrator</td>
                    @endif

                    <td>
                      <a href="/admin/video/{{ $item->id }}" class="btn btn-sm text-white m-1" style="background-color: orange;">Detail</a>
                      <a href="/admin/video/{{ $item->id }}/edit" class="btn btn-sm text-white m-1" style="background-color: orange;">Edit</a>
                      <form action="/admin/video/{{ $item->id }}" method="post" class="d-inline m-1">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm text-white" style="background-color: orange;" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
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
</div>

@endsection