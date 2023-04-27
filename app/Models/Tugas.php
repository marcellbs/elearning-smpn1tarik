<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'tugas';
    protected $primaryKey = 'kode_tugas';
    protected $guarded = ['kode_tugas'];


    public function guru() {
        return $this->belongsTo(Guru::class, 'kode_guru');
    }

    public function mapel(){
        return $this->belongsTo(Mapel::class, 'kode_pelajaran');
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kode_kelas');
    }


}
