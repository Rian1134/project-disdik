<?php

use App\Http\Controllers\Admin\PegawaiController as AdminPegawaiController;
use App\Http\Controllers\Admin\PersetujuanPegawaiController;
use App\Http\Controllers\Admin\PersetujuanSiswaController;
use App\Http\Controllers\Admin\SekolahController as AdminSekolahController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\PegawaiController as UserPegawaiController;
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

    // Persetujuan siswa hasil import (tambah & hapus)
    Route::prefix('persetujuan-siswa')->name('persetujuan-siswa.')->group(function () {
        Route::get('/', [PersetujuanSiswaController::class, 'index'])->name('index');

        Route::post('tambah/{siswa}/setujui', [PersetujuanSiswaController::class, 'setujuiTambah'])->name('tambah.setujui');
        Route::post('tambah/{siswa}/tolak', [PersetujuanSiswaController::class, 'tolakTambah'])->name('tambah.tolak');
        Route::post('tambah/sekolah/{sekolah}/setujui-semua', [PersetujuanSiswaController::class, 'setujuiSemuaTambah'])->name('tambah.setujui-semua');

        Route::post('hapus/{siswa}/setujui', [PersetujuanSiswaController::class, 'setujuiHapus'])->name('hapus.setujui');
        Route::post('hapus/{siswa}/tolak', [PersetujuanSiswaController::class, 'tolakHapus'])->name('hapus.tolak');
    });

    // Persetujuan pegawai hasil import (tambah & hapus)
    Route::prefix('persetujuan-pegawai')->name('persetujuan-pegawai.')->group(function () {
        Route::get('/', [PersetujuanPegawaiController::class, 'index'])->name('index');

        Route::post('tambah/{pegawai}/setujui', [PersetujuanPegawaiController::class, 'setujuiTambah'])->name('tambah.setujui');
        Route::post('tambah/{pegawai}/tolak', [PersetujuanPegawaiController::class, 'tolakTambah'])->name('tambah.tolak');
        Route::post('tambah/sekolah/{sekolah}/setujui-semua', [PersetujuanPegawaiController::class, 'setujuiSemuaTambah'])->name('tambah.setujui-semua');

        Route::post('hapus/{pegawai}/setujui', [PersetujuanPegawaiController::class, 'setujuiHapus'])->name('hapus.setujui');
        Route::post('hapus/{pegawai}/tolak', [PersetujuanPegawaiController::class, 'tolakHapus'])->name('hapus.tolak');
    });

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

    Route::post('pegawai/import', [UserPegawaiController::class, 'import'])->name('pegawai.import');
    Route::get('pegawai/template', [UserPegawaiController::class, 'download'])->name('pegawai.download');
    Route::resource('pegawai', UserPegawaiController::class);
});
