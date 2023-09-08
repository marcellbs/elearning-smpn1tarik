@extends('layout.main')

@section('content')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
      <li class="breadcrumb-item"><a href="/admin/siswa">Siswa</a></li>
      <li class="breadcrumb-item active">Detail Siswa</li>
    </ol>
  </nav>
</div>


<section class="section profile">
  <div class="row">
    <div class="col-xl-4 mb-3">
      <div class="card mb-2">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

          @if( file_exists( public_path().'/img/siswa/'.$siswa[0]->foto ))
            <img src="/img/siswa/{{ $siswa[0]->foto }}" alt="profil-{{ $siswa->nama_siswa }}" class="rounded-circle img-thumbnail">
          @else
            <img src="/img/{{ $siswa[0]->foto }}" alt="profil-{{ $siswa[0]->nama_siswa }}" class="rounded-circle img-thumbnail">
          @endif

          <h5 class="mt-2 mb-0 pb-0 text-center"><strong>{{ ucwords($siswa[0]->nama_siswa) }}</strong></h5>
          <p class="mt-2 mb-0">Siswa</p>
          {{-- <p class="mt-1">{{ $siswa->nis }} | {{ $siswa->nama_kelas }}</p> --}}
          
        </div>
      </div>
      <div class="d-grid gap-4 mt-0">
        <a href="/admin/siswa" class="btn text-white" style="background-color: orange">Kembali</a>
      </div>
    </div>

    <div class="col-xl-8">
      <div id="alert-container"></div>
      <div class="col-lg-12">
        <div class="card">
          <h4 class="mx-3 mt-3 fw-bold">Overview</h4>
          {{-- <div class="form-check form-switch mx-3">
            <label for="flexSwitchCheckChecked" id="checkBoxLabel">Nonaktifkan Siswa</label>
            <input class="form-check-input" type="checkbox" role="switch" @if ($siswa->status == 1) checked @endif id="flexSwitchCheckChecked" data-kode-siswa={{ $siswa->kode_siswa }}>
          </div> --}}

          <div class="card-body">
            <hr>
            <div class="table-responsive mt-3">

              <table class="table table-bordered table-responsive">
                <tr>
                  <td colspan="3" class="text-center fw-bold">Data Siswa</td>
                </tr>
                <tr>
                  <td>Nomor Induk Siswa</td>
                  <td>:</td>
                  <td>{{ $siswa[0]->nis }}</td>
                </tr>
                <tr>
                  <td>Nama</td>
                  <td>:</td>
                  <td>{{ $siswa[0]->nama_siswa }}</td>
                </tr>
                <tr>
                  <td>Status</td>
                  <td>:</td>
                  <td id="status-siswa">{!! $siswa[0]->status == "1" ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Nonaktif</span>' !!}</td>
                </tr>
                <tr>
                  <td>Username</td>
                  <td>:</td>
                  <td>{{ $siswa[0]->username }}</td>
                </tr>
                <tr>
                  <td>Kelas</td>
                  <td>:</td>
                  <td>
                    @foreach ($siswa as $dataSiswa)
                        {{ $dataSiswa->nama_kelas }} - {{ $dataSiswa->tahun_ajaran }}
                        <br>
                    @endforeach
                  </td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td>:</td>
                  <td>{!! $siswa[0]->email != null ? $siswa[0]->email : '<i>Belum ada keterangan</i>' !!}</td>
                </tr>
                <tr>
                  <td>Jenis Kelamin</td>
                  <td>:</td>
                  <td>{!! $siswa[0]->jenis_kelamin != null ? $siswa[0]->jenis_kelamin : '<i>Belum ada keterangan</i>' !!}</td>
                </tr>
                <tr>
                  <td>Telepon</td>
                  <td>:</td>
                  <td>{!! $siswa[0]->telepon != null ? $siswa[0]->telepon : '<i>Belum ada keterangan</i>' !!}</td>
                </tr>
                <tr>
                  <td>Agama</td>
                  <td>:</td>
                  <td>{!! $siswa[0]->agama != null ? $siswa[0]->agama : '<i>Belum ada keterangan</i>'  !!}</td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td>:</td>
                  <td>{!! $siswa[0]->alamat != null ? $siswa[0]->alamat : '<i>Belum ada keterangan</i>' !!}</td>
                </tr>

              </table>

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- <script>
  document.getElementById('flexSwitchCheckChecked').addEventListener('change', function() {
    let status = this.checked ? '1' : '0';
    let id = this.getAttribute('data-kode-siswa');

    let formData = new FormData();
    formData.append('status', status);
    formData.append('kode_siswa', id);

    let xhr = new XMLHttpRequest();
    xhr.open('post', '/update-status');
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
              let status_siswa = document.getElementById('status-siswa');
              let checkBoxLabel = document.getElementById('checkBoxLabel');
              if (status_siswa && checkBoxLabel) {
                status_siswa.innerHTML = status === '1' ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Nonaktif</span>';
                checkBoxLabel.innerHTML = status === '1' ? 'Nonaktifkan Siswa' : 'Aktifkan Siswa';
              }
              
              if(status === '1') {
                showAlert('Status berhasil diubah menjadi aktif', 'success');
              } else {
                showAlert('Status berhasil diubah menjadi nonaktif', 'danger');
              }
          } else {
              showAlert('Status gagal diubah', 'danger');
          }
      }
    };
    
    xhr.send(formData);

  });

  function showAlert(message, type) {
    let alertContainer = document.getElementById('alert-container');
    let alert = document.createElement('div');
    alert.classList.add('alert', `alert-${type}`, 'alert-dismissible', 'fade', 'show');
    alert.setAttribute('role', 'alert');
    alert.innerHTML = `
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      ${message}
    `;
    alertContainer.innerHTML = '';
    alertContainer.appendChild(alert);
  }

</script> --}}
@endsection