<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Matericontroller;
use App\Http\Controllers\PengampuController;
use App\Http\Controllers\ElearningController;
use App\Http\Controllers\PelajaranController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\TugasController;

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

Route::get('/', [ElearningController::class, 'index'])->middleware('guest');


Route::get('/admin', [AdminController::class, 'index'])->middleware('auth:webadmin');
Route::resource('admin/materi', MateriController::class)->middleware('auth:webadmin');
// Route::resource('admin/materi', MateriController::class)->middleware('auth:webguru');
Route::get('/admin/pengumuman', [AdminController::class, 'pengumuman'])->middleware('auth:webadmin');
// Route::get('/admin/kelas', [AdminController::class, 'kelas'])->middleware('auth:webadmin');
Route::resource('/admin/kelas', KelasController::class)->middleware('auth:webadmin');
Route::resource('/admin/mapel', PelajaranController::class)->middleware('auth:webadmin');
Route::resource('/admin/pengampu', PengampuController::class)->middleware('auth:webadmin');
Route::get('/admin/siswa', [AdminController::class, 'siswa'])->middleware('auth:webadmin');
Route::get('/admin/guru', [AdminController::class, 'guru'])->middleware('auth:webadmin');
Route::get('/admin/mapel', [AdminController::class, 'mapel'])->middleware('auth:webadmin');
Route::get('/admin/profile', [AdminController::class, 'profile'])->middleware('auth:webadmin');
Route::post('/admin/createpengumuman', [AdminController::class, 'createPengumuman'])->middleware('auth:webadmin');

Route::get('/admin/register', [AdminController::class, 'register']);
Route::get('/admin/login', [AdminController::class, 'login'])->name('login')->middleware('guest');
Route::post('/admin/addRegister', [AdminController::class, 'addRegister']);
Route::post('/admin/auth', [AdminController::class, 'store']);
Route::get('/admin/logout', [AdminController::class, 'logout']);
Route::get('/admin/admin', [AdminController::class, 'admin'])->middleware('auth:webadmin');
Route::delete('/admin/pengumuman/{id}', [AdminController::class, 'destroyPengumuman'])->middleware('auth:webadmin');

Route::get('/siswa/create', [SiswaController::class, 'create']);
Route::post('/siswa/store', [SiswaController::class, 'store']);

Route::get('/guru', [GuruController::class, 'index'])->middleware('auth:webguru');
Route::get('/guru/login', [GuruController::class, 'login'])->name('login')->middleware('guest');
Route::post('/guru/auth', [GuruController::class, 'auth']);
Route::get('/guru/register', [GuruController::class, 'register']);
Route::post('/guru/register', [GuruController::class, 'save']);
Route::get('/guru/logout', [GuruController::class, 'logout']);
// route untuk menampilkan detail pengampu dari id yang sudah di hash
Route::get('/guru/detail/{id}', [GuruController::class, 'detail'])->middleware('auth:webguru');
Route::resource('/guru/pengampu', PengampuController::class)->middleware('auth:webguru');
Route::resource('/guru/tugas', TugasController::class)->middleware('auth:webguru');
Route::get('/guru/materi/shared', [MateriController::class, 'shared'])->middleware('auth:webguru');
Route::resource('/guru/materi', MateriController::class)->middleware('auth:webguru');


