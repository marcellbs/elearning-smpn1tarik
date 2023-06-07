<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class PelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'mapel' => \App\Models\Mapel::all(),
            'title' => 'Pelajaran',
        ];
        return view('admin.mapel', $data);
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
            'pelajaran' => 'required',
        ],
        [
            'pelajaran.required' => 'Kolom nama pelajaran harus diisi',
        ]);

        Mapel::create([
            'nama_pelajaran' => $request->pelajaran,
        ]);

        return redirect('/admin/mapel')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function show(Mapel $mapel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function edit(Mapel $mapel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'pelajaran' => 'required',
        ],
        [
            'pelajaran.required' => 'Kolom nama pelajaran harus diisi',
        ]);

        Mapel::where('kode_pelajaran', $mapel->kode_pelajaran)
            ->update([
                'nama_pelajaran' => $request->pelajaran,
            ]);

        return redirect('/admin/mapel')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mapel  $mapel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        return redirect('/admin/mapel')->with('success', 'Data berhasil dihapus');
    }
}
