
<form action="{{ route('presensi.export') }}" method="POST">
  @csrf
  <div class="form-group">
      <label for="kode_pelajaran">Kode Pelajaran</label>
      <input type="text" name="kode_pelajaran" id="kode_pelajaran" class="form-control" required>
  </div>
  <div class="form-group">
      <label for="tanggal_mulai">Tanggal Mulai</label>
      <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
  </div>
  <div class="form-group">
      <label for="tanggal_akhir">Tanggal Akhir</label>
      <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-primary">Export to Excel</button>
</form>

