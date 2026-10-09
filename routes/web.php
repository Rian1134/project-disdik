<?php

use App\Http\Controllers\Admin\PegawaiController as AdminPegawaiController;
use App\Http\Controllers\Admin\SekolahController as AdminSekolahController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
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
