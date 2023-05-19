<?php

namespace App\Http\Controllers;

use App\Models\JawabanTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            // menampilkan data tugas dari user yang login
            'tugas' => Tugas::where('kode_guru', auth()->user()->kode_guru)->orderBy('created_at', 'desc')->get(),
            'title' => 'Tugas',
            // menampilkan siswa yang mengumpulkan tugas dari tabel jawaban_tugas
            
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
            // menampilkan kelas yang diajar oleh guru yang login saat ini menggunakan select distinct
            'kelas' => \App\Models\Kelas::select('kelas.kode_kelas', 'kelas.nama_kelas', 'tingkat_kelas.nama_tingkat')
                ->join('tingkat_kelas', 'tingkat_kelas.kode_tingkat', '=', 'kelas.kode_tingkat')
                ->join('pengampu', 'pengampu.kode_kelas', '=', 'kelas.kode_kelas')
                ->where('pengampu.kode_guru', auth()->user()->kode_guru)
                ->distinct()
                ->get(),
            
            // menampilkan mapel sesuai yang dipilih oleh guru yang login saat ini menggunakan distinct
            'mapel' => \App\Models\Mapel::select('pelajaran.kode_pelajaran', 'pelajaran.nama_pelajaran')
                ->join('pengampu', 'pengampu.kode_pelajaran', '=', 'pelajaran.kode_pelajaran')
                ->where('pengampu.kode_guru', auth()->user()->kode_guru)
                ->distinct()
                ->get(),
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
            'berkas' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:2048',
            'deadline' => 'required',

        ]);

        $tugas = new Tugas;
        $tugas->judul_tugas = $request->judul_tugas;
        $tugas->keterangan = $request->deskripsi_tugas;
        $tugas->kode_kelas = $request->kelas;
        $tugas->kode_pelajaran = $request->mapel;
        $tugas->kode_guru = \Illuminate\Support\Facades\Auth::guard('webguru')->user()->kode_guru;
        $tugas->deadline = $request->deadline;
        
        if($request->hasFile('berkas')){
            $file = $request->file('berkas');
            $filename = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
            $file->move('tugas/', $filename);

            $tugas->berkas = $filename;
        }else{
            $tugas->berkas = '';
        }

        // dd($tugas);

        $tugas->save();
        
        return redirect('guru/tugas')->with('success', 'Tugas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tugas  $tugas 
     * @return \Illuminate\Http\Response
     */
    public function show(Tugas $tuga)
    {
            $tgl_indonesia = \Carbon\Carbon::parse($tuga->deadline)->locale('id');
            $data = [
                'title' => 'Detail Tugas',
                'tugas' => $tuga,
                'tgl_indonesia' => $tgl_indonesia->isoFormat('dddd, D MMMM Y'),
                'jawaban' => JawabanTugas::where('kode_tugas', $tuga->kode_tugas)->get(),
            ];
        
            return view('tugas.detailtugas', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function edit(Tugas $tuga)
    {
        $data = [
            'title' => 'Edit Tugas',
            'tugas' => $tuga,
            'kelas' => \App\Models\Kelas::select('kelas.kode_kelas', 'kelas.nama_kelas', 'tingkat_kelas.nama_tingkat')
                ->join('tingkat_kelas', 'tingkat_kelas.kode_tingkat', '=', 'kelas.kode_tingkat')
                ->join('pengampu', 'pengampu.kode_kelas', '=', 'kelas.kode_kelas')
                ->where('pengampu.kode_guru', auth()->user()->kode_guru)
                ->distinct()
                ->get(),
            
            // menampilkan mapel sesuai yang dipilih oleh guru yang login saat ini menggunakan distinct
            'mapel' => \App\Models\Mapel::select('pelajaran.kode_pelajaran', 'pelajaran.nama_pelajaran')
                ->join('pengampu', 'pengampu.kode_pelajaran', '=', 'pelajaran.kode_pelajaran')
                ->where('pengampu.kode_guru', auth()->user()->kode_guru)
                ->distinct()
                ->get(),
            
        ];

        // dd($data);
        return view('tugas.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tugas $tuga)
    {
        $request->validate([
            'judul_tugas' => 'required',
            'kelas' => 'required',
            'deadline' => 'required',
        ],[
            'judul_tugas.required' => 'Judul tugas tidak boleh kosong',
            'kelas.required' => 'Kelas tidak boleh kosong',
            'deadline.required' => 'Deadline tidak boleh kosong',
        ]);
        // cek apakah ada file yang diupload atau tidak
        if($request->hasFile('berkas')){
            // cek apakah file sebelumnya ada atau tidak
            if($tuga->berkas != ''){
                unlink('tugas/' . $tuga->berkas);
            }
            $file = $request->file('berkas');
            // nama file terdiri dari waktu
            $filename = $file->getClientOriginalName() . '.' . $file->getClientOriginalExtension();
            $file->move('tugas/', $filename);

            $tuga->berkas = $filename;

            // hapus file sebelumnya
            unlink('tugas/' . $tuga->berkas);
        }

        $tuga->judul_tugas = $request->judul_tugas;
        $tuga->keterangan = $request->keterangan;
        $tuga->kode_kelas = $request->kelas;
        $tuga->kode_pelajaran = $request->mapel;
        $tuga->kode_guru = \Illuminate\Support\Facades\Auth::guard('webguru')->user()->kode_guru;
        $tuga->deadline = $request->deadline;

        $tuga->save();

        // kembali ke halaman sebelumnya
        return redirect('/guru/tugas')->with('success', 'Tugas berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tugas $tuga)
    {
        //cek apakah ada file atau tidak
        if($tuga->berkas != ''){
            unlink('tugas/' . $tuga->berkas);
        }

        $tuga->delete();
        return redirect('/guru/tugas')->with('success', 'Tugas berhasil dihapus');

    }

    public function getKelas($id)
    {
        $kelas = \App\Models\Kelas::where('kode_kelas', $id)->where('kode_guru', \Illuminate\Support\Facades\Auth::guard('webguru')->user()->kode_guru)->first();
        
        return response()->json($kelas);
    }
}
