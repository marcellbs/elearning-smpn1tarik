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
    protected $fillable = [
        'judul_tugas',
        'keterangan',
        'berkas',
        'kode_guru',
        'kode_kelas',
        'kode_pelajaran',
        'created_at',
        'deadline'
    ];

    public function guru() {
        return $this->belongsTo(Guru::class, 'kode_guru');
    }

    public function mapel(){
        return $this->belongsTo(Mapel::class, 'kode_pelajaran');
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class, 'kode_kelas', 'kode_kelas');
    }

    public function getJumlahSiswaMengumpulkanAttribute()
    {
        return $this->jawaban()->count();
    }

    public function jawaban(){
        return $this->hasMany(JawabanTugas::class, 'kode_tugas');
    }

    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class, 'kode_kelas', 'kode_kelas');
    }


}
