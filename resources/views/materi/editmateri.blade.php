@extends((Auth::guard('webadmin')->check()) ? 'layout.main' : 'layout.guru')
@section('content')

@include('partials.page-title', ['title' => $title])

{{-- cek webadmin atau webguru --}}

@if( Auth::guard('webadmin')->check() )
  <form action="/admin/materi/{{ $materi->kode_materi }}" method="post" enctype="multipart/form-data">
@else
  <form action="/guru/materi/{{ $materi->kode_materi }}" method="post" enctype="multipart/form-data">
@endif
  @method('patch')
  @csrf
  <input type="hidden" name="kode_materi" value="{{$materi->kode_materi}}">

  <div class="form-group">
    <label for="judul_materi">Judul</label>
    <input type="text" class="form-control @error('judul_materi') is-invalid @enderror" id="judul_materi" name="judul_materi" value="{{old('judul_materi', $materi->judul_materi)}}">
    @error('judul_materi')
    <div class="invalid-feedback">
      {{$message}}
    </div>
    @enderror
  </div>

  <div class="form-group">
    <label for="keterangan">Deskripsi</label>
    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{$materi->keterangan}}</textarea>
    @error('keterangan')
    <div class="invalid-feedback">
      {{$message}}
    </div>
    @enderror
  </div>

  <div class="form-group">
    <label for="kelas">Kelas</label>
    <select class="form-select @error('kelas') is-invalid @enderror" name="kelas" id="kelas">
      <option value="">Pilih Kelas</option>
      @foreach ($kelas as $k)
      <option value="{{$k->kode_tingkat}}" {{$materi->kode_tingkat == $k->kode_tingkat ? 'selected' : ''}}>{{$k->nama_tingkat}}</option>
      @endforeach
    </select>
    @error('kelas')
    <div class="invalid-feedback">
      {{$message}}
    </div>
    @enderror

  <div class="form-group">
    <label for="mapel">Mata Pelajaran</label>
    <select class="form-select @error('mapel') is-invalid @enderror" name="mapel" id="mapel">
      <option value="">Pilih Mata Pelajaran</option>
      @foreach ($mapel as $m)
      <option value="{{$m->kode_pelajaran}}" {{$materi->kode_pelajaran == $m->kode_pelajaran ? 'selected' : ''}}>{{$m->nama_pelajaran}}</option>
      @endforeach
    </select>
    @error('mapel')
    <div class="invalid-feedback">
      {{$message}}
    </div>
    @enderror
  </div>

  <div class="form-group">
    <label for="file">File</label>
    <input class="form-control @error('file') is-invalid @enderror" type="file" id="file" name="file">
    @error('file')
    <div class="invalid-feedback">
      {{$message}}
    </div>
    @enderror
  </div>
  <div class="mt-3 d-flex">
    <button type="submit" class="ms-auto btn text-white" style="background-color: orange">Ubah</button>
    <a href="{{ (Auth::guard('webadmin')->check()) ? '/admin/materi' : '/guru/materi' }}" class="btn mx-2" style="color:orange; border: 1px solid orange">Kembali</a>
  </div>

</form>




@endsection