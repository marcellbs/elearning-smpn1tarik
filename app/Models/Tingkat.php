<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tingkat extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'tingkat_kelas';
    protected $primaryKey = 'kode_tingkat';


    protected $guarded = [
        'kode_tingkat',
        'nama_tingkat',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kode_tingkat', 'kode_tingkat');
    }

    public function siswa(){
        return $this->belongsTo(Siswa::class, 'kode_tingkat', 'kode_tingkat');
    } 

    public function pengampu(){
        return $this->belongsTo(Pengampu::class, 'kode_tingkat', 'kode_tingkat');
    }

    

}
