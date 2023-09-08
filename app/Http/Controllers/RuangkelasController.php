<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use Illuminate\Http\Request;

class RuangkelasController extends Controller
{
    // ruang kelas ini memiliki fitur dashboard, video yang terkait dengan kelasnya, kemudian ada video sesuai dengan kelasnya, fitur tugas sesuai dengan kelasnya, rekap tugas berdasarkan kelasnya. sehingga harus ada id sebagai parameter untuk mengetahui kelas mana yang akan diakses

    public function index($id){
        $hash = new Hashids('my-hash',10);
        $pengampu = \App\Models\Pengampu::find($hash->decode($id)[0]);

        $kelas_siswa = \App\Models\KelasSiswa::where('kode_kelas', $pengampu->kode_kelas)->get();
        
        $materi = \App\Models\Materi::where('kode_guru', $pengampu->kode_guru)->where('kode_pelajaran', $pengampu->kode_pelajaran)->where('tingkat', $pengampu->kelas->nama_kelas[0])->get();

        $data = [
            'title' => ''.$pengampu->mapel->nama_pelajaran.' '.$pengampu->kelas->nama_kelas.'',
            'hash' => $hash,
            'pengampu' => $pengampu,
            'materi' => $materi,
            'siswa' => \App\Models\Siswa:: join('kelas_siswa', 'siswa.kode_siswa', '=', 'kelas_siswa.kode_siswa')
            ->where('kelas_siswa.kode_kelas', $pengampu->kode_kelas)
            ->where('kelas_siswa.kode_thajaran', $pengampu->kode_thajaran)
            ->where('siswa.status', '1')
            ->orderBy('nis', 'asc')
            ->get(),
        ];

        return view('guru.detailkelas', $data);
    }

    public function video($id){
        $hash = new Hashids('my-hash',10);
        $pengampu = \App\Models\Pengampu::find($hash->decode($id)[0]);

        $materi = \App\Models\Materi::where('kode_guru', $pengampu->kode_guru)->where('kode_pelajaran', $pengampu->kode_pelajaran)->get();

        $video = \App\Models\Video::where('kode_pelajaran', $pengampu->kode_pelajaran)->where('tingkat', $pengampu->kelas->nama_kelas[0])->paginate(5);

        $data = [
            'title' => 'Video Pembelajaran '.$pengampu->mapel->nama_pelajaran.' '.$pengampu->kelas->nama_kelas.'',
            'hash' => $hash,
            'pengampu' => $pengampu,
            'video' => $video,    
        ];

        return view('guru.video', $data);
    }

    public function materiKelas($id){
        $hash = new Hashids('my-hash',10);
        $pengampu = \App\Models\Pengampu::find($hash->decode($id)[0]);

        $materi = \App\Models\Materi::where('kode_pelajaran', $pengampu->kode_pelajaran)->where('tingkat', $pengampu->kelas->nama_kelas[0])->paginate(5);

        $data = [
            'title' => 'Materi Pelajaran '.$pengampu->mapel->nama_pelajaran.' '.$pengampu->kelas->nama_kelas.'',
            'hash' => $hash,
            'pengampu' => $pengampu,
            'materi' => $materi,
        ];
        
        return view('guru.materikelas', $data);
    }

    public function tugasKelas($id){
        $hash = new Hashids('my-hash',10);
        $pengampu = \App\Models\Pengampu::find($hash->decode($id)[0]);

        $tugas = \App\Models\Tugas::where('kode_guru', $pengampu->kode_guru)->where('kode_pelajaran', $pengampu->kode_pelajaran)->paginate(5);

        $jumlahSiswaKelas = \App\Models\KelasSiswa::where('kode_kelas', $pengampu->kode_kelas)->where('kode_thajaran', $pengampu->kode_thajaran)->count();

        $totalTugas = \App\Models\Tugas::where('kode_guru', $pengampu->kode_guru)->where('kode_pelajaran', $pengampu->kode_pelajaran)->count();
            
        $data = [
            'title' => 'Tugas '.$pengampu->mapel->nama_pelajaran.' '.$pengampu->kelas->nama_kelas.'',
            'hash' => $hash,
            'pengampu' => $pengampu,
            'tugas' => $tugas,
            'jumlahSiswaKelas' => $jumlahSiswaKelas,
            'totalTugas' => $totalTugas,
        ];
        
        return view('guru.tugaskelas', $data);
    }

    public function rekapTugas($id){
        $hash = new Hashids('my-hash',10);
        $pengampu = \App\Models\Pengampu::find($hash->decode($id)[0]);

        $tugas = \App\Models\Tugas::where('kode_guru', $pengampu->kode_guru)->where('kode_pelajaran', $pengampu->kode_pelajaran)->where('kode_kelas', $pengampu->kode_kelas)->get();

        $jumlahSiswaKelas = \App\Models\KelasSiswa::where('kode_kelas', $pengampu->kode_kelas)->where('kode_thajaran', $pengampu->kode_thajaran)->count();

        $totalTugas = \App\Models\Tugas::where('kode_guru', $pengampu->kode_guru)->where('kode_pelajaran', $pengampu->kode_pelajaran)->count();

        $siswa = \App\Models\Siswa:: join('kelas_siswa', 'siswa.kode_siswa', '=', 'kelas_siswa.kode_siswa')
            ->where('kelas_siswa.kode_kelas', $pengampu->kode_kelas)
            ->where('kelas_siswa.kode_thajaran', $pengampu->kode_thajaran)
            ->where('siswa.status', '1')
            ->orderBy('nis', 'asc')
            ->get();

        $data = [
            'title' => 'Rekap Tugas '.$pengampu->mapel->nama_pelajaran.' '.$pengampu->kelas->nama_kelas.'',
            'hash' => $hash,
            'pengampu' => $pengampu,
            'tugas' => $tugas,
            'jumlahSiswaKelas' => $jumlahSiswaKelas,
            'totalTugas' => $totalTugas,
            'siswa' => $siswa,
        ];
        
        return view('ruangkelas.rekaptugaskelas', $data);

    }
}
