<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\PengampuController;
use App\Http\Controllers\ElearningController;
use App\Http\Controllers\PelajaranController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\JawabantugasController;
use App\Http\Controllers\JadwalmengajarController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\TaskstudentsController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\JadwalOnlineController;
use App\Http\Controllers\TahunAjaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/admin', [AdminController::class, 'index'])->middleware('auth:webadmin');
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin')->middleware('guest');
Route::get('/admin/register', [AdminController::class, 'register']);

Route::resource('/admin/materi', MateriController::class)->middleware('auth:webadmin');
// Route::resource('admin/materi', MateriController::class)->middleware('auth:webguru');
Route::get('/admin/pengumuman', [AdminController::class, 'pengumuman'])->middleware('auth:webadmin');
Route::resource('/admin/kelas', KelasController::class)->middleware('auth:webadmin');
Route::get('/admin/tahun-ajaran', [TahunAjaranController::class, 'index'])->middleware('auth:webadmin');
// Route::put('/switch-tahun-ajaran/{id}', [TahunAjaranController::class, 'switchbox'])->name('tahun-ajaran.update');
Route::post('/admin/tahun-ajaran/switchbox/{id}', [TahunAjaranController::class, 'switchbox'])->name('tahunajaran.switchbox');
Route::post('/admin/tahun-ajaran', [TahunAjaranController::class, 'storeTahunAjaran'])->middleware('auth:webadmin')->name('tahunajaran.store');
Route::put('/admin/tahun-ajaran/{id}', [TahunAjaranController::class, 'updateTahunAjaran'])->middleware('auth:webadmin')->name('tahunajaran.update');
Route::delete('/admin/tahun-ajaran/{id}', [TahunAjaranController::class, 'deleteTahunAjaran'])->middleware('auth:webadmin')->name('tahunajaran.destroy');
// routes/web.php
Route::post('/naik-kelas', [AdminController::class,'naikKelas'])->name('naik-kelas');


Route::post('/admin/uploadkelas', [AdminController::class, 'uploadkelas'])->middleware('auth:webadmin');
Route::resource('/admin/mapel', PelajaranController::class)->middleware('auth:webadmin');
Route::resource('/admin/pengampu', PengampuController::class)->middleware('auth:webadmin');

Route::get('/admin/siswa', [AdminController::class, 'siswa'])->middleware('auth:webadmin');
Route::get('/admin/detailsiswa/{id}', [AdminController::class, 'detailsiswa'])->middleware('auth:webadmin');
Route::get('/admin/siswa/{id}/edit', [AdminController::class, 'editsiswa'])->middleware('auth:webadmin');
Route::patch('/admin/siswa/{id}', [AdminController::class, 'updatesiswa'])->middleware('auth:webadmin');
Route::get('/admin/tambahsiswa', [AdminController::class, 'tambahsiswa'])->middleware('auth:webadmin');
Route::post('/admin/tambahsiswa', [AdminController::class, 'submitsiswa'])->middleware('auth:webadmin');
Route::post('/admin/uploadsiswa', [AdminController::class, 'uploadsiswa'])->middleware('auth:webadmin');
Route::post('/admin/hapuskelassembilan', [AdminController::class, 'hapusSiswaKelasSembilan'])->middleware('auth:webadmin')->name('siswa.hapus.kelassembilan');
Route::delete('/admin/siswa/{id}', [AdminController::class, 'hapussiswa'])->middleware('auth:webadmin');
// Route::post('/naik-kelas', [AdminController::class, 'naikKelas'])->name('naik-kelas');
Route::post('/update-status', [AdminController::class, 'updateStatus'])->middleware('auth:webadmin');

Route::get('/admin/guru', [AdminController::class, 'guru'])->middleware('auth:webadmin');
Route::post('/admin/uploadguru', [AdminController::class, 'uploadguru'])->middleware('auth:webadmin');
Route::delete('/admin/guru/{id}', [AdminController::class, 'hapusguru'])->middleware('auth:webadmin');
Route::get('/admin/detailguru/{id}', [AdminController::class, 'detailguru'])->middleware('auth:webadmin');
Route::get('/admin/guru/{id}/edit', [AdminController::class, 'editguru'])->middleware('auth:webadmin');
Route::patch('/admin/guru/{id}', [AdminController::class, 'updateguru'])->middleware('auth:webadmin');
Route::get('/admin/tambahguru', [AdminController::class, 'tambahguru'])->middleware('auth:webadmin');
Route::post('/admin/tambahguru', [AdminController::class, 'submitguru'])->middleware('auth:webadmin');

Route::get('/admin/mapel', [AdminController::class, 'mapel'])->middleware('auth:webadmin');
Route::post('/admin/uploadmapel', [AdminController::class, 'uploadmapel'])->middleware('auth:webadmin');

// ===========================================================
// ===================== CRUD PROFILE ==========================
// ===========================================================
Route::get('/admin/profile', [AdminController::class, 'profile'])->middleware('auth:webadmin');
Route::patch('/admin/profile/{id}', [AdminController::class, 'updateProfile'])->middleware('auth:webadmin');
Route::patch('/admin/password/{id}', [AdminController::class, 'changePassword'])->middleware('auth:webadmin');

// ===========================================================
// ===================== CRUD PENGUMUMAN =====================
// ===========================================================

Route::post('/admin/createpengumuman', [AdminController::class, 'createPengumuman'])->middleware('auth:webadmin');
Route::patch(('/admin/pengumuman/{id}'), [AdminController::class, 'updatePengumuman'])->middleware('auth:webadmin');
Route::delete('/admin/pengumuman/{id}', [AdminController::class, 'destroyPengumuman'])->middleware('auth:webadmin');
Route::get('/admin/detail/{id}', [AdminController::class, 'detailPengumuman'])->middleware('auth:webadmin');

// ===========================================================
// ===================== END PENGUMUMAN ======================
// ===========================================================

Route::post('/admin/addRegister', [AdminController::class, 'addRegister']);
Route::post('/admin/auth', [AdminController::class, 'store']);
Route::get('/admin/logout', [AdminController::class, 'logout']);
Route::get('/admin/admin', [AdminController::class, 'admin'])->middleware('auth:webadmin');
Route::get('/admin/tambah', [AdminController::class, 'tambahadmin'])->middleware('auth:webadmin');
Route::post('/admin/tambah', [AdminController::class, 'submitadmin'])->middleware('auth:webadmin');
Route::get('/admin/editadmin/{id}/edit', [AdminController::class, 'editadmin'])->middleware('auth:webadmin');
Route::patch('/admin/editadmin/{id}', [AdminController::class, 'updateadmin'])->middleware('auth:webadmin');
Route::delete('/admin/admin/{id}', [AdminController::class, 'deleteadmin'])->middleware('auth:webadmin');
Route::get('/siswa/create', [SiswaController::class, 'create']);
Route::post('/siswa/store', [SiswaController::class, 'store']);

Route::get('/guru', [GuruController::class, 'index'])->middleware('auth:webguru');
Route::get('/guru/login', [GuruController::class, 'login'])->name('guru')->middleware('guest');
Route::post('/guru/auth', [GuruController::class, 'auth']);
Route::get('/guru/register', [GuruController::class, 'register']);
Route::post('/guru/register', [GuruController::class, 'save']);
Route::get('/guru/logout', [GuruController::class, 'logout']);

Route::get('/guru/tugas/report-excel', [TugasController::class, 'exportReport'])->middleware('auth:webguru')->name('tugas.export-excel');
Route::get('/guru/jadwal-mengajar', [JadwalmengajarController::class, 'index'])->middleware('auth:webguru');
Route::get('/guru/tugas/report', [TugasController::class, 'report'])->middleware('auth:webguru');
Route::get('/tugas/{tuga}/download-all', [TugasController::class, 'downloadAll'])->middleware('auth:webguru')->name('tugas.download-all');
Route::resource('/guru/tugas', TugasController::class)->middleware('auth:webguru');
Route::get('/guru/mapel', [GuruController::class, 'mapel'])->middleware('auth:webguru');
Route::get('/guru/detail/{id}', [GuruController::class, 'detail'])->middleware('auth:webguru');
Route::resource('/guru/pengampu', PengampuController::class)->middleware('auth:webguru');
Route::get('/guru/materi/shared', [MateriController::class, 'shared'])->middleware('auth:webguru');
Route::resource('/guru/materi', MateriController::class)->middleware('auth:webguru');
Route::get('/guru/materi/{id}/edit', [MateriController::class, 'edit'])->middleware('auth:webguru');
Route::patch('/guru/nilai/{id}', [TugasController::class, 'nilaiJawaban'])->middleware('auth:webguru');

Route::get('/guru/pengumuman/shared',[PengumumanController::class,'sharedNotice'])->middleware('auth:webguru');
Route::resource('/guru/pengumuman', PengumumanController::class)->middleware('auth:webguru');
Route::get('/guru/profile', [GuruController::class, 'profile'])->middleware('auth:webguru');
Route::patch('/guru/profile/{id}', [GuruController::class, 'changeProfile'])->middleware('auth:webguru');
Route::patch('/guru/password/{id}', [GuruController::class, 'changePassword'])->middleware('auth:webguru');

Route::get('/guru/presensi/{id}', [PresensiController::class, 'index'])->middleware('auth:webguru')->name('presensi.index');
Route::post('/guru/presensi', [PresensiController::class, 'storePresensi'])->middleware('auth:webguru')->name('presensi.store');
Route::get('/guru/presensi', [PresensiController::class, 'presensi'])->middleware('auth:webguru')->name('presensi');
Route::get('/load-options', [PresensiController::class, 'loadOptions'])->middleware('auth:webguru')->name('loadOptions');
// Route::get('/guru/presensi/{tanggalPresensi}/edit/{kodeKelas}', [PresensiController::class, 'editPresensi'])->middleware('auth:webguru')->name('presensi.edit');
Route::get('/guru/presensi/{tanggalPresensi}/edit/{kodeKelas}/{kodePelajaran}', [PresensiController::class, 'editPresensi'])->middleware('auth:webguru')->name('presensi.edit');
Route::patch('/guru/presensi/update', [PresensiController::class,'updatePresensi'])->middleware('auth:webguru')->name('presensi.update');
Route::get('/presensi/export/{kelas}/{mapel}/{tanggal}', [PresensiController::class, 'export'])->name('presensi.export');
Route::get('/guru/rekappresensi', [PresensiController::class, 'generateExcel'])->middleware('auth:webguru')->name('presensi.exports');

Route::get('/siswa', [SiswaController::class, 'index'])->middleware('auth:websiswa');
Route::get('/siswa/login', [SiswaController::class, 'login'])->name('siswa')->middleware('guest');
Route::post('/siswa/auth', [SiswaController::class, 'auth'])->middleware('guest');
Route::get('/siswa/register', [SiswaController::class, 'register']);
Route::post('/siswa/register', [SiswaController::class, 'save']);
Route::get('/siswa/logout', [SiswaController::class, 'logout']);
Route::get('/siswa/detail/{id}', [SiswaController::class, 'detail'])->middleware('auth:websiswa');
Route::resource('/siswa/materi', MateriController::class)->middleware('auth:websiswa');
Route::get('/guru/tugas/create/{id}', [TugasController::class, 'getKelas'])->middleware('auth:webguru');
Route::put('/guru/detail/{id}', [GuruController::class, 'updateLink'])->middleware('auth:webguru');

Route::resource('/siswa/tugas', TaskstudentsController::class)->middleware('auth:websiswa');
Route::resource('/siswa/jawabantugas', JawabantugasController::class)->middleware('auth:websiswa');
Route::get('/siswa/pengumuman', [SiswaController::class, 'pengumuman'])->middleware('auth:websiswa');
Route::get('/siswa/mapel', [SiswaController::class, 'mapel'])->middleware('auth:websiswa');
Route::get('/siswa/profile', [SiswaController::class, 'profile'])->middleware('auth:websiswa');
Route::get('/siswa/jadwal-online', [JadwalOnlineController::class, 'index'])->middleware('auth:websiswa');
Route::patch('/siswa/profile/{id}', [SiswaController::class, 'changeProfile'])->middleware('auth:websiswa');
Route::patch('/siswa/password/{id}', [SiswaController::class, 'changePassword'])->middleware('auth:websiswa');

Route::get('/kelas/getByTahunAjaran', [KelasController::class, 'getByTahunAjaran'])->middleware('auth:webguru')->name('kelas.getByTahunAjaran');
Route::get('/get-mapel', [TugasController::class, 'getMapel'])->middleware('auth:webguru')->name('get-mapel');
Route::get('/get-kelas', [TugasController::class,'getKelas'])->middleware('auth:webguru')->name('get-kelas');
Route::get('/', [ElearningController::class, 'index'])->middleware('guest');


