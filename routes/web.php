<?php

use App\Http\Controllers\Admin\PegawaiController as AdminPegawaiController;
use App\Http\Controllers\Admin\SekolahController as AdminSekolahController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\SekolahController as UserSekolahController;
use App\Http\Controllers\User\SiswaController as UserSiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.store');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('sekolah', AdminSekolahController::class);

    Route::resource('users', UserController::class);

    Route::resource('siswa', AdminSiswaController::class);
    Route::post('siswa/import', [AdminSiswaController::class, 'import'])->name('siswa.import');
    Route::get('siswa/sekolah/{sekolah}', [AdminSiswaController::class, 'sekolah'])->name('siswa.sekolah');
    Route::get('/files/download/template-siswa', [AdminSiswaController::class, 'download'])->name('files.download.siswa');

    Route::resource('pegawai', AdminPegawaiController::class);
    Route::post('pegawai/import', [AdminPegawaiController::class, 'import'])->name('pegawai.import');
    Route::get('pegawai/sekolah/{sekolah}', [AdminPegawaiController::class, 'sekolah'])->name('pegawai.sekolah');
    Route::get('/files/download/template-pegawai', [AdminPegawaiController::class, 'download'])->name('files.download.pegawai');

});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::resource('sekolah', UserSekolahController::class)->only(['index', 'create', 'store', 'edit', 'update']);

    Route::post('siswa/import', [UserSiswaController::class, 'import'])->name('siswa.import');
    Route::get('siswa/template', [UserSiswaController::class, 'download'])->name('siswa.download');
    Route::resource('siswa', UserSiswaController::class);
});
