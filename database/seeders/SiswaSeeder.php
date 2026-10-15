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

        // [kelas, nama, jk, status_tempat_tinggal, pekerjaan ayah, pekerjaan ibu, penghasilan, saudara, bantuan, status_pelajar, persetujuan, sumber, hapus_diajukan]
        $data = [
            ['7', 'Ahmad Fauzi',        'L', 'Bersama orang tua', 'Petani',           'Ibu rumah tangga', 'Kurang dari Rp1.000.000',      3, 'PIP',   'Aktif', 'disetujui', 'manual', false],
            ['7', 'Siti Nurhaliza',     'P', 'Bersama orang tua', 'Wiraswasta',       'Pedagang',         'Rp1.000.000 - Rp2.000.000',    2, 'Tidak', 'Aktif', 'disetujui', 'manual', false],
            ['7', 'Dimas Prasetyo',     'L', 'Wali',              'Buruh',            'Buruh',            'Kurang dari Rp1.000.000',      4, 'PIP',   'Aktif', 'disetujui', 'import', false],
            ['8', 'Putri Ayu Lestari',  'P', 'Bersama orang tua', 'PNS',              'Guru',             'Rp3.000.000 - Rp5.000.000',    1, 'Tidak', 'Aktif', 'disetujui', 'manual', false],
            ['8', 'Rizky Ramadhan',     'L', 'Asrama',            'Nelayan',          'Ibu rumah tangga', 'Rp1.000.000 - Rp2.000.000',    2, 'KIP',   'Aktif', 'disetujui', 'import', false],
            ['8', 'Anisa Rahmawati',    'P', 'Bersama orang tua', 'Karyawan swasta',  'Karyawan swasta',  'Rp3.000.000 - Rp5.000.000',    1, 'Tidak', 'Aktif', 'disetujui', 'manual', false],
            ['9', 'Bagas Setiawan',     'L', 'Bersama orang tua', 'Sopir',            'Pedagang',         'Rp2.000.000 - Rp3.000.000',    2, 'PIP',   'Aktif', 'disetujui', 'import', false],
            ['9', 'Dewi Kartika',       'P', 'Panti asuhan',      'Tidak bekerja',    'Tidak bekerja',    'Tidak berpenghasilan',         0, 'KIP',   'Aktif', 'disetujui', 'manual', false],
            ['7', 'Fajar Nugroho',      'L', 'Bersama orang tua', 'Petani',           'Petani',           'Kurang dari Rp1.000.000',      5, 'PIP',   'Aktif', 'disetujui',  'import', false],
            ['9', 'Maya Safitri',       'P', 'Bersama orang tua', 'Wiraswasta',       'Guru',             'Lebih dari Rp5.000.000',       1, 'Tidak', 'Aktif', 'disetujui',  'import', false],
            // - 15 data tambahan ---
            ['7', 'Rendi Pratama',      'L', 'Bersama orang tua', 'Buruh',            'Ibu rumah tangga', 'Rp1.000.000 - Rp2.000.000',    3, 'PIP',   'Aktif', 'disetujui', 'manual', false],
            ['7', 'Salsabila Putri',    'P', 'Bersama orang tua', 'Pedagang',         'Pedagang',         'Rp2.000.000 - Rp3.000.000',    2, 'Tidak', 'Aktif', 'disetujui', 'import', false],
            ['8', 'Andi Firmansyah',    'L', 'Kos',               'Karyawan swasta',  'Ibu rumah tangga', 'Rp2.000.000 - Rp3.000.000',    1, 'Tidak', 'Aktif', 'disetujui', 'manual', false],
            ['8', 'Nabila Zahra',       'P', 'Bersama orang tua', 'PNS',              'PNS',              'Rp3.000.000 - Rp5.000.000',    1, 'Tidak', 'Aktif', 'disetujui', 'import', false],
            ['8', 'Galih Permana',      'L', 'Bersama orang tua', 'Petani',           'Pedagang',         'Rp1.000.000 - Rp2.000.000',    4, 'KIP',   'Aktif', 'disetujui', 'manual', false],
            ['9', 'Intan Permatasari',  'P', 'Bersama orang tua', 'Sopir',            'Ibu rumah tangga', 'Kurang dari Rp1.000.000',      3, 'PIP',   'Aktif', 'disetujui', 'import', false],
            ['9', 'Raka Aditya',        'L', 'Asrama',            'Nelayan',          'Nelayan',          'Rp1.000.000 - Rp2.000.000',    2, 'KIP',   'Aktif', 'disetujui', 'manual', false],
            ['9', 'Citra Dewi',         'P', 'Bersama orang tua', 'Wiraswasta',       'Wiraswasta',       'Rp3.000.000 - Rp5.000.000',    1, 'Tidak', 'Aktif', 'disetujui', 'import', false],
            ['7', 'Bayu Saputra',       'L', 'Wali',              'Buruh',            'Buruh',            'Kurang dari Rp1.000.000',      5, 'PIP',   'Aktif', 'disetujui',  'manual', false],
            ['7', 'Melati Kusuma',      'P', 'Bersama orang tua', 'Guru',             'Guru',             'Rp3.000.000 - Rp5.000.000',    1, 'Tidak', 'Aktif', 'disetujui', 'import', false],
            ['8', 'Fikri Ardiansyah',   'L', 'Bersama orang tua', 'Karyawan swasta',  'Pedagang',         'Rp2.000.000 - Rp3.000.000',    2, 'Tidak', 'Aktif', 'disetujui',  'manual', false],
            ['8', 'Ayu Wulandari',      'P', 'Panti asuhan',      'Tidak bekerja',    'Tidak bekerja',    'Tidak berpenghasilan',         0, 'KIP',   'Aktif', 'disetujui', 'import', false],
            ['8', 'Hendra Wijaya',      'L', 'Bersama orang tua', 'Petani',           'Petani',           'Kurang dari Rp1.000.000',      4, 'PIP',   'Aktif', 'disetujui', 'manual', false],
            ['9', 'Sinta Maharani',     'P', 'Bersama orang tua', 'PNS',              'Ibu rumah tangga', 'Rp3.000.000 - Rp5.000.000',    1, 'Tidak', 'Aktif', 'disetujui',  'import', false],
            ['9', 'Doni Setiawan',      'L', 'Kos',               'Wiraswasta',       'Wiraswasta',       'Lebih dari Rp5.000.000',       2, 'Tidak', 'Aktif', 'disetujui', 'manual', false],
        ];

        foreach ($data as $i => $d) {
            $nomor = $i + 1;

            Siswa::updateOrCreate(
                ['sekolah_id' => $sekolah->id, 'nisn' => sprintf('00%08d', 20000 + $nomor)],
                [
                    'status_persetujuan' => $d[10],
                    'sumber' => $d[11],
                    'hapus_diajukan_pada' => $d[12] ? now() : null,
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
                    'pekerjaan_ibu' => $d[5],
                    'kisaran_penghasilan_ayah' => $d[6],
                    'kisaran_penghasilan_ibu' => $d[6],
                    'jumlah_saudara' => $d[7],
                    'bantuan_pendidikan' => $d[8],
                    'status_pelajar' => $d[9],
                ]
            );
        }
    }
}
