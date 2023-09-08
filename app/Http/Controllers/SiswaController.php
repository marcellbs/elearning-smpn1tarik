<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\KelasSiswa;
use Illuminate\Http\Request;
use Hashids\Hashids;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $siswa = \App\Models\Siswa::all();
        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)->first();

        // mengambil kode siswa dari kode_kelas di kelas _siswa yang memiliki kode_thajaran yang sama dengan tahun ajaran yang aktif
        $kelasSiswa = \App\Models\KelasSiswa::where('kode_siswa', auth()->guard('websiswa')->user()->kode_siswa)
            ->where('kode_thajaran', $tahunAjaran->id)
            ->first();

        
        $query = \App\Models\Pengampu::query();
        $query->where('kode_kelas', $kelasSiswa->kode_kelas)->where('kode_thajaran', $tahunAjaran->id);
        
        // Filter berdasarkan nama pelajaran jika ada pencarian
        $namaPelajaran = $request->input('nama_pelajaran');
        if ($namaPelajaran) {
            $query->join('pelajaran', 'pengampu.kode_pelajaran', '=', 'pelajaran.kode_pelajaran')
                ->where('pelajaran.nama_pelajaran', 'like', '%' . $namaPelajaran . '%');
        }
        
        $pengumuman = \App\Models\Pengumuman::orderBy('tgl_upload', 'desc')->limit(3)->get();
        $pengampu = $query->get();

        $hash = new Hashids('my-hash',10);
        
        
        $data = [
            'title' => 'Dashboard',
            'siswa' => $siswa,
            'kelas_siswa' => $kelasSiswa,
            'pengampu' => $pengampu,
            'tahunAjaran' => $tahunAjaran->tahun_ajaran,
            'pengumuman' => $pengumuman,
            'hash' => $hash,
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
            // 'tingkat' => \App\Models\Tingkat::all(),
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
        
        $materi = \App\Models\Materi::where('kode_guru', $pengampu->kode_guru)->where('kode_pelajaran', $pengampu->kode_pelajaran)->get();
        
        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)->first();
        $kelasSiswa = \App\Models\KelasSiswa::where('kode_siswa', auth()->guard('websiswa')->user()->kode_siswa)
        ->where('kode_thajaran', $tahunAjaran->id)
        ->first();

        $data = [
            'kelas_siswa' => $kelasSiswa,
            'title' => ''.$pengampu->mapel->nama_pelajaran.' '.$pengampu->kelas->nama_kelas.'',
            'pengampu' => $pengampu,
            'materi' => $materi,
            'siswa' => \App\Models\Siswa:: join('kelas_siswa', 'siswa.kode_siswa', '=', 'kelas_siswa.kode_siswa')
            ->where('kelas_siswa.kode_kelas', $pengampu->kode_kelas)
            ->where('kelas_siswa.kode_thajaran', $pengampu->kode_thajaran)
            ->where('siswa.status', '1')
            ->orderBy('nis', 'asc')
            ->get(),
        ];

        return view('siswa.detailkelas', $data);
    }

    public function pengumuman(Request $request)
    {
        $query = \App\Models\Pengumuman::orderByDesc('tgl_upload');
        $kelasSiswa = KelasSiswa::where('kode_siswa', auth()->guard('websiswa')->user()->kode_siswa)->first();

        // Filter berdasarkan pencarian nama pengumuman
        $keyword = $request->input('keyword');
        if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('judul_pengumuman', 'like', '%' . $keyword . '%')
                    ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
            });
        }

        $pengumuman = $query->paginate(6);

        $data = [
            'title' => 'Pengumuman',
            'kelas_siswa' => $kelasSiswa,
            'pengumuman' => $pengumuman,
        ];

        return view('siswa.pengumuman', $data);
    }


    // public function mapel()
    // {
    //     // $hash = new \Vinkla\Hashids\Facades\Hashids('my-hash', 10);
    //     $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)->first();

    //     $kelasSiswa = KelasSiswa::where('kode_siswa', auth()->guard('websiswa')->user()->kode_siswa)
    //     ->where('kode_thajaran', $tahunAjaran->id)
    //     ->first();

    //     $query = \App\Models\Pengampu::where('kode_kelas', $kelasSiswa->kode_kelas)->where('kode_thajaran', $tahunAjaran->id)->orderBy('kode_pelajaran', 'asc');
        
    //     $pengampu = $query->get();

    //     $data = [
    //         'title' => 'Mata Pelajaran',
    //         'kelas_siswa' => $kelasSiswa,
    //         'pengampu' => $pengampu
    //     ];

    //     return view('siswa.mapel', $data);
    // }

    // public function mapel(Request $request)
    // {
    //     $listTahunAjaran = \App\Models\TahunAjaran::pluck('tahun_ajaran', 'id');

    //     $tahunAjaranId = $request->input('tahun_ajaran');

    //     // Jika tidak ada filter tahun ajaran yang dipilih, ambil tahun ajaran aktif
    //     if (empty($tahunAjaranId)) {
    //         $tahunAjaranAktif = \App\Models\TahunAjaran::where('status_aktif', 1)->first();
    //         $tahunAjaranId = $tahunAjaranAktif->id;
    //     }

    //     $kelasSiswa = KelasSiswa::where('kode_siswa', auth()->guard('websiswa')->user()->kode_siswa)
    //         ->where('kode_thajaran', $tahunAjaranId)
    //         ->first();

    //     $query = \App\Models\Pengampu::where('kode_kelas', $kelasSiswa->kode_kelas)
    //         ->where('kode_thajaran', $tahunAjaranId)
    //         ->orderBy('kode_pelajaran', 'asc');

    //     $pengampu = $query->get();

    //     $data = [
    //         'title' => 'Mata Pelajaran',
    //         'kelas_siswa' => $kelasSiswa,
    //         'pengampu' => $pengampu,
    //         'listTahunAjaran' => $listTahunAjaran,
    //         'tahun_ajaran_id' => $tahunAjaranId
    //     ];

    //     return view('siswa.mapel', $data);
    // }

    public function mapel(Request $request)
    {
        $listTahunAjaran = \App\Models\TahunAjaran::pluck('tahun_ajaran', 'id');

        $namaTahunAjaran = $request->input('tahun_ajaran');

        // Jika tidak ada filter tahun ajaran yang dipilih, ambil tahun ajaran aktif
        if (empty($namaTahunAjaran)) {
            $tahunAjaranAktif = \App\Models\TahunAjaran::where('status_aktif', 1)->first();
            $namaTahunAjaran = $tahunAjaranAktif->tahun_ajaran;
        }

        $tahunAjaran = \App\Models\TahunAjaran::where('tahun_ajaran', $namaTahunAjaran)->first();

        $kelasSiswa = KelasSiswa::where('kode_siswa', auth()->guard('websiswa')->user()->kode_siswa)
            ->where('kode_thajaran', $tahunAjaran->id)
            ->first();

        if (empty($kelasSiswa)) {
            return redirect()->back()->with('error', 'Tahun Ajaran ' . $namaTahunAjaran . ' tidak ditemukan');
        }
        
        $query = \App\Models\Pengampu::where('kode_kelas', $kelasSiswa->kode_kelas)
            ->where('kode_thajaran', $tahunAjaran->id)
            ->orderBy('kode_pelajaran', 'asc');
        

        $pengampu = $query->get();

        $data = [
            'title' => 'Mata Pelajaran',
            'kelas_siswa' => $kelasSiswa,
            'pengampu' => $pengampu,
            'listTahunAjaran' => $listTahunAjaran,
            'tahun_ajaran_id' => $namaTahunAjaran
        ];

        return view('siswa.mapel', $data);
    }


    public function profile(){
        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)->first();

        $kelasSiswa = KelasSiswa::where('kode_siswa', auth()->guard('websiswa')->user()->kode_siswa)
        ->where('kode_thajaran', $tahunAjaran->id)
        ->first();

        $data = [
            'title' => 'Profil',
            'kelas_siswa' => $kelasSiswa,
            'tahun_ajaran' => $tahunAjaran,
        ];

        return view('siswa.profile', $data);
    }

    public function changeProfile(Request $request, $id){
        // $request->validate([
        //     'nis' => 'required',
        //     'nama' => 'required',
        //     'email' => 'required',
        //     'jk' => 'required',
        //     'alamat' => 'required',
        //     'telepon' => 'required|numeric',
        //     'agama' => 'required',
        //     'foto' => 'image|mimes:jpeg,png,jpg|max:3072',
        // ],[
        //     'nis.required' => 'Kolom NIS harus diisi',
        //     'nama.required' => 'Kolom nama harus diisi',
        //     'email.required' => 'Kolom email harus diisi',
        //     'jk.required' => 'Kolom jenis kelamin harus diisi',
        //     'alamat.required' => 'Kolom alamat harus diisi',
        //     'telepon.required' => 'Kolom telepon harus diisi',
        //     'telepon.numeric' => 'Kolom telepon harus berupa angka',
        //     'agama.required' => 'Kolom agama harus diisi',
        //     'foto.image' => 'Kolom foto harus berupa gambar',
        //     'foto.mimes' => 'Format foto harus jpeg, jpg, atau png',
        //     'foto.max' => 'Ukuran foto maksimal 3 MB',
        // ]);

        if($request->file('foto') == null){
            \App\Models\Siswa::where('kode_siswa', $id)->update([
                'nis' => $request->nis,
                'nama_siswa' => $request->nama,
                'email' => $request->email,
                'jenis_kelamin' => $request->jk,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'agama' => $request->agama,
            ]);
        }else{
            // hapus foto lama
            $siswa = \App\Models\Siswa::where('kode_siswa', $id)->first();
            
            // jika foto = avatar-1 s.d. 20 , maka tidak usah dihapus
            $foto = ['avatar-1.png', 'avatar-2.png', 'avatar-3.png', 'avatar-4.png', 'avatar-5.png', 'avatar-6.png', 'avatar-7.png', 'avatar-8.png', 'avatar-9.png', 'avatar-10.png', 'avatar-11.png', 'avatar-12.png', 'avatar-13.png', 'avatar-14.png', 'avatar-15.png', 'avatar-16.png', 'avatar-17.png', 'avatar-18.png', 'avatar-19.png', 'avatar-20.png'];

            if(!in_array($siswa->foto, $foto)){
                unlink(public_path('img/siswa/'.$siswa->foto));
            }

            // upload foto baru
            $foto = $request->file('foto');
            $nama_foto = time()."_".$foto->getClientOriginalName();
            $tujuan_upload = 'img/siswa';
            $foto->move($tujuan_upload, $nama_foto);
            
            // update data
            \App\Models\Siswa::where('kode_siswa', $id)->update([
                'nis' => $request->nis,
                'nama_siswa' => $request->nama,
                'email' => $request->email,
                'jenis_kelamin' => $request->jk,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'agama' => $request->agama,
                'foto' => $nama_foto,
            ]);

        }
        // jika sukses 
        return redirect()->back()->with('sukses', 'Data berhasil diubah');

    }

    // method untuk mengubah password
    public function changePassword(Request $request, $id){

        $request->validate([
            'password' => 'required',
            'passwordbaru' => 'required|min:8|max:100',
            'ulangpassword' => 'required|same:passwordbaru',
        ],[
            'password.required' => 'Password saat ini tidak boleh kosong',
            'passwordbaru.required' => 'Password baru tidak boleh kosong',
            'passwordbaru.min' => 'Password minimal 8 karakter',
            'passwordbaru.max' => 'Password maksimal 100 karakter',
            'ulangpassword.required' => 'Konfirmasi password tidak boleh kosong',
            'ulangpassword.same' => 'Password tidak sama',
        ]);

        // dd($request->all());

        $siswa = Siswa::find($id);

        // cek password saat ini sama atau tidak
        if(! \Illuminate\Support\Facades\Hash::check($request->password, $siswa->password)){
            // jika password tidak sama
            return redirect()->back()->with('gagal', 'Password saat ini salah');

        } else {
            // jika password sama
            // maka update password
            $siswa->update([
                'password' => bcrypt($request->passwordbaru),
            ]);

            return redirect()->back()->with('sukses', 'Password berhasil diubah');
        }

    }


}
