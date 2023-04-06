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


    // relasi ke pengampu
    public function pengampu(){
        return $this->belongsTo(Pengampu::class, 'kode_pengampu');
    }


}
