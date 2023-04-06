<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'pelajaran';
    protected $primaryKey = 'kode_pelajaran';
    public $timestamps = false;
    protected $guarded = ['kode_pelajaran'];

    public function pengampu(){
        return $this->hasMany(Pengampu::class, 'kode_pelajaran', 'kode_pelajaran');
    }


    


}
