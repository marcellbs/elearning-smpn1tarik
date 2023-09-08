<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::query();
        // pencarian 
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('video.judul', 'like', "%".$search."%");
            });
        }

        $video = $query->paginate(5);

        $data = [
            // paginate
            'video' => $video,
            'title' => 'Video Pembelajaran',
        ];

        return view('video.index', $data);
    }
    public function videoSiswa(Request $request)
    {
        $query = Video::query();
        // pencarian 
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('video.judul', 'like', "%".$search."%");
            });
        }

        $video = $query->paginate(5);
        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)->first();
        $kelasSiswa = \App\Models\KelasSiswa::where('kode_siswa', auth()->guard('websiswa')->user()->kode_siswa)->where('kode_thajaran', $tahunAjaran->id)->first();

        $data = [
            // paginate
            'video' => $video,
            'title' => 'Video Pembelajaran',
            'kelas_siswa' => $kelasSiswa,
        ];

        return view('video.videosiswa', $data);
    }

    public function detail($id)
    {
        $data = [
            'video' => Video::find($id),
            'title' => 'Video Pembelajaran'
        ];

        return view('video.detail', $data);
    }
    public function detailVideoSiswa($id)
    {
        $tahunAjaran = \App\Models\TahunAjaran::where('status_aktif', 1)->first();
        $kelasSiswa = \App\Models\KelasSiswa::where('kode_siswa', auth()->guard('websiswa')->user()->kode_siswa)->where('kode_thajaran', $tahunAjaran->id)->first();

        $data = [
            'video' => Video::find($id),
            'title' => 'Video Pembelajaran',
            'kelas_siswa' => $kelasSiswa,
        ];

        return view('video.detailvideosiswa', $data);
    }

    public function create()
    {

        $data = [
            'title' => 'Tambah Video Pembelajaran',
            'mapel' => \App\Models\Mapel::all(),
        ];

        return view('video.create', $data);
    }

    public function save(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'link' => 'required',
            'mapel' => 'required',
            'tingkat' => 'required',
        ]);

        
        Video::create([
            'judul' => $request->judul,
            'kode_pelajaran' => $request->mapel,
            'kode_guru' => auth()->user()->kode_guru,
            'kode_admin' => '',
            'tingkat' => $request->tingkat,
            'link' => $request->link,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        // kembali ke halaaman sebelumnya
        return redirect('/guru/video/shared')->with('success', 'Video berhasil ditambahkan');
    }

    public function shared()
    {
        $data = [
            'video' => Video::where('kode_guru', auth()->user()->kode_guru)->paginate(5),
            'title' => 'Manajemen Video'
        ];

        return view('video.shared', $data);
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Video Pembelajaran',
            'mapel' => \App\Models\Mapel::all(),
            'video' => Video::find($id),
        ];

        return view('video.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'link' => 'required',
            'mapel' => 'required',
            'tingkat' => 'required',
        ]);

        $waktuIndonesia = new \DateTimeZone('Asia/Jakarta');
        $waktu = new \DateTime();
        $waktu->setTimezone($waktuIndonesia);


        Video::where('id', $id)->update([
            'judul' => $request->judul,
            'kode_pelajaran' => $request->mapel,
            'kode_guru' => auth()->user()->kode_guru,
            'tingkat' => $request->tingkat,
            'link' => $request->link,
            'updated_at' => $waktu->format('Y-m-d H:i:s'),
        ]);
        
        return redirect('/guru/video/shared')->with('success', 'Video berhasil diubah');
    }

    public function destroy($id)
    {
        Video::where('id', $id)->delete();

        return redirect('/guru/video/shared')->with('success', 'Video berhasil dihapus');
    }

    public function adminVideo()
    {
        $data = [
            'video' => Video::all(),
            'title' => 'Manajemen Video'
        ];

        return view('video.adminvideo', $data);
    }

    public function adminVideoCreate()
    {
        $data = [
            'title' => 'Tambah Video Pembelajaran',
            'mapel' => \App\Models\Mapel::all(),
        ];

        return view('video.adminvideocreate', $data);
    }

    public function adminVideoSave(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'link' => 'required',
            'mapel' => 'required',
            'tingkat' => 'required',
        ]);

        
        Video::create([
            'judul' => $request->judul,
            'kode_pelajaran' => $request->mapel,
            'kode_guru' => null,
            'kode_admin' => auth()->user()->kode_admin,
            'tingkat' => $request->tingkat,
            'link' => $request->link,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        // kembali ke halaaman sebelumnya
        return redirect('/admin/video')->with('success', 'Video berhasil ditambahkan');
    }

    public function adminVideoEdit($id)
    {
        $data = [
            'title' => 'Edit Video Pembelajaran',
            'mapel' => \App\Models\Mapel::all(),
            'video' => Video::find($id),
        ];

        return view('video.adminvideoedit', $data);
    }

    public function adminVideoUpdate(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'link' => 'required',
            'mapel' => 'required',
            'tingkat' => 'required',
        ]);

        $waktuIndonesia = new \DateTimeZone('Asia/Jakarta');
        $waktu = new \DateTime();
        $waktu->setTimezone($waktuIndonesia);

        Video::where('id', $id)->update([
            'judul' => $request->judul,
            'kode_pelajaran' => $request->mapel,
            'kode_admin' => auth()->user()->kode_admin,
            'tingkat' => $request->tingkat,
            'link' => $request->link,
            'updated_at' => $waktu->format('Y-m-d H:i:s'),
        ]);

        return redirect('/admin/video')->with('success', 'Video berhasil diubah');
    }

    public function adminVideoDestroy($id)
    {
        Video::where('id', $id)->delete();

        return redirect('/admin/video')->with('success', 'Video berhasil dihapus');
    }

    public function adminVideoDetail($id)
    {
        $data = [
            'video' => Video::find($id),
            'title' => 'Video Pembelajaran'
        ];

        return view('video.adminvideodetail', $data);
    }
}
