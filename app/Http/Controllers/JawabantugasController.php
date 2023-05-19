<?php

namespace App\Http\Controllers;

use App\Models\JawabanTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JawabantugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'lampiran' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:5120',
        ]);

        // ambil data siswa
        $siswa = \App\Models\Siswa::where('kode_siswa', auth()->user()->kode_siswa)->first();
        
        // ambil file yang diupload
        $file = $request->file('lampiran');
        $nama_file = $file->getClientOriginalName();
        $file->move('jawaban', $nama_file);

        $wib = new \DateTimeZone('Asia/Jakarta');
        $waktu = new \DateTime();
        $waktu->setTimezone($wib);
        $waktu->format('Y-m-d H:i:s');


        $jawaban = new JawabanTugas;
        $jawaban->kode_tugas = $request->kdtugas;
        $jawaban->kode_siswa = $siswa->kode_siswa;
        $jawaban->berkas = $nama_file;
        $jawaban->keterangan = $request->catatan;
        $jawaban->tgl_upload = $waktu;


        $jawaban->save();

        // return ke halaman sebelumnya
        return redirect()->back()->with('success', 'Jawaban berhasil dikumpulkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JawabanTugas  $jawabanTugas
     * @return \Illuminate\Http\Response
     */
    public function show(JawabanTugas $jawabanTuga)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JawabanTugas  $jawabanTugas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'title' => 'Ubah Jawaban Tugas',
            'jawab' => \App\Models\JawabanTugas::find($id),
            'kelas_siswa' => \App\Models\KelasSiswa::where('kode_siswa', Auth::guard('websiswa')->user()->kode_siswa)->first(),
        ];
        
        return view('siswa.editjawaban', $data);
    }

    public function update(Request $request, $id)
    {   
        $jawaban = JawabanTugas::find($id);

        // cek apakah ada file baru yang diupload atau tidak
        if ($request->hasFile('berkas')) {
            $file = $request->file('berkas');
            $filename = $file->getClientOriginalName();
            $file->move('jawaban', $filename);


            // hapus file lama
            $jawaban = JawabanTugas::find($id);
            unlink('jawaban/' . $jawaban->berkas);
            
            
            $jawaban->berkas = $filename;
        }

        $wib = new \DateTimeZone('Asia/Jakarta');
        $waktu = new \DateTime();
        $waktu->setTimezone($wib);
        $waktu->format('Y-m-d H:i:s');
        
        $jawaban->keterangan = $request->keterangan;
        $jawaban->tgl_upload = $waktu;

        // dd($jawaban);

        $jawaban->save();

        // return ke halaman detail tugas yang dijawab
        return redirect()->route('tugas.show', $jawaban->kode_tugas)->with('success', 'Jawaban berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JawabanTugas  $jawabanTugas
     * @return \Illuminate\Http\Response
     */
    public function destroy(JawabanTugas $jawabanTugas)
    {
        //
    }
}
