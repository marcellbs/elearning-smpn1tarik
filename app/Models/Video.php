<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'video';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function mapel(){
        return $this->belongsTo(Mapel::class, 'kode_pelajaran');
    }

    public function guru(){
        return $this->belongsTo(Guru::class, 'kode_guru');
    }

    public function admin(){
        return $this->belongsTo(Admin::class, 'kode_admin');
    }




}
