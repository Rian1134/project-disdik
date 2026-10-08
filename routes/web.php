<?php

use App\Http\Controllers\Admin\SekolahController as AdminSekolahController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('sekolah', AdminSekolahController::class);
    Route::resource('siswa', AdminSiswaController::class);
    Route::post('siswa/import', [AdminSiswaController::class, 'import'])->name('siswa.import');
    Route::get('siswa/sekolah/{sekolah}', [AdminSiswaController::class, 'sekolah'])->name('siswa.sekolah');

    Route::get('/files/download', [AdminSiswaController::class, 'download'])->name('files.download');
});
