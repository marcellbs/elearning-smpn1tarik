<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tahun_ajaran',
        'status_aktif'
    ];
    public $timestamps = false;

    public function kelasSiswa(){
        return $this->hasMany(KelasSiswa::class, 'kode_thajaran', 'id');
    }

    public function kelas()
    {
        return $this->hasManyThrough(
            Kelas::class,
            Pengampu::class,
            'kode_thajaran', // Foreign key pada tabel Pengampu
            'kode_kelas', // Foreign key pada tabel Kelas
            'id', // Primary key pada tabel TahunAjaran
            'kode_kelas' // Primary key pada tabel Kelas
        );
    }

    public function pengampu()
    {
        return $this->hasMany(Pengampu::class, 'kode_thajaran', 'id');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'kode_thajaran', 'id');
    }

}
