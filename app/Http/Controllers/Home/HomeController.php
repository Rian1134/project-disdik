<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Sekolah;
use App\Models\Siswa;

class HomeController extends Controller
{
    /* ------------------------------------------------------------------
     |  Landing page
     | ------------------------------------------------------------------ */
    public function index()
    {
        // Jika hanya ingin menghitung data yang sudah disetujui admin, ganti dengan baris di bawahnya.
        $pegawai = fn () => Pegawai::query();
        // $pegawai = fn () => Pegawai::where('status_persetujuan', 'disetujui');

        // Tenaga Pendidik (guru). "Guru" ikut dihitung karena dipakai di data seeder.
        $jabatanPendidik = ['Tenaga Pendidik', 'Guru'];

        $stats = [
            'siswa' => Siswa::count(),

            'pendidik' => $pegawai()->whereIn('jabatan', $jabatanPendidik)->count(),

            // Tenaga Kependidikan (TU, operator, pustakawan, dll.)
            'kependidikan' => $pegawai()->where('jabatan', 'Tenaga Kependidikan')->count(),

            'sekolah' => Sekolah::count(),
        ];

        // Data grafik ringkasan: [label => jumlah]
        $grafikKelas = Siswa::selectRaw("concat('Kelas ', substring_index(kelas, ' ', 1)) as label, count(*) as total")
            ->groupBy('label')->orderBy('label')->pluck('total', 'label');

        $statusPegawai = "coalesce(nullif(status_kepegawaian, ''), 'Tanpa status') as label, count(*) as total";

        $grafikPendidik = $pegawai()->whereIn('jabatan', $jabatanPendidik)
            ->selectRaw($statusPegawai)->groupBy('label')->pluck('total', 'label');

        $grafikKependidikan = $pegawai()->where('jabatan', 'Tenaga Kependidikan')
            ->selectRaw($statusPegawai)->groupBy('label')->pluck('total', 'label');

        $grafikSekolah = Sekolah::selectRaw('status_sekolah as label, count(*) as total')
            ->groupBy('label')->pluck('total', 'label');

        return view('landing.index', compact(
            'stats', 'grafikKelas', 'grafikPendidik', 'grafikKependidikan', 'grafikSekolah'
        ));
    }
}
