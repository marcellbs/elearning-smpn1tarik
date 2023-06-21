<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Hashids\Hashids;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Mapel;
use App\Models\Tingkat;
use App\Models\Pengampu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $hash = new Hashids('my-hash', 10);
        $kodeGuru = Auth::guard('webguru')->user()->kode_guru;

        $query = Pengampu::where('kode_guru', $kodeGuru);

        $kodeKelas = $request->input('kode_kelas');
        if ($kodeKelas) {
            $query->whereHas('kelas', function ($q) use ($kodeKelas) {
                $q->where('kode_kelas', $kodeKelas);
            });
        }

        $kodePelajaran = $request->input('kode_pelajaran');
        if ($kodePelajaran) {
            $query->where('pengampu.kode_pelajaran', $kodePelajaran);
        }

        $pengampu = $query
            ->join('pelajaran', 'pengampu.kode_pelajaran', '=', 'pelajaran.kode_pelajaran')
            ->join('kelas', 'pengampu.kode_kelas', '=', 'kelas.kode_kelas')
            ->join('tahun_ajaran', 'pengampu.kode_thajaran', '=', 'tahun_ajaran.id')
            ->select('pengampu.*', 'pelajaran.nama_pelajaran', 'kelas.nama_kelas', 'tahun_ajaran.tahun_ajaran')
            ->where('tahun_ajaran.status_aktif', '1')
            ->distinct()
            ->get();


        $kelasOptions = Kelas::join('kelas_siswa', 'kelas.kode_kelas', '=', 'kelas_siswa.kode_kelas')
            ->join('pengampu', 'kelas.kode_kelas', '=', 'pengampu.kode_kelas')
            ->join('tahun_ajaran', 'pengampu.kode_thajaran', '=', 'tahun_ajaran.id')
            ->where('tahun_ajaran.status_aktif', '1')
            ->where('pengampu.kode_guru', $kodeGuru)
            ->select('kelas.kode_kelas', 'kelas.nama_kelas')
            ->distinct()
            ->pluck('nama_kelas', 'kode_kelas');
    
        $pelajaranOptions = Mapel::where('status_aktif', '1')
            ->join('pengampu', 'pelajaran.kode_pelajaran', '=', 'pengampu.kode_pelajaran')
            ->join('tahun_ajaran', 'pengampu.kode_thajaran', '=', 'tahun_ajaran.id')
            ->where('tahun_ajaran.status_aktif', '1')
            ->where('pengampu.kode_guru', $kodeGuru)
            ->select('pelajaran.kode_pelajaran', 'pelajaran.nama_pelajaran')
            ->distinct()
            ->pluck('nama_pelajaran', 'kode_pelajaran');

        $data = [
            'guru' => Guru::all(),
            'pengampu' => $pengampu,
            'kelasOptions' => $kelasOptions,
            'pelajaranOptions' => $pelajaranOptions,
            'title' => 'Dashboard',
            'hash' => $hash,
        ];

        return view('guru.index', $data);
    }


    public function mapel(Request $request)
    {
        $hash = new Hashids('my-hash', 10);
        $kodeGuru = Auth::guard('webguru')->user()->kode_guru;

        // Ambil tahun ajaran yang aktif
        $tahunAjaranAktif = \App\Models\TahunAjaran::where('status_aktif', 1)->first();

        if ($tahunAjaranAktif) {
            $idTahunAjaranAktif = $tahunAjaranAktif->id;

            $tahunAjaranOptions = \App\Models\TahunAjaran::pluck('tahun_ajaran', 'id');

            $tahunAjaranId = $request->input('tahun_ajaran', $idTahunAjaranAktif); // Jika tahun ajaran tidak dipilih, gunakan tahun ajaran aktif secara default

            $pengampu = \App\Models\Pengampu::where('kode_guru', $kodeGuru)
                ->where('kode_thajaran', $tahunAjaranId)
                ->get();

            $data = [
                'guru' => \App\Models\Guru::all(),
                'pengampu' => $pengampu,
                'tahunAjaranOptions' => $tahunAjaranOptions,
                'tahunAjaranAktif' => $tahunAjaranAktif,
                'title' => 'Mata Pelajaran',
                'hash' => $hash,
            ];

            return view('guru.mapel', $data);
        }

        // Tindakan jika tahun ajaran aktif tidak tersedia
        // ...
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
            'title' => ''.$pengampu->mapel->nama_pelajaran.' '.$pengampu->kelas->nama_kelas.'',
            'hash' => $hash,
            'pengampu' => $pengampu,
            'materi' => $materi,
            // menampilkan siswa dari tabel siswa yang memiliki id yang sama di tabel kelassiswa dan kode kelas yang sama dan tahun ajaran yang sama dengan pengampu
            'siswa' => \App\Models\Siswa:: join('kelas_siswa', 'siswa.kode_siswa', '=', 'kelas_siswa.kode_siswa')
            ->where('kelas_siswa.kode_kelas', $pengampu->kode_kelas)
            ->where('kelas_siswa.kode_thajaran', $pengampu->kode_thajaran)
            ->get(),


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

    //========================================
    //===============PROFILE==================
    //========================================

    public function profile(){
        $hash = new Hashids('my-hash',10);
        $data = [
            'title' => 'Profile',
            // 'hash' => $hash,
            // 'guru' => \App\Models\Guru::where('kode_guru', \Illuminate\Support\Facades\Auth::guard('webguru')->user()->kode_guru)->first(),
        ];

        return view('guru.profile', $data);
    }
    // ubah profile
    public function changeProfile(Request $request, $id){
        // validasi
        $request->validate([
            'nip' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'jk' => 'required',
            'alamat' => 'required',
            'telepon' => 'required|numeric',
            'agama' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:3072',
        ],[
            'nip.required' => 'Kolom NIP harus diisi',
            'nama.required' => 'Kolom nama harus diisi',
            'email.required' => 'Kolom email harus diisi',
            'jk.required' => 'Kolom jenis kelamin harus diisi',
            'alamat.required' => 'Kolom alamat harus diisi',
            'telepon.required' => 'Kolom telepon harus diisi',
            'telepon.numeric' => 'Kolom telepon harus berupa angka',
            'agama.required' => 'Kolom agama harus diisi',
            'foto.image' => 'Kolom foto harus berupa gambar',
            'foto.mimes' => 'Format foto harus jpeg, jpg, atau png',
            'foto.max' => 'Ukuran foto maksimal 3 MB',
        ]);

        // cek apakah ada file foto yang diupload atau tidak
        // jika nama file diawali dengan avatar maka tidak ada file yang diupload

        if($request->file('foto') == null){
            // jika tidak ada file yang diupload
            // maka update data guru tanpa foto

            // dd($request->all());
            \App\Models\Guru::where('kode_guru', $id)->update([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'jenis_kelamin' => $request->jk,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'agama' => $request->agama,
            ]);

        }else{
            // jika ada file yang diupload
            // maka update data guru dengan foto
            // hapus foto lama
            $guru = \App\Models\Guru::where('kode_guru', $id)->first();

            // jika foto tidak sama dengan file avatar user di folder public/img maka hapus foto
            if($guru->foto != auth()->user()->foto){
                unlink(public_path('img/guru/'.$guru->foto));
            }

            // upload foto baru
            $foto = $request->file('foto');
            $nama_foto = time().'_'.$foto->getClientOriginalName();
            $tujuan_upload = 'img/guru';
            $foto->move($tujuan_upload, $nama_foto);

            // hapus foto lama
            unlink(public_path('img/guru/'.$guru->foto));

            // update data guru
            \App\Models\Guru::where('kode_guru', $id)->update([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'email' => $request->email,
                'jenis_kelamin' => $request->jk,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'agama' => $request->agama,
                'foto' => $nama_foto,
            ]);
        }

        return redirect()->back()->with('sukses', 'Data berhasil diubah');
    }

    // ubah password
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

        $guru = Guru::find($id);

        if(\Illuminate\Support\Facades\Hash::check($request->password, $guru->password)){
            $guru->update([
                'password' => bcrypt($request->passwordbaru),
            ]);
            return redirect('/guru/profile')->with('sukses', 'Password berhasil diubah');
        }else{
            return redirect('/guru/profile')->with('gagal', 'Password saat ini salah');
        }
    }
}
