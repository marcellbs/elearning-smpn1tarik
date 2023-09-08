<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Guru;
use Hashids\Hashids;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Pengampu;
use Illuminate\Http\Request;
use App\Models\PresensiModel;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Illuminate\Pagination\LengthAwarePaginator;




class PresensiController extends Controller
{
    public function index($id){
        $hash = new Hashids('my-hash',10);
        $pengampu = Pengampu::find($hash->decode($id)[0]);
        // menemukan pengampu dari detailkelas yang dipilih di halaman dashboard

        $kelas_siswa = \App\Models\KelasSiswa::where('kode_kelas', $pengampu->kode_kelas)
        ->where('kode_thajaran', $pengampu->kode_thajaran)
        ->get();

        $data = [
            'title' => 'Presensi',
            'pengampu' => $pengampu,
            'siswa' => Siswa::whereIn('kode_siswa', $kelas_siswa->pluck('kode_siswa')->toArray())->get(),
            'hash' => $hash,
        ];

        return view('presensi.index', $data);
    }

    public function storePresensi(Request $request){

        // jika tidak memiliki daftar siswa
        if(!$request->has('presensi')){
            return redirect()->back()->with('error', '<strong>Gagal ! </strong> Tidak ada siswa yang dipilih.');
        }

        $presensiData = $request->input('presensi');

        foreach ($presensiData as $siswaId => $status) {
            $siswa = Siswa::find($siswaId);
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d');

            $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)->first();

            // Cek apakah presensi sudah dilakukan pada tanggal tersebut berdasarkan kode pelajaran
            $existingPresensi = PresensiModel::where('kode_siswa', $siswaId)
                ->where('tanggal_presensi', $date)
                ->where('kode_pelajaran', $request->kode_pelajaran)
                ->where('kode_thajaran', $tahunAjaran->id)
                ->first();

            if ($existingPresensi) {
                return redirect()->back()->with('error', '<strong>Gagal!</strong> Presensi untuk hari ini sudah dilakukan.');
            }

            

            // Simpan data presensi ke dalam tabel presensi
            PresensiModel::create([
                'kode_siswa' => $siswaId,
                'status' => $status,
                'tanggal_presensi' => $date,
                'kode_guru' => $request->kode_guru,
                'kode_pelajaran' => $request->kode_pelajaran,
                'kode_kelas' => $request->kode_kelas,
                'kode_kelas' => $request->kode_kelas,
                'kode_thajaran' => $tahunAjaran->id,
            ]);
            
        }

        // Redirect atau lakukan tindakan lain setelah penyimpanan berhasil
        return redirect()->back()->with('success', 'Data presensi berhasil disimpan.');
    }

    // public function presensi(){
    //     $kodeGuru = auth()->guard('webguru')->user()->kode_guru;
    //     $pengampuGuru = Pengampu::where('kode_guru', $kodeGuru)->get();
    //     $kelas = Kelas::whereIn('kode_kelas', $pengampuGuru->pluck('kode_kelas')->unique())->paginate(6);

    //     // Mengambil mapel dari setiap pengampu yang diampu oleh guru dengan distinct
    //     $mapelGuru = Mapel::whereIn('kode_pelajaran', $pengampuGuru->pluck('kode_pelajaran')->unique())->get();

    //     $data = [

    //         'title' => 'Presensi',
    //         'presensi' => PresensiModel::where('kode_guru', $kodeGuru)
    //             ->with('kelas')
    //             ->orderBy('tanggal_presensi', 'desc')
    //             ->get()
    //             ->groupBy(['tanggal_presensi', 'kode_kelas', 'kode_pelajaran']),
    //         'mapelGuru' => $mapelGuru,
    //         'kelasGuru' => $kelas,
    //     ];


    //     return view('guru.presensi', $data);
    // }

    // public function presensi()
    // {
    //     $kodeGuru = auth()->guard('webguru')->user()->kode_guru;
    //     $pengampuGuru = Pengampu::where('kode_guru', $kodeGuru)->get();
    //     $kelas = Kelas::whereIn('kode_kelas', $pengampuGuru->pluck('kode_kelas')->unique())->paginate(6);

    //     // Mengambil mapel dari setiap pengampu yang diampu oleh guru dengan distinct
    //     $mapelGuru = Mapel::whereIn('kode_pelajaran', $pengampuGuru->pluck('kode_pelajaran')->unique())->get();

    //     // kode thajaran
    //     $presensi = PresensiModel::where('kode_guru', $kodeGuru)
    //         ->with('kelas', 'tahunAjaran')
    //         ->orderBy('tanggal_presensi', 'desc')
    //         ->get()
    //         ->groupBy(['tanggal_presensi', 'kode_kelas', 'kode_pelajaran']); 

    //     $tahun = \App\Models\PresensiModel::where('kode_guru', $kodeGuru)
    //         ->with('kelas', 'tahunAjaran')
    //         ->orderBy('tanggal_presensi', 'desc')
    //         ->get()
    //         ->groupBy(['kode_thajaran']);

    //     $data = [
    //         'title' => 'Presensi',
    //         'presensi' => $presensi,
    //         'mapelGuru' => $mapelGuru,
    //         'kelasGuru' => $kelas,
    //         'tahun' => $tahun,
    //     ];

    //     return view('guru.presensi', $data);
    // }

    // public function presensi()
    // {
    //     // Mendapatkan data presensi dengan relasi
    //     $presensi = PresensiModel::with('kelas', 'mapel', 'tahunAjaran')->where('kode_thajaran', \App\Models\TahunAjaran::where('status_aktif', 1)->first()->id);

    //     // Mengelompokkan presensi berdasarkan kelas, mata pelajaran, dan tahun ajaran
    //     $groupedPresensi = $presensi->get()->groupBy(['kelas.nama_kelas', 'mapel.nama_pelajaran', 'tahunAjaran.tahun_ajaran']);

    //     // Menghitung total masing-masing status untuk setiap kelompok presensi
    //     $statusCounts = [];
    //     foreach ($groupedPresensi as $groupKey => $group) {
    //         $statusCounts[$groupKey] = [
    //             'S' => $group->where('status', 'S')->count(),
    //             'H' => $group->where('status', 'H')->count(),
    //             'I' => $group->where('status', 'I')->count(),
    //             'A' => $group->where('status', 'A')->count(),
    //             'K' => $group->where('status', 'K')->count()
    //         ];
    //     }

    //     // Paginasi hasil pengelompokkan presensi
    //     $perPage = 6;
    //     $currentPage = request()->query('page', 1);
    //     $groupedPresensi = new LengthAwarePaginator(
    //         $groupedPresensi->forPage($currentPage, $perPage),
    //         $groupedPresensi->count(),
    //         $perPage,
    //         $currentPage,
    //         ['path' => request()->url()]
    //     );

    //     $tahunAjaranOptions = \App\Models\TahunAjaran::pluck('tahun_ajaran', 'id');

    //     return view('guru.presensi', [
    //         'groupedPresensi' => $groupedPresensi,
    //         'statusCounts' => $statusCounts,
    //         'title' => 'Presensi',
    //         'tahunAjaranOptions' => $tahunAjaranOptions
    //     ]);
    // }

    // public function presensi(Request $request)
    // {
    //     $tahunAjaranId = $request->input('tahun_ajaran');
        
    //     // Mendapatkan data presensi dengan relasi
    //     $presensi = PresensiModel::with('kelas', 'mapel', 'tahunAjaran');

    //     // Filter berdasarkan tahun ajaran jika ada
    //     if ($tahunAjaranId) {
    //         $presensi->where('kode_thajaran', $tahunAjaranId);
    //     } else {
    //         // Jika tidak ada tahun ajaran yang dipilih, ambil tahun ajaran aktif
    //         $tahunAjaranAktif = \App\Models\TahunAjaran::where('status_aktif', 1)->first();
    //         if ($tahunAjaranAktif) {
    //             $presensi->where('kode_thajaran', $tahunAjaranAktif->id);
    //         }
    //     }

    //     // Mengelompokkan presensi berdasarkan kelas, mata pelajaran, dan tahun ajaran
    //     $groupedPresensi = $presensi->get()->groupBy(['kelas.nama_kelas', 'mapel.nama_pelajaran', 'tahunAjaran.tahun_ajaran']);

    //     // Menghitung total masing-masing status untuk setiap kelompok presensi
    //     $statusCounts = [];
    //     foreach ($groupedPresensi as $groupKey => $group) {
    //         $statusCounts[$groupKey] = [
    //             'S' => $group->where('status', 'S')->count(),
    //             'H' => $group->where('status', 'H')->count(),
    //             'I' => $group->where('status', 'I')->count(),
    //             'A' => $group->where('status', 'A')->count(),
    //             'K' => $group->where('status', 'K')->count()
    //         ];
    //     }

    //     // Paginasi hasil pengelompokkan presensi
    //     $perPage = 6;
    //     $currentPage = request()->query('page', 1);
    //     $groupedPresensi = new LengthAwarePaginator(
    //         $groupedPresensi->forPage($currentPage, $perPage),
    //         $groupedPresensi->count(),
    //         $perPage,
    //         $currentPage,
    //         ['path' => request()->url()]
    //     );

    //     // Mendapatkan daftar tahun ajaran
    //     $tahunAjaranOptions = \App\Models\TahunAjaran::pluck('tahun_ajaran', 'id');

    //     return view('guru.presensi', [
    //         'groupedPresensi' => $groupedPresensi,
    //         'statusCounts' => $statusCounts,
    //         'title' => 'Presensi',
    //         'tahunAjaranOptions' => $tahunAjaranOptions
    //     ]);
    // }

    public function presensi(Request $request)
    {
        $guruId = auth()->user()->kode_guru;
        $tahunAjaranId = $request->input('tahun_ajaran');

        // Mendapatkan data presensi dengan relasi
        // $presensi = PresensiModel::with('kelas', 'mapel', 'tahunAjaran')->orderBy('created_at', 'desc');

        $presensi = PresensiModel::with('kelas', 'mapel', 'tahunAjaran')
            ->where('kode_guru', $guruId)
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan tahun ajaran jika ada
        if ($tahunAjaranId) {
            $presensi->where('kode_thajaran', $tahunAjaranId);
        } else {
            // Jika tidak ada tahun ajaran yang dipilih, ambil tahun ajaran aktif
            $tahunAjaranAktif = \App\Models\TahunAjaran::where('status_aktif', 1)->first();
            if ($tahunAjaranAktif) {
                $presensi->where('kode_thajaran', $tahunAjaranAktif->id);
            }
        }

        // Mengelompokkan presensi berdasarkan tanggal presensi, kelas, mapel, dan tahun ajaran berdasarkan tanggal presensi
        $groupedPresensi = $presensi->get()->groupBy(['tanggal_presensi', 'kelas.nama_kelas', 'mapel.nama_pelajaran', 'tahunAjaran.tahun_ajaran']);

        // Menghitung total masing-masing status untuk setiap kelompok presensi
        $statusCounts = [];
        foreach ($groupedPresensi as $groupKey => $group) {
            $statusCounts[$groupKey] = [
                'S' => $group->where('status', 'S')->count(),
                'H' => $group->where('status', 'H')->count(),
                'I' => $group->where('status', 'I')->count(),
                'A' => $group->where('status', 'A')->count(),
                'K' => $group->where('status', 'K')->count()
            ];
        }

        // Paginasi hasil pengelompokkan presensi
        $perPage = 6;
        $currentPage = request()->query('page', 1);
        $groupedPresensi = new LengthAwarePaginator(
            $groupedPresensi->forPage($currentPage, $perPage),
            $groupedPresensi->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        // Mendapatkan daftar tahun ajaran
        $tahunAjaranOptions = \App\Models\TahunAjaran::pluck('tahun_ajaran', 'id');

        return view('guru.presensi', [
            'groupedPresensi' => $groupedPresensi,
            'statusCounts' => $statusCounts,
            'title' => 'Presensi',
            'tahunAjaranOptions' => $tahunAjaranOptions
        ]);
    }



    public function editPresensi($tanggalPresensi, $kodeKelas, $kodePelajaran)
    {
        // urutkan berdasarkan nama siswa
        $presensi = PresensiModel::where('tanggal_presensi', $tanggalPresensi)
            ->where('kode_kelas', $kodeKelas)
            ->where('kode_pelajaran', $kodePelajaran)
            ->get();

        $data = [
            'title' => 'Edit Presensi',
            'presensi' => $presensi,
        ];

        return view('guru.edit_presensi', $data);
    }

    public function updatePresensi(Request $request)
    {
        $input = $request->input('presensi');

        foreach ($input as $presensiId => $status) {
            $presensi = PresensiModel::findOrFail($presensiId);
            $presensi->status = $status;

            $presensi->save();
        }

        return redirect('/guru/presensi')->with('success', 'Data presensi berhasil diperbarui');
    }

    public function generateExcel(Request $request)
    {
        $kode_guru = auth()->guard('webguru')->user()->kode_guru;
        $kode_pelajaran = $request->input('kode_pelajaran');
        $kode_kelas = $request->input('kode_kelas');

        // Ambil informasi guru, pelajaran, dan kelas
        $guru = Guru::where('kode_guru', $kode_guru)->first();
        $pelajaran = Mapel::where('kode_pelajaran', $kode_pelajaran)->first();
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->first();

        // Ambil data presensi berdasarkan kode pelajaran dan kode kelas
        $presensi = PresensiModel::where('kode_pelajaran', $kode_pelajaran)
            ->where('kode_kelas', $kode_kelas)
            ->get();

        // Menghitung tanggal presensi terawal dan terakhir
        $tanggalPresensiTerawal = $presensi->min('tanggal_presensi');
        $tanggalPresensiTerakhir = $presensi->max('tanggal_presensi');

        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menampilkan informasi guru, pelajaran, kelas, dan rentang tanggal presensi
        $sheet->setCellValue('A1', 'Nama Guru: ' . $guru->nama);
        $sheet->setCellValue('A2', 'Mata Pelajaran: ' . $pelajaran->nama_pelajaran);
        $sheet->setCellValue('A3', 'Kelas: ' . $kelas->nama_kelas);
        $sheet->setCellValue('A4', 'Tanggal Presensi: ' . $tanggalPresensiTerawal . ' - ' . $tanggalPresensiTerakhir);

        // Menyimpan data ke dalam spreadsheet
        $columnIndex = 1;
        $rowIndex = 6;

        // Header
        $sheet->setCellValue('A' . $rowIndex, 'NIS');
        $sheet->setCellValue('B' . $rowIndex, 'Nama Siswa');

        // Tanggal presensi
        $tanggalPresensi = $presensi->pluck('tanggal_presensi')->unique()->sort();

        $columnIndex = 3;
        foreach ($tanggalPresensi as $index => $tanggal) {
            $column = Coordinate::stringFromColumnIndex($columnIndex++);
            $cellCoordinate = $column . $rowIndex;
            $sheet->setCellValue($cellCoordinate, $tanggal);
        }

        // Header H, S, I, A, K
        $headerColumnIndex = count($tanggalPresensi) + 4; // Kolom setelah tanggal presensi
        $headerRow = $rowIndex ;

        $headerColumns = ['H', 'S', 'I', 'A', 'K'];
        foreach ($headerColumns as $headerIndex => $headerColumn) {
            $column = Coordinate::stringFromColumnIndex($headerColumnIndex++);
            $cellCoordinate = $column . $headerRow;
            $sheet->setCellValue($cellCoordinate, $headerColumn);
        }

        // Data presensi siswa
        $siswaIds = $presensi->pluck('kode_siswa')->unique()->toArray();
        $siswa = Siswa::whereIn('kode_siswa', $siswaIds)->get()->keyBy('kode_siswa');

        foreach ($siswa as $siswa) {
            $columnIndex = count($tanggalPresensi) + 3; // Kolom setelah tanggal presensi
            $rowIndex++;

            $sheet->setCellValue('A' . $rowIndex, $siswa->nis);
            $sheet->setCellValue('B' . $rowIndex, $siswa->nama_siswa);

            // Menghitung rekap status per siswa
            $rekapStatus = [
                'H' => 0,
                'S' => 0,
                'I' => 0,
                'A' => 0,
                'K' => 0,
            ];

            $columnIndex = 3;
            foreach ($tanggalPresensi as $tanggal) {
                $column = Coordinate::stringFromColumnIndex($columnIndex++);
                $cellCoordinate = $column . $rowIndex;
                $presensiSiswa = $presensi->where('kode_siswa', $siswa->kode_siswa)
                    ->where('tanggal_presensi', $tanggal)
                    ->first();
                $status = $presensiSiswa ? $presensiSiswa->status : '';
                $sheet->setCellValue($cellCoordinate, $status);

                // Menambahkan rekap status per siswa
                if (array_key_exists($status, $rekapStatus)) {
                    $rekapStatus[$status]++;
                }
            }

            // Menambahkan rekap status per siswa setelah tanggal presensi
            $columnIndex++;
            foreach ($rekapStatus as $status => $count) {
                $column = Coordinate::stringFromColumnIndex($columnIndex++);
                $cellCoordinate = $column . $rowIndex;
                $sheet->setCellValue($cellCoordinate, $count);
            }
        }

        // Mengatur lebar kolom agar sesuai dengan konten
        $highestColumn = $sheet->getHighestColumn();
        $columnRange = range('A', $highestColumn);

        foreach ($columnRange as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Membuat objek writer dan mengirimkan spreadsheet ke browser
        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_presensi '.$pelajaran->nama_pelajaran." ".$kelas->nama_kelas.'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit();
    }

    public function loadOptions(Request $request)
    {
        $tahunAjaranId = $request->input('tahun_ajaran');

        // Mendapatkan kelas yang diampu oleh guru berdasarkan tahun ajaran yang dipilih
        $kelasOptions = \App\Models\Pengampu::select('pengampu.kode_kelas', 'kelas.nama_kelas')
            ->join('kelas', 'pengampu.kode_kelas', '=', 'kelas.kode_kelas')
            ->where('pengampu.kode_guru', auth()->user()->kode_guru)
            ->where('pengampu.kode_thajaran', $tahunAjaranId)
            ->distinct()
            ->get();

        // Mendapatkan mapel yang diampu oleh guru berdasarkan tahun ajaran yang dipilih
        $mapelOptions = \App\Models\Pengampu::select('pelajaran.kode_pelajaran', 'pelajaran.nama_pelajaran')
            ->join('pelajaran', 'pengampu.kode_pelajaran', '=', 'pelajaran.kode_pelajaran')
            ->where('pengampu.kode_guru', auth()->user()->kode_guru)
            ->where('pengampu.kode_thajaran', $tahunAjaranId)
            ->distinct()
            ->get();

        return response()->json([
            'kelasOptions' => $kelasOptions,
            'mapelOptions' => $mapelOptions
        ]);
    }




}
