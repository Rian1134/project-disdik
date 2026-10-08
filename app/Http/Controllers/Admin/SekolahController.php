<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sekolahs = Sekolah::withCount('siswas')->orderBy('nama_sekolah')->paginate(15);

        return view('admin.sekolah.index', compact('sekolahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::pluck('name', 'id')->toArray();

        return view('admin.sekolah.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Sekolah::create($this->validated($request));

        return redirect()->route('admin.sekolah.index')->with('success', 'Data sekolah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sekolah $sekolah)
    {
        $sekolah->loadCount('siswas');

        return view('admin.sekolah.show', compact('sekolah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sekolah $sekolah)
    {
        $users = User::pluck('name', 'id')->toArray();

        return view('admin.sekolah.edit', compact('sekolah', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        $sekolah->update($this->validated($request, $sekolah));

        return redirect()->route('admin.sekolah.index')->with('success', 'Data sekolah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sekolah $sekolah)
    {
        $sekolah->delete();

        return redirect()->route('admin.sekolah.index')->with('success', 'Data sekolah berhasil dihapus.');
    }

    /**
     * Aturan validasi untuk store & update (unique mengabaikan data sendiri saat update).
     */
    private function validated(Request $request, ?Sekolah $sekolah = null): array
    {
        return $request->validate([
            'user_id' => ['required', 'exists:users,id'],
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
            'tipe_internet' => ['required', 'integer'],
            'internet_provider' => ['required', 'integer'],
            'bandwith_internet' => ['required', 'integer'],
            'sumber_listrik' => ['required', 'string'],
            'daya_listrik' => ['required', 'integer'],
            'sumber_air' => ['required', 'string'],
        ]);
    }
}