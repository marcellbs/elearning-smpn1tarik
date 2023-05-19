<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Guru extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;

    use HasFactory;

    protected $table = 'guru';
    protected $primaryKey = 'kode_guru';
    protected $fillable = [ 
        'nip',
        'username',
        'nama',
        'jenis_kelamin',
        'alamat',
        'alamat',
        'telepon',
        'agama',
        'foto',
        'email', 
        'password'
    ];

    public $timestamps = false;

    public function pengampu(){
        return $this->hasMany(Pengampu::class, 'kode_guru', 'kode_guru');
    }

    public function materi(){
        return $this->hasMany(Materi::class, 'kode_guru', 'kode_guru');
    }

    public function jawaban(){
        return $this->hasMany(JawabanTugas::class, 'kode_guru', 'kode_guru');
    }


    
}
