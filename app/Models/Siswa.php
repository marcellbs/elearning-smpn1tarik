<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'kode_siswa';
    protected $fillable =[
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'alamat',
        'telepon',
        'agama',
        'foto',
        'email',
        'pass'
    ];
    // tidak menggunakan created_at dan updated_at
    public $timestamps = false;

    // menampilkan tingkat kelas siswa dan nama kelas siswa
    public function kelasSiswa(){
        $query = KelasSiswa::where('kode_siswa', $this->kode_siswa)->first();
        $kelas = Kelas::where('kode_kelas', $query->kode_kelas)->first();
        $tingkat = Tingkat::where('kode_tingkat', $kelas->kode_tingkat)->first();
        return $tingkat->nama_tingkat . ' ' . $kelas->nama_kelas;
    }

    public function kelas(){
        return $this->hasManyThrough(Kelas::class, KelasSiswa::class, 'kode_siswa', 'kode_kelas', 'kode_siswa', 'kode_kelas');
    }

    public function tingkat(){
        return $this->hasManyThrough(Tingkat::class, Kelas::class, 'kode_tingkat', 'kode_kelas', 'kode_tingkat', 'kode_kelas');
    }





}
