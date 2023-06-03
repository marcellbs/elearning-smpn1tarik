<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Admin;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\KelasSiswa;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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

    // =======================================================
    // ===================== CRUD PENGUMUMAN =================
    // =======================================================

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

    public function updatePengumuman(Request $request, $id){

        $request->validate(
            [
                'judul' => 'required|min:3',
                'deskripsi' => 'required|min:3',
            ],
            [
                'judul.required' => 'Judul tidak boleh kosong',
                'judul.min' => 'Judul minimal 3 karakter',
                'deskripsi.required' => 'Deskripsi tidak boleh kosong',
                'deskripsi.min' => 'Deskripsi minimal 3 karakter',
            ]
            );

        Pengumuman::find($id)->update([
            'judul_pengumuman' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/admin/pengumuman')->with('sukses', 'Pengumuman berhasil diubah');

    }

    public function detailPengumuman($id){
        $data = [
            'pengumuman' => Pengumuman::find($id),
            'title' => 'Detail Pengumuman',
        ];
        return view('admin.detail-pengumuman', $data);
    }

    
    // =======================================================
    // ===================== SISWA ===========================
    // =======================================================

    public function siswa(){
        $data = [
            // menampilkan data siswa dan kelasnya
            'siswa' => Siswa::leftJoin('kelas_siswa', 'siswa.kode_siswa', '=', 'kelas_siswa.kode_siswa')
            ->leftJoin('kelas', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
            ->leftJoin('tingkat_kelas', 'kelas.kode_tingkat', '=', 'tingkat_kelas.kode_tingkat')
            ->select('siswa.*', 'kelas.nama_kelas', 'tingkat_kelas.nama_tingkat')
            ->orderBy('kelas.kode_kelas', 'asc')
            ->get(),
            'title' => 'Data Siswa',
        ];
        return view('admin.siswa', $data);
    }


    public function uploadsiswa(Request $request){
    // Validasi file yang diunggah
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ],[
        'file.required' => 'File tidak boleh kosong',
        'file.mimes' => 'File harus berupa file Excel'
    ]);

    // Ambil file yang diunggah
    $file = $request->file('file');

    // Baca file Excel menggunakan PhpSpreadsheet
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

    // Dapatkan daftar semua sheet dalam file
    $sheets = $spreadsheet->getAllSheets();

    // Loop untuk setiap sheet
    foreach ($sheets as $sheet) {
        $data = $sheet->toArray(null, true, true, true);

        // Hapus baris header
        unset($data[1]);

        // Loop untuk setiap baris data
        foreach ($data as $row) {
            $nis = $row['A'];
            $namaSiswa = $row['B'];
            $username = $row['C'];
            $password = $row['D'];

            // Simpan data siswa
            $siswa = Siswa::create([
                'nis' => $nis,
                'nama_siswa' => $namaSiswa,
                'username' => $username,
                'password' => bcrypt($password)
            ]);

            $kodeKelas = $row['E'];

            // Simpan data ke dalam tabel kelas_siswa
            KelasSiswa::create([
                'kode_siswa' => $siswa->kode_siswa,
                'kode_kelas' => $kodeKelas
            ]);
        }
    }

    // Redirect ke halaman upload dengan pesan sukses
    return redirect()->back()->with('success', '<strong>Berhasil!</strong> Data berhasil diunggah.');

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

    // =======================================================
    // ===================== PROFILE ======================
    // =======================================================

    public function updateProfile(Request $request, $id){
        $request->validate([
            'nama' => 'required|min:3',
            'email' => 'required|email:dns',
        ],[
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.min' => 'Nama minimal 3 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
        ]);
        
        Admin::find($id)->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        return redirect('/admin/profile')->with('sukses', 'Profil berhasil diubah');
    }

    // =======================================================
    // ===================== REGISTER ========================
    // =======================================================
    
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

    public function changePassword(Request $request, $id){
        $request->validate([
            'password' => 'required',
            'passwordbaru' => 'required|min:8|max:100',
            'ulangpassword' => 'required|same:passwordbaruJ',
        ],[
            'password.required' => 'Password saat ini tidak boleh kosong',
            'passwordbaru.required' => 'Password baru tidak boleh kosong',
            'passwordbaru.min' => 'Password minimal 8 karakter',
            'passwordbaru.max' => 'Password maksimal 100 karakter',
            'ulangpassword.required' => 'Konfirmasi password tidak boleh kosong',
            'ulangpassword.same' => 'Password tidak sama',
        ]);

        $admin = Admin::find($id);

        if(\Illuminate\Support\Facades\Hash::check($request->password, $admin->password)){
            $admin->update([
                'password' => bcrypt($request->passwordbaru),
            ]);
            return redirect('/admin/profile')->with('sukses', 'Password berhasil diubah');
        }else{
            return redirect('/admin/profile')->with('gagal', 'Password saat ini salah');
        }
    }
    
}
