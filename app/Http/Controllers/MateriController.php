<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\KelasSiswa;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // cek apakah yang login adalah admin atau guru
        $check = \Illuminate\Support\Facades\Auth::guard('webadmin')->check() || \Illuminate\Support\Facades\Auth::guard('webguru')->check();
        if($check){
            $query = \App\Models\Materi::query();

            // Pencarian
            $search = $request->input('search');
            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('materi.judul_materi', 'like', '%'.$search.'%')
                        ->orWhere('materi.keterangan', 'like', '%'.$search.'%');
                });
            }

            $kodeTingkat = $request->input('tingkat');

            if ($kodeTingkat) {
                $query->where('materi.tingkat', $kodeTingkat);
            }

            // Filtering berdasarkan kode_pelajaran
            $kodePelajaran = $request->input('kode_pelajaran');

            if ($kodePelajaran) {
                $query->where('materi.kode_pelajaran', $kodePelajaran);
            }

            $materi = $query
            // ->join('tingkat_kelas', 'materi.kode_tingkat', '=', 'tingkat_kelas.kode_tingkat')
            ->join('pelajaran', 'materi.kode_pelajaran', '=', 'pelajaran.kode_pelajaran')
            ->select('materi.*','pelajaran.nama_pelajaran')
            ->get();

            $pelajaranOptions = \App\Models\Mapel::pluck('nama_pelajaran', 'kode_pelajaran');


            $data = [
                'materi' => $materi,
                'pelajaranOptions' => $pelajaranOptions,
                'title' => 'Materi',
                
            ];

            return view('materi.materi', $data);

        } elseif(\Illuminate\Support\Facades\Auth::guard('websiswa')->check()) {

            $query = \App\Models\Materi::query();

            // Pencarian
            $search = $request->input('search');
            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('materi.judul_materi', 'like', '%'.$search.'%')
                        ->orWhere('materi.keterangan', 'like', '%'.$search.'%');
                });
            }

            $kodeTingkat = $request->input('tingkat');

            if ($kodeTingkat) {
                $query->where('materi.tingkat', $kodeTingkat);
            }

            // Filtering berdasarkan kode_pelajaran
            $kodePelajaran = $request->input('kode_pelajaran');

            if ($kodePelajaran) {
                $query->where('materi.kode_pelajaran', $kodePelajaran);
            }
            
            $materi = $query
            ->join('pelajaran', 'materi.kode_pelajaran', '=', 'pelajaran.kode_pelajaran')
            ->select('materi.*', 'pelajaran.nama_pelajaran')
            ->paginate(5);

            $pelajaranOptions = \App\Models\Mapel::pluck('nama_pelajaran', 'kode_pelajaran');


            $data = [
                'materi' => $materi,
                'pelajaranOptions' => $pelajaranOptions,
                'title' => 'Materi',
                'kelas_siswa' => KelasSiswa::where('kode_siswa', \Illuminate\Support\Facades\Auth::guard('websiswa')->user()->kode_siswa)->first(),
                
            ];

            return view('siswa.materi', $data);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $check = \Illuminate\Support\Facades\Auth::guard('webadmin')->check() || \Illuminate\Support\Facades\Auth::guard('webguru')->check();
        if($check) {
            $data = [
                'title' => 'Tambah Materi',
                // 'kelas' => \App\Models\Tingkat::all(),
                'mapel' => \App\Models\Mapel::all(),
            ];
            return view('materi.addmateri', $data);

        }elseif(\Illuminate\Support\Facades\Auth::guard('websiswa')->check()){
            return redirect('/siswa/materi')->with('gagal', 'Maaf, anda tidak memiliki akses ke halaman tersebut');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = \Illuminate\Support\Facades\Auth::guard('webadmin')->check() || \Illuminate\Support\Facades\Auth::guard('webguru')->check();
        if($check) {
            $request->validate([
                'judul' => 'required',
                'kelas' => 'required',
                'mapel' => 'required',
                'file' => 'required',

            ],[
                'judul.required' => 'Kolom judul harus diisi',
                'kelas.required' => 'Kolom kelas harus diisi',
                'mapel.required' => 'Kolom pelajaran harus diisi',
                'file.required' => 'Kolom file harus diisi',
            ]);

            $file = $request->file('file');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'file/materi';
            $file->move($tujuan_upload,$nama_file);

            // jika yang login berasal dari tabel admin maka kode admin yang akan disimpan
            $check = \Illuminate\Support\Facades\Auth::guard('webadmin')->check();
            if($check){
                $kode_admin = \Illuminate\Support\Facades\Auth::guard('webadmin')->user()->kode_admin;
                $kode_guru = NULL;
            }else{
                $kode_guru = \Illuminate\Support\Facades\Auth::guard('webguru')->user()->kode_guru;
                $kode_admin = NULL;
            }

            Materi::create([
                'judul_materi' => $request->judul,
                'tingkat' => $request->kelas,
                'kode_pelajaran' => $request->mapel,
                'keterangan' => $request->deskripsi,
                'berkas' => $nama_file,
                'kode_admin' => $kode_admin,
                'kode_guru' => $kode_guru,
            ]);

            if(\Illuminate\Support\Facades\Auth::guard('webadmin')->check())
                return redirect('/admin/materi')->with('sukses', 'Data berhasil ditambahkan');
            else(\Illuminate\Support\Facades\Auth::guard('webguru')->check());
                return redirect('/guru/materi')->with('sukses', 'Data berhasil ditambahkan');

        }elseif(\Illuminate\Support\Facades\Auth::guard('websiswa')->check()){
            return redirect('/siswa/materi')->with('gagal', 'Maaf, anda tidak memiliki akses ke halaman tersebut');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Materi  $materi
     * @return \Illuminate\Http\Response
     */
    public function show(Materi $materi)
    {
        $check = \Illuminate\Support\Facades\Auth::guard('webadmin')->check() || \Illuminate\Support\Facades\Auth::guard('webguru')->check();
        if($check) {
            $data = [
                'title' => 'Detail Materi',
                'materi' => $materi,
            ];
            return view('materi.detail', $data);
        }elseif(\Illuminate\Support\Facades\Auth::guard('websiswa')->check()){
            $data = [
                'title' => 'Detail Materi',
                'materi' => $materi,
                'kelas_siswa' => \App\Models\KelasSiswa::where('kode_siswa', \Illuminate\Support\Facades\Auth::guard('websiswa')->user()->kode_siswa)->first(),
            ];
            return view('siswa.detailmateri', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Materi  $materi
     * @return \Illuminate\Http\Response
     */
    public function edit(Materi $materi)
    {
        $check = \Illuminate\Support\Facades\Auth::guard('webadmin')->check() || \Illuminate\Support\Facades\Auth::guard('webguru')->check();
        if($check) {
            $data = [
                'title' => 'Edit Materi',
                'materi' => $materi,
                // 'kelas' => \App\Models\Tingkat::all(),
                'mapel' => \App\Models\Mapel::all(),
            ];
            
            return view('materi.editmateri', $data);

        }elseif(\Illuminate\Support\Facades\Auth::guard('websiswa')->check()){
            return redirect('/siswa/materi')->with('gagal', 'Maaf, anda tidak memiliki akses ke halaman tersebut');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Materi  $materi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materi $materi)
    {
        $check = \Illuminate\Support\Facades\Auth::guard('webadmin')->check() || \Illuminate\Support\Facades\Auth::guard('webguru')->check();

        if($check){
            $request->validate([
                'judul_materi' => 'required',
                'kelas' => 'required',
                'mapel' => 'required',
            ],[
                'judul_materi.required' => 'Kolom judul harus diisi',
                'kelas.required' => 'Kolom kelas harus diisi',
                'mapel.required' => 'Kolom pelajaran harus diisi',
            ]);

            // cek apakah ada file yang diupload atau tidak, jika ada maka file lama akan dihapus dan file baru akan diupload
            if($request->hasFile('file')){
                $file = $request->file('file');
                $nama_file = time()."_".$file->getClientOriginalName();
                $tujuan_upload = 'file/materi';
                $file->move($tujuan_upload,$nama_file);

                // hapus file lama
                $file_lama = $materi->berkas;
                $path = public_path().'/file/materi/'.$file_lama;
                unlink($path);

                $materi->berkas = $nama_file;
            }


            $materi->judul_materi = $request->judul_materi;
            $materi->tingkat = $request->kelas;
            $materi->keterangan = $request->keterangan;
            $materi->kode_pelajaran = $request->mapel;
            $materi->save();

            if(\Illuminate\Support\Facades\Auth::guard('webadmin')->check()){
                return redirect('/admin/materi')->with('sukses', 'Data berhasil diubah');
            } else {
                return redirect('/guru/materi')->with('sukses', 'Data berhasil diubah');
            }
        }elseif(\Illuminate\Support\Facades\Auth::guard('websiswa')->check()){
            return redirect('/siswa/materi')->with('gagal', 'Maaf, anda tidak memiliki akses ke halaman tersebut');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Materi  $materi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materi $materi)
    {
        $check = \Illuminate\Support\Facades\Auth::guard('webadmin')->check() || \Illuminate\Support\Facades\Auth::guard('webguru')->check();
        if($check){
            $materi->delete();

            if(\Illuminate\Support\Facades\Auth::guard('webadmin')->check()){
                unlink(public_path().'/file/materi/'.$materi->berkas);
                return redirect('/admin/materi')->with('sukses', 'Data berhasil dihapus');
            } elseif(\Illuminate\Support\Facades\Auth::guard('webguru')->check()) {
                unlink(public_path().'/file/materi/'.$materi->berkas);
                return redirect('/guru/materi')->with('sukses', 'Data berhasil dihapus');
            }
        }else{
            return redirect('/')->with('gagal', 'Maaf, anda tidak memiliki akses ke halaman tersebut');
        }
        

    }

    public function shared(){
        $data = [
            'title' => 'Materi yang dibagikan',
            'materi' => \App\Models\Materi::where('kode_guru', \Illuminate\Support\Facades\Auth::guard('webguru')->user()->kode_guru)->get(),
        ];
        return view('materi.shared', $data);
    }

}
