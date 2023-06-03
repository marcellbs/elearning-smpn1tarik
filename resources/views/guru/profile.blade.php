@extends('layout.guru')

@section('content')
  @include ('partials.page-title', ['title' => 'Profile'])

  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            {{-- cek nama file foto apakah sama dengan di folder img --}}
            @if (file_exists(public_path('img/guru/' . auth()->user()->foto)))
              <img src="/img/guru/{{ auth()->user()->foto }}" alt="Profile" class="rounded-circle img-thumbnail">
            @else
              <img src="/img/{{ auth()->user()->foto }}" alt="Profile" class="rounded-circle">
            @endif
            
            <h5 class="mt-2 mb-0 pb-0"><strong>{{ auth()->user()->nama }}</strong></h5>
            <p class="mt-2">Guru / Pengajar</p>
            
            {{-- <a href="#" class="btn text-white w-100" style="background-color: orange;">Ubah Profil</a> --}}
          </div>
        </div>
      </div>
      <div class="col-xl-8">
  
        {{-- alert --}}
        @if (session()->has('sukses'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session('sukses') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
        @endif
  
        @if (session()->has('gagal'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {!! session('gagal') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
        @endif

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">
  
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>
  
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change">Change Profile</button>
              </li>
              
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
              </li>
            </ul>
  
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
  
                <div class="row mt-3">
                  <div class="col-lg-3 col-md-4 label ">NIP</div>
                  {{-- memecah nip dengan spasi --}}
                  {{-- contoh : 20010203 201607 2 003 --}}
                  {{-- 20010203 = tanggal lahir --}}
                  {{-- 201607 = tanggal masuk --}}
                  {{-- 2 = jenis kelamin --}}
                  {{-- 003 = urutan --}}
                  @php
                    $tgl_lahir = substr(auth()->user()->nip, 0, 8);
                    $tgl_masuk = substr(auth()->user()->nip, 8, 6);
                    $jenis_kelamin = substr(auth()->user()->nip, 14, 1);
                    $urutan = substr(auth()->user()->nip, 15, 3);

                    // mengubah format nip
                    $nip = $tgl_lahir . ' ' . $tgl_masuk . ' ' . $jenis_kelamin . ' ' . $urutan;

                  @endphp
                  <div class="col-lg-9 col-md-8">{{ $nip }}</div>
                  {{-- <div class="col-lg-9 col-md-8">{{ auth()->user()->nip }}</div> --}}
                </div>

                <div class="row mt-3">
                  <div class="col-lg-3 col-md-4 label ">Nama Lengkap</div>
                  <div class="col-lg-9 col-md-8">{{ auth()->user()->nama }}</div>
                </div>
  
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8">{{ auth()->user()->email }}</div>
                </div>
                
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Jenis Kelamin</div>
                  @if(auth()->user()->jenis_kelamin == null)
                    <div class="col-lg-9 col-md-8 text-muted"><i>Belum / Tidak ada informasi</i></div>
                  @else
                    <div class="col-lg-9 col-md-8">{{ auth()->user()->jenis_kelamin }}</div>
                  @endif
                </div>
                
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Telepon</div>
                  @if(auth()->user()->telepon == null)
                    <div class="col-lg-9 col-md-8 text-muted"><i>Belum / Tidak ada informasi</i></div>
                  @else
                    <div class="col-lg-9 col-md-8">{{ auth()->user()->telepon }}</div>
                  @endif
                </div>

                {{-- alamat --}}
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Alamat</div>
                  @if(auth()->user()->alamat == null)
                    <div class="col-lg-9 col-md-8 text-muted"><i>Belum / Tidak ada informasi</i></div>
                  @else
                    <div class="col-lg-9 col-md-8">{{ auth()->user()->alamat }}</div>
                  @endif
                </div>
  
              </div>
  
              {{-- ubah password --}}
              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form action="/guru/password/{{ auth()->user()->kode_guru }}" method="post">
                  @csrf
                  @method('patch')
  
                  <div class="row mb-3">
                    <label for="password" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" type="password" class="form-control" id="password">
                    </div>
                  </div>
  
                  <div class="row mb-3">
                    <label for="passwordbaru" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="passwordbaru" type="password" class="form-control" id="passwordbaru">
                    </div>
                  </div>
  
                  <div class="row mb-3">
                    <label for="ulangpassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="ulangpassword" type="password" class="form-control" id="ulangpassword">
                    </div>
                  </div>
  
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->
  
              </div>
              
              {{-- ubah profil --}}
              <div class="tab-pane fade pt-3" id="profile-change">                
                <form action="/guru/profile/{{ auth()->user()->kode_guru }}" method="post" enctype="multipart/form-data">
                  @csrf
                  @method('patch')
  
                  <div class="row mb-3">
                    <label for="nip" class="col-md-4 col-lg-3 col-form-label">NIP</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="nip" type="text" class="form-control" id="nip" value="{{ auth()->user()->nip }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="nama" type="text" class="form-control" id="nama" value="{{ auth()->user()->nama }}">
                    </div>
                  </div>
  
                  <div class="row mb-3">
                    <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="email" type="email" class="form-control" id="email" value="{{ auth()->user()->email }}">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="jk" class="col-md-4 col-lg-3 col-form-label">Jenis Kelamin</label>
                    <div class="col-md-8 col-lg-9">
                      {{-- dropdown --}}
                      <select name="jk" id="jk" class="form-select">
                        <option value="" {{ auth()->user()->jenis_kelamin == null ? 'selected' : '' }}>-- Pilih--</option>
                        {{-- ternary --}}
                        <option value="Laki-laki" {{ auth()->user()->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ auth()->user()->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        {{-- jika belum ada atau null--}}

                      </select>
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="telepon" class="col-md-4 col-lg-3 col-form-label">Telepon</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="telepon" type="text" class="form-control" id="telepon" value="{{ auth()->user()->telepon }}">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control">
                        {{ auth()->user()->alamat }}
                      </textarea>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="agama" class="col-md-4 col-lg-3 col-form-label">Agama</label>
                    <div class="col-md-8 col-lg-9">
                      {{-- dropdown --}}
                      <select name="agama" id="agama" class="form-select">
                        {{-- ternary --}}
                        <option value="" {{ auth()->user()->agama == null ? 'selected' : '' }}>--Pilih--</option>
                        <option value="Islam" {{ auth()->user()->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ auth()->user()->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ auth()->user()->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ auth()->user()->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ auth()->user()->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ auth()->user()->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                      </select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="foto" class="col-md-4 col-lg-3 col-form-label">Foto</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="file" name="foto" id="foto" class="form-control">
                      {{-- text --}}
                      <div id="foto" class="form-text">Gunakan foto/gambar dengan format <strong>.jpg</strong> /<strong>.png</strong> dengan perbandingan 1:1 </div>
                    </div>
                  </div>

  
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Ubah Profile</button>
                  </div>
                </form><!-- End Change Password Form -->
  
              </div>
  
            </div><!-- End Bordered Tabs -->
  
          </div>
        </div>
  
      </div>
      
  
      
    </div>
  </section>
@endsection