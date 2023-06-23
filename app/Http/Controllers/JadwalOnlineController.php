<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalOnlineController extends Controller
{
    public function index(){
        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)->first();
        $data = [
            'title' => 'Jadwal Online',

            'jadwal' => \App\Models\Jadwal::join('pengampu', 'pengampu.id', '=', 'jadwal.kode_pengampu')
                ->join('kelas', 'kelas.kode_kelas', '=', 'pengampu.kode_kelas')
                ->join('kelas_siswa', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
                ->join('siswa', 'siswa.kode_siswa', '=', 'kelas_siswa.kode_siswa')
                ->join('pelajaran', 'pelajaran.kode_pelajaran', '=', 'pengampu.kode_pelajaran')
                ->join('guru', 'guru.kode_guru', '=', 'pengampu.kode_guru')
                ->where('siswa.kode_siswa', auth()->user()->kode_siswa)
                ->where('pengampu.kode_thajaran', $tahunAjaran->id)
                ->select('jadwal.*', 'kelas.nama_kelas', 'pelajaran.nama_pelajaran', 'guru.nama')
                ->get(),

            'kelas_siswa' => \App\Models\KelasSiswa::where('kode_siswa', auth()->user()->kode_siswa)->first(),
        ];
        return view('siswa.jadwal-online', $data);
    }
}
