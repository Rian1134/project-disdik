<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SekolahController extends Controller
{
    /**
     * Tampilkan data sekolah milik user yang login.
     */
    public function index()
    {
        $sekolah = Sekolah::withCount('siswas')->where('user_id', Auth::id())->first();

        return view('user.sekolah.index', compact('sekolah'));
    }

    /**
     * Form tambah data sekolah (satu akun hanya boleh punya satu sekolah).
     */
    public function create()
    {
        if ($this->sudahPunyaSekolah()) {
            return redirect()->route('user.sekolah.index');
        }

        return view('user.sekolah.create');
    }

    /**
     * Simpan data sekolah baru, otomatis terhubung ke akun yang login.
     */
    public function store(Request $request)
    {
        if ($this->sudahPunyaSekolah()) {
            return redirect()->route('user.sekolah.index')->with('error', 'Akun Anda sudah memiliki data sekolah.');
        }

        Sekolah::create($this->validated($request) + ['user_id' => Auth::id()]);

        return redirect()->route('user.sekolah.index')->with('success', 'Data sekolah berhasil ditambahkan.');
    }

    /**
     * Form edit data sekolah (hanya sekolah milik sendiri).
     */
    public function edit(Sekolah $sekolah)
    {
        $this->pastikanMilikSendiri($sekolah);

        return view('user.sekolah.edit', compact('sekolah'));
    }

    /**
     * Simpan perubahan data sekolah.
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        $this->pastikanMilikSendiri($sekolah);

        $sekolah->update($this->validated($request, $sekolah));

        return redirect()->route('user.sekolah.index')->with('success', 'Data sekolah berhasil diperbarui.');
    }

    /**
     * User hanya boleh mengubah sekolah yang terhubung ke akunnya.
     */
    private function pastikanMilikSendiri(Sekolah $sekolah): void
    {
        abort_unless($sekolah->user_id === Auth::id(), 403);
    }

    private function sudahPunyaSekolah(): bool
    {
        return Sekolah::where('user_id', Auth::id())->exists();
    }

    /**
     * Aturan validasi untuk store & update (unique mengabaikan data sendiri saat update).
     */
    private function validated(Request $request, ?Sekolah $sekolah = null): array
    {
        return $request->validate([
            'nss' => ['required', 'string', Rule::unique('sekolahs', 'nss')->ignore($sekolah)],
            'npsn' => ['required', 'string', Rule::unique('sekolahs', 'npsn')->ignore($sekolah)],
            'nama_sekolah' => ['required', 'string', Rule::unique('sekolahs', 'nama_sekolah')->ignore($sekolah)],
            'nama_kepala_sekolah' => ['required', 'string'],
            'akreditasi' => ['required', 'string', 'size:1'],
            'status_sekolah' => ['required', 'string'],
            'tanggal_sk_pendirian' => ['required', 'string'],
            'tanggal_sk_izin_oprasional' => ['required', 'string'],
            'implementasi_kurikulum' => ['required', 'string'],

            'alamat' => ['required', 'string'],
            'rt_rw' => ['required', 'string'],
            'desa_kelurahan' => ['required', 'string'],
            'kecamatan' => ['required', 'string'],
            'kabupaten' => ['required', 'string'],
            'provinsi' => ['required', 'string'],
            'kode_pos' => ['required', 'string'],

            'laus_tanah' => ['required', 'integer'],
            'laus_bangunan' => ['required', 'integer'],
            'tipe_internet' => ['nullable', 'string'],
            'internet_provider' => ['nullable', 'string'],
            'bandwith_internet' => ['nullable', 'integer'],
            'sumber_listrik' => ['nullable', 'string'],
            'daya_listrik' => ['nullable', 'integer'],
            'sumber_air' => ['nullable', 'string'],
        ]);
    }
}