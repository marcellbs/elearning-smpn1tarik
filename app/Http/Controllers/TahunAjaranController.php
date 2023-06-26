<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index(){
        // mengambil semua tahunAjaran dan diurutkan berdasarkan tahun ajaran
        $tahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();
        $data = [
            'title' => 'Tahun Ajaran',
            'tahunAjaran' => $tahunAjaran
        ];

        return view('tahunajaran.index', $data);
    }

    // public function switchbox(Request $request, $id)
    // {
    //     $tahunAjaran = TahunAjaran::findOrFail($id);

    //     // Mengambil tahun ajaran yang sedang aktif (jika ada)
    //     $tahunAjaranAktif = TahunAjaran::where('status_aktif', 1)->first();

    //     // Memeriksa apakah ada tahun ajaran yang sedang aktif
    //     if ($tahunAjaranAktif) {
    //         // Mengubah status tahun ajaran yang sedang aktif menjadi tidak aktif
    //         $tahunAjaranAktif->status_aktif = 0;
    //         $tahunAjaranAktif->save();
    //     }

    //     // Mengubah status tahun ajaran yang dipilih
    //     $tahunAjaran->status_aktif = $request->status_aktif;
    //     $tahunAjaran->save();

    //     return response()->json(['message' => 'Status berhasil diperbarui.']);
    // }

    public function switchbox(Request $request, $id)
    {
        // Mendapatkan objek TahunAjaran berdasarkan ID
        $tahunAjaran = TahunAjaran::findOrFail($id);

        // Memperbarui status_aktif sesuai dengan nilai yang dikirim melalui permintaan
        $tahunAjaran->status_aktif = $request->status_aktif;

        // Menyimpan perubahan
        $tahunAjaran->save();

        // Menyiapkan data yang akan dikirim sebagai respons JSON
        $responseData = [
            'message' => 'Status berhasil diperbarui.',
            'statusHTML' => $tahunAjaran->status_aktif == 1 ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Nonaktif</span>'
        ];

        // Mengembalikan respons JSON
        return response()->json($responseData);
    }

    public function storeTahunAjaran(){
        // validasi data
        request()->validate([
            'tahun_ajaran' => 'required|unique:tahun_ajaran,tahun_ajaran',
        ],[
            'tahun_ajaran.required' => 'Kolom tahun ajaran harus diisi',
            'tahun_ajaran.unique' => 'Tahun ajaran sudah ada',
        ]);

        $tahunAjaran = new TahunAjaran();
        $tahunAjaran->tahun_ajaran = request('tahun_ajaran');
        $tahunAjaran->status_aktif = 0;
        $tahunAjaran->save();

        // mengembalikan halaman ke url /tahunajaran
        return redirect()->back()->with('sukses', "<strong>Berhasil !</strong> Tahun ajaran $tahunAjaran->tahun_ajaran berhasil ditambahkan");
    }

    public function updateTahunAjaran(){
        // validasi data
        request()->validate([
            'tahun_ajaran' => 'required|unique:tahun_ajaran,tahun_ajaran,'.request('id'),
        ],[
            'tahun_ajaran.required' => 'Kolom tahun ajaran harus diisi',
            'tahun_ajaran.unique' => 'Tahun ajaran sudah ada',
        ]);

        $tahunAjaran = TahunAjaran::findOrFail(request('id'));
        $tahunAjaran->tahun_ajaran = request('tahun_ajaran');
        $tahunAjaran->save();

        return redirect()->back()->with('sukses', "<strong>Berhasil !</strong> Tahun ajaran $tahunAjaran->tahun_ajaran berhasil diubah");
    }

    public function deleteTahunAjaran($id){
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->delete();

        return redirect()->back()->with('sukses', "<strong>Berhasil !</strong> Tahun ajaran $tahunAjaran->tahun_ajaran berhasil dihapus");
    }

}
