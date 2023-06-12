<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;


    public $timestamps = false;
    protected $table = 'kelas';
    protected $primaryKey = 'kode_kelas';
    protected $fillable = ['kode_kelas', 'nama_kelas', 'kode_tingkat', 'kode_admin'];

    // relasi ke tingkat
    public function tingkat(){
        return $this->belongsTo(Tingkat::class, 'kode_tingkat', 'kode_tingkat');
    }

    // relasi ke admin
    public function admin(){
        return $this->belongsTo(Admin::class, 'kode_admin');
    }

    // relasi ke kelas siswa
    public function kelasSiswa(){
        return $this->belongsTo(KelasSiswa::class, 'kode_kelas', 'kode_kelas');
    }

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswa', 'kode_kelas', 'kode_siswa');
    }


    // relasi ke pengampu
    public function pengampu(){
        return $this->hasMany(Pengampu::class, 'kode_kelas', 'kode_kelas');
    }

    public function tugas(){
        return $this->hasMany(Tugas::class, 'kode_kelas', 'kode_kelas');
    }

}
