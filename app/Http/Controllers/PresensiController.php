<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Hashids\Hashids;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Pengampu;
use Illuminate\Http\Request;
use App\Models\PresensiModel;
use App\Exports\PresensiExport;
use Maatwebsite\Excel\Facades\Excel;



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

        $data = [

            'title' => 'Presensi',
            'presensi' => PresensiModel::where('kode_guru', $kodeGuru)
                ->with('kelas')
                ->get()
                ->groupBy(['tanggal_presensi', 'kode_kelas']),
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

public function export($kelas, $mapel, $tanggal)
{
    $kelasData = Kelas::where('kode_kelas', $kelas)->firstOrFail();
    $mapelData = Mapel::where('kode_pelajaran', $mapel)->firstOrFail();

    $presensi = PresensiModel::where('kode_kelas', $kelas)
        ->where('kode_pelajaran', $mapel)
        ->where('tanggal_presensi', $tanggal)
        ->firstOrFail();

    $guru = Guru::where('kode_guru', $presensi->kode_guru)->firstOrFail();
    $export = new PresensiExport($kelas, $mapel, $tanggal, $guru->kode_guru, $kelasData->nama_kelas, $mapelData->nama_pelajaran);


    return Excel::download($export, 'presensi_'.$kelasData->tingkat->nama_tingkat.$kelasData->nama_kelas.'_'.$mapelData->nama_pelajaran.'_'.$tanggal.'.xlsx');
}





}
