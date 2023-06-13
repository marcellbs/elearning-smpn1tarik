<?php

namespace App\Exports;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\PresensiModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PresensiExport implements FromView, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $guru = Guru::first(); // Contoh: Mengambil data guru pertama
        $mapel = Mapel::first(); // Contoh: Mengambil data mata pelajaran pertama
        $kelas = Kelas::first(); // Contoh: Mengambil data kelas pertama
        $presensiData = PresensiModel::whereBetween('tanggal_presensi', [$this->startDate, $this->endDate])->get();

        return view('presensi.export', [
            'guru' => $guru,
            'mapel' => $mapel,
            'kelas' => $kelas,
            'presensiData' => $presensiData,
        ]);
    }

    public function registerEvents(): array
{
    $guru = Guru::first(); // Mengambil data guru pertama
    $mapel = Mapel::first(); // Mengambil data mata pelajaran pertama
    $kelas = Kelas::first(); // Mengambil data kelas pertama
    
    return [
        AfterSheet::class => function (AfterSheet $event) use ($guru, $mapel, $kelas) {
            $event->sheet->setCellValue('A1', 'Nama Guru: ' . $guru->nama);
            $event->sheet->setCellValue('A2', 'Mata Pelajaran: ' . $mapel->nama_pelajaran);
            $event->sheet->setCellValue('A3', 'Presensi: ' . $this->startDate . ' - ' . $this->endDate);
        },
    ];
}



}
