<?php

namespace App\Http\Controllers;

use App\Models\KelasSiswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Dashboard',
            'siswa' => \App\Models\Siswa::all(),
            'kelas_siswa' => KelasSiswa::where('kode_siswa', \Illuminate\Support\Facades\Auth::guard('websiswa')->user()->kode_siswa)->first(),
            // menampilkan pengampu pelajaran berdasar kelas siswa yang login
            'pengampu' => \App\Models\Pengampu::where('kode_kelas', KelasSiswa::where('kode_siswa', \Illuminate\Support\Facades\Auth::guard('websiswa')->user()->kode_siswa)->first()->kode_kelas)->get(),

            
        ];
        return view('siswa.index', $data);
    }

    public function login(){
        $data = [
            'title' => 'Login Siswa',
        ];

        return view('siswa.login', $data);
    }

    public function auth(Request $request){
        $credentials = $request->validate([
            'username' => 'required|exists:siswa,username',
            'password' => 'required',
        ],[
            'username.required' => 'Kolom username harus diisi',
            'username.exists' => 'Username tidak terdaftar',
            'password.required' => 'Kolom password harus diisi',
        ]);

        if(\Illuminate\Support\Facades\Auth::guard('websiswa')->attempt($credentials)){
            
            $request->session()->regenerate();
            

            return redirect('/siswa');
        }
        
        return back()->with('gagal', 'Username atau password salah');
    }

    public function register(){
        $data = [
            'title' => 'Register Siswa',
            'kelas' => \App\Models\Kelas::all(),
            'tingkat' => \App\Models\Tingkat::all(),
        ];

        return view('siswa.register', $data);
    }

    public function save(Request $request){
        $request->validate([
            'nis' => 'required|unique:siswa,nis|numeric',
            'nama' => 'required',
            'password' => 'required',
            'passwordc' => 'required|same:password',
        ],[
            'nis.numeric' => 'Kolom nis harus berupa angka',
            'nis.required' => 'Kolom nis harus diisi',
            'nis.unique' => 'NIS sudah terdaftar',
            'nama.required' => 'Kolom nama harus diisi',
            'password.required' => 'Kolom password harus diisi',
            'passwordc.required' => 'Kolom konfirmasi password harus diisi',
            'passwordc.same' => 'Konfirmasi password tidak cocok',
        ]);
        
        // memilih foto random avatar-1.png sampai avatar-10.png
        $foto = 'avatar-'.rand(1, 10).'.png';
        $username = explode(' ', $request->nama)[0].'-'.$request->nis;


        \App\Models\Siswa::create([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama,
            'username' => $username,
            'jenis_kelamin' => null,
            'alamat' => null,
            'telepon' => null,
            'agama' => null,
            'foto' => $foto,
            'password' => bcrypt($request->password),
        ]);

        // KelasSiswa
        $siswa = \App\Models\Siswa::where('nis', $request->nis)->first();

        KelasSiswa::create([
            'kode_siswa' => $siswa->kode_siswa,
            'kode_kelas' => $request->kelas,
        ]);
        

        return redirect('/siswa/login')->with('sukses', 'Akun berhasil dibuat');
    }

    public function logout(Request $request){
        \Illuminate\Support\Facades\Auth::guard('websiswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/siswa/login');
    }
    // method detail kelas
    public function detail($id){
        // $hash = new Hashids('my-hash',10);
        $pengampu = \App\Models\Pengampu::find($id);
        $kelas_siswa = KelasSiswa::where('kode_kelas', $pengampu->kode_kelas)->get();
        $materi = \App\Models\Materi::where('kode_guru', $pengampu->kode_guru)->where('kode_pelajaran', $pengampu->kode_pelajaran)->get();

        $data = [
            'kelas_siswa' => KelasSiswa::where('kode_siswa', \Illuminate\Support\Facades\Auth::guard('websiswa')->user()->kode_siswa)->first(),
            'title' => ''.$pengampu->mapel->nama_pelajaran.' '.$pengampu->kelas->tingkat->nama_tingkat.''.$pengampu->kelas->nama_kelas.'',
            'pengampu' => $pengampu,
            'materi' => $materi,
            'siswa' => \App\Models\Siswa::whereIn('kode_siswa', $kelas_siswa->pluck('kode_siswa'))->orderBy('nis', 'asc')->get(),
        ];

        return view('siswa.detailkelas', $data);
    }



}
