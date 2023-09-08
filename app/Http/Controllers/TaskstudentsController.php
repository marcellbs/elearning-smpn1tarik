<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Tugas;
use App\Models\JawabanTugas;
use Illuminate\Http\Request;

class TaskstudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // public function index(Request $request)
    // {
    //     $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)->first();
    //     $query = Tugas::with('guru')
    //         ->join('kelas', 'kelas.kode_kelas', '=', 'tugas.kode_kelas')
    //         ->join('kelas_siswa', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
    //         ->where('kelas_siswa.kode_siswa', auth()->user()->kode_siswa)
    //         ->where('tugas.kode_thajaran', $tahunAjaran->id)
    //         ->orderBy('tugas.created_at', 'desc');

    //     $kodePelajaran = $request->input('kode_pelajaran');
    //     if ($kodePelajaran) {
    //         $query->where('tugas.kode_pelajaran', $kodePelajaran);
    //     }

    //     $tugas = $query->paginate(6);

    //     $kelasSiswa = \App\Models\KelasSiswa::where('kode_siswa', auth()->user()->kode_siswa)->first();
    //     $pelajaranOptions = Mapel::pluck('nama_pelajaran', 'kode_pelajaran');

    //     $data = [
    //         'tugas' => $tugas,
    //         'title' => 'Tugas',
    //         'kelas_siswa' => $kelasSiswa,
    //         'pelajaranOptions' => $pelajaranOptions,
    //     ];

    //     return view('siswa.tugas', $data);
    // }

    public function index(Request $request)
    {
        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)->first();

        $query = Tugas::with('guru')
            ->join('kelas', 'kelas.kode_kelas', '=', 'tugas.kode_kelas')
            ->join('kelas_siswa', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
            ->where('kelas_siswa.kode_siswa', auth()->user()->kode_siswa)
            ->where('tugas.kode_thajaran', $tahunAjaran->id)
            ->orderBy('tugas.created_at', 'desc');

        $kodePelajaran = $request->input('kode_pelajaran');
        if ($kodePelajaran) {
            $query->where('tugas.kode_pelajaran', $kodePelajaran);
        }

        $namaTahunAjaran = $request->input('tahun_ajaran');
        if ($namaTahunAjaran) {
            $tahunAjaran = \App\Models\TahunAjaran::where('tahun_ajaran', $namaTahunAjaran)->first();
            $query->where('tugas.kode_thajaran', $tahunAjaran->id);
        }

        $tugas = $query->paginate(6);

        $kelasSiswa = \App\Models\KelasSiswa::where('kode_siswa', auth()->guard('websiswa')->user()->kode_siswa)
        ->where('kode_thajaran', $tahunAjaran->id)
        ->first();
<<<<<<< HEAD

        if(!$kelasSiswa) {
            return redirect()->back()->with('error', 'Anda belum terdaftar di kelas manapun untuk tahun ajaran ini');
        }

=======
        
        if(!$kelasSiswa) {
            return redirect()->back()->with('error', 'Anda belum terdaftar di kelas manapun untuk tahun ajaran ini');
        }
        
>>>>>>> 4ebc43f947b002fad9b38b3d82049793dfbdf3f9
        $pelajaranOptions = Mapel::pluck('nama_pelajaran', 'kode_pelajaran');
        $listTahunAjaran = \App\Models\TahunAjaran::pluck('tahun_ajaran', 'id');

        $data = [
            'tugas' => $tugas,
            'title' => 'Tugas',
            'kelas_siswa' => $kelasSiswa,
            'pelajaranOptions' => $pelajaranOptions,
            'listTahunAjaran' => $listTahunAjaran,
            'tahun_ajaran_id' => $namaTahunAjaran
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

        $siswa = \App\Models\Siswa::where('kode_siswa', auth()->user()->kode_siswa)->first();

        $file = $request->file('berkas');
        $nama_file = $file->getClientOriginalName();
        $file->move('jawaban', $nama_file);

        $waktu_upload = now('Asia/Jakarta');

        // dd($request->all(), $siswa, $nama_file, $waktu_upload);

        $jawaban = JawabanTugas::create([
            'kode_tugas' => $request->kdtugas,
            'kode_siswa' => $siswa->kode_siswa,
            'berkas' => $nama_file,
            'keterangan' => $request->keterangan,
            'tgl_upload' => $waktu_upload,
        ]);

        if( $jawaban ) {
            return redirect()->back()->with('success', 'Jawaban berhasil dikumpulkan');
        } else {
            return redirect()->back()->with('error', 'Jawaban gagal dikumpulkan');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Menampilkan detail tugas yang dipilih
        $tugas = Tugas::with('kelas', 'jawaban')
            ->where('kode_tugas', $id)
            ->first();

        // Mengambil jawaban tugas siswa yang terkait
        $jawaban = JawabanTugas::where('kode_tugas', $id)
            ->where('kode_siswa', auth()->user()->kode_siswa)
            ->first();
        
        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)->first();
        $kelasSiswa = \App\Models\KelasSiswa::where('kode_siswa', auth()->guard('websiswa')->user()->kode_siswa)
            ->where('kode_thajaran', $tahunAjaran->id)
            ->first();

        $data = [
            'tugas' => $tugas,
            'title' => 'Detail Tugas',
            'jawaban' => $jawaban,
            'kelas_siswa' => $kelasSiswa,
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
