<?php

namespace App\Http\Controllers;

use App\Models\Pengampu;
use Illuminate\Http\Request;
use Hashids\Hashids;

class GuruController extends Controller
{
    public function index()
    {
        $hash = new Hashids('my-hash', 10);
        $data = [
            'guru' => \App\Models\Guru::all(),
            'pengampu' => \App\Models\Pengampu::where('kode_guru', \Illuminate\Support\Facades\Auth::guard('webguru')->user()->kode_guru)->get(),
            'title' => 'Dashboard',
            'hash' => $hash,
        ];
        
        return view('guru.index', $data);
    }

    public function login()
    {
        return view('guru.login');
    }

    public function auth(Request $request){

        $request->validate([
            'username' => 'required|exists:guru,username',
            'password' => 'required',

        ],[
            'username.required' => 'Kolom username harus diisi',
            'username.exists' => 'Username tidak terdaftar',
            'password.required' => 'Kolom password harus diisi',
        ]);

        if(\Illuminate\Support\Facades\Auth::guard('webguru')->attempt([
            'username' => $request->username, 
            'password' => $request->password
        ])){
            return redirect('/guru');
        
        }else{
            return redirect('/guru/login')->with('gagal', 'Email atau password salah');
        }

    }



    public function register(){
        return view('guru.register');
    }

    public function save(Request $request){
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'password' => 'required',
        ],[
            'nama.required' => 'Kolom nama harus diisi',
            'nip.required' => 'Kolom NIP harus diisi',
            'password.required' => 'Kolom password harus diisi',
        ]);

        // username diisi dengan nama depan guru dan apabila ada spasi jangan diisi, huruf kecil semua
        $username = strtolower(explode(' ', $request->nama)[0]);

        \App\Models\Guru::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'username' => $username,
            'password' => bcrypt($request->password),
            'foto' => null,
            'email' => null,
            'jenis_kelamin' => null,
            'alamat' => null,
            'telepon' => null,
        ]);
    }

    public function logout(Request $request){
        \Illuminate\Support\Facades\Auth::guard('webguru')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/guru/login');
    }

    public function detail($id){
        $hash = new Hashids('my-hash',10);
        $pengampu = Pengampu::find($hash->decode($id)[0]);

        $kelas_siswa = \App\Models\KelasSiswa::where('kode_kelas', $pengampu->kode_kelas)->get();
        $materi = \App\Models\Materi::where('kode_guru', $pengampu->kode_guru)->where('kode_pelajaran', $pengampu->kode_pelajaran)->get();

        $data = [
            'title' => ''.$pengampu->mapel->nama_pelajaran.' '.$pengampu->kelas->tingkat->nama_tingkat.''.$pengampu->kelas->nama_kelas.'',
            'hash' => $hash,
            'pengampu' => $pengampu,
            'materi' => $materi,
            // menampilkan siswa dari tabel siswa yang memiliki id yang sama di tabel kelassiswa dan kode kelas yang sama di tabel pengampu urutkan berdasarkan nis
            'siswa' => \App\Models\Siswa::whereIn('kode_siswa', $kelas_siswa->pluck('kode_siswa'))->orderBy('nis', 'asc')->get(),


        ];

        return view('guru.detailkelas', $data);
    }

    // method untuk menambahkan link video conferece
    public function updateLink(Request $request, $id){
        $hash = new Hashids('my-hash',10);
        $pengampu = Pengampu::find($hash->decode($id)[0]);
        $pengampu->link = $request->link;
        $pengampu->save();

        return redirect('/guru/detail/'.$hash->encode($pengampu->id));
    }
}
