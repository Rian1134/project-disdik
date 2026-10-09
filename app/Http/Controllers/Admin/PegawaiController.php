<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\PegawaiImport;
use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     * Rekap jumlah pegawai per sekolah (sesuai format laporan).
     */
    public function index()
    {
        // guru_total / tu_total menghitung semua status (termasuk Non-ASN dan Lainnya)
        // supaya tidak ada pegawai yang terlewat di kolom Jumlah dan Total.
        $guru = "pegawais.jabatan = 'Tenaga Pendidik'";
        $tu = "pegawais.jabatan = 'Tenaga Kependidikan'";

        $sekolahs = Sekolah::leftJoin('pegawais', 'pegawais.sekolah_id', '=', 'sekolahs.id')
            ->selectRaw("
                sekolahs.id, sekolahs.nss, sekolahs.npsn, sekolahs.nama_sekolah,

                ifnull(sum($guru and pegawais.status_kepegawaian = 'PNS'), 0) as guru_pns,
                ifnull(sum($guru and pegawais.status_kepegawaian = 'PPPK'), 0) as guru_pppk,
                ifnull(sum($guru and pegawais.status_kepegawaian = 'PPPK Paruh Waktu'), 0) as guru_paruh,
                ifnull(sum($guru and pegawais.status_kepegawaian = 'Honorer'), 0) as guru_honorer,

                ifnull(sum($tu and pegawais.status_kepegawaian = 'PNS'), 0) as tu_pns,
                ifnull(sum($tu and pegawais.status_kepegawaian = 'PPPK'), 0) as tu_pppk,
                ifnull(sum($tu and pegawais.status_kepegawaian = 'PPPK Paruh Waktu'), 0) as tu_paruh,
                ifnull(sum($tu and pegawais.status_kepegawaian = 'Honorer'), 0) as tu_honorer,

                ifnull(sum($guru), 0) as guru_total,
                ifnull(sum($tu), 0) as tu_total
            ")
            ->groupBy('sekolahs.id', 'sekolahs.nss', 'sekolahs.npsn', 'sekolahs.nama_sekolah')
            ->orderBy('sekolahs.nama_sekolah')
            ->paginate(15);

        return view('admin.pegawai.index', compact('sekolahs'));
    }

    /**
     * Daftar pegawai pada satu sekolah.
     */
    public function sekolah(Sekolah $sekolah)
    {
        // Tidak memakai relasi $sekolah->pegawais() supaya model Sekolah tidak perlu diubah.
        $pegawais = Pegawai::where('sekolah_id', $sekolah->id)->orderBy('jabatan')->orderBy('nama')->paginate(15);

        return view('admin.pegawai.sekolah', compact('sekolah', 'pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolahs = Sekolah::orderBy('nama_sekolah')->pluck('nama_sekolah', 'id')->toArray();
        $opsi = $this->opsi();

        return view('admin.pegawai.create', compact('sekolahs', 'opsi'));
    }

    /**
     * Store a newly created resource in storage (isi manual).
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            ['sekolah_id' => ['required', 'exists:sekolahs,id']] + PegawaiImport::rules(),
            [],
            PegawaiImport::labels()
        );

        Pegawai::create($data);

        return redirect()->route('admin.pegawai.sekolah', $data['sekolah_id'])
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Import banyak pegawai dari file Excel (template-pegawai.xlsx).
     * Sekolah dipilih di form upload; seluruh pegawai di file masuk ke sekolah itu.
     */
    public function import(Request $request)
    {
        $request->validate([
            'sekolah_id' => ['required', 'exists:sekolahs,id'],
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [], ['sekolah_id' => 'Sekolah', 'file' => 'File Excel']);

        Excel::import(new PegawaiImport((int) $request->sekolah_id), $request->file('file'));

        return redirect()->route('admin.pegawai.sekolah', $request->sekolah_id)
            ->with('success', 'Data pegawai berhasil diimport dari Excel.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        $pegawai->load('sekolah');

        return view('admin.pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        $sekolahs = Sekolah::orderBy('nama_sekolah')->pluck('nama_sekolah', 'id')->toArray();
        $opsi = $this->opsi();

        return view('admin.pegawai.edit', compact('pegawai', 'sekolahs', 'opsi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $data = $request->validate(
            ['sekolah_id' => ['required', 'exists:sekolahs,id']] + PegawaiImport::rules(),
            [],
            PegawaiImport::labels()
        );

        $pegawai->update($data);

        return redirect()->route('admin.pegawai.sekolah', $pegawai->sekolah_id)
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        $sekolahId = $pegawai->sekolah_id;
        $pegawai->delete();

        return redirect()->route('admin.pegawai.sekolah', $sekolahId)
            ->with('success', 'Data pegawai berhasil dihapus.');
    }

    public function download()
    {
        // Sesuaikan path jika file berada di storage/app/public/files
        $path = storage_path('app/public/template/template-pegawai.xlsx');

        if (file_exists($path)) {
            return response()->download($path);
        }

        abort(404, 'File tidak ditemukan.');
    }

    /**
     * Pilihan dropdown untuk form (value => label).
     */
    private function opsi(): array
    {
        return [
            'jenis_kelamin' => ['L' => 'Laki-laki', 'P' => 'Perempuan'],
            'agama' => array_combine(Pegawai::AGAMA, Pegawai::AGAMA),
            'jabatan' => array_combine(Pegawai::JABATAN, Pegawai::JABATAN),
            'tugas' => array_combine(Pegawai::TUGAS, Pegawai::TUGAS),
            'status_kepegawaian' => array_combine(Pegawai::STATUS_KEPEGAWAIAN, Pegawai::STATUS_KEPEGAWAIAN),
            'pendidikan' => array_combine(Pegawai::PENDIDIKAN, Pegawai::PENDIDIKAN),
        ];
    }
}
