<?php

namespace App\Exports;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\PresensiModel;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\FromCollection;


class PresensiExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $kodeKelas;
    protected $kodePelajaran;
    protected $kodeGuru;
    protected $tanggalPresensi;
    protected $namaKelas;
    protected $namaPelajaran;

    public function __construct($kodeKelas, $kodePelajaran, $tanggalPresensi, $kodeGuru, $namaKelas, $namaPelajaran)
    {
        $this->kodeKelas = $kodeKelas;
        $this->kodePelajaran = $kodePelajaran;
        $this->tanggalPresensi = $tanggalPresensi;
        $this->kodeGuru = $kodeGuru;
        $this->namaKelas = $namaKelas;
        $this->namaPelajaran = $namaPelajaran;
    }

    public function collection()
    {
        $siswaData = Siswa::whereHas('kelas', function ($query) {
            $query->where('kelas_siswa.kode_kelas', $this->kodeKelas);
        })->get();

        $data = [];

        foreach ($siswaData as $siswa) {
            $row = [
                'NIS' => $siswa->nis,
                'Nama Siswa' => $siswa->nama_siswa,
            ];

            $presensi = PresensiModel::where('kode_kelas', $this->kodeKelas)
                ->where('kode_pelajaran', $this->kodePelajaran)
                ->where('tanggal_presensi', $this->tanggalPresensi)
                ->where('kode_siswa', $siswa->kode_siswa)
                ->first();

            $statusPresensi = $presensi ? $presensi->status : '';
            $row['Status Presensi'] = $statusPresensi;

            $data[] = $row;
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Status Presensi',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $guru = Guru::where('kode_guru', $this->kodeGuru)->first();
                $kelas = Kelas::where('kode_kelas', $this->kodeKelas)->first();
                $mapel = Mapel::where('kode_pelajaran', $this->kodePelajaran)->first();

                $event->sheet->setCellValue('D1', 'Nama Guru: ' . $guru->nama);
                $event->sheet->setCellValue('D2', 'Kelas: ' . $kelas->tingkat->nama_tingkat.$kelas->nama_kelas);
                $event->sheet->setCellValue('D3', 'Mata Pelajaran: ' . $mapel->nama_pelajaran);
                $event->sheet->setCellValue('D4', 'Tanggal Presensi: ' . date('l, d-m-Y', strtotime($this->tanggalPresensi)));

                $event->sheet->getStyle('D1:D4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }


    
}
