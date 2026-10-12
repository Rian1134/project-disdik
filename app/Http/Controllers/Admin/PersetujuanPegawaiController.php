<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Sekolah;

class PersetujuanPegawaiController extends Controller
{
    /**
     * Halaman persetujuan: tab "Tambah" (pegawai import baru) dan tab "Hapus" (pengajuan hapus).
     */
    public function index()
    {
        $menungguTambah = Pegawai::menungguTambah()
            ->with('sekolah')
            ->orderBy('sekolah_id')
            ->orderBy('jabatan')
            ->orderBy('nama')
            ->paginate(20, ['*'], 'tambah');

        $menungguHapus = Pegawai::menungguHapus()
            ->with('sekolah')
            ->orderBy('hapus_diajukan_pada')
            ->paginate(20, ['*'], 'hapus');

        // Ringkasan per sekolah untuk tombol "Setujui semua".
        $ringkasanSekolah = Sekolah::query()
            ->withCount(['pegawais as menunggu_count' => fn ($q) => $q->menungguTambah()])
            ->having('menunggu_count', '>', 0)
            ->get();

        return view('admin.persetujuan-pegawai.index', compact('menungguTambah', 'menungguHapus', 'ringkasanSekolah'));
    }

    /** Setujui satu pegawai import -> masuk ke daftar. */
    public function setujuiTambah(Pegawai $pegawai)
    {
        abort_unless($pegawai->isMenungguTambah(), 404);

        $pegawai->update(['status_persetujuan' => Pegawai::STATUS_DISETUJUI]);

        return back()->with('success', "Pegawai {$pegawai->nama} disetujui dan masuk ke daftar.");
    }

    /** Tolak pegawai import -> datanya dibuang. */
    public function tolakTambah(Pegawai $pegawai)
    {
        abort_unless($pegawai->isMenungguTambah(), 404);

        $pegawai->delete();

        return back()->with('success', "Pegawai {$pegawai->nama} ditolak dan dihapus dari antrean.");
    }

    /** Setujui semua pegawai import yang menunggu pada satu sekolah. */
    public function setujuiSemuaTambah(Sekolah $sekolah)
    {
        $jumlah = Pegawai::menungguTambah()
            ->where('sekolah_id', $sekolah->id)
            ->update(['status_persetujuan' => Pegawai::STATUS_DISETUJUI]);

        return back()->with('success', "{$jumlah} pegawai dari {$sekolah->nama_sekolah} disetujui.");
    }

    /** Setujui pengajuan hapus -> data benar-benar dihapus. */
    public function setujuiHapus(Pegawai $pegawai)
    {
        abort_unless($pegawai->isMenungguHapus(), 404);

        $pegawai->delete();

        return back()->with('success', "Pegawai {$pegawai->nama} dihapus.");
    }

    /** Tolak pengajuan hapus -> pegawai tetap di daftar. */
    public function tolakHapus(Pegawai $pegawai)
    {
        abort_unless($pegawai->isMenungguHapus(), 404);

        $pegawai->update(['hapus_diajukan_pada' => null]);

        return back()->with('success', "Pengajuan hapus {$pegawai->nama} ditolak.");
    }
}
