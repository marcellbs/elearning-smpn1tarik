<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Models\Pengampu;

class PengampuControllerr extends Controller
{
    public function index(){
        $data = [
            'title' => 'Data Pengampu',
            'pengampu' => Pengampu::all(),
            'guru' => \App\Models\Guru::all(),
            'mapel' => Mapel::all(),
            'kelas' => \App\Models\Kelas::all(),
            // menampilkan kelas apa saja yang sudah diampu
            'kelas_ada' => Pengampu::select('kode_kelas')->get(),
        ];
        return view('admin.pengampu', $data);
    }

    public function store(Request $request){
        $request->validate([
            'guru' => 'required',
            'kelas' => 'required',
            'mapel' => 'required',
        ],
        [
            'guru.required' => 'Kolom guru harus diisi',
            'kelas.required' => 'Kolom kelas harus diisi',
            'mapel.required' => 'Kolom pelajaran harus diisi',
        ]
        );

        Pengampu::create([
            'kode_guru' => $request->guru,
            'kode_kelas' => $request->kelas,
            'kode_pelajaran' => $request->mapel,
        ]);

        return redirect('/admin/pengampu')->with('sukses', 'Data berhasil ditambahkan');
    }


}
