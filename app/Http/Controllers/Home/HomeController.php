<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    private const PER_HALAMAN = 15;

    /* ------------------------------------------------------------------
     |  Landing page
     | ------------------------------------------------------------------ */
    public function index()
    {
        // Jika hanya ingin menghitung data yang sudah disetujui admin, ganti dengan baris di bawahnya.
        $pegawai = fn () => Pegawai::query();
        // $pegawai = fn () => Pegawai::where('status_persetujuan', 'disetujui');

        $stats = [
            'siswa' => Siswa::count(),

            // Tenaga Pendidik (guru). "Guru" ikut dihitung karena dipakai di data seeder.
            'pendidik' => $pegawai()->whereIn('jabatan', ['Tenaga Pendidik', 'Guru'])->count(),

            // Tenaga Kependidikan (TU, operator, pustakawan, dll.)
            'kependidikan' => $pegawai()->where('jabatan', 'Tenaga Kependidikan')->count(),

            'sekolah' => Sekolah::count(),
        ];

        return view('landing.index', compact('stats'));
    }

    /* ------------------------------------------------------------------
     |  Daftar data publik (tanpa login)
     |
     |  Hanya kolom non-sensitif yang di-SELECT. NIP, NIK, NISN, alamat, tempat/tanggal
     |  lahir, golongan, pangkat, agama, dan nomor identitas lain SENGAJA tidak
     |  diambil dari database, jadi tidak mungkin ikut tampil walau view diubah.
     |
     |  Nama kolom dicari otomatis dari daftar kandidat agar tidak error bila
     |  nama kolom di tabel Anda berbeda (nama, nama_siswa, nama_sekolah, dst).
     | ------------------------------------------------------------------ */
    public function siswa(Request $request)
    {
        $cari = trim((string) $request->query('q', ''));
        [$namaSekolah, $relasi] = $this->relasiSekolah();

        // label tampilan => kandidat nama kolom di tabel siswa
        $peta = [
            'Nama' => $this->kolom(Siswa::class, ['nama', 'nama_siswa', 'nama_lengkap', 'nama_peserta_didik']),
            'Jenis Kelamin' => $this->kolom(Siswa::class, ['jenis_kelamin']),
            'Kelas' => $this->kolom(Siswa::class, ['kelas']),
        ];
        $peta = array_filter($peta); // buang yang kolomnya tidak ada

        $query = Siswa::query()
            ->with($relasi)
            ->select(array_merge(['id', 'sekolah_id'], array_values($peta)));
        // ->where('status_persetujuan', 'disetujui') // aktifkan jika hanya data yang sudah disetujui

        $kolomNama = $peta['Nama'] ?? null;

        if ($cari !== '' && $kolomNama) {
            $query->where($kolomNama, 'like', '%'.$cari.'%');
        }

        $data = $query->orderBy($kolomNama ?? 'id')
            ->paginate(self::PER_HALAMAN)
            ->withQueryString();

        $head = array_merge(array_keys($peta), ['Sekolah']);

        $rows = $data->getCollection()->map(function ($s) use ($peta, $namaSekolah) {
            $baris = [];
            foreach ($peta as $label => $kolom) {
                $baris[] = $this->format($label, $s->{$kolom});
            }
            $baris[] = $namaSekolah ? ($s->sekolah?->{$namaSekolah} ?? '-') : '-';

            return $baris;
        })->all();

        return $this->tampil('Data Siswa', 'bi-mortarboard-fill', $head, $rows, $data, $cari);
    }

    public function pegawai(Request $request)
    {
        $jenis = $request->query('jenis'); // pendidik | kependidikan | (kosong = semua)
        $cari = trim((string) $request->query('q', ''));
        [$namaSekolah, $relasi] = $this->relasiSekolah();

        $query = Pegawai::query()
            ->with($relasi)
            ->select(['id', 'sekolah_id', 'nama', 'jabatan', 'tugas', 'status_kepegawaian']);
        // ->where('status_persetujuan', 'disetujui') // aktifkan jika hanya data yang sudah disetujui

        if ($jenis === 'pendidik') {
            $query->whereIn('jabatan', ['Tenaga Pendidik', 'Guru']);
        } elseif ($jenis === 'kependidikan') {
            $query->where('jabatan', 'Tenaga Kependidikan');
        } else {
            $jenis = null;
        }

        if ($cari !== '') {
            $query->where('nama', 'like', '%'.$cari.'%');
        }

        $data = $query->orderBy('nama')->paginate(self::PER_HALAMAN)->withQueryString();

        $rows = $data->getCollection()->map(fn ($p) => [
            $p->nama,
            $p->jabatan ?: '-',
            $p->tugas ?: '-',
            $p->status_kepegawaian ?: '-',
            $namaSekolah ? ($p->sekolah?->{$namaSekolah} ?? '-') : '-',
        ])->all();

        $judul = match ($jenis) {
            'pendidik' => 'Data Tenaga Pendidik',
            'kependidikan' => 'Data Tenaga Kependidikan',
            default => 'Data Pegawai',
        };

        $tabs = [
            ['label' => 'Semua', 'url' => route('public.pegawai'), 'aktif' => $jenis === null],
            ['label' => 'Tenaga Pendidik', 'url' => route('public.pegawai', ['jenis' => 'pendidik']), 'aktif' => $jenis === 'pendidik'],
            ['label' => 'Tenaga Kependidikan', 'url' => route('public.pegawai', ['jenis' => 'kependidikan']), 'aktif' => $jenis === 'kependidikan'],
        ];

        return $this->tampil(
            $judul,
            'bi-person-badge-fill',
            ['Nama', 'Jabatan', 'Tugas', 'Status Kepegawaian', 'Sekolah'],
            $rows,
            $data,
            $cari,
            $tabs,
            $jenis
        );
    }

    public function sekolah(Request $request)
    {
        $cari = trim((string) $request->query('q', ''));
        [$namaSekolah] = $this->relasiSekolah();

        $query = Sekolah::query()->select($namaSekolah ? ['id', $namaSekolah] : ['id']);

        if ($cari !== '' && $namaSekolah) {
            $query->where($namaSekolah, 'like', '%'.$cari.'%');
        }

        $data = $query->orderBy($namaSekolah ?? 'id')->paginate(self::PER_HALAMAN)->withQueryString();

        $rows = $data->getCollection()
            ->map(fn ($s) => [$namaSekolah ? $s->{$namaSekolah} : 'Sekolah #'.$s->id])
            ->all();

        return $this->tampil('Data Sekolah', 'bi-building-fill', ['Nama Sekolah'], $rows, $data, $cari);
    }

    /* ------------------------------------------------------------------
     |  Helper
     | ------------------------------------------------------------------ */

    /** Ambil nama kolom pertama dari kandidat yang benar-benar ada di tabel model. */
    private function kolom(string $model, array $kandidat): ?string
    {
        $tabel = (new $model)->getTable();

        return collect($kandidat)->first(fn ($k) => Schema::hasColumn($tabel, $k));
    }

    /** Nama kolom "nama sekolah" + definisi eager load relasi sekolah. */
    private function relasiSekolah(): array
    {
        $nama = $this->kolom(Sekolah::class, ['nama', 'nama_sekolah', 'nama_satuan_pendidikan', 'nama_lengkap']);

        return [$nama, $nama ? "sekolah:id,{$nama}" : 'sekolah'];
    }

    private function format(string $label, mixed $nilai): string
    {
        if ($label === 'Jenis Kelamin') {
            return match (strtoupper((string) $nilai)) {
                'L' => 'Laki-laki',
                'P' => 'Perempuan',
                default => $nilai ?: '-',
            };
        }

        return (string) ($nilai ?: '-');
    }

    private function tampil(string $judul, string $ikon, array $head, array $rows, $paginator, string $cari, ?array $tabs = null, ?string $jenis = null)
    {
        return view('landing.data', compact('judul', 'ikon', 'head', 'rows', 'paginator', 'cari', 'tabs', 'jenis'));
    }
}
