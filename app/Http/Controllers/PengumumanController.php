<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = [
            'pengumuman' => \App\Models\Pengumuman::all()->sortByDesc('tgl_upload'),
            // 'pengumuman' => Pengumuman::where('kode_guru', \Illuminate\Support\Facades\Auth::guard('webguru')->user()->kode_guru)->orderBy('tgl_upload', 'desc')->get(),
            'title' => 'Pengumuman',
        ];
        
        return view('pengumuman.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [      
            'title' => 'Tambah Pengumuman',
        ];

        return view('pengumuman.create', $data);
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
            'judul_pengumuman' => 'required',
            'deskripsi' => 'required',
        ],[
            'judul_pengumuman.required' => 'Judul pengumuman harus diisi',
            'deskripsi.required' => 'Deskripsi pengumuman harus diisi',
        ]);
        
        // local datetime
        date_default_timezone_set('Asia/Jakarta');

        $pengumuman = new Pengumuman;
        $pengumuman->judul_pengumuman = $request->judul_pengumuman;
        $pengumuman->deskripsi = $request->deskripsi;
        $pengumuman->kode_guru = \Illuminate\Support\Facades\Auth::guard('webguru')->user()->kode_guru;
        $pengumuman->tgl_upload = date('Y-m-d H:i:s');

        // dd($pengumuman);

        $pengumuman->save();

        return redirect('/guru/pengumuman')->with('status', 'Pengumuman berhasil ditambahkan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function show(Pengumuman $pengumuman)
    {
        $data = [
            'pengumuman' => $pengumuman,
            'title' => 'Pengumuman',

        ];
        return view('pengumuman.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengumuman $pengumuman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'judul_pengumuman' => 'required',
            'deskripsi' => 'required',
        ],[
            'judul_pengumuman.required' => 'Judul pengumuman harus diisi',
            'deskripsi.required' => 'Deskripsi pengumuman harus diisi',
        ]);

        
        // dd($pengumuman);
        // update
        Pengumuman::where('id', $pengumuman->id)
            ->update([
                'judul_pengumuman' => $request->judul_pengumuman,
                'deskripsi' => $request->deskripsi,
            ]);


        return redirect()->back()->with('status', 'Pengumuman berhasil diubah !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengumuman $pengumuman)
    {
        Pengumuman::destroy($pengumuman->id);
        return redirect()->back()->with('status', 'Pengumuman berhasil dihapus !');
    }

    public function sharedNotice()
    {
        $data = [
            'pengumuman' => \App\Models\Pengumuman::where('kode_guru', \Illuminate\Support\Facades\Auth::guard('webguru')->user()->kode_guru)->orderBy('tgl_upload', 'desc')->get(),
            'title' => 'Pengumuman',
        ];
        
        return view('pengumuman.shared', $data);
    }
}
