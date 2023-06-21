<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            // pagination
            'kelas' => Kelas::paginate(10),
            'title' => 'Kelas',
        ];
        
        return view('admin.kelas', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric|unique:kelas,kode_kelas',
            'tingkat' => 'required',
            'kelas' => 'required|alpha|size:1|in:A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z',
        ],[
            'id.required' => 'ID tidak boleh kosong!',
            'id.numeric' => 'ID hanya boleh berisi angka!',
            'id.unique' => 'ID sudah ada!',
            'tingkat.required' => 'Tingkat tidak boleh kosong!',
            'kelas.required' => 'Kelas tidak boleh kosong!',
            'kelas.alpha' => 'Kelas hanya boleh berisi huruf!',
            'kelas.size' => 'Kelas hanya boleh berisi 1 huruf!',
            'kelas.in' => 'Kelas hanya boleh berisi huruf kapital A-Z!',
        ]);

        Kelas::create(
            [
                'kode_kelas' => $request->id,
                'nama_kelas' => $request->kelas,
                'kode_tingkat' => $request->tingkat,
                'kode_admin' => \Illuminate\Support\Facades\Auth::user()->kode_admin,
            ]
        );

        return redirect('/admin/kelas')->with('status', 'Data Kelas Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kela)
    {
        $data = [
            'kelas' => $kela,
            'title' => 'Edit Kelas',
        ];
    
        return view('admin.editkelas', $data);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'kode_kelas' => 'required|numeric',
            'nama_kelas' => 'required|alpha|size:1|in:A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z',
            'tingkat' => 'required',
        ],[
            'kode_kelas.required' => 'ID tidak boleh kosong!',
            'kode_kelas.numeric' => 'ID hanya boleh berisi angka!',
            'nama_kelas.required' => 'Kelas tidak boleh kosong!',
            'nama_kelas.alpha' => 'Kelas hanya boleh berisi huruf!',
            'nama_kelas.size' => 'Kelas hanya boleh berisi 1 huruf!',
            'nama_kelas.in' => 'Kelas hanya boleh berisi huruf kapital A-Z!',
            'tingkat.required' => 'Tingkat tidak boleh kosong!',
        ]);

        Kelas::where('kode_kelas', $kela->kode_kelas)
            ->update([
                'kode_kelas' => $request->kode_kelas,
                'nama_kelas' => $request->nama_kelas,
                'kode_tingkat' => $request->tingkat,
            ]);
        
        return redirect('/admin/kelas')->with('status', 'Data Kelas Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kela)
    {
        $kela->delete();

        return redirect('/admin/kelas')->with('status', 'Data Kelas Berhasil Dihapus!');
    }


    public function getByTahunAjaran(Request $request)
    {
        $tahunAjaranId = $request->input('tahun_ajaran_id');
        $kelasOptions = Kelas::select('kelas.kode_kelas', 'kelas.nama_kelas')
            ->join('pengampu', 'pengampu.kode_kelas', '=', 'kelas.kode_kelas')
            ->where('pengampu.kode_guru', auth()->user()->kode_guru)
            ->where('pengampu.kode_thajaran', $tahunAjaranId)
            ->distinct()
            ->pluck('kelas.nama_kelas', 'kelas.kode_kelas')
            ->toArray();
        

        return response()->json($kelasOptions);
    }


}
