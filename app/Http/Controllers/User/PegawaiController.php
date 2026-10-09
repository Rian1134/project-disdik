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
     */
    public function index()
    {
        $sekolah = $this->sekolahSaya();
        $pegawais = Pegawai::where('sekolah_id', $sekolah->id)->orderBy('jabatan')->orderBy('nama')->paginate(15);

        return view('user.pegawai.index', compact('sekolah', 'pegawais'));
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
     */
    public function store(Request $request)
    {
        $sekolah = $this->sekolahSaya();

        $data = $request->validate(PegawaiImport::rules(), [], PegawaiImport::labels());

        Pegawai::create($data + ['sekolah_id' => $sekolah->id]);

        return redirect()->route('user.pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Import banyak pegawai dari file Excel (template-pegawai.xlsx) ke sekolah milik sendiri.
     */
    public function import(Request $request)
    {
        $sekolah = $this->sekolahSaya();

        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [], ['file' => 'File Excel']);

        Excel::import(new PegawaiImport($sekolah->id), $request->file('file'));

        return redirect()->route('user.pegawai.index')->with('success', 'Data pegawai berhasil diimport dari Excel.');
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
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        $this->pastikanMilikSendiri($pegawai);

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
     */
    private function pastikanMilikSendiri(Pegawai $pegawai): void
    {
        abort_unless($pegawai->sekolah_id === $this->sekolahSaya()->id, 403);
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