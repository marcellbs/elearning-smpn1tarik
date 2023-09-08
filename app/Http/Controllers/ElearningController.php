<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ElearningController extends Controller
{
    public function index(){
        return view('landing.index');
    }

    public function percobaan($id){
        $data = [
            'title' => 'Percobaan',
            // mengambil id dari tabel pengampu
            'pengampu' => \App\Models\Pengampu::find($id),
        ];
        
        return view('layout.ruangkelas', $data);
    }
}
