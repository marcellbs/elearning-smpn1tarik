<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use Illuminate\Http\Request;
use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;

class PengampuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hash = new Hashids();
        $data = [
            'pengampu' => \App\Models\Pengampu::all(),
            'guru' => \App\Models\Guru::all(),
            'mapel' => \App\Models\Mapel::all(),
            'kelas' => \App\Models\Kelas::all(),
            'title' => 'Pengampu',
            'hash' => $hash,
        ];
        return view('admin.pengampu', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'guru' => 'required',
            'kelas' => 'required',
            'mapel' => 'required',
        ],[
            'guru.required' => 'Kolom guru harus diisi',
            'kelas.required' => 'Kolom kelas harus diisi',
            'mapel.required' => 'Kolom pelajaran harus diisi',
        ]);

        Pengampu::create([
            'kode_guru' => $request->guru,
            'kode_kelas' => $request->kelas,
            'kode_pelajaran' => $request->mapel,
        ]);

        return redirect('/admin/pengampu')->with('sukses', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengampu  $pengampu
     * @return \Illuminate\Http\Response
     */
    public function show(Pengampu $pengampu)
    {
        $data = [
            'title' => 'Detail Pengampu',
            'pengampu' => $pengampu,
            'kelas_siswa' => \App\Models\KelasSiswa::where('kode_kelas', $pengampu->kode_kelas)->get(),
        ];
        
        return view('pengampu.detailpengampu', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengampu  $pengampu
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengampu $pengampu)
    {
        $data = [
            'title' => 'Edit Pengampu',
            'pengampu' => $pengampu,
            'guru' => \App\Models\Guru::all(),
            'mapel' => \App\Models\Mapel::all(),
            'kelas' => \App\Models\Kelas::all(),
        ];
        return view('pengampu.editpengampu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengampu  $pengampu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengampu $pengampu)
    {
        $request->validate([
            'guru' => 'required',
            'kelas' => 'required',
            'mapel' => 'required',

        ],[
            'guru.required' => 'Kolom guru harus diisi',
            'kelas.required' => 'Kolom kelas harus diisi',
            'mapel.required' => 'Kolom pelajaran harus diisi',
        ]); 

        Pengampu::where('id', $pengampu->id)
            ->update([
                'kode_guru' => $request->guru,
                'kode_kelas' => $request->kelas,
                'kode_pelajaran' => $request->mapel,
                'link' => null,
            ]);

        return redirect('/admin/pengampu')->with('sukses', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengampu  $pengampu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengampu $pengampu)
    {
        $pengampu->delete();
        return redirect('/admin/pengampu')->with('sukses', 'Data berhasil dihapus');
    }
}
