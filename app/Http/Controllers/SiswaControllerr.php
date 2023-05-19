<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    

    public function create(){
        $data = [
            'title' => 'Tambah Siswa',
            'kelas' => \App\Models\Kelas::all(),
            'tingkat' => \App\Models\Tingkat::all(),
        ];
        return view('siswa.add-siswa', $data);
    }

    public function store(Request $request){
        Siswa::create([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'agama' => $request->agama,
            'foto' => $request->foto,
            'email' => $request->email,
            'pass' => $request->password,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        // menangani kelas siswa dan tingkat kelas siswa
        $siswa = Siswa::where('nis', $request->nis)->first();
        $kelas = Kelas::where('kode_kelas', $request->kode_kelas)->first();
        KelasSiswa::create([
            'kode_siswa' => $siswa->kode_siswa,
            'kode_kelas' => $request->kode_kelas,
            'kode_tingkat' => $request->nama_tingkat,
        ]);



        return redirect('/siswa')->with('status', 'Data siswa berhasil ditambahkan');
    }


}
