<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Rekap jumlah siswa per sekolah (sesuai format laporan).
     */
    public function index()
    {
        // Kelas disimpan sebagai angka: 7, 8, 9 (boleh diikuti rombel, mis. "7A" atau "7 A").
        // Angka romawi (VII, VIII, IX) tetap dikenali supaya data lama tidak hilang.
        $vii = "siswas.kelas regexp '^(7|VII([^I]|$))'";
        $viii = "siswas.kelas regexp '^(8|VIII)'";
        $ix = "siswas.kelas regexp '^(9|IX)'";

        $sekolahs = Sekolah::leftJoin('siswas', 'siswas.sekolah_id', '=', 'sekolahs.id')
            ->selectRaw("
                sekolahs.id, sekolahs.nss, sekolahs.npsn, sekolahs.nama_sekolah,

                count(distinct case when $vii then siswas.kelas end) as vii_rombel,
                ifnull(sum($vii and siswas.jenis_kelamin = 'L'), 0) as vii_l,
                ifnull(sum($vii and siswas.jenis_kelamin = 'P'), 0) as vii_p,

                count(distinct case when $viii then siswas.kelas end) as viii_rombel,
                ifnull(sum($viii and siswas.jenis_kelamin = 'L'), 0) as viii_l,
                ifnull(sum($viii and siswas.jenis_kelamin = 'P'), 0) as viii_p,

                count(distinct case when $ix then siswas.kelas end) as ix_rombel,
                ifnull(sum($ix and siswas.jenis_kelamin = 'L'), 0) as ix_l,
                ifnull(sum($ix and siswas.jenis_kelamin = 'P'), 0) as ix_p,

                count(distinct siswas.kelas) as total_rombel,
                ifnull(sum(siswas.jenis_kelamin = 'L'), 0) as total_l,
                ifnull(sum(siswas.jenis_kelamin = 'P'), 0) as total_p
            ")
            ->groupBy('sekolahs.id', 'sekolahs.nss', 'sekolahs.npsn', 'sekolahs.nama_sekolah')
            ->orderBy('sekolahs.nama_sekolah')
            ->paginate(15);

        return view('admin.siswa.index', compact('sekolahs'));
    }

    /**
     * Daftar siswa pada satu sekolah.
     */
    public function sekolah(Sekolah $sekolah)
    {
        $siswas = $sekolah->siswas()->orderBy('kelas')->orderBy('nama_siswa')->paginate(15);

        return view('admin.siswa.sekolah', compact('sekolah', 'siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sekolahs = Sekolah::orderBy('nama_sekolah')->pluck('nama_sekolah', 'id')->toArray();
        $opsi = $this->opsi();

        return view('admin.siswa.create', compact('sekolahs', 'opsi'));
    }

    /**
     * Store a newly created resource in storage (isi manual).
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            ['sekolah_id' => ['required', 'exists:sekolahs,id']] + SiswaImport::rules(),
            [],
            SiswaImport::labels()
        );

        Siswa::create($data);

        return redirect()->route('admin.siswa.sekolah', $data['sekolah_id'])
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Import banyak siswa dari file Excel (template Template_Data_Siswa_web.xlsx).
     */
    public function import(Request $request)
    {
        $request->validate([
            'sekolah_id' => ['required', 'exists:sekolahs,id'],
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [], ['sekolah_id' => 'Sekolah', 'file' => 'File Excel']);

        Excel::import(new SiswaImport((int) $request->sekolah_id), $request->file('file'));

        return redirect()->route('admin.siswa.sekolah', $request->sekolah_id)
            ->with('success', 'Data siswa berhasil diimport dari Excel.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load('sekolah');
        $sekolahs = Sekolah::orderBy('nama_sekolah')->pluck('nama_sekolah', 'id')->toArray();
        $opsi = $this->opsi();

        return view('admin.siswa.show', compact('siswa', 'sekolahs', 'opsi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $sekolahs = Sekolah::orderBy('nama_sekolah')->pluck('nama_sekolah', 'id')->toArray();
        $opsi = $this->opsi();

        return view('admin.siswa.edit', compact('siswa', 'sekolahs', 'opsi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $data = $request->validate(
            ['sekolah_id' => ['required', 'exists:sekolahs,id']] + SiswaImport::rules(),
            [],
            SiswaImport::labels()
        );

        $siswa->update($data);

        return redirect()->route('admin.siswa.sekolah', $siswa->sekolah_id)
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $sekolahId = $siswa->sekolah_id;
        $siswa->delete();

        return redirect()->route('admin.siswa.sekolah', $sekolahId)
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