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
     * Tampilkan profil sekolah milik user yang login.
     */
    public function index()
    {
        $sekolah = Sekolah::withCount('siswas')->where('user_id', Auth::id())->first();

        $siswas = $sekolah?->siswas()->orderBy('nama_siswa')->get();
        $pegawais = $sekolah?->pegawais()->orderBy('nama')->get();
        $prestasis = $sekolah?->prestasis()->orderBy('id')->get();

        $grafikJk = $sekolah?->siswas()
            ->selectRaw("if(jenis_kelamin = 'L', 'Laki-laki', 'Perempuan') as label, count(*) as total")
            ->groupBy('label')->pluck('total', 'label');
        $grafikKelas = $sekolah?->siswas()
            ->selectRaw("concat('Kelas ', substring_index(kelas, ' ', 1)) as label, count(*) as total")
            ->groupBy('label')->orderByRaw("field(label, 'Kelas VII', 'Kelas VIII', 'Kelas IX')")->pluck('total', 'label');

        $grafikJabatan = $sekolah?->pegawais()
            ->selectRaw('jabatan as label, count(*) as total')->groupBy('label')->pluck('total', 'label');
        $grafikGolongan = $sekolah?->pegawais()
            ->selectRaw("coalesce(nullif(golongan, ''), 'Tanpa golongan') as label, count(*) as total")
            ->groupBy('label')->pluck('total', 'label');
        $grafikStatus = $sekolah?->pegawais()
            ->selectRaw('status_kepegawaian as label, count(*) as total')->groupBy('label')->pluck('total', 'label');

        // Jumlah guru per mata pelajaran (hanya tugas Guru Mapel), terbanyak di atas
        $grafikMapel = $sekolah?->pegawais()
            ->where('tugas', 'Guru Mapel')
            ->whereNotNull('mata_pelajaran')
            ->where('mata_pelajaran', '!=', '')
            ->selectRaw('mata_pelajaran as label, count(*) as total')
            ->groupBy('label')->orderByDesc('total')->orderBy('label')->pluck('total', 'label');

        return view('user.sekolah.index', compact(
            'sekolah', 'siswas', 'pegawais', 'prestasis',
            'grafikJk', 'grafikKelas', 'grafikJabatan', 'grafikGolongan', 'grafikStatus', 'grafikMapel'
        ));
    }

    /**
     * Form tambah profil sekolah (satu akun hanya boleh punya satu sekolah).
     */
    public function create()
    {
        if ($this->sudahPunyaSekolah()) {
            return redirect()->route('user.sekolah.index');
        }

        return view('user.sekolah.create');
    }

    /**
     * Simpan profil sekolah baru, otomatis terhubung ke akun yang login.
     */
    public function store(Request $request)
    {
        if ($this->sudahPunyaSekolah()) {
            return redirect()->route('user.sekolah.index')->with('error', 'Akun Anda sudah memiliki profil sekolah.');
        }

        $sekolah = Sekolah::create($this->validated($request) + ['user_id' => Auth::id()]);
        $this->simpanPrestasi($sekolah, $request);

        return redirect()->route('user.sekolah.index')->with('success', 'Profil sekolah berhasil ditambahkan.');
    }

    /**
     * Form edit profil sekolah (hanya sekolah milik sendiri).
     */
    public function edit(Sekolah $sekolah)
    {
        $this->pastikanMilikSendiri($sekolah);

        return view('user.sekolah.edit', compact('sekolah'));
    }

    /**
     * Simpan perubahan profil sekolah.
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        $this->pastikanMilikSendiri($sekolah);

        $sekolah->update($this->validated($request, $sekolah));
        $this->simpanPrestasi($sekolah, $request);

        return redirect()->route('user.sekolah.index')->with('success', 'Profil sekolah berhasil diperbarui.');
    }

    /**
     * User hanya boleh mengubah sekolah yang terhubung ke akunnya.
     */
    private function pastikanMilikSendiri(Sekolah $sekolah): void
    {
        abort_unless($sekolah->user_id === Auth::id(), 403);
    }

    /**
     * Prestasi dikirim sebagai baris berulang (jenis_prestasi[] & nama_prestasi[]);
     * daftar lama diganti dengan yang baru, baris kosong dilewati.
     */
    private function simpanPrestasi(Sekolah $sekolah, Request $request): void
    {
        $sekolah->prestasis()->delete();

        foreach ((array) $request->input('nama_prestasi') as $i => $nama) {
            $nama = trim((string) $nama);

            if ($nama === '') {
                continue;
            }

            $sekolah->prestasis()->create([
                'jenis' => $request->input("jenis_prestasi.$i") === 'Non-Akademik' ? 'Non-Akademik' : 'Akademik',
                'prestasi' => mb_substr($nama, 0, 255),
            ]);
        }
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
            'visi' => ['nullable', 'string'],
            'misi' => ['nullable', 'string'],

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
