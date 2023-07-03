<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use App\Models\Jadwal;
use App\Models\Pengampu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengampuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hash = new Hashids();

        // menampilkan pengampu dan relasinya ke jadwal
        // menampilkan data pengampu sekali dan jadwal yang ada di pengampu tersebut walaupun ada lebih dari satu
        $pengampu = Pengampu::with('jadwal', 'tahunAjaran')->orderBy('kode_thajaran', 'desc')->get();

        $data = [
            'pengampu' => $pengampu,
            'guru' => \App\Models\Guru::all(),
            'mapel' => \App\Models\Mapel::all(),
            'kelas' => \App\Models\Kelas::all(),
            'tahun_ajaran' => \App\Models\TahunAjaran::all(),
            'title' => 'Pengampu',
            'hash' => $hash,
        ];
        return view('admin.pengampu', $data);
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
            'guru' => 'required',
            'kelas' => 'required',
            'mapel' => 'required',
            'tahun_ajaran' => 'required'
        ],[
            'guru.required' => 'Kolom guru harus diisi',
            'kelas.required' => 'Kolom kelas harus diisi',
            'mapel.required' => 'Kolom pelajaran harus diisi',
            'tahun_ajaran.required' => 'Kolom tahun ajaran harus diisi',
        ]);

        // dd($request->all());
        $pengampu = new Pengampu();
        $pengampu->kode_guru = $request->guru;
        $pengampu->kode_kelas = $request->kelas;
        $pengampu->kode_pelajaran = $request->mapel;
        $pengampu->kode_thajaran = $request->tahun_ajaran;

        $pengampu->save();


        if ($request->has('hari') && is_array($request->hari)) {
            $hari = $request->hari;
            $jamMulai = $request->jam_mulai;
            $jamBerakhir = $request->jam_berakhir;

            foreach ($hari as $key => $h) {
                $jadwal = new \App\Models\Jadwal();
                $jadwal->kode_pengampu = $pengampu->id;
                $jadwal->hari = $h;
                $jadwal->jam_mulai = $jamMulai[$key];
                $jadwal->jam_berakhir = $jamBerakhir[$key];

                $jadwal->save();
            }
        }

        return redirect('/admin/pengampu')->with('sukses', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengampu  $pengampu
     * @return \Illuminate\Http\Response
     */
    public function show(Pengampu $pengampu)
    {
        // menampilkan siswa dengan status aktif saja
        foreach ($pengampu->kelas->siswa as $key => $siswa) {
            if ($siswa->status == 'Tidak Aktif') {
                unset($pengampu->kelas->siswa[$key]);
            }
        }

        $data = [
            'title' => 'Detail Pengampu',
            'pengampu' => $pengampu,
            'jadwal' => $pengampu->jadwal,
            'kelas_siswa' => \App\Models\Siswa:: join('kelas_siswa', 'siswa.kode_siswa', '=', 'kelas_siswa.kode_siswa')
            ->where('kelas_siswa.kode_kelas', $pengampu->kode_kelas)
            ->where('kelas_siswa.kode_thajaran', $pengampu->kode_thajaran)
            ->where('siswa.status', '1')
            ->orderBy('nis', 'asc')
            ->get(),
        ];
        
        return view('pengampu.detailpengampu', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengampu  $pengampu
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengampu $pengampu)
    {
        $jadwal = $pengampu->jadwal;
        $data = [
            'title' => 'Edit Pengampu',
            'pengampu' => $pengampu,
            'guru' => \App\Models\Guru::all(),
            'mapel' => \App\Models\Mapel::all(),
            'kelas' => \App\Models\Kelas::all(),
            'tahun_ajaran' => \App\Models\TahunAjaran::all(),
            'jadwal' => $jadwal,
        ];
        return view('pengampu.editpengampu', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengampu  $pengampu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengampu $pengampu)
    {
        $request->validate([
            'guru' => 'required',
            'kelas' => 'required',
            'mapel' => 'required',
            'tahun_ajaran' => 'required',
            'hari[]' => 'required',
            'jam_mulai[]' => 'required',
            'jam_berakhir[]' => 'required',

        ],[
            'guru.required' => 'Kolom guru harus diisi',
            'kelas.required' => 'Kolom kelas harus diisi',
            'mapel.required' => 'Kolom pelajaran harus diisi',
            'tahun_ajaran.required' => 'Kolom tahun ajaran harus diisi',
            'hari[].required' => 'Kolom hari harus diisi',
            'jam_mulai[].required' => 'Kolom jam mulai harus diisi',
            'jam_berakhir[].required' => 'Kolom jam berakhir harus diisi',
        ]); 

        // dd($request->all());

        $pengampu = Pengampu::findOrFail($pengampu->id);
        $pengampu->kode_guru = $request->guru;
        $pengampu->kode_kelas = $request->kelas;
        $pengampu->kode_pelajaran = $request->mapel;
        $pengampu->kode_thajaran = $request->tahun_ajaran;

        $pengampu->save();

        // Menghapus jadwal yang dihilangkan dari form
        if ($request->has('jadwal_id') && is_array($request->jadwal_id)) {
            $jadwalIDs = $request->jadwal_id;

            // Menghapus jadwal yang tidak ada dalam array jadwal_id dari form
            $pengampu->jadwal()->whereNotIn('id', $jadwalIDs)->delete();
        } else {
            // Jika tidak ada jadwal yang dikirimkan, hapus semua jadwal
            $pengampu->jadwal()->delete();
        }

        // Simpan jadwal yang diubah atau ditambahkan
        if ($request->has('hari') && is_array($request->hari)) {
            $hari = $request->hari;
            $jamMulai = $request->jam_mulai;
            $jamBerakhir = $request->jam_berakhir;
            $jadwalIds = $request->jadwal_id; // ID jadwal yang ada di form

            foreach ($hari as $key => $h) {
                if (isset($jadwalIds[$key])) {
                    // Jadwal yang diubah
                    $jadwal = Jadwal::find($jadwalIds[$key]);
                    $jadwal->hari = $h;
                    $jadwal->jam_mulai = $jamMulai[$key];
                    $jadwal->jam_berakhir = $jamBerakhir[$key];
                    // tambahkan atribut jadwal lainnya sesuai kebutuhan
                    $jadwal->save();
                } else {
                    // Jadwal baru
                    $jadwal = new Jadwal();
                    $jadwal->kode_pengampu = $pengampu->id;
                    $jadwal->hari = $h;
                    $jadwal->jam_mulai = $jamMulai[$key];
                    $jadwal->jam_berakhir = $jamBerakhir[$key];
                    // tambahkan atribut jadwal lainnya sesuai kebutuhan
                    $jadwal->save();
                }
            }
        }

        return redirect('/admin/pengampu')->with('sukses', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengampu  $pengampu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengampu $pengampu)
    {
        $pengampu->delete();
        return redirect('/admin/pengampu')->with('sukses', 'Data berhasil dihapus');
    }
}
