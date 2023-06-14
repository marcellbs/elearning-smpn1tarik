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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;




class PresensiController extends Controller
{


    public function index($id){
        $hash = new Hashids('my-hash',10);
        $pengampu = Pengampu::find($hash->decode($id)[0]);
        // menemukan pengampu dari detailkelas yang dipilih di halaman dashboard

        $kelas_siswa = \App\Models\KelasSiswa::where('kode_kelas', $pengampu->kode_kelas)->get();

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

            // Cek apakah presensi sudah dilakukan pada tanggal tersebut berdasarkan kode pelajaran
            $existingPresensi = PresensiModel::where('kode_siswa', $siswaId)
                ->where('tanggal_presensi', $date)
                ->where('kode_pelajaran', $request->kode_pelajaran)
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
            ]);
            
        }

        // Redirect atau lakukan tindakan lain setelah penyimpanan berhasil
        return redirect()->back()->with('success', 'Data presensi berhasil disimpan.');
    }

    public function presensi(){
        $kodeGuru = auth()->guard('webguru')->user()->kode_guru;
        $pengampuGuru = Pengampu::where('kode_guru', $kodeGuru)->get();
        $kelas = Kelas::whereIn('kode_kelas', $pengampuGuru->pluck('kode_kelas')->unique())->get();

        // Mengambil mapel dari setiap pengampu yang diampu oleh guru dengan distinct
        $mapelGuru = Mapel::whereIn('kode_pelajaran', $pengampuGuru->pluck('kode_pelajaran')->unique())->get();

        $data = [

            'title' => 'Presensi',
            'presensi' => PresensiModel::where('kode_guru', $kodeGuru)
                ->with('kelas')
                ->orderBy('tanggal_presensi', 'desc')
                ->get()
                ->groupBy(['tanggal_presensi', 'kode_kelas', 'kode_pelajaran']),
            'mapelGuru' => $mapelGuru,
            'kelasGuru' => $kelas,
        ];


        return view('guru.presensi', $data);
    }

    public function editPresensi($tanggalPresensi, $kodeKelas, $kodePelajaran)
    {
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

// public function export($kelas, $mapel, $tanggal)
// {
//     $kelasData = Kelas::where('kode_kelas', $kelas)->firstOrFail();
//     $mapelData = Mapel::where('kode_pelajaran', $mapel)->firstOrFail();

//     $presensi = PresensiModel::where('kode_kelas', $kelas)
//         ->where('kode_pelajaran', $mapel)
//         ->where('tanggal_presensi', $tanggal)
//         ->firstOrFail();

//     $guru = Guru::where('kode_guru', $presensi->kode_guru)->firstOrFail();
//     $export = new PresensiExport($kelas, $mapel, $tanggal, $guru->kode_guru, $kelasData->nama_kelas, $mapelData->nama_pelajaran);


//     return Excel::download($export, 'presensi_'.$kelasData->tingkat->nama_tingkat.$kelasData->nama_kelas.'_'.$mapelData->nama_pelajaran.'_'.$tanggal.'.xlsx');
// }

    // public function generateExcel(Request $request)
    // {
    //     $kodeGuru = auth()->guard('webguru')->user()->kode_guru;
    //     $kodePelajaran = $request->input('kode_pelajaran');
    //     $tanggalMulai = $request->input('tanggal_mulai');
    //     $tanggalAkhir = $request->input('tanggal_akhir');
    //     $kodeKelas = $request->input('kode_kelas');

    //     $export = new RekapPresensiExport($kodeGuru, $kodePelajaran, $tanggalMulai, $tanggalAkhir, $kodeKelas);

    //     return Excel::download($export, 'Rekap_Presensi.xlsx');
    // }

//     public function generateExcel(Request $request)
//     {
//         $kode_guru = auth()->guard('webguru')->user()->kode_guru;
//         $tanggal_mulai = $request->input('tanggal_mulai');
//         $tanggal_akhir = $request->input('tanggal_akhir');
//         $kode_pelajaran = $request->input('kode_pelajaran');
//         $kode_kelas = $request->input('kode_kelas');

//         // Validasi tanggal mulai, tanggal akhir, kode pelajaran, dan kode kelas jika diperlukan

//         // Ambil informasi guru dan pelajaran
//         $guru = Guru::where('kode_guru', $kode_guru)->first();
//         $pelajaran = Mapel::where('kode_pelajaran', $kode_pelajaran)->first();
//         $kelas = Kelas::where('kode_kelas', $kode_kelas)->first();

//         // Ambil data presensi berdasarkan tanggal mulai, tanggal akhir, kode pelajaran, dan kode kelas
//         $presensi = PresensiModel::whereBetween('tanggal_presensi', [$tanggal_mulai, $tanggal_akhir])
//             ->where('kode_pelajaran', $kode_pelajaran)
//             ->where('kode_kelas', $kode_kelas)
//             ->get();

//         // Ambil ID siswa dari presensi
//         $siswaIds = $presensi->pluck('kode_siswa')->unique()->toArray();

//         // Ambil data siswa berdasarkan ID siswa
//         $siswa = Siswa::whereIn('kode_siswa', $siswaIds)->get()->keyBy('kode_siswa');
//         // dd($siswa);
//         // Membuat spreadsheet baru
//         $spreadsheet = new Spreadsheet();
//         $sheet = $spreadsheet->getActiveSheet();

//         // Menampilkan informasi guru, pelajaran, kelas, dan rentang tanggal presensi
//         $sheet->setCellValue('A1', 'Nama Guru: ' . $guru->nama);
//         $sheet->setCellValue('A2', 'Mata Pelajaran: ' . $pelajaran->nama_pelajaran);
//         $sheet->setCellValue('A3', 'Kelas: ' . $kelas->tingkat->nama_tingkat.$kelas->nama_kelas);
//         $sheet->setCellValue('A4', 'Tanggal Presensi: ' . $tanggal_mulai . ' - ' . $tanggal_akhir);

//         // Menyimpan data ke dalam spreadsheet
//         $columnIndex = 1;
//         $rowIndex = 6;

//         // Header
//         $sheet->setCellValue('A' . $rowIndex, 'NIS');
//         $sheet->setCellValue('B' . $rowIndex, 'Nama Siswa');

//         // Tanggal presensi
//         $tanggalPresensi = [];
//         $presensiData = [];

//         foreach ($presensi as $row) {
//             $tanggalPresensi[] = $row->tanggal_presensi;
//             $presensiData[$row->kode_siswa][$row->tanggal_presensi] = $row->status;
//         }

//         $tanggalPresensi = array_unique($tanggalPresensi);
//         sort($tanggalPresensi);

//         $columnIndex = 3;
//         foreach ($tanggalPresensi as $index => $tanggal) {
//             $column = Coordinate::stringFromColumnIndex($columnIndex++);

//             $cellCoordinate = $column . $rowIndex;
//             $sheet->setCellValue($cellCoordinate, $tanggal);
//         }

//         // Data presensi siswa
//         $rowIndex++;

//         foreach ($siswa as $siswaData) {
//             $columnIndex = 1;

//             $sheet->setCellValue('A' . $rowIndex, $siswaData->nis);
//             $sheet->setCellValue('B' . $rowIndex, $siswaData->nama_siswa);

//             $columnIndex = 3;
//             foreach ($tanggalPresensi as $tanggal) {
//                 $column = Coordinate::stringFromColumnIndex($columnIndex++);
//                 $cellCoordinate = $column . $rowIndex;
//                 $sheet->setCellValue($cellCoordinate, $presensiData[$siswaData->kode_siswa][$tanggal] ?? '');
//             }

//             $rowIndex++;
//         }

//         // Mengatur lebar kolom agar sesuai dengan konten
//         $sheet->getColumnDimension('A')->setAutoSize(true);
//         $sheet->getColumnDimension('B')->setAutoSize(true);

//         foreach (range('C', $sheet->getHighestColumn()) as $column) {
//             $sheet->getColumnDimension($column)->setWidth(12);
//         }

//         // Membuat objek writer dan mengirimkan spreadsheet ke browser
//         $writer = new Xlsx($spreadsheet);
//         $filename = 'rekap_presensi.xlsx';

//         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//         header('Content-Disposition: attachment; filename="' . $filename . '"');
//         $writer->save('php://output');
//         exit();
//     }


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
    $sheet->setCellValue('A3', 'Kelas: ' . $kelas->tingkat->nama_tingkat.$kelas->nama_kelas);
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
    $filename = 'rekap_presensi.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $writer->save('php://output');
    exit();
}



}
