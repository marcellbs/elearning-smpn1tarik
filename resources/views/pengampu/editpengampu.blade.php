@extends('layout.main')
@section('content')

@include('partials.page-title', ['title' => $title])

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mt-3">
          <h5>Edit Pengampu : <strong>{{ $pengampu->guru->nama }}</strong></h5>
          <form action="/admin/pengampu/{{ $pengampu->id }}" method="post">
            @method('patch')
            @csrf
            
              <div class="col-md-6 mt-2">
                <label for="guru">Nama Guru</label>
                <select class="form-select @error('guru') is-invalid @enderror" name="guru" id="guru">
                  <option value="">Pilih Guru</option>
                  @foreach ($guru as $g)
                  <option value="{{$g->kode_guru}}" {{ $g->kode_guru == $pengampu->guru->kode_guru ? 'selected' : '' }}>{{$g->nama}}</option>
                  @endforeach
                </select>
                @error('guru')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
              
              <div class="col-md-6 mt-2">
                <label for="mapel">Mata Pelajaran</label>
                <select class="form-select @error('mapel') is-invalid @enderror" name="mapel" id="mapel">
                  <option value="">Pilih Mata Pelajaran</option>
                  @foreach ($mapel as $m)
                  <option value="{{$m->kode_pelajaran}}" {{ $m->kode_pelajaran == $pengampu->mapel->kode_pelajaran ? 'selected' : '' }}>{{$m->nama_pelajaran}}</option>
                  @endforeach
                </select>
                @error('mapel')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>

              {{-- select untuk nama kelas --}}
              <div class="col-md-6 mt-2 mb-2">
                <label for="kelas">Kelas</label>
                <select name="kelas" class="form-select  @error('kelas') is-invalid @enderror"  id="kelas">
                  <option value="">Pilih Kelas</option>
                  @foreach ($kelas as $k)
                  <option value="{{$k->kode_kelas}}" {{ $k->kode_kelas == $pengampu->kelas->kode_kelas ? 'selected' : '' }}>{{$k->nama_kelas}}</option>
                  @endforeach
                </select>
                @error('kelas')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>

              <div class="col-md-6 mt-2 mb-2">
                <label for="tahun_ajaran">Tahun Ajaran</label>
                <select name="tahun_ajaran" class="form-select  @error('tahun_ajaran') is-invalid @enderror"  id="tahun_ajaran">
                  
                  @foreach ($tahun_ajaran as $k)
                  <option value="{{$k->id}}" {{ $k->id == $pengampu->kode_thajaran ? 'selected' : '' }}>{{$k->tahun_ajaran}}</option>
                  @endforeach
                </select>
                @error('tahun_ajaran')
                <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
              </div>

              <label for="jadwal-container">Jadwal Mengajar</label>
              
              <div id="jadwal-container">
                  <div class="jadwal-group">
              
                      @foreach ($pengampu->jadwal as $key => $j)
                      <div class="row">
                          <div class="col-sm-2">
                              <label class="form-label">Hari:</label>
                              <select name="hari[]" class="form-select @error('hari[]') is-invalid @enderror">
                                  <option value="Senin" {{ $j->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                                  <option value="Selasa" {{ $j->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                  <option value="Rabu" {{ $j->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                  <option value="Kamis" {{ $j->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                  <option value="Jumat" {{ $j->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                  <option value="Sabtu" {{ $j->hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                              </select>

                              @error('hari[]')
                              <div class="invalid-feedback">
                                  {{$message}}
                              </div>
                              @enderror
                          </div>
                          <div class="col-sm-2">
                              <label class="form-label">Jam Mulai:</label>
                              <input type="text" name="jam_mulai[]" class="form-control @error('jam_mulai[]') is-invalid @enderror" value="{{ $j->jam_mulai }}">
                              @error('jam_mulai[]')
                              <div class="invalid-feedback">
                                  {{$message}}
                              </div>
                              @enderror
                            </div>
                          <div class="col-sm-2">
                              <label class="form-label">Jam Berakhir:</label>
                              <input type="text" name="jam_berakhir[]" class="form-control @error('jam_berakhir[]') is-invalid @enderror" value="{{ $j->jam_berakhir }}">
                              @error('jam_berakhir[]')
                              <div class="invalid-feedback">
                                  {{$message}}
                              </div>
                              @enderror
                            </div>
                          <div class="col-1">
                              <label for="remove-jadwal" class="form-label">&nbsp;</label>
                              @if ($key == 0)
                              <button type="button" id="add-jadwal" class="add-jadwal btn form-control">+</button>
                              @else
                              <button type="button" class="remove-jadwal btn form-control">&times;</button>
                              @endif
                              <input type="hidden" name="jadwal_id[]" value="{{ $j->id }}">
                          </div>
                      </div>
                      @endforeach
              
                  </div>
              </div>
            

              

              <div class="d-flex">
                <a href="/admin/pengampu" class="btn btn-white mt-2 ms-auto me-1" style="color:orange; border:1px solid orange;">Kembali</a>
                
                <button type="submit" class="btn text-white mt-2" style="background-color: orange;">Ubah</button>
              </div>



          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('add-jadwal').addEventListener('click', function() {
    var jadwalContainer = document.getElementById('jadwal-container');
    var jadwalGroup = document.createElement('div');
    jadwalGroup.classList.add('jadwal-group');
    jadwalGroup.innerHTML = `
      <div class="row">
        <div class="col-sm-2">
          <label class="form-label">Hari:</label>
          <select name="hari[]" id="hari" class="form-select @error('hari[]') is-invalid @enderror" required>
            <option value="Senin">Senin</option>
            <option value="Selasa">Selasa</option>
            <option value="Rabu">Rabu</option>
            <option value="Kamis">Kamis</option>
            <option value="Jumat">Jumat</option>
            <option value="Sabtu">Sabtu</option>
          </select>
          @error('hari[]')
            <div class="invalid-feedback">
              {{$message}}
            </div>
          @enderror
        </div>
        <div class="col-sm-2">
          <label class="form-label">Jam Mulai:</label>
          <input type="text" name="jam_mulai[]" class="form-control @error('jam_mulai[]') is-invalid @enderror" required>
          @error('jam_mulai[]')
            <div class="invalid-feedback">
              {{$message}}
            </div>
          @enderror
        </div>
        <div class="col-sm-2">
          <label class="form-label">Jam Berakhir:</label>
          <input type="text" name="jam_berakhir[]" class="form-control @error('jam_berakhir[]') is-invalid @enderror" required>
          @error('jam_berakhir[]')
            <div class="invalid-feedback">
              {{$message}}
            </div>
          @enderror
        </div>
        <div class="col-1">
          <label for="remove-jadwal" class="form-label">&nbsp;</label>
          <button type="button" class="remove-jadwal btn form-control">&times;</button>
        </div>
      </div>
    `;
    jadwalContainer.appendChild(jadwalGroup);
  });

  // Event listener untuk tombol "Hapus Jadwal"
  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('remove-jadwal')) {
      event.target.parentElement.parentElement.remove();
    }
  });
</script>

@endsection