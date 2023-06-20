<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tahun_ajaran',
        'status'
    ];
    public $timestamps = false;

    public function kelasSiswa(){
        return $this->hasMany(KelasSiswa::class, 'kode_thajaran', 'id');
    }
}
