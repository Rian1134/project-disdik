<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Sekolah;
use App\Models\Siswa;

class PersetujuanSiswaController extends Controller
{
    /**
     * Halaman persetujuan: tab "Tambah" (siswa import baru) dan tab "Hapus" (pengajuan hapus).
     */
    public function index()
    {
        $menungguTambah = Siswa::menungguTambah()
            ->with('sekolah')
            ->orderBy('sekolah_id')
            ->orderBy('kelas')
            ->orderBy('nama_siswa')
            ->paginate(20, ['*'], 'tambah');

        $menungguHapus = Siswa::menungguHapus()
            ->with('sekolah')
            ->orderBy('hapus_diajukan_pada')
            ->paginate(20, ['*'], 'hapus');

        // Ringkasan per sekolah untuk tombol "Setujui semua".
        $ringkasanSekolah = Sekolah::query()
            ->withCount(['siswas as menunggu_count' => fn ($q) => $q->menungguTambah()])
            ->having('menunggu_count', '>', 0)
            ->get();

        // Lencana angka pada tab atas (siswa & pegawai). Tab yang sedang dibuka memakai total paginator.
        $jenis = 'siswa';
        $badgeSiswa = $menungguTambah->total() + $menungguHapus->total();
        $badgePegawai = Pegawai::menungguTambah()->count() + Pegawai::menungguHapus()->count();

        return view('admin.persetujuan.index', compact(
            'jenis', 'menungguTambah', 'menungguHapus', 'ringkasanSekolah', 'badgeSiswa', 'badgePegawai'
        ));
    }

    /** Setujui satu siswa import -> masuk ke daftar. */
    public function setujuiTambah(Siswa $siswa)
    {
        abort_unless($siswa->isMenungguTambah(), 404);

        $siswa->update(['status_persetujuan' => Siswa::STATUS_DISETUJUI]);

        return back()->with('success', "Siswa {$siswa->nama_siswa} disetujui dan masuk ke daftar.");
    }

    /** Tolak siswa import -> datanya dibuang. */
    public function tolakTambah(Siswa $siswa)
    {
        abort_unless($siswa->isMenungguTambah(), 404);

        $siswa->delete();

        return back()->with('success', "Siswa {$siswa->nama_siswa} ditolak dan dihapus dari antrean.");
    }

    /** Setujui semua siswa import yang menunggu pada satu sekolah. */
    public function setujuiSemuaTambah(Sekolah $sekolah)
    {
        $jumlah = Siswa::menungguTambah()
            ->where('sekolah_id', $sekolah->id)
            ->update(['status_persetujuan' => Siswa::STATUS_DISETUJUI]);

        return back()->with('success', "{$jumlah} siswa dari {$sekolah->nama_sekolah} disetujui.");
    }

    /** Setujui pengajuan hapus -> data benar-benar dihapus. */
    public function setujuiHapus(Siswa $siswa)
    {
        abort_unless($siswa->isMenungguHapus(), 404);

        $siswa->delete();

        return back()->with('success', "Siswa {$siswa->nama_siswa} dihapus.");
    }

    /** Tolak pengajuan hapus -> siswa tetap di daftar. */
    public function tolakHapus(Siswa $siswa)
    {
        abort_unless($siswa->isMenungguHapus(), 404);

        $siswa->update(['hapus_diajukan_pada' => null]);

        return back()->with('success', "Pengajuan hapus {$siswa->nama_siswa} ditolak.");
    }
}
