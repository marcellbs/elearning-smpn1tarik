<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JawabanTugas;
use App\Models\Tugas;


class JawabanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            // menampilkan data tugas berdasarkan kelassiswa yang login dan berikan pagination
            // 'tugas' => Tugas::where('kode_kelas', \App\Models\KelasSiswa::where('kode_siswa', auth()->user()->kode_siswa)->first()->kode_kelas)->orderBy('created_at', 'desc')->get(),

            'tugas' => Tugas::join('kelas', 'kelas.kode_kelas', '=', 'tugas.kode_kelas')
                ->join('kelas_siswa', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
                ->where('kelas_siswa.kode_siswa', auth()->user()->kode_siswa)
                ->orderBy('tugas.created_at', 'desc')
                // ->get()
                ->paginate(10),

            'title' => 'Tugas',
            'kelas_siswa' => \App\Models\KelasSiswa::where('kode_siswa', auth()->user()->kode_siswa)->first(),
            'jawaban' => JawabanTugas::where('kode_siswa', auth()->user()->kode_siswa)->get(),
            'tgs' => Tugas::all(),
        ];

        return view('siswa.tugas', $data);
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
            'berkas' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:5120',
        ]);

        // ambil data siswa
        $siswa = \App\Models\Siswa::where('kode_siswa', auth()->user()->kode_siswa)->first();
        
        // ambil file yang diupload
        $file = $request->file('berkas');
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
        $jawaban->keterangan = $request->keterangan;
        $jawaban->tgl_upload = $waktu;

        // dd($jawaban);

        $jawaban->save();

        // return ke halaman sebelumnya
        return redirect()->back()->with('success', 'Jawaban berhasil dikumpulkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // menampilkan detail tugas yang dipilih
        $data = [
            'tugas' => Tugas::join('kelas', 'kelas.kode_kelas', '=', 'tugas.kode_kelas')
                ->join('kelas_siswa', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
                ->leftjoin('jawaban_tugas', 'jawaban_tugas.kode_tugas', '=', 'tugas.kode_tugas')
                ->select('tugas.*', 'kelas.nama_kelas', 'kelas_siswa.kode_siswa', 'jawaban_tugas.tgl_upload', 'jawaban_tugas.kode_tugas as kode_tugas_jawaban', )
                ->where('kelas_siswa.kode_siswa', auth()->user()->kode_siswa)
                ->where('tugas.kode_tugas', $id)
                ->orderBy('tugas.created_at', 'desc')
                ->first(),

            'title' => 'Detail Tugas',
            'jawaban' => JawabanTugas::where('kode_tugas', $id)->where('kode_siswa', auth()->user()->kode_siswa)->first(),
            'kelas_siswa' => \App\Models\KelasSiswa::where('kode_siswa', auth()->user()->kode_siswa)->first(),
        ];

        return view('siswa.detail-tugas', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
