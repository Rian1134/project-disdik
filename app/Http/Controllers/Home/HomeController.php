<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Sekolah;
use App\Models\Siswa;

class HomeController extends Controller
{
    public function index()
    {
        // Jika hanya ingin menghitung data yang sudah disetujui admin, ganti dengan baris di bawahnya.
        $pegawai = fn () => Pegawai::query();
        // $pegawai = fn () => Pegawai::where('status_persetujuan', 'disetujui');

        $stats = [
            'siswa' => Siswa::count(),

            // Tenaga Pendidik (guru). "Guru" ikut dihitung karena dipakai di data seeder.
            'pendidik' => $pegawai()->whereIn('jabatan', ['Tenaga Pendidik', 'Guru'])->count(),

            // Tenaga Kependidikan (TU, operator, pustakawan, dll.)
            'kependidikan' => $pegawai()->where('jabatan', 'Tenaga Kependidikan')->count(),

            'sekolah' => Sekolah::count(),
        ];

        return view('landing.index', compact('stats'));
    }
}
