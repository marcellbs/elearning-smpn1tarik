<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use Illuminate\Support\Facades\Auth;
use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasControllerr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
                'title' => 'Tugas',
                'tugas' => Tugas::all(),
                'pengampu' => Pengampu::all(),
                'kelas' => \App\Models\Kelas::all(),
                'mapel' => \App\Models\Mapel::all(),                 
        ];        

        return view('tugas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Tugas Baru',
            'kelasYangDiajar' => Pengampu::where('kode_guru', Auth::guard('webguru')->user()->kode_guru)->get(),
            
        ];

        // dd($data);
        return view('tugas.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            // dd($request->all());
            $request->validate([
                
                'judul_tugas' => 'required',
                'deskripsi_tugas' => 'required',
                'kelas' => 'required',
                'berkas' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:2048',
                'deadline' => 'required',

            ]);
    
            $file = $request->file('berkas');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'tugas';
            $file->move($tujuan_upload,$nama_file);
    
            $tugas = new Tugas;
            $tugas->judul_tugas = $request->judul_tugas;
            $tugas->keterangan = $request->deskripsi_tugas;
            $tugas->kode_kelas = $request->kelas;
            $tugas->kode_pelajaran = Pengampu::where('kode_kelas', $request->kelas)->first()->kode_pelajaran;
            $tugas->kode_guru = Auth::guard('webguru')->user()->kode_guru;
            $tugas->deadline = $request->deadline;
            $tugas->berkas = $nama_file;

            // dd($tugas);

            $tugas->save();
            return redirect()->route('tugas.index')->with('success', 'Tugas baru berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function show(Tugas $tugas)
    {
        $data = [
            'title' => 'Detail Tugas',
            'tugas' => $tugas,
        ];

        return view('tugas.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function edit(Tugas $tugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tugas $tugas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tugas $tugas)
    {
        $tugas->delete();
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus');
    }
}
