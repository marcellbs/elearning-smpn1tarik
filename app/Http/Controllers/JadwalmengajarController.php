<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalmengajarController extends Controller
{
    public function index(){
        $guru = Auth::user(); // Mengambil guru yang sedang login
        $pengampu = Pengampu::where('kode_guru', $guru->kode_guru)->get(); // Mengambil pengampu berdasarkan kode guru yang login
        $pengampu = $pengampu->sortBy('jam_mulai'); // Mengurutkan pengampu berdasarkan jam_mulai
        $jadwalMengajar = $pengampu->groupBy('hari'); // Mengelompokkan pengampu berdasarkan hari
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']; // Daftar semua hari dalam seminggu
        
        
        $data = [
            'title' => 'Jadwal Mengajar',
            'jadwalMengajar' => $jadwalMengajar,
            'hariList' => $hariList,
        ];
        return view('guru.jadwal-mengajar', $data);
    }
}
