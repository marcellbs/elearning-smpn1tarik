<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Admin extends Model implements Authenticatable
{   
    use \Illuminate\Auth\Authenticatable;
    use HasFactory;

    protected $table = 'admin';
    protected $primaryKey = 'kode_admin';
    protected $fillable = [
        'nama',
        'email',
        'foto',
        'email',
        'password',
    ];
    public $timestamps = false;

    
    
}
