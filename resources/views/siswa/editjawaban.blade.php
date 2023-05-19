@extends('layout.siswa')

@section('content')
@include('partials.page-title', ['title' => 'Ubah Tugas'])


<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        {{ $jawab }}
        <div class="table-responsive">
          <form action="/siswa/jawabantugas/{{ $jawab->id }}" method="post" enctype="multipart/form-data">
            @method('patch')
            @csrf

            <div class="mb-3 mt-2">
              <label for="keterangan" class="form-label">Catatan</label>
              <textarea class="form-control" id="keterangan" rows="3" name="keterangan">
                {{ $jawab->keterangan }}
              </textarea>
            </div>
            <div class="mb-3">
              <label for="berkas" class="form-label">Lampiran</label>
              <input class="form-control" type="file" id="berkas" name="berkas" value="{{ $jawab->berkas }}">
            </div>
            <button type="submit" class="btn btn-primary">Ubah Tugas</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection