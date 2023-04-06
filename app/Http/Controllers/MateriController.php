<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'materi' => \App\Models\Materi::all(),
            'title' => 'Material',
        ];
        return view('materi.materi', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Materi',
            'kelas' => \App\Models\Tingkat::all(),
            'mapel' => \App\Models\Mapel::all(),
        ];
        return view('materi.addmateri', $data);
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
            'judul' => 'required',
            'kelas' => 'required',
            'mapel' => 'required',
            'file' => 'required',

        ],[
            'judul.required' => 'Kolom judul harus diisi',
            'kelas.required' => 'Kolom kelas harus diisi',
            'mapel.required' => 'Kolom pelajaran harus diisi',
            'file.required' => 'Kolom file harus diisi',
        ]);

        $file = $request->file('file');
        $nama_file = time()."_".$file->getClientOriginalName();
        $tujuan_upload = 'file/materi';
        $file->move($tujuan_upload,$nama_file);

        // jika yang login berasal dari tabel admin maka kode admin yang akan disimpan
        $check = \Illuminate\Support\Facades\Auth::guard('webadmin')->check();
        if($check){
            $kode_admin = \Illuminate\Support\Facades\Auth::guard('webadmin')->user()->kode_admin;
            $kode_guru = NULL;
        }else{
            $kode_guru = \Illuminate\Support\Facades\Auth::guard('webguru')->user()->kode_guru;
            $kode_admin = NULL;
        }

        Materi::create([
            'judul_materi' => $request->judul,
            'kode_tingkat' => $request->kelas,
            'kode_pelajaran' => $request->mapel,
            'keterangan' => $request->deskripsi,
            'berkas' => $nama_file,
            'kode_admin' => $kode_admin,
            'kode_guru' => $kode_guru,
        ]);

        return redirect('/admin/materi')->with('sukses', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Materi  $materi
     * @return \Illuminate\Http\Response
     */
    public function show(Materi $materi)
    {
        $data = [
            'title' => 'Detail Materi',
            'materi' => $materi,
        ];
        return view('materi.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Materi  $materi
     * @return \Illuminate\Http\Response
     */
    public function edit(Materi $materi)
    {
        $data = [
            'title' => 'Edit Materi',
            'materi' => $materi,
            'kelas' => \App\Models\Tingkat::all(),
            'mapel' => \App\Models\Mapel::all(),
        ];
        
        return view('materi.editmateri', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Materi  $materi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materi $materi)
    {
        $request->validate([
            'judul_materi' => 'required',
            'kelas' => 'required',
            'mapel' => 'required',
        ],[
            'judul_materi.required' => 'Kolom judul harus diisi',
            'kelas.required' => 'Kolom kelas harus diisi',
            'mapel.required' => 'Kolom pelajaran harus diisi',
        ]);

        // cek apakah ada file yang diupload atau tidak, jika ada maka file lama akan dihapus dan file baru akan diupload
        if($request->hasFile('file')){
            $file = $request->file('file');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'file/materi';
            $file->move($tujuan_upload,$nama_file);

            // hapus file lama
            $file_lama = $materi->berkas;
            $path = public_path().'/file/materi/'.$file_lama;
            unlink($path);

            $materi->berkas = $nama_file;
        }


        $materi->judul_materi = $request->judul_materi;
        $materi->kode_tingkat = $request->kelas;
        $materi->keterangan = $request->keterangan;
        $materi->kode_pelajaran = $request->mapel;
        $materi->save();

        if(\Illuminate\Support\Facades\Auth::guard('webadmin')->check()){
            return redirect('/admin/materi')->with('sukses', 'Data berhasil diubah');
        } else {
            return redirect('/guru/materi')->with('sukses', 'Data berhasil diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Materi  $materi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materi $materi)
    {
        $materi->delete();
        if(\Illuminate\Support\Facades\Auth::guard('webadmin')->check()){
            return redirect('/admin/materi')->with('sukses', 'Data berhasil dihapus');
        } else {
            return redirect('/guru/materi')->with('sukses', 'Data berhasil dihapus');
        }

    }

    public function shared(){
        $data = [
            'title' => 'Materi yang dibagikan',
            'materi' => \App\Models\Materi::where('kode_guru', \Illuminate\Support\Facades\Auth::guard('webguru')->user()->kode_guru)->get(),
        ];
        return view('materi.shared', $data);
    }

}
