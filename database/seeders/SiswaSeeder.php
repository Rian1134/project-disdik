<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $sekolah = Sekolah::first();

        if (! $sekolah) {
            $this->command?->error('Belum ada data sekolah. Buat sekolah dulu sebelum menjalankan seeder ini.');

            return;
        }

        // [kelas, nama, jk, status_tempat_tinggal, pekerjaan ayah, penghasilan ayah, saudara, bantuan, status_pelajar, persetujuan, sumber, hapus_diajukan]
        // Pekerjaan ibu selalu "Ibu Rumah Tangga" (tanpa penghasilan); semua nilai sama dengan pilihan di template-siswa.xlsx.
        $data = [
            ['VII', 'Ahmad Fauzi', 'L', 'Rumah orang tua', 'Petani', '< Rp1 juta', 3, 'PIP', 'Aktif', 'disetujui', 'manual', false],
            ['VII', 'Siti Nurhaliza', 'P', 'Rumah orang tua', 'Wiraswasta', 'Rp1–3 juta', 2, 'Tidak Ada', 'Aktif', 'disetujui', 'manual', false],
            ['VII', 'Dimas Prasetyo', 'L', 'Wali', 'Buruh', '< Rp1 juta', 4, 'PIP', 'Aktif', 'disetujui', 'import', false],
            ['VIII', 'Putri Ayu Lestari', 'P', 'Rumah orang tua', 'PNS', 'Rp3–5 juta', 1, 'Tidak Ada', 'Aktif', 'disetujui', 'manual', false],
            ['VIII', 'Rizky Ramadhan', 'L', 'Asrama', 'Nelayan', 'Rp1–3 juta', 2, 'KIP', 'Aktif', 'disetujui', 'import', false],
            ['VIII', 'Anisa Rahmawati', 'P', 'Rumah orang tua', 'Karyawan Swasta', 'Rp3–5 juta', 1, 'Tidak Ada', 'Aktif', 'disetujui', 'manual', false],
            ['IX', 'Bagas Setiawan', 'L', 'Rumah orang tua', 'Lainnya', 'Rp1–3 juta', 2, 'PIP', 'Aktif', 'disetujui', 'import', false],
            ['IX', 'Dewi Kartika', 'P', 'Lainnya', 'Tidak bekerja', 'Rp 0', 0, 'KIP', 'Aktif', 'disetujui', 'manual', false],
            ['VII', 'Fajar Nugroho', 'L', 'Rumah orang tua', 'Petani', '< Rp1 juta', 5, 'PIP', 'Aktif', 'disetujui', 'import', false],
            ['IX', 'Maya Safitri', 'P', 'Rumah orang tua', 'Wiraswasta', 'Rp5–10 juta', 1, 'Tidak Ada', 'Aktif', 'disetujui', 'import', false],
            // - 15 data tambahan ---
            ['VII', 'Rendi Pratama', 'L', 'Rumah orang tua', 'Buruh', 'Rp1–3 juta', 3, 'PIP', 'Aktif', 'disetujui', 'manual', false],
            ['VII', 'Salsabila Putri', 'P', 'Rumah orang tua', 'Pedagang', 'Rp1–3 juta', 2, 'Tidak Ada', 'Aktif', 'disetujui', 'import', false],
            ['VIII', 'Andi Firmansyah', 'L', 'Kost', 'Karyawan Swasta', 'Rp1–3 juta', 1, 'Tidak Ada', 'Aktif', 'disetujui', 'manual', false],
            ['VIII', 'Nabila Zahra', 'P', 'Rumah orang tua', 'PNS', 'Rp3–5 juta', 1, 'Tidak Ada', 'Aktif', 'disetujui', 'import', false],
            ['VIII', 'Galih Permana', 'L', 'Rumah orang tua', 'Petani', 'Rp1–3 juta', 4, 'KIP', 'Aktif', 'disetujui', 'manual', false],
            ['IX', 'Intan Permatasari', 'P', 'Rumah orang tua', 'Lainnya', '< Rp1 juta', 3, 'PIP', 'Aktif', 'disetujui', 'import', false],
            ['IX', 'Raka Aditya', 'L', 'Asrama', 'Nelayan', 'Rp1–3 juta', 2, 'KIP', 'Aktif', 'disetujui', 'manual', false],
            ['IX', 'Citra Dewi', 'P', 'Rumah orang tua', 'Wiraswasta', 'Rp3–5 juta', 1, 'Tidak Ada', 'Aktif', 'disetujui', 'import', false],
            ['VII', 'Bayu Saputra', 'L', 'Wali', 'Buruh', '< Rp1 juta', 5, 'PIP', 'Aktif', 'disetujui', 'manual', false],
            ['VII', 'Melati Kusuma', 'P', 'Rumah orang tua', 'Guru', 'Rp3–5 juta', 1, 'Tidak Ada', 'Aktif', 'disetujui', 'import', false],
            ['VIII', 'Fikri Ardiansyah', 'L', 'Rumah orang tua', 'Karyawan Swasta', 'Rp1–3 juta', 2, 'Tidak Ada', 'Aktif', 'disetujui', 'manual', false],
            ['VIII', 'Ayu Wulandari', 'P', 'Lainnya', 'Tidak bekerja', 'Rp 0', 0, 'KIP', 'Aktif', 'disetujui', 'import', false],
            ['VIII', 'Hendra Wijaya', 'L', 'Rumah orang tua', 'Petani', '< Rp1 juta', 4, 'PIP', 'Aktif', 'disetujui', 'manual', false],
            ['IX', 'Sinta Maharani', 'P', 'Rumah orang tua', 'PNS', 'Rp3–5 juta', 1, 'Tidak Ada', 'Aktif', 'disetujui', 'import', false],
            ['IX', 'Doni Setiawan', 'L', 'Kost', 'Wiraswasta', 'Rp5–10 juta', 2, 'Tidak Ada', 'Aktif', 'disetujui', 'manual', false],
        ];

        foreach ($data as $i => $d) {
            $nomor = $i + 1;

            Siswa::updateOrCreate(
                ['sekolah_id' => $sekolah->id, 'nisn' => sprintf('00%08d', 20000 + $nomor)],
                [
                    'status_persetujuan' => $d[9],
                    'sumber' => $d[10],
                    'hapus_diajukan_pada' => $d[11] ? now() : null,
                    'nik' => sprintf('3201%012d', 100000 + $nomor),
                    'nama_siswa' => $d[1],
                    'kelas' => $d[0],
                    'jenis_kelamin' => $d[2],
                    'tempat_lahir' => ['Bandung', 'Bogor', 'Garut', 'Cianjur', 'Sukabumi'][$i % 5],
                    'tanggal_lahir' => now()->subYears(13 + intdiv($i, 4))->subDays($i * 17)->toDateString(),
                    'alamat' => 'Jl. Merdeka No. '.($nomor * 3),
                    'status_tempat_tinggal' => $d[3],
                    'nama_ayah' => 'Bapak '.explode(' ', $d[1])[0],
                    'nama_ibu' => 'Ibu '.explode(' ', $d[1])[0],
                    'pekerjaan_ayah' => $d[4],
                    'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                    'kisaran_penghasilan_ayah' => $d[5],
                    'kisaran_penghasilan_ibu' => 'Rp 0',
                    'jumlah_saudara' => $d[6],
                    'bantuan_pendidikan' => $d[7],
                    'status_pelajar' => $d[8],
                ]
            );
        }
    }
}
