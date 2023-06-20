<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Admin;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\KelasSiswa;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;
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
        $jumlahData = Siswa::join('kelas_siswa', 'siswa.kode_siswa', '=', 'kelas_siswa.kode_siswa')
        ->join('kelas', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
        ->where('kelas.nama_kelas', 'LIKE', '9%')
        ->count();

        $data = [
            // menampilkan data siswa dan kelasnya
            'siswa' => Siswa::leftJoin('kelas_siswa', 'siswa.kode_siswa', '=', 'kelas_siswa.kode_siswa')
                ->leftJoin('kelas', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
                ->select('siswa.*', 'kelas.nama_kelas')
                ->orderBy('kelas.kode_kelas', 'asc')
                ->get(),

            'title' => 'Data Siswa',
            'jumlahData' => $jumlahData,

        ];
        return view('admin.siswa', $data);
    }

    public function uploadsiswa(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ],[
            'file.required' => 'File tidak boleh kosong',
            'file.mimes' => 'File harus berupa file Excel'
        ]);

        // Ambil file yang diunggah
        $file = $request->file('file');

        // Baca file Excel menggunakan PhpSpreadsheet
        $spreadsheet = IOFactory::load($file);

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
                $foto = $row['F'];

                // Simpan data siswa
                $siswa = Siswa::create([
                    'nis' => $nis,
                    'nama_siswa' => $namaSiswa,
                    'username' => $username,
                    'password' => bcrypt($password),
                    'foto' => $foto,
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

    public function tambahsiswa(){
        $data = [
            'title' => 'Tambah Siswa',
            'kelas' => Kelas::all(),
        ];
        return view('admin.tambahsiswa', $data);
    }

    public function submitsiswa(Request $request){
        $request->validate([
            'nama'  => 'required|min:3',
            'nis'   => 'required|numeric|unique:siswa,nis',
            'kelas' => 'required',
            'password' => 'required|min:8|max:100',
            'confirm-password' => 'required|same:password',
        ],[
            'nama' => 'Kolom Nama tidak boleh kosong',
            'nama.min' => 'Nama minimal 3 karakter',
            'nis' => 'Kolom NIS tidak boleh kosong',
            'nis.numeric' => 'NIS harus berupa angka',
            'nis.unique' => 'NIS sudah terdaftar',
            'kelas' => 'Kolom Kelas tidak boleh kosong',
            'password' => 'Kolom Kata Sandi tidak boleh kosong',
            'password.min' => 'Kata Sandi minimal 8 karakter',
            'password.max' => 'Kata Sandi maksimal 100 karakter',
            'confirm-password' => 'Konfirmasi Kata Sandi tidak boleh kosong',
            'confirm-password.same' => 'Kata Sandi tidak sama',
        ]);

        $foto = 'avatar-'.rand(1, 10).'.png';
        // username berisikan nama depan-nis
        // nama = rizki ramadan
        // nis  = 123456
        // username = rizki-123456
        $username = explode(' ', $request->nama)[0].'-'.$request->nis;

        Siswa::create([
            'nis' => $request->nis,
            'nama_siswa' => $request->nama,
            'username' => $username,
            'jenis_kelamin' => null,
            'alamat' => null,
            'telepon' => null,
            'agama' => null,
            'email' => null,
            'foto' => $foto,
            'password' => bcrypt($request->password),
        ]);

        // simpan ke kelas siswa
        $siswa = Siswa::where('nis', $request->nis)->first();

        KelasSiswa::create([
            'kode_siswa' => $siswa->kode_siswa,
            'kode_kelas' => $request->kelas,
        ]);

        return redirect('/admin/siswa')->with('success', '<strong>Berhasil !</strong> Siswa baru berhasil ditambahkan');
    }

    public function hapussiswa($id){
        // cari kode_siswa, hapus berdasarkan id, dan cari di tabel kelas_siswa jika ada, hapus juga
        $siswa = Siswa::where('kode_siswa', $id)->first();
        $kelasSiswa = KelasSiswa::where('kode_siswa', $id)->first();

        if($kelasSiswa){
            $kelasSiswa->delete();
        }
        $siswa->delete();
        return redirect('/admin/siswa')->with('success', '<strong>Berhasil !</strong> Siswa berhasil dihapus');
    }

    public function detailsiswa($id){
        
        $siswa = Siswa::leftJoin('kelas_siswa', 'siswa.kode_siswa', '=', 'kelas_siswa.kode_siswa')
            ->leftJoin('kelas', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
            ->select('siswa.*', 'kelas.nama_kelas')
            ->where('siswa.kode_siswa', $id)
            ->first();

        $data = [
            'title' => 'Detail Siswa',
            'siswa' => $siswa,
        ];
        return view('admin.detailsiswa', $data);
    }

    public function editsiswa($id){
        $siswa = Siswa::leftJoin('kelas_siswa', 'siswa.kode_siswa', '=', 'kelas_siswa.kode_siswa')
            ->leftJoin('kelas', 'kelas_siswa.kode_kelas', '=', 'kelas.kode_kelas')
            ->select('siswa.*', 'kelas.kode_kelas', 'kelas.nama_kelas')
            ->where('siswa.kode_siswa', $id)
            ->first();

        $data = [
            'title' => 'Edit Siswa',
            'siswa' => $siswa,
            'kelas' => Kelas::all(),
        ];
        return view('admin.editsiswa', $data);
    }

    public function updatesiswa(Request $request, $id){
        $request->validate([
            'nama'  => 'required|min:3',
            'nis'   => 'required|numeric',
            'kelas' => 'required',
        ],[
            'nama' => 'Kolom Nama tidak boleh kosong',
            'nama.min' => 'Nama minimal 3 karakter',
            'nis' => 'Kolom NIS tidak boleh kosong',
            'nis.numeric' => 'NIS harus berupa angka',
            'kelas' => 'Kolom Kelas tidak boleh kosong',
        ]);

        $siswa = Siswa::find($id);
        $siswa->nis = $request->nis;
        $siswa->nama_siswa = $request->nama;

        // jika password tidak kosong
        if($request->password != null){
            $request->validate([
                'password' => 'required|min:8|max:100',
                'password_confirmation' => 'required|same:password',
            ],[
                'password' => 'Kolom Kata Sandi tidak boleh kosong',
                'password.min' => 'Kata Sandi minimal 8 karakter',
                'password.max' => 'Kata Sandi maksimal 100 karakter',
                'password_confirmation' => 'Konfirmasi Kata Sandi tidak boleh kosong',
                'password_confirmation.same' => 'Kata Sandi tidak sama',
            ]);

            $siswa->password = bcrypt($request->password);
        }

        // jika di tabel kelas_siswa tidak ada data siswa dengan kode_siswa = $id
        // maka buat data baru
        if(KelasSiswa::where('kode_siswa', $id)->count() == 0){
            KelasSiswa::create([
                'kode_siswa' => $id,
                'kode_kelas' => $request->kelas,
            ]);
        }else{
            // jika ada, maka update data
            $kelas_siswa = KelasSiswa::where('kode_siswa', $id)->first();
            $kelas_siswa->kode_kelas = $request->kelas;
            $kelas_siswa->save();
        }

        $siswa->save();

        return redirect('/admin/siswa')->with('success', '<strong>Berhasil !</strong> Siswa berhasil diubah');

    }


    // =======================================================
    // ===================== SISWA ===========================
    // =======================================================




    // =======================================================
    // ===================== GURU ============================
    // =======================================================

    public function guru(){
        $data = [
            'guru' => Guru::all(),
            'title' => 'Data Guru',
        ];
        return view('admin.guru', $data);
    }

    public function tambahguru(){
        $data = [
            'title' => 'Tambah Guru',
        ];

        return view('admin.tambahguru', $data);
    }

    public function submitguru(Request $request){
        $request->validate([
            'nip' => 'required|numeric',
            'nama' => 'required|min:3',
            'password' => 'required|min:8|max:100',
            'password_confirmation' => 'required|same:password',
        ]);
        // foto diambil dari avatar-(angka).png
        $foto = 'avatar-'.rand(1, 20).'.png';

        // membuat username dari nama
        // contoh : nama = Drs. Sulaiman 
        // maka username = sulaiman
        // contoh : nama = Nurdiono, M.Pd.
        // maka username = nurdiono
        // contoh : nama = Anggoro Adhi Priyo Utomo, S.Pd.
        // maka username = anggoro-adhi (2 kata pertama)
        // contoh : nama = Drs. sulih prihatiningsih, M.Pd.
        // maka username = sulih-prihatiningsih (2 kata terakhir)
        // koma dihilangkan
        $nama = explode(' ', $request->nama);
        $username = strtolower($nama[0]);
        // jika nama hanya satu kata
        if(count($nama) == 1){
            $username = $nama[0];
        }

        $gelar = [
            'S.Pd.', 'S.Pd.I', 'S.Kom','S.T', 'SE', 'SH.', 'M.Pd.', 'M.Pd.I', 'M.Kom', 'Drs.', 'Dra.', 'Dr.', 'S.Th', 'S.Si', 'A.Md'
        ];

        // jika nama dengan index 1 ada di array gelar
        if(in_array($nama[1], $gelar)){
            $username = strtolower($nama[0]);
        } elseif(in_array($nama[0], $gelar)){
            $username = strtolower($nama[1]);
        } elseif(in_array($nama[2], $gelar)){
            $username = strtolower($nama[0]).'-'.strtolower($nama[1]);
        } elseif(count($nama) > 2){
            $username = strtolower($nama[0]).'-'.strtolower($nama[1]);
        } elseif(in_array($nama[0], $gelar) && count($nama) > 2){
            $username = strtolower($nama[1]).'-'.strtolower($nama[2]);
        } else {
            $username = strtolower($nama[0]);
        }
        $username = str_replace(',', '', $username);

        $guru = new Guru;
        $guru->nip = $request->nip;
        $guru->nama = $request->nama;
        $guru->password = bcrypt($request->password);
        $guru->foto = $foto;
        $guru->username = $username;

        // dd($request->all(), $guru->foto, $guru->username);

        $guru->save();

        return redirect('/admin/guru')->with('success', '<strong>Berhasil !</strong> Guru berhasil ditambahkan');
    }

    public function detailguru($id){
        $guru = Guru::find($id);

        $data = [
            'title' => 'Detail Guru',
            'guru' => $guru,
        ];
        return view('admin.detailguru', $data);
    }

    public function hapusguru($id){
        $guru = Guru::find($id);
        $guru->delete();

        return redirect('/admin/guru')->with('success', '<strong>Berhasil !</strong> Guru berhasil dihapus');
    }

    public function uploadguru(Request $request){
            // Validasi file
            $request->validate([
                'file' => 'required|mimes:xls,xlsx'
            ],[
                'file.required' => 'Kolom file tidak boleh kosong',
                'file.mimes' => 'File harus bertipe .xls atau .xlsx'
            ]);

            // Ambil file Excel dari request
            $file = $request->file('file');

            // Baca file Excel
            $spreadsheet = IOFactory::load($file);

            // Ambil sheet dengan nama tertentu
            // $worksheet = $spreadsheet->getSheetByName('NamaSheet');
            $worksheet = $spreadsheet->getSheet(1);
            $data = $worksheet->toArray();

            // Loop melalui setiap baris data
            for ($i = 1; $i < count($data); $i++) {
                $row = $data[$i];
    
                // Buat data guru baru
                $guru = new Guru();
                $guru->nip = $row[0];
                $guru->nama = $row[1];
                $guru->username = $row[2];
                $guru->foto = $row[3];
                $guru->password = bcrypt($row[4]); // Gunakan bcrypt() untuk mengenkripsi password
    
                // Simpan data guru
                $guru->save();
            }

            // Berikan notifikasi
            return redirect()->back()->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function editguru($id){
        $data = [
            'title' => 'Edit Guru',
            'guru' => Guru::find($id),
        ];

        return view('admin.editguru', $data);
    }

    public function updateguru(Request $request, $id){
        $request->validate([
            'username' => 'required',
            'nama' => 'required',
        ],[
            'username.required' => 'Kolom Username tidak boleh kosong',
            'nama.required' => 'Kolom Nama tidak boleh kosong',
            
        ]);

        $guru = Guru::find($id);

        // jika nip tidak kosong
        if($request->nip != null){
            $request->validate([
                'nip' => 'required',
            ],[
                'nip.required' => 'Kolom NIP tidak boleh kosong',
            ]);

            $guru->nip = $request->nip;
        } else {
            $guru->nip = null;
        }

        
        $guru->username = $request->username;
        $guru->nama = $request->nama;
        
        // jika password tidak kosong
        if($request->password != null){
            $request->validate([
                'password' => 'required|min:8|max:100',
                'password_confirmation' => 'required|same:password',
            ],[
                'password' => 'Kolom Kata Sandi tidak boleh kosong',
                'password.min' => 'Kata Sandi minimal 8 karakter',
                'password.max' => 'Kata Sandi maksimal 100 karakter',
                'password_confirmation' => 'Konfirmasi Kata Sandi tidak boleh kosong',
                'password_confirmation.same' => 'Kata Sandi tidak sama',
            ]);

            $guru->password = bcrypt($request->password);
        }

        $guru->save();

        // pengondisian berhasil atau tidak
        if($guru){
            // redirect dengan pesan sukses
            return redirect('/admin/guru')->with('success', '<strong>Berhasil !</strong> Guru berhasil diubah');
        }else{
            // redirect dengan pesan error
            return redirect('/admin/guru')->with('error', '<strong>Gagal !</strong> Guru gagal diubah');
        }
    }

    public function deleteadmin($id){
        $admin = Admin::find($id);
        $admin->delete();

        return redirect('/admin/admin')->with('success', '<strong>Berhasil !</strong> Admin berhasil dihapus');
    }





    // =======================================================
    // ===================== GURU ============================
    // =======================================================

    // =======================================================
    // ===================== MAPEL ===========================
    // =======================================================
    public function mapel(){
        $data = [
            'mapel' => Mapel::all(),
            'title' => 'Data Mata Pelajaran',
        ];
        return view('admin.mapel', $data);
    }

    public function uploadmapel(Request $request){
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ],[
            'file.required' => 'Kolom file tidak boleh kosong',
            'file.mimes' => 'File harus bertipe .xls atau .xlsx'
        ]);
        
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getSheet(1);

        $data = $worksheet->toArray();

        for ($i = 1; $i < count($data); $i++) {
            $row = $data[$i];

            $mapel = new Mapel();
            $mapel->nama_pelajaran = $row[0];
            $mapel->save();
        }

        return redirect()->back()->with('success', 'Data mata pelajaran berhasil ditambahkan.');
    }

    
    // =======================================================
    // ===================== PROFILE =========================
    // =======================================================
    public function profile(){
        $data = [
            'title' => 'Profil Pengguna',
        ];
        return view('admin.profile', $data);
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
    // ===================== PROFILE =========================
    // =======================================================


    public function admin(){
        $data = [
            'admin' => Admin::all(),
            'title' => 'Data Administrator',
        ];
        return view('admin.admin', $data);
    }

    public function tambahadmin(){
        $data = [
            'title' => 'Tambah Administrator',
            'guru' => Guru::all(),
        ];
        return view('admin.tambahadmin', $data);
    }

    public function submitadmin(Request $request){
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required|min:8|max:100',
            'password_confirmation' => 'required|same:password',
        ],[
            'nama' => 'Nama Guru tidak boleh kosong',
            'email' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'password' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Password maksimal 100 karakter',
            'password_confirmation' => 'Konfirmasi Password tidak boleh kosong',
            'password_confirmation.same' => 'Password tidak sama',
        ]);

        $foto = 'avatar-'.rand(1, 20).'.png';

        // dd($request->all(), $foto);
        Admin::create([
            'nama' => $request->nama,
            'foto' => $foto,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // jika berhasil
        if($request){
            // redirect dengan pesan sukses
            return redirect('/admin/admin')->with('success', '<strong>Berhasil !</strong> Admin berhasil ditambahkan');
        }else{
            // redirect dengan pesan error
            return redirect('/admin/admin')->with('error', '<strong>Gagal !</strong> Admin gagal ditambahkan');
        }

    }

    public function editadmin($id){
        $data = [
            'title' => 'Edit Admin',
            // 'guru' => Guru::all(),
            'admin' => Admin::find($id),
        ];

        return view('admin.editadmin', $data);
    }

    public function updateadmin(Request $request, $id){
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email:dns',
        ],[
            'nama' => 'Nama Guru tidak boleh kosong',
            'email' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
        ]);

        $admin = Admin::find($id);

        $admin->nama = $request->nama;
        $admin->email = $request->email;

        // cek apakah password tidak kosong
        if($request->password != null){
            $request->validate([
                'password' => 'required|min:8|max:100',
                'password_confirmation' => 'required|same:password',
            ],[
                'password' => 'Kolom Kata Sandi tidak boleh kosong',
                'password.min' => 'Kata Sandi minimal 8 karakter',
                'password.max' => 'Kata Sandi maksimal 100 karakter',
                'password_confirmation' => 'Konfirmasi Kata Sandi tidak boleh kosong',
                'password_confirmation.same' => 'Kata Sandi tidak sama',
            ]);

            $admin->password = bcrypt($request->password);
        }

        // dd($request->all(),$admin);
        $admin->save();

        // pengondisian berhasil atau tidak
        if($admin){
            // redirect dengan pesan sukses
            return redirect('/admin/admin')->with('success', '<strong>Berhasil !</strong> Admin berhasil diubah');
        }else{
            // redirect dengan pesan error
            return redirect('/admin/admin')->with('error', '<strong>Gagal !</strong> Admin gagal diubah');
        }


    }

    // =======================================================
    // ======================= KELAS =========================
    // =======================================================

    public function uploadkelas(Request $request){
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ],[
            'file.required' => 'File tidak boleh kosong',
            'file.mimes' => 'File harus berupa excel',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getSheet(1);

        $data = $worksheet->toArray();

        for ($i = 1; $i < count($data); $i++) {
            $row = $data[$i];

            $kelas = new Kelas();
            $kelas->kode_kelas= $row[0];
            $kelas->nama_kelas = $row[1];
            $kelas->kode_admin = $row[2];

            $kelas->save();
        }

        return redirect()->back()->with('status', 'Data kelas berhasil ditambahkan.');

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



    // =======================================================
    // ===================== LOGIN ===========================
    // =======================================================
    public function login(){
        return view('admin.login');
    }

    public function store(Request $request){

        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::guard('webadmin')->attempt($credentials)){
            $request->session()->regenerate();
            return redirect('/admin');
        }

        return back()->with('loginError', 'Login gagal, email atau password salah');
    }
    // =======================================================
    // ===================== LOGIN ===========================
    // =======================================================


    
    // =======================================================
    // ===================== LOGOUT ==========================
    // =======================================================
    public function logout(Request $request){
        Auth::guard('webadmin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
    // =======================================================
    // ===================== LOGOUT ==========================
    // =======================================================
    
}
