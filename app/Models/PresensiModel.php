<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiModel extends Model
{
    use HasFactory;

    protected $table = 'presensi';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'kode_siswa', 'kode_siswa');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode_kelas');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'kode_pelajaran', 'kode_pelajaran');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'kode_guru', 'kode_guru');
    }

    public function kelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class, 'kode_kelas', 'kode_kelas');
    }

    

}
