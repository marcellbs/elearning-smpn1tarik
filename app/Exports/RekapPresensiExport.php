<?php

namespace App\Exports;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\PresensiModel;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class RekapPresensiExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $kodeGuru;
    protected $kodePelajaran;
    protected $tanggalMulai;
    protected $tanggalAkhir;
    protected $kodeKelas;

    public function __construct($kodeGuru, $kodePelajaran, $tanggalMulai, $tanggalAkhir, $kodeKelas)
    {
        $this->kodeGuru = $kodeGuru;
        $this->kodePelajaran = $kodePelajaran;
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalAkhir = $tanggalAkhir;
        $this->kodeKelas = $kodeKelas;
    }

    public function view(): View
    {
        $tanggalMulai = Carbon::createFromFormat('Y-m-d', $this->tanggalMulai);
        $tanggalAkhir = Carbon::createFromFormat('Y-m-d', $this->tanggalAkhir);

        $presensiData = PresensiModel::where('kode_guru', $this->kodeGuru)
            ->where('kode_pelajaran', $this->kodePelajaran)
            ->whereBetween('tanggal_presensi', [$tanggalMulai, $tanggalAkhir])
            ->get();

        $siswaIds = $presensiData->pluck('kode_siswa')->unique();
        $siswaData = Siswa::whereIn('kode_siswa', $siswaIds)->get();

        $dates = [];
        $currentDate = $tanggalMulai->copy();
        while ($currentDate <= $tanggalAkhir) {
            $dates[] = $currentDate->format('d/m/Y');
            $currentDate->addWeek();
        }

        $data = [
            'siswaData' => $siswaData,
            'presensiData' => $presensiData,
            'dates' => $dates,
            'title' => 'Rekap Presensi',
        ];

        return view('presensi.rekap_presensi', $data);
    }
}
