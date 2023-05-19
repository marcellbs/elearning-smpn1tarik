<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Admin;
use App\Models\Pengumuman;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Tingkat;
use App\Models\Mapel;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function test(){
        $admin = Admin::all();
        return response()->json($admin, 200);
    }
    public function index(){
        $data = [
            // jumlah total guru
            'active' => 'dashboard',
            'total_guru' => Guru::count(),
            'total_siswa' => Siswa::count(),
            'total_admin' => Admin::count(),
            'pengumuman' => Pengumuman::orderBy('tgl_upload', 'desc')->limit(3)->get(),
            'title' => 'Admin Dashboard',
        ];
        return view('admin.index', $data);
    }

    public function materi(){
        $data = [
            'materi' => \App\Models\Materi::all(),
            'title' => 'Material',
        ];
        return view('admin.materi', $data);
    }

    public function pengumuman(){
        $data = [
            // pengumuman berdasarkan id admin
            'pengumuman' => Pengumuman::where('kode_admin', Auth::guard('webadmin')->user()->kode_admin)->orderBy('tgl_upload', 'desc')->get(),
            'title' => 'Pengumuman',
        ];
        return view('admin.pengumuman', $data);
    }

    public function createPengumuman(Request $request){
        $request->validate(
            [
                'judul_pengumuman' => 'required|min:3',
                'deskripsi' => 'required|min:3',
            ],
            [
                'judul.required' => 'Judul tidak boleh kosong',
                'judul.min' => 'Judul minimal 3 karakter',
                'deskripsi.required' => 'Deskripsi tidak boleh kosong',
                'deskripsi.min' => 'Deskripsi minimal 3 karakter',
            ]
            );

        Pengumuman::create([
            'judul_pengumuman' => $request->judul_pengumuman,
            'deskripsi' => $request->deskripsi,
            'tgl_upload' => date('Y-m-d H:i:s'),
            'kode_admin' => Auth::guard('webadmin')->user()->kode_admin,
            'kode_guru' => null,
        ]);

        return redirect('/admin/pengumuman')->with('sukses', 'Pengumuman berhasil ditambahkan');
        
    }

    public function destroyPengumuman($id){
        Pengumuman::destroy($id);
        return redirect('/admin/pengumuman')->with('sukses', 'Pengumuman berhasil dihapus');
    }

    public function editPengumuman($id){
        $data = [
            'pengumuman' => Pengumuman::find($id),
            'title' => 'Edit Pengumuman',
        ];
        return view('admin.edit-pengumuman', $data);
    }

    public function siswa(){
        $data = [
            // data siswa dan kelas siswa
            'siswa' => Siswa::all(),
            'kelas_siswa' => KelasSiswa::all(),
            

            'title' => 'Data Siswa',
        ];
        return view('admin.siswa', $data);
    }

    public function guru(){
        $data = [
            'guru' => Guru::all(),
            'title' => 'Data Guru',
        ];
        return view('admin.guru', $data);
    }

    public function admin(){
        $data = [
            'admin' => Admin::all(),
            'title' => 'Data Admin',
        ];
        return view('admin.admin', $data);
    }

    public function mapel(){
        $data = [
            'mapel' => Mapel::all(),
            'title' => 'Data Mata Pelajaran',
        ];
        return view('admin.mapel', $data);
    }

    public function profile(){
        $data = [
            'title' => 'Profil Pengguna',
        ];
        return view('admin.profile', $data);
    }
    
    public function register(){
        $data =[
            'title' => 'Register',
        ];
        return view('admin.register', $data);
    }

    public function addRegister(Request $request){
        // membuat gambar random 
        $namaFile = 'avatar-'.rand(1, 20).'.png';    

        $request->validate([
            'nama' => 'required|min:3',
            'email' => 'required|email:dns|unique:admin',
            'password' => 'required|min:8|max:100',
            'password2' => 'required|same:password',
        ],[
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.min' => 'Nama minimal 3 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Password maksimal 100 karakter',
            'password2.required' => 'Konfirmasi password tidak boleh kosong',
            'password2.same' => 'Password tidak sama',
        ]);

        // encrypt password
        Admin::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'foto' => $namaFile,
        ]);

        // $request->session()->flash('sukses', 'Akun berhasil dibuat, silahkan login');
        // return redirect('/admin/login');

        return redirect('/admin/login')->with('sukses', '<strong>Akun berhasil dibuat !</strong>, silahkan login');

    }

    public function login(){
        return view('admin.login');
    }

    public function store(Request $request){

        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        if(Auth::guard('webadmin')->attempt($credentials)){
            $request->session()->regenerate();
            return redirect('/admin');
        }

        return back()->with('loginError', 'Login gagal, email atau password salah');
    }

    public function logout(Request $request){
        Auth::guard('webadmin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    
}
