<div class="text-center">
  <img src="/img/{{ auth()->user()->foto }}" alt="Profile" class="align-center rounded-circle image-profile">
  <h5 class="mb-0 mt-3">{{ ucwords(auth()->user()->nama_siswa)  }}</h5>
  {{-- <p class="mt-0">Siswa | {{$kelas_siswa->kelas->tingkat->nama_tingkat." ".$kelas_siswa->kelas->nama_kelas }}</p> --}}
  <p class="mt-0">Siswa | {{ $kelas_siswa }} </p>
</div>