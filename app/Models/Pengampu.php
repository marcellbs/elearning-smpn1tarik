<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengampu extends Model
{
    use HasFactory;

    protected $table = 'pengampu';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function guru(){
        return $this->belongsTo(Guru::class, 'kode_guru', 'kode_guru');
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kode_kelas');
    }

    public function mapel(){
        return $this->belongsTo(Mapel::class, 'kode_pelajaran', 'kode_pelajaran');
    }

    public function tingkat(){
        return $this->belongsTo(Tingkat::class, 'kode_tingkat', 'kode_tingkat');
    }

    public function tugas(){
        return $this->hasMany(Tugas::class, 'kode_pengampu', 'kode_pengampu');
    }

    // menampilkan pelajaran yang sama dan kelas apa saja yang diampu guru
    public function scopePelajaran($query, $kode_guru){
        return $query->where('kode_guru', $kode_guru)->get();
    }

    public function tahunAjaran(){
        return $this->belongsTo(TahunAjaran::class, 'kode_thajaran', 'id');
    }

    public function jadwal(){
        return $this->hasMany(Jadwal::class, 'kode_pengampu');
    }

}
