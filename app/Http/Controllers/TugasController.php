<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\KelasSiswa;
use App\Models\TahunAjaran;
use App\Models\JawabanTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     $tahunAjaranAktif = \App\Models\TahunAjaran::where('status_aktif', '1')->first();
    //     $query = Tugas::where('kode_guru', auth()->user()->kode_guru);

    //     // Filtering berdasarkan kode_kelas
    //     $kodeKelas = $request->input('kode_kelas');
    //     if ($kodeKelas) {
    //         $query->where('kode_kelas', $kodeKelas);
    //     }

    //     $tugas = $query->where('tugas.kode_thajaran', $tahunAjaranAktif->id)
    //     ->orderBy('created_at', 'desc')
    //     ->paginate(6);

    //     foreach ($tugas as $t) {
    //         $kelas = Kelas::find($t->kode_kelas);
    //         // $t->nama_tingkat = $kelas->tingkat->nama_tingkat;

    //         $jumlahSiswaKelas = KelasSiswa::where('kode_kelas', $t->kode_kelas)
    //             ->count();

    //         $t->jumlahSiswaKelas = $jumlahSiswaKelas;
    //     }

    //     $kelasOptions = Kelas::select('kelas.kode_kelas', 'kelas.nama_kelas')
    //         ->join('pengampu', 'pengampu.kode_kelas', '=', 'kelas.kode_kelas')
    //         ->where('pengampu.kode_guru', auth()->user()->kode_guru)
    //         ->where('pengampu.kode_thajaran', $tahunAjaranAktif->id)
    //         ->distinct()
    //         ->get();

    //     $tahunAjaranOptions = 

    //     $data = [
    //         'tugas' => $tugas,
    //         'kelasOptions' => $kelasOptions,
    //         'title' => 'Tugas',
    //     ];
            
    //     return view('tugas.index', $data);
    // }

    public function index(Request $request)
    {
        // Mendapatkan tahun ajaran aktif
        $tahunAjaranAktif = \App\Models\TahunAjaran::where('status_aktif', '1')->first();

        // Menginisialisasi query tugas dengan memfilter berdasarkan kode guru
        $query = Tugas::where('kode_guru', auth()->user()->kode_guru);

        // Filtering berdasarkan kode_kelas
        $kodeKelasTerpilih = $request->input('kode_kelas');
        if ($kodeKelasTerpilih) {
            $query->where('kode_kelas', $kodeKelasTerpilih);
        }

        // Filtering berdasarkan tahun ajaran, termasuk tahun ajaran sebelumnya jika dipilih
        $tahunAjaranTerpilih = $request->input('tahun_ajaran');
        if ($tahunAjaranTerpilih) {
            $query->whereHas('kelas', function ($kelasQuery) use ($tahunAjaranTerpilih) {
                $kelasQuery->where('kode_thajaran', $tahunAjaranTerpilih);
            });
        } elseif ($tahunAjaranAktif) {
            $query->whereHas('kelas', function ($kelasQuery) use ($tahunAjaranAktif) {
                $kelasQuery->where('kode_thajaran', $tahunAjaranAktif->id);
            });
        }

        // Mengambil tugas dengan mengurutkan berdasarkan created_at secara descending dan membaginya menjadi beberapa halaman
        $tugas = $query
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        
        $tugas->appends(['tahun_ajaran' => $tahunAjaranTerpilih, 'kode_kelas' => $kodeKelasTerpilih]);
        // Menambahkan jumlah siswa ke setiap tugas
        foreach ($tugas as $t) {
            $jumlahSiswaKelas = KelasSiswa::where('kode_kelas', $t->kode_kelas)
            ->where('kode_thajaran', $t->kode_thajaran)
            ->count();
            $t->jumlahSiswaKelas = $jumlahSiswaKelas;
        }
        // Opsi kelas yang tersedia jika tahun ajaran dipilih
        $kelasOptions = [];
        if ($tahunAjaranTerpilih) {
            $kelasOptions = Kelas::select('kelas.kode_kelas', 'kelas.nama_kelas')
                ->join('pengampu', 'pengampu.kode_kelas', '=', 'kelas.kode_kelas')
                ->where('pengampu.kode_guru', auth()->user()->kode_guru)
                ->where('pengampu.kode_thajaran', $tahunAjaranTerpilih)
                ->distinct()
                ->get();
        }

        // Opsi tahun ajaran untuk dropdown
        $tahunAjaranOptions = \App\Models\TahunAjaran::pluck('tahun_ajaran', 'id');

        // Data yang akan dikirimkan ke view
        $data = [
            'tugas' => $tugas,
            'kelasOptions' => $kelasOptions,
            'tahunAjaranOptions' => $tahunAjaranOptions,
            'tahunAjaran' => $tahunAjaranAktif,
            'kodeKelasTerpilih' => $kodeKelasTerpilih,
            'tahunAjaranTerpilih' => $tahunAjaranTerpilih,
            'title' => 'Tugas',
        ];

        // Menampilkan view dengan data yang telah disiapkan
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
            
            'kelas' => \App\Models\Kelas::select('kelas.kode_kelas', 'kelas.nama_kelas')
                ->join('pengampu', 'pengampu.kode_kelas', '=', 'kelas.kode_kelas')
                ->where('pengampu.kode_guru', auth()->user()->kode_guru)
                ->where('pengampu.kode_thajaran', \App\Models\TahunAjaran::where('status_aktif', '1')->first()->id)
                ->distinct()
                ->get(),
            
            'mapel' => \App\Models\Mapel::select('pelajaran.kode_pelajaran', 'pelajaran.nama_pelajaran')
                ->join('pengampu', 'pengampu.kode_pelajaran', '=', 'pelajaran.kode_pelajaran')
                ->where('pengampu.kode_guru', auth()->user()->kode_guru)
                ->where('pengampu.kode_thajaran', \App\Models\TahunAjaran::where('status_aktif', '1')->first()->id)
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
        $tugas->kode_thajaran = \App\Models\TahunAjaran::where('status_aktif', '1')->first()->id;
        
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
            $siswa = Siswa::select('siswa.nis', 'siswa.nama_siswa', 'jawaban_tugas.tgl_upload', 'jawaban_tugas.nilai', 'jawaban_tugas.berkas', 'jawaban_tugas.id', 'jawaban_tugas.keterangan')
                ->join('kelas_siswa', 'kelas_siswa.kode_siswa', '=', 'siswa.kode_siswa')
                ->join('tugas', 'tugas.kode_kelas', '=', 'kelas_siswa.kode_kelas')
                ->leftJoin('jawaban_tugas', function ($join) use ($tuga) {
                    $join->on('jawaban_tugas.kode_siswa', '=', 'siswa.kode_siswa')
                        ->where('jawaban_tugas.kode_tugas', '=', $tuga->kode_tugas);
                })
                ->where('tugas.kode_tugas', $tuga->kode_tugas)
                ->where('kelas_siswa.kode_thajaran', $tuga->kode_thajaran)
                ->get();

            $tgl_indonesia = \Carbon\Carbon::parse($tuga->deadline)->locale('id');

            $data = [
                'title' => 'Detail Tugas',
                'tugas' => $tuga,
                'tgl_indonesia' => $tgl_indonesia->isoFormat('dddd, D MMMM Y'),
                'siswa' => $siswa,
                'jawaban' => JawabanTugas::where('kode_tugas', $tuga->kode_tugas)->get(),
            ];

            return view('tugas.detailtugass', $data);
    }


        
    public function downloadAll(Tugas $tuga)
    {
        $siswa = Siswa::select('jawaban_tugas.berkas')
            ->join('kelas_siswa', 'kelas_siswa.kode_siswa', '=', 'siswa.kode_siswa')
            ->join('tugas', 'tugas.kode_kelas', '=', 'kelas_siswa.kode_kelas')
            ->join('kelas', 'kelas.kode_kelas', '=', 'kelas_siswa.kode_kelas')
            // ->join('tingkat_kelas', 'tingkat_kelas.kode_tingkat', '=', 'kelas.kode_tingkat')
            ->join('jawaban_tugas', function ($join) use ($tuga) {
                $join->on('jawaban_tugas.kode_siswa', '=', 'siswa.kode_siswa')
                    ->where('jawaban_tugas.kode_tugas', '=', $tuga->kode_tugas);
            })
            ->where('tugas.kode_tugas', $tuga->kode_tugas)
            // nama_siswa
            ->select('siswa.nama_siswa', 'jawaban_tugas.berkas', 'siswa.nis', 'tugas.judul_tugas', 'kelas.nama_kelas')
            ->get();
            
        $zip = new ZipArchive();
        // tingkat_kelas->nama_tingkat . kelas->nama_kelas
        $zipFileName = 'JawabanTugas_' . $tuga->judul_tugas . '_' .$siswa[0]->nama_kelas . '.zip';

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($siswa as $dataSiswa) {
                $berkas = $dataSiswa->berkas;

                if (!empty($berkas)) {
                    $fileExtension = pathinfo($berkas, PATHINFO_EXTENSION);
                    $namaFile =  $dataSiswa->nis . '_jawaban_' . $dataSiswa->nama_siswa. '.' . $fileExtension;

                    // Ambil file jawaban dari folder public/jawaban
                    $fileJawaban = public_path('jawaban/' . $berkas);

                    // Tambahkan file ke dalam zip
                    $zip->addFile($fileJawaban, $namaFile);
                }
            }

            $zip->close();

            // Set header dan mengembalikan file zip sebagai respons download
            $headers = [
                'Content-Type' => 'application/octet-stream',
            ];

            return response()->download($zipFileName, $zipFileName, $headers);
        } 
        
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
            'kelas' => \App\Models\Kelas::select('kelas.kode_kelas', 'kelas.nama_kelas')
                ->join('pengampu', 'pengampu.kode_kelas', '=', 'kelas.kode_kelas')
                ->where('pengampu.kode_guru', auth()->user()->kode_guru)
                ->where('pengampu.kode_thajaran', $tuga->kode_thajaran)
                ->distinct()
                ->get(),
            
            // menampilkan mapel sesuai yang dipilih oleh guru yang login saat ini menggunakan distinct
            'mapel' => \App\Models\Mapel::select('pelajaran.kode_pelajaran', 'pelajaran.nama_pelajaran')
                ->join('pengampu', 'pengampu.kode_pelajaran', '=', 'pelajaran.kode_pelajaran')
                ->where('pengampu.kode_guru', auth()->user()->kode_guru)
                ->where('pengampu.kode_thajaran', $tuga->kode_thajaran)
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
        return redirect()->back()->with('success', 'Tugas berhasil dihapus');

    }


    public function nilaiJawaban(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required',
        ],[
            'nilai.required' => 'Nilai tidak boleh kosong',
        ]);

        $jawaban = JawabanTugas::find($id);
        $jawaban->nilai = $request->nilai;
        $jawaban->save();

        return redirect()->back()->with('success', 'Nilai berhasil disimpan');
    }
    
    public function report(Request $request)
    {
        $tahunAjaranAktif = \App\Models\TahunAjaran::where('status_aktif', 1)->first();
        $tahunAjaranOptions = \App\Models\TahunAjaran::pluck('tahun_ajaran', 'id');

        $selectedTahunAjaran = $request->input('tahun_ajaran');
        $selectedKelas = $request->input('kode_kelas');
        $selectedPelajaran = $request->input('kode_pelajaran');

        $mapel = Mapel::select('pelajaran.kode_pelajaran', 'pelajaran.nama_pelajaran')
            ->join('pengampu', 'pengampu.kode_pelajaran', '=', 'pelajaran.kode_pelajaran')
            ->where('pengampu.kode_guru', auth()->user()->kode_guru)
            ->where('pengampu.kode_thajaran', $selectedTahunAjaran)
            ->distinct()
            ->get();

        $kelas = Kelas::select('kelas.kode_kelas', 'kelas.nama_kelas')
            ->join('pengampu', 'pengampu.kode_kelas', '=', 'kelas.kode_kelas')
            ->where('pengampu.kode_guru', auth()->user()->kode_guru)
            ->where('pengampu.kode_thajaran', $selectedTahunAjaran)
            ->distinct()
            ->get();

        $tugas = Tugas::where('kode_kelas', $selectedKelas)
            ->where('kode_pelajaran', $selectedPelajaran)
            ->where('kode_guru', auth()->user()->kode_guru)
            ->where('kode_thajaran', $selectedTahunAjaran)
            ->get();

        $siswa = Siswa::whereHas('kelasSiswa', function ($query) use ($selectedKelas, $selectedTahunAjaran) {
            $query->where('kode_kelas', $selectedKelas)
                ->where('kode_thajaran', $selectedTahunAjaran);
        })->get();

        $namaMapel = Mapel::where('kode_pelajaran', $selectedPelajaran)->value('nama_pelajaran');

        $data = [
            'title' => 'Report Tugas',
            'tugas' => $tugas,
            'mapel' => $mapel,
            'kelas' => $kelas,
            'siswa' => $siswa,
            'kodePelajaran' => $selectedPelajaran,
            'kodeKelas' => $selectedKelas,
            'namaGuru' => auth()->user()->nama,
            'namaMapel' => $namaMapel,
            'tahunAjaranOptions' => $tahunAjaranOptions,
            'selectedTahunAjaran' => $selectedTahunAjaran,
            
        ];

        return view('tugas.reporttugas', $data);
    }

    public function getKelas(Request $request)
    {
        try {
            $tahunAjaran = $request->input('tahun_ajaran');
    
            $kelas = \App\Models\Pengampu::select('pengampu.kode_kelas', 'kelas.nama_kelas')
                ->join('kelas', 'pengampu.kode_kelas', '=', 'kelas.kode_kelas')
                ->where('pengampu.kode_guru', auth()->user()->kode_guru)
                ->where('pengampu.kode_thajaran', $tahunAjaran)
                ->distinct()
                ->get();
    
            return response()->json($kelas);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getMapel(Request $request)
    {
        $tahunAjaran = $request->input('tahun_ajaran');
        $kelas = $request->input('kode_kelas');

        $mapel = \App\Models\Pengampu::select('pelajaran.kode_pelajaran', 'pelajaran.nama_pelajaran')
            ->join('pelajaran', 'pengampu.kode_pelajaran', '=', 'pelajaran.kode_pelajaran')
            ->where('pengampu.kode_guru', auth()->user()->kode_guru)
            ->where('pengampu.kode_thajaran', $tahunAjaran)
            ->distinct()
            ->get();

        return response()->json($mapel);
    }


    // public function report(Request $request)
    // {
    //     $mapel = Mapel::select('pelajaran.kode_pelajaran', 'pelajaran.nama_pelajaran')
    //         ->join('pengampu', 'pengampu.kode_pelajaran', '=', 'pelajaran.kode_pelajaran')
    //         ->where('pengampu.kode_guru', auth()->user()->kode_guru)
    //         ->where('pengampu.kode_thajaran', \App\Models\TahunAjaran::where('status_aktif', 1)->first()->id)
    //         ->distinct()
    //         ->get();
        
    //     $kelas = Kelas::select('kelas.kode_kelas', 'kelas.nama_kelas')
    //         ->join('pengampu', 'pengampu.kode_kelas', '=', 'kelas.kode_kelas')
    //         ->where('pengampu.kode_guru', auth()->user()->kode_guru)
    //         ->where('pengampu.kode_thajaran', \App\Models\TahunAjaran::where('status_aktif', 1)->first()->id)
    //         ->distinct()
    //         ->get();

    //     $kodeKelas = $request->input('kode_kelas');
    //     $kodePelajaran = $request->input('kode_pelajaran');

    //     $tugas = Tugas::where('kode_kelas', $kodeKelas)
    //         ->where('kode_pelajaran', $kodePelajaran)
    //         ->where('kode_guru', auth()->user()->kode_guru)
    //         ->where('kode_thajaran', \App\Models\TahunAjaran::where('status_aktif', 1)->first()->id)
    //         ->get();

    //     $siswa = Siswa::whereHas('kelasSiswa', function ($query) use ($kodeKelas) {
    //         $query->where('kode_kelas', $kodeKelas)
    //         ->where('kode_thajaran', \App\Models\TahunAjaran::where('status_aktif', 1)->first()->id);
    //     })->get();

    //     $namaMapel = Mapel::where('kode_pelajaran', $kodePelajaran)->value('nama_pelajaran');

    //     $data = [
    //         'title' => 'Report Tugas',
    //         'tugas' => $tugas,
    //         'mapel' => $mapel,
    //         'kelas' => $kelas,
    //         'siswa' => $siswa,
    //         'kodePelajaran' => $kodePelajaran,
    //         'kodeKelas' => $kodeKelas,
    //         'namaGuru' => auth()->user()->nama,
    //         'namaMapel' => $namaMapel, // Tambahkan ini untuk nama mapel
    //     ];

    //     return view('tugas.reporttugas', $data);
    // }

    public function exportReport(Request $request)
    {
        $kodeKelas = $request->input('kode_kelas');
        $kodePelajaran = $request->input('kode_pelajaran');
        $selectedTahunAjaran = $request->input('tahun_ajaran');

        $mapel = Mapel::where('kode_pelajaran', $kodePelajaran)->first();
        $kelas = Kelas::where('kode_kelas', $kodeKelas)->first();
        $guru = Guru::where('kode_guru', auth()->user()->kode_guru)->first();
        $tahunAjaran = TahunAjaran::where('id', $selectedTahunAjaran)->first();

        $tugas = Tugas::where('kode_kelas', $kodeKelas)
            ->where('kode_pelajaran', $kodePelajaran)
            ->where('kode_guru', auth()->user()->kode_guru)
            ->get();

        $siswa = Siswa::whereHas('kelasSiswa', function ($query) use ($kodeKelas) {
            $query->where('kode_kelas', $kodeKelas);
        })->get();

        // Membuat objek Spreadsheet
        $spreadsheet = new Spreadsheet();

        // Judul Sheet
        $spreadsheet->getActiveSheet()->setTitle('Report Tugas');

        // Menambahkan informasi header pada lembar kerja utama
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'Nama Guru : ' . $guru->nama);
        $spreadsheet->getActiveSheet()->setCellValue('A2', 'Tugas Kelas : '. $kelas->nama_kelas);
        $spreadsheet->getActiveSheet()->setCellValue('A3', 'Mapel : ' . $mapel->nama_pelajaran);
        $spreadsheet->getActiveSheet()->setCellValue('A4', 'Tahun Ajaran : ' . $tahunAjaran->tahun_ajaran);

        // Menambahkan header tabel pada lembar kerja utama
        $spreadsheet->getActiveSheet()->setCellValue('A6', 'NIS');
        $spreadsheet->getActiveSheet()->setCellValue('B6', 'Nama Siswa');

        //Mengatur lebar kolom
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        $column = 'B'; // Kolom awal pada lembar kerja utama
        $columnIndex = 3; // Indeks kolom awal pada lembar kerja utama

        foreach ($tugas as $index => $t) {
            $column = chr(ord($column) + 1); // Mengambil nilai ASCII huruf dan menambahkannya dengan 1
            $spreadsheet->getActiveSheet()->setCellValue($column . '6', 'Tugas ' . ($index + 1));
            $columnIndex++;
        }

        // Menambahkan data siswa dan nilai tugas pada lembar kerja utama
        $rowIndex = 7;

        foreach ($siswa as $index => $sis) {
            $spreadsheet->getActiveSheet()->setCellValue('A' . $rowIndex, $sis->nis);
            $spreadsheet->getActiveSheet()->setCellValue('B' . $rowIndex, $sis->nama_siswa);

            foreach ($tugas as $index => $t) {
                $jawaban = $t->jawaban->where('kode_siswa', $sis->kode_siswa)->first();
                $nilai = $jawaban ? $jawaban->nilai : '-';
                $column = chr(65 + $index + 2); // Mengubah indeks kolom menjadi huruf dengan offset 2 karena ada 2 kolom sebelumnya
                $spreadsheet->getActiveSheet()->setCellValue($column . $rowIndex, $nilai);

                // Memberikan format pada sel dengan tanda minus (-)
                if ($nilai == '-') {
                    $cellCoordinate = $column . $rowIndex;
                    $cellFill = $spreadsheet->getActiveSheet()->getStyle($cellCoordinate)->getFill();
                    $cellFill->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFA500'); // Warna oranye dalam format ARGB
                }
            }

            $rowIndex++;
        }

        // Menambahkan keterangan pada lembar kerja utama
        $keteranganRow = $rowIndex + 2;
        $spreadsheet->getActiveSheet()->setCellValue('A' . $keteranganRow, 'Keterangan');
        $spreadsheet->getActiveSheet()->getStyle('A' . $keteranganRow)->getFont()->setBold(true);

        $keteranganRow++;
        // $spreadsheet->getActiveSheet()->setCellValue('A' . $keteranganRow, 'FFA500');
        // warna oranye dalam format ARGB
        $spreadsheet->getActiveSheet()->getStyle('A' . $keteranganRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFA500');
        $spreadsheet->getActiveSheet()->setCellValue('B' . $keteranganRow, 'Siswa belum mengumpulkan');

        $keteranganRow++;
        $spreadsheet->getActiveSheet()->getStyle('A' . $keteranganRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF');
        // $spreadsheet->getActiveSheet()->setCellValue('A' . $keteranganRow, 'FFFFFF');
        $spreadsheet->getActiveSheet()->setCellValue('B' . $keteranganRow, 'Belum dinilai');

        // Membuat sheet tugas dan nilai
        foreach ($tugas as $index => $t) {
            $worksheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Tugas ' . ($index + 1));
            $spreadsheet->addSheet($worksheet, $index + 1);

            // Menambahkan informasi header pada sheet tugas dan nilai
            $worksheet->setCellValue('A1', 'Nama Guru: ' . $guru->nama);
            $worksheet->setCellValue('A2', 'Kelas: ' . $kelas->nama_kelas);
            $worksheet->setCellValue('A3', 'Mapel: ' . $mapel->nama_pelajaran);
            $worksheet->setCellValue('A4', 'Tugas: ' . $t->judul_tugas);
            $worksheet->setCellValue('A5', 'Deskripsi Tugas: ' . $t->keterangan);

            // Menambahkan header tabel pada sheet tugas dan nilai
            $worksheet->setCellValue('A7', 'NIS');
            $worksheet->setCellValue('B7', 'Nama Siswa');
            $worksheet->setCellValue('C7', 'Nilai');
            $worksheet->setCellValue('D7', 'Keterangan');

            // Menambahkan data siswa dan nilai tugas pada sheet tugas dan nilai
            $rowIndex = 8;

            foreach ($siswa as $index => $sis) {
                $worksheet->setCellValue('A' . $rowIndex, $sis->nis);
                $worksheet->setCellValue('B' . $rowIndex, $sis->nama_siswa);

                // mengatur lebar kolom
                $worksheet->getColumnDimension('A')->setWidth(30);
                $worksheet->getColumnDimension('B')->setAutoSize(true);

                $jawaban = $t->jawaban->where('kode_siswa', $sis->kode_siswa)->first();
                $nilai = $jawaban ? $jawaban->nilai : '-';
                $worksheet->setCellValue('C' . $rowIndex, $nilai);

                // Memberikan format pada sel dengan tanda minus (-)
                if ($nilai == '-') {
                    $cellCoordinate = 'C' . $rowIndex;
                    $cellFill = $worksheet->getStyle($cellCoordinate)->getFill();
                    $cellFill->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFA500'); // Warna oranye dalam format ARGB
                }

                $keterangan = $jawaban ? $jawaban->keterangan : '-';
                $worksheet->setCellValue('D' . $rowIndex, $keterangan);
                $worksheet->getColumnDimension('D')->setAutoSize(true);

                $rowIndex++;
            }


            // menambahkan keterangan
            $keteranganRow = $rowIndex + 2;
            $worksheet->setCellValue('A' . $keteranganRow, 'Keterangan');
            $worksheet->getStyle('A' . $keteranganRow)->getFont()->setBold(true);
        
            $keteranganRow++;
            $spreadsheet->getActiveSheet()->getStyle('A' . $keteranganRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFA500');
            $worksheet->setCellValue('B' . $keteranganRow, 'Siswa belum mengumpulkan');
            
            $keteranganRow++;
            // $worksheet->setCellValue('A' . $keteranganRow, 'FFFFFF');
            $spreadsheet->getActiveSheet()->getStyle('A' . $keteranganRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF');
            $worksheet->setCellValue('B' . $keteranganRow, 'Belum dinilai');
        }



        // Simpan file Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Report_Tugas_'.$mapel->nama_pelajaran.'_'.$kelas->nama_kelas.'.xlsx';
        $filePath = storage_path('app/public/' . $fileName);
        $writer->save($filePath);

        // Kirim file Excel sebagai response
        return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
    }




}
