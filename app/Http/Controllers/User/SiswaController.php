<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Daftar siswa pada sekolah milik user yang login.
     */
    public function index()
    {
        $sekolah = $this->sekolah();
        $siswas = $sekolah->siswas()->orderBy('kelas')->orderBy('nama_siswa')->paginate(15);

        return view('user.siswa.index', compact('sekolah', 'siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opsi = $this->opsi();

        return view('user.siswa.create', compact('opsi'));
    }

    /**
     * Store a newly created resource in storage (isi manual).
     */
    public function store(Request $request)
    {
        $data = $request->validate(SiswaImport::rules(), [], SiswaImport::labels());

        // sekolah_id tidak diisi dari form, selalu sekolah milik user.
        $data['sekolah_id'] = $this->sekolah()->id;

        Siswa::create($data);

        return redirect()->route('user.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Import banyak siswa dari file Excel (template Template_Data_Siswa_web.xlsx).
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [], ['file' => 'File Excel']);

        Excel::import(new SiswaImport($this->sekolah()->id), $request->file('file'));

        return redirect()->route('user.siswa.index')
            ->with('success', 'Data siswa berhasil diimport dari Excel.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $this->pastikanMilikSendiri($siswa);

        return view('user.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $this->pastikanMilikSendiri($siswa);

        $opsi = $this->opsi();

        return view('user.siswa.edit', compact('siswa', 'opsi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $this->pastikanMilikSendiri($siswa);

        $data = $request->validate(SiswaImport::rules(), [], SiswaImport::labels());

        $siswa->update($data);

        return redirect()->route('user.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $this->pastikanMilikSendiri($siswa);

        $siswa->delete();

        return redirect()->route('user.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function download()
    {
        // Sesuaikan path jika file berada di storage/app/public/files
        $path = storage_path('app/public/template/template-siswa.xlsx');

        if (file_exists($path)) {
            return response()->download($path);
        }

        abort(404, 'File tidak ditemukan.');
    }

    /**
     * Sekolah milik user yang login (tabel sekolahs punya kolom user_id).
     */
    private function sekolah(): Sekolah
    {
        $sekolah = Sekolah::where('user_id', auth()->id())->first();

        abort_if(! $sekolah, 403, 'Akun kamu belum terhubung dengan sekolah.');

        return $sekolah;
    }

    /**
     * User hanya boleh mengakses siswa di sekolahnya sendiri.
     */
    private function pastikanMilikSendiri(Siswa $siswa): void
    {
        abort_unless((int) $siswa->sekolah_id === (int) $this->sekolah()->id, 403);
    }

    /**
     * Pilihan dropdown untuk form (value => label).
     */
    private function opsi(): array
    {
        return [
            'jenis_kelamin' => ['L' => 'Laki-laki', 'P' => 'Perempuan'],
            'status_tempat_tinggal' => array_combine(Siswa::STATUS_TEMPAT_TINGGAL, Siswa::STATUS_TEMPAT_TINGGAL),
            'pekerjaan' => array_combine(Siswa::PEKERJAAN, Siswa::PEKERJAAN),
            'penghasilan' => array_combine(Siswa::PENGHASILAN, Siswa::PENGHASILAN),
            'bantuan' => array_combine(Siswa::BANTUAN, Siswa::BANTUAN),
            'status_pelajar' => array_combine(Siswa::STATUS_PELAJAR, Siswa::STATUS_PELAJAR),
        ];
    }
}