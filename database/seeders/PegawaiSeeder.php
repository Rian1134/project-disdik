<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\Sekolah;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $sekolah = Sekolah::first();

        if (! $sekolah) {
            $this->command?->error('Belum ada data sekolah. Buat sekolah dulu sebelum menjalankan seeder ini.');

            return;
        }

        $pendidik = 'Tenaga Pendidik';
        $kependidikan = 'Tenaga Kependidikan';

        $menunggu = Pegawai::STATUS_MENUNGGU;
        $disetujui = Pegawai::STATUS_DISETUJUI;

        $manual = Pegawai::SUMBER_MANUAL;
        $import = Pegawai::SUMBER_IMPORT;

        // Nilai jabatan, tugas, mata_pelajaran, status_kepegawaian, dan pendidikan
        // harus sama dengan konstanta di model Pegawai (dropdown template Excel).
        // [nama, jk, agama, jabatan, tugas, mata_pelajaran, status_kepegawaian, pendidikan, golongan, pangkat, persetujuan, sumber, hapus_diajukan]
        $data = [
            ['Drs. Hendra Wijaya, M.Pd.',  'L', 'Islam',   $pendidik,     'Kepala Sekolah',       null,                                  'PNS',     'S2',            'IV/a',  'Pembina',           $disetujui, $manual, false],
            ['Dra. Sri Wahyuni',           'P', 'Islam',   $pendidik,     'Guru Mapel',           'Matematika',                          'PNS',     'S1',            'III/d', 'Penata Tk. I',      $disetujui, $manual, false],
            ['Agus Salim, S.Pd.',          'L', 'Islam',   $pendidik,     'Guru Mapel',           'Ilmu Pengetahuan Alam (IPA)',         'PPPK',    'S1',            'IX',    '-',                 $disetujui, $import, false],
            ['Maria Magdalena, S.Pd.',     'P', 'Kristen', $pendidik,     'Guru Mapel',           'Bahasa Inggris',                      'PNS',     'S1',            null,    null,                $disetujui, $manual, false],
            ['I Made Sudirta, S.Kom.',     'L', 'Hindu',   $kependidikan, 'Lainnya',              null,                                  'Honorer', 'S1',            null,    null,                $disetujui, $import, false],
            ['Nur Aisyah, A.Md.',          'P', 'Islam',   $kependidikan, 'Tata Usaha',           null,                                  'Honorer', 'Lainnya',       null,    null,                $disetujui, $manual, false],
            ['Budi Santoso, S.Pd.',        'L', 'Islam',   $pendidik,     'Wakil Kepala Sekolah', null,                                  'PNS',     'S1',            'III/c', 'Penata',            $disetujui, $import, true],
            ['Yohanes Pratama',            'L', 'Katolik', $kependidikan, 'Kebersihan',           null,                                  'Honorer', 'SMA Sederajat', null,    null,                $disetujui, $manual, false],
            ['Lestari Handayani, S.Pd.',   'P', 'Islam',   $pendidik,     'Guru Mapel',           'Bahasa Indonesia',                    'PPPK',    'S1',            null,    null,                $menunggu,  $import, false],
            ['Wayan Ariani, S.Pd.',        'P', 'Hindu',   $pendidik,     'Guru Mapel',           'Seni dan Budaya',                     'PPPK',    'S1',            'IX',    '-',                 $menunggu,  $import, false],
            // --- 15 data tambahan ---
            ['Rina Marlina, S.Pd.',        'P', 'Islam',   $pendidik,     'Guru Mapel',           'Ilmu Pengetahuan Sosial (IPS)',       'PNS',     'S1',            'III/b', 'Penata Muda Tk. I', $disetujui, $manual, false],
            ['Dedi Kurniawan, S.Pd.',      'L', 'Islam',   $pendidik,     'Guru Mapel',           'PJOK',                                'PNS',     'S1',            'III/c', 'Penata',            $disetujui, $import, false],
            ['Sari Puspita, S.Pd.',        'P', 'Islam',   $pendidik,     'Guru Mapel',           'Pendidikan Pancasila',                'PPPK',    'S1',            'IX',    '-',                 $disetujui, $manual, false],
            ['Antonius Sihombing, S.Pd.',  'L', 'Kristen', $pendidik,     'Guru Mapel',           'Ilmu Pengetahuan Sosial (IPS)',       'PNS',     'S1',            null,    null,                $disetujui, $import, false],
            ['Ni Luh Putu Sari, S.Pd.',    'P', 'Hindu',   $pendidik,     'Guru Mapel',           'Pendidikan Agama dan Budi Pekerti',   'PNS',     'S1',            'III/d', 'Penata Tk. I',      $disetujui, $manual, false],
            ['Hendra Gunawan, S.Kom.',     'L', 'Islam',   $kependidikan, 'Laboran',              null,                                  'Honorer', 'S1',            null,    null,                $disetujui, $import, false],
            ['Fitriani, A.Md.',            'P', 'Islam',   $kependidikan, 'Pustakawan',           null,                                  'Honorer', 'Lainnya',       null,    null,                $disetujui, $manual, false],
            ['Yusuf Maulana, S.Pd.',       'L', 'Islam',   $pendidik,     'Guru Mapel',           'Lainnya',                             'PPPK',    'S1',            null,    null,                $menunggu,  $import, false],
            ['Kadek Widyastuti, S.Pd.',    'P', 'Hindu',   $pendidik,     'Guru Mapel',           'Prakarya',                            'PPPK',    'S1',            'IX',    '-',                 $disetujui, $import, false],
            ['Rudi Hartono, S.Pd.',        'L', 'Islam',   $pendidik,     'Wakil Kepala Sekolah', null,                                  'PNS',     'S1',            'III/d', 'Penata Tk. I',      $disetujui, $manual, false],
            ['Siti Aminah, S.Pd.',         'P', 'Islam',   $pendidik,     'Guru Mapel',           'Ilmu Pengetahuan Alam (IPA)',         'PNS',     'S1',            'III/c', 'Penata',            $disetujui, $import, false],
            ['Petrus Kurniawan, S.Pd.',    'L', 'Katolik', $pendidik,     'Bimbingan Konseling',  null,                                  'PNS',     'S1',            null,    null,                $menunggu,  $manual, false],
            ['Rahmawati, S.Pd.',           'P', 'Islam',   $pendidik,     'Guru Mapel',           'Informatika',                         'PPPK',    'S1',            'IX',    '-',                 $disetujui, $import, false],
            ['I Gede Arta',                'L', 'Hindu',   $kependidikan, 'Security',             null,                                  'Honorer', 'SMA Sederajat', null,    null,                $disetujui, $manual, false],
            ['Dewi Sartika, S.E.',         'P', 'Islam',   $kependidikan, 'Bendahara',            null,                                  'PNS',     'S1',            'III/b', 'Penata Muda Tk. I', $disetujui, $import, false],
        ];

        foreach ($data as $i => $d) {
            $nomor = $i + 1;

            Pegawai::updateOrCreate(
                ['sekolah_id' => $sekolah->id, 'nip' => sprintf('1980%014d', 1000 + $nomor)],
                [
                    'status_persetujuan' => $d[10],
                    'sumber' => $d[11],
                    'hapus_diajukan_pada' => $d[12] ? now() : null,
                    'nama' => $d[0],
                    'jenis_kelamin' => $d[1],
                    'agama' => $d[2],
                    'tempat_lahir' => ['Bandung', 'Bogor', 'Garut', 'Denpasar', 'Cirebon'][$i % 5],
                    'tanggal_lahir' => now()->subYears(25 + $i * 3)->subDays($i * 11)->toDateString(),
                    'nik' => sprintf('3201%012d', 200000 + $nomor),
                    'alamat' => 'Jl. Pendidikan No. '.($nomor * 2),
                    'golongan' => $d[8] ?: null,
                    'pangkat' => $d[9],
                    'terhitung_mulai_tanggal' => now()->subYears(2 + $i)->toDateString(),
                    'jabatan' => $d[3],
                    'tugas' => $d[4],
                    'mata_pelajaran' => $d[5],
                    'status_kepegawaian' => $d[6],
                    'pendidikan_terakhir' => $d[7],
                    'unit_satuan_pendidikan_terakhir' => 'Universitas Pendidikan Indonesia',
                ]
            );
        }
    }
}
