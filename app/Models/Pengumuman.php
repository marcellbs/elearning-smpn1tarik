<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;
    protected $table = 'pengumuman';
    protected $fillable = ['judul_pengumuman', 'deskripsi', 'tanggal_upload', 'kode_admin', 'kode_guru'];
    public $timestamps = false;

    // menampilkan pengumuman terbaru

    // relasi ke admin
    public function admin(){
        return $this->belongsTo(Admin::class, 'kode_admin');
    }

    // relasi ke guru
    public function guru(){
        return $this->belongsTo(Guru::class, 'kode_guru');
    }
}


