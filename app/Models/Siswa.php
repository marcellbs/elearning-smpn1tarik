<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'kode_siswa';
    protected $fillable =[
        'nis',
        'nama_siswa',
        'username',
        'jenis_kelamin',
        'alamat',
        'telepon',
        'agama',
        'foto',
        'email',
        'password'
    ];
    // tidak menggunakan created_at dan updated_at
    public $timestamps = false;

    // menampilkan tingkat kelas siswa dan nama kelas siswa
    public function kelas_Siswa(){
        //

    }

    public function tingkat(){
        return $this->hasManyThrough(Tingkat::class, Kelas::class, 'kode_tingkat', 'kode_kelas', 'kode_tingkat', 'kode_kelas');
    }

    public function kelasSiswa(){
        return $this->hasMany(KelasSiswa::class, 'kode_siswa', 'kode_siswa');
    }

    public function jawaban(){
        return $this->hasMany(JawabanTugas::class, 'kode_siswa', 'kode_siswa');
    }

}
