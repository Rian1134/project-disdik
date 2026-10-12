<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Imports\PegawaiImport;
use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PegawaiController extends Controller
{
    /**
     * Daftar pegawai pada sekolah milik user yang login.
     * Hanya pegawai yang sudah disetujui admin yang tampil di daftar.
     */
    public function index()
    {
        $sekolah = $this->sekolahSaya();

        $pegawais = Pegawai::disetujui()
            ->where('sekolah_id', $sekolah->id)
            ->orderBy('jabatan')
            ->orderBy('nama')
            ->paginate(15);

        $jumlahMenunggu = Pegawai::menungguTambah()
            ->where('sekolah_id', $sekolah->id)
            ->count();

        return view('user.pegawai.index', compact('sekolah', 'pegawais', 'jumlahMenunggu'));
    }

    /**
     * Form tambah pegawai (upload Excel atau isi manual).
     */
    public function create()
    {
        $this->sekolahSaya();
        $opsi = $this->opsi();

        return view('user.pegawai.create', compact('opsi'));
    }

    /**
     * Simpan pegawai (isi manual) ke sekolah milik sendiri.
     * Isi manual langsung masuk daftar (tidak perlu persetujuan).
     */
    public function store(Request $request)
    {
        $sekolah = $this->sekolahSaya();

        $data = $request->validate(PegawaiImport::rules(), [], PegawaiImport::labels());

        Pegawai::create($data + [
            'sekolah_id' => $sekolah->id,
            'status_persetujuan' => Pegawai::STATUS_DISETUJUI,
            'sumber' => Pegawai::SUMBER_MANUAL,
        ]);

        return redirect()->route('user.pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Import banyak pegawai dari file Excel (template-pegawai.xlsx) ke sekolah milik sendiri.
     * Pegawai hasil import berstatus "menunggu" sampai disetujui admin.
     */
    public function import(Request $request)
    {
        $sekolah = $this->sekolahSaya();

        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [], ['file' => 'File Excel']);

        // Penanda: semua pegawai dengan id lebih besar dari ini dibuat oleh import ini.
        $idTerakhir = (int) Pegawai::max('id');

        Excel::import(new PegawaiImport($sekolah->id), $request->file('file'));

        $jumlah = Pegawai::query()
            ->where('sekolah_id', $sekolah->id)
            ->where('id', '>', $idTerakhir)
            ->update([
                'status_persetujuan' => Pegawai::STATUS_MENUNGGU,
                'sumber' => Pegawai::SUMBER_IMPORT,
            ]);

        return redirect()->route('user.pegawai.index')
            ->with('success', "{$jumlah} data pegawai berhasil diimport dan menunggu persetujuan admin sebelum masuk ke daftar.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        $this->pastikanMilikSendiri($pegawai);

        return view('user.pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        $this->pastikanMilikSendiri($pegawai);
        $opsi = $this->opsi();

        return view('user.pegawai.edit', compact('pegawai', 'opsi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $this->pastikanMilikSendiri($pegawai);

        $pegawai->update($request->validate(PegawaiImport::rules(), [], PegawaiImport::labels()));

        return redirect()->route('user.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Hapus pegawai.
     * - Pegawai hasil import: hanya mengajukan penghapusan, admin yang memutuskan.
     * - Pegawai isi manual: langsung dihapus.
     */
    public function destroy(Pegawai $pegawai)
    {
        $this->pastikanMilikSendiri($pegawai);

        if ($pegawai->isDariImport()) {
            if ($pegawai->isMenungguHapus()) {
                return redirect()->route('user.pegawai.index')
                    ->with('error', 'Pengajuan hapus untuk pegawai ini sudah dikirim dan menunggu admin.');
            }

            $pegawai->update(['hapus_diajukan_pada' => now()]);

            return redirect()->route('user.pegawai.index')
                ->with('success', 'Pengajuan hapus dikirim. Data akan dihapus setelah disetujui admin.');
        }

        $pegawai->delete();

        return redirect()->route('user.pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }

    public function download()
    {
        $path = storage_path('app/public/template/template-pegawai.xlsx');

        if (file_exists($path)) {
            return response()->download($path);
        }

        abort(404, 'File tidak ditemukan.');
    }

    /**
     * Sekolah milik user yang login. Kalau belum punya, arahkan ke form tambah sekolah.
     */
    private function sekolahSaya(): Sekolah
    {
        $sekolah = Sekolah::where('user_id', Auth::id())->first();

        if (! $sekolah) {
            throw new HttpResponseException(
                redirect()->route('user.sekolah.create')->with('error', 'Lengkapi data sekolah terlebih dahulu.')
            );
        }

        return $sekolah;
    }

    /**
     * User hanya boleh mengakses pegawai di sekolahnya sendiri.
     * Pegawai yang belum disetujui admin dianggap tidak ada (404).
     */
    private function pastikanMilikSendiri(Pegawai $pegawai): void
    {
        abort_unless($pegawai->sekolah_id === $this->sekolahSaya()->id, 403);
        abort_if($pegawai->isMenungguTambah(), 404);
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
