<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTugas extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'jawaban_tugas';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    // relasi ke tugas
    public function tugas(){
        return $this->belongsTo(Tugas::class, 'kode_tugas');
    }

    // relasi ke siswa
    public function siswa(){
        return $this->belongsTo(Siswa::class, 'kode_siswa');
    }

    // relasi ke guru
    public function guru(){
        return $this->belongsTo(Guru::class, 'kode_guru');
    }
}
