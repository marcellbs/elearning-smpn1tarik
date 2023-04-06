<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';
    protected $guarded = ['kode_materi'];
    protected $primaryKey = 'kode_materi';
    public $timestamps = false;


    public function mapel(){
        return $this->belongsTo(Mapel::class, 'kode_pelajaran');
    }

    public function tingkat(){
        return $this->belongsTo(Tingkat::class, 'kode_tingkat');
    }

    public function guru(){
        return $this->belongsTo(Guru::class, 'kode_guru');
    }

    public function admin(){
        return $this->belongsTo(Admin::class, 'kode_admin');
    }



}
