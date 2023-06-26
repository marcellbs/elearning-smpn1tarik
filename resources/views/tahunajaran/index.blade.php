@extends('layout.main')

@section('content')
  <div class="pagetitle">
    <h1>Tahun Ajaran</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
        <li class="breadcrumb-item active"><a href="/admin/tahun-ajaran">Tahun Ajaran</a></li>
      </ol>
    </nav>
  </div>

  <div id="alert-container"></div>

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

  @if (session()->has('pesan'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {!! session('pesan') !!}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive mt-3">

            <table class="table table-striped" id="datatable">
              
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tahunAjaranModal">
                Tambah Tahun Ajaran
              </button>

              <!-- Modal tambah tahun ajaran -->
              <div class="modal fade" id="tahunAjaranModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Tahun Ajaran Baru</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <form action="/admin/tahun-ajaran" method="post">
                          @csrf
                          <div class="mb-3">
                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran">
                          </div>
                          
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>

                        </form>
                    </div>
                  </div>
                </div>
              </div>

              <thead>
                <tr>
                  <th >No</th>
                  <th>Tahun Ajaran</th>
                  <th>Status</th>
                  <th>Switch</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tahunAjaran as $th)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $th->tahun_ajaran }}</td>
                  <td id="status-aktif-{{ $th->id }}">
                    @if($th->status_aktif == 1)
                      <span class="badge bg-success">Aktif</span>
                    @else
                      <span class="badge bg-danger">Nonaktif</span>
                    @endif
                  </td>
                  <td>
                    <div class="form-check form-switch">
                      <input class="form-check-input switch-status" type="checkbox" role="switch" id="switchStatus{{ $th->id }})" data-id="{{ $th->id }}" @if ($th->status_aktif == 1) checked @endif>
                    </div>
                  </td>
                  <td>
                    
                    <button type="button" class="btn btn-sm btn-warning mb-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $th->id }}">
                      <i class="bi bi-pen"></i>
                    </button>

                    <form action="/admin/tahun-ajaran/{{ $th->id }}" method="post" class="d-inline">
                      @csrf
                      @method('delete')
                      <button type="submit" class="btn btn-sm btn-danger mb-2" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></button>
                    </form>
                    
                  </td>
                </tr>


                {{-- modal edit --}}
                <div class="modal fade" id="editModal{{ $th->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Tahun Ajaran {{ $th->tahun_ajaran }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="/admin/tahun-ajaran/{{ $th->id }}" method="post">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                          <div class="mb-3">
                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="{{ $th->tahun_ajaran }}">
                          </div>
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>

                      </form>

                    </div>
                  </div>
                </div>


                @endforeach
              </tbody>
  
            </table>
            <div class="d-flex">
              <a href="/admin" class="btn btn-primary ms-auto mt-2">Kembali</a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>


  <script>
    // Menggunakan event delegation untuk menangani perubahan switch status
    document.addEventListener('change', function(event) {
      if (event.target.classList.contains('switch-status')) {
        var statusAktif = event.target.checked ? 1 : 0; // Mendapatkan status baru
  
        // Mendapatkan ID tahun ajaran dari atribut data-id
        var tahunAjaranId = event.target.dataset.id;
  
        // Membuat objek data yang akan dikirim dalam permintaan
        var data = {
          status_aktif: statusAktif
        };
  
        // Mengirim permintaan ke endpoint switchbox menggunakan Fetch API
        fetch('/admin/tahun-ajaran/switchbox/' + tahunAjaranId, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify(data)
        })
        .then(function(response) {
          if (response.ok) {
            return response.json();
          } else {
            throw new Error('Terjadi kesalahan saat memperbarui status.');
          }
        })
        .then(function(responseData) {
          // Tanggapan dari server berhasil diterima
          showAlert(responseData.message, 'success');
          // Perbarui tampilan status secara dinamis
          var statusElement = document.querySelector('#status-aktif-' + tahunAjaranId);
          statusElement.innerHTML = responseData.statusHTML;
        })
        .catch(function(error) {
          // Terjadi kesalahan saat mengirim permintaan atau menangani tanggapan
          showAlert(error.message, 'danger');
        });
      }
    });

    function showAlert(message, alertType) {
      var alertDiv = document.createElement('div');
      alertDiv.className = 'alert alert-' + alertType;
      alertDiv.textContent = message;

      var alertContainer = document.getElementById('alert-container');
      alertContainer.appendChild(alertDiv);

      setTimeout(function() {
        alertDiv.remove();
      }, 3000);
    }

  </script>

  
  

@endsection