<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            // pagination
            'kelas' => Kelas::paginate(10),
            'title' => 'Kelas',
            'tingkat' => \App\Models\Tingkat::all(),
        ];
        
        return view('admin.kelas', $data);
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
            'tingkat' => 'required',
            'kelas' => 'required|alpha|size:1|in:A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z',
        ],[
            'tingkat.required' => 'Tingkat tidak boleh kosong!',
            'kelas.required' => 'Kelas tidak boleh kosong!',
            'kelas.alpha' => 'Kelas hanya boleh berisi huruf!',
            'kelas.size' => 'Kelas hanya boleh berisi 1 huruf!',
            'kelas.in' => 'Kelas hanya boleh berisi huruf kapital A-Z!',
        ]);

        Kelas::create(
            [
                'nama_kelas' => $request->kelas,
                'kode_tingkat' => $request->tingkat,
                'kode_admin' => \Illuminate\Support\Facades\Auth::user()->kode_admin,
            ]
        );

        return redirect('/admin/kelas')->with('status', 'Data Kelas Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kelas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect('/admin/kelas')->with('status', 'Data Kelas Berhasil Dihapus!');
    }
}
