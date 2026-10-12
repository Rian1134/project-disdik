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

        // [nama, jk, agama, jabatan, tugas, status_kepegawaian, pendidikan, golongan, pangkat, persetujuan, sumber, hapus_diajukan]
        $data = [
            ['Drs. Hendra Wijaya, M.Pd.',  'L', 'Islam',    'Kepala Sekolah',     'Kepala Sekolah',      'PNS',        'S2', 'IV/a',  'Pembina',           'disetujui', 'manual', false],
            ['Dra. Sri Wahyuni',           'P', 'Islam',    'Guru',               'Guru Matematika',     'PNS',        'S1', 'III/d', 'Penata Tk. I',      'disetujui', 'manual', false],
            ['Agus Salim, S.Pd.',          'L', 'Islam',    'Guru',               'Guru IPA',            'PPPK',       'S1', 'IX',    '-',                 'disetujui', 'import', false],
            ['Maria Magdalena, S.Pd.',     'P', 'Kristen',  'Guru',               'Guru Bahasa Inggris', 'PNS',        'S1', null,    null,                'disetujui', 'manual', false],
            ['I Made Sudirta, S.Kom.',     'L', 'Hindu',    'Tenaga Kependidikan', 'Operator Sekolah',    'Honorer',    'S1', null,    null,                'disetujui', 'import', false],
            ['Nur Aisyah, A.Md.',          'P', 'Islam',    'Tenaga Kependidikan', 'Tata Usaha',          'Honorer',    'D3', null,    null,                'disetujui', 'manual', false],
            ['Budi Santoso, S.Pd.',        'L', 'Islam',    'Wakil Kepala Sekolah', 'Wakasek Kurikulum',  'PNS',        'S1', 'III/c', 'Penata',            'disetujui', 'import', true],
            ['Yohanes Pratama',            'L', 'Katolik',  'Tenaga Kependidikan', 'Penjaga Sekolah',     'Honorer',    'SMA', '',      null,                'disetujui', 'manual', false],
            ['Lestari Handayani, S.Pd.',   'P', 'Islam',    'Guru',               'Guru Bahasa Indonesia', 'PPPK',       'S1', null,    null,                'menunggu',  'import', false],
            ['Wayan Ariani, S.Pd.',        'P', 'Hindu',    'Guru',               'Guru Seni Budaya',    'PPPK',       'S1', 'IX',    '-',                 'menunggu',  'import', false],
            // --- 15 data tambahan ---
            ['Rina Marlina, S.Pd.',        'P', 'Islam',    'Guru',               'Guru IPS',            'PNS',        'S1', 'III/b', 'Penata Muda Tk. I', 'disetujui', 'manual', false],
            ['Dedi Kurniawan, S.Pd.',      'L', 'Islam',    'Guru',               'Guru Penjaskes',      'PNS',        'S1', 'III/c', 'Penata',            'disetujui', 'import', false],
            ['Sari Puspita, S.Pd.',        'P', 'Islam',    'Guru',               'Guru PKn',            'PPPK',       'S1', 'IX',    '-',                 'disetujui', 'manual', false],
            ['Antonius Sihombing, S.Pd.',  'L', 'Kristen',  'Guru',               'Guru Sejarah',        'PNS',        'S1', null,    null,                'disetujui', 'import', false],
            ['Ni Luh Putu Sari, S.Pd.',    'P', 'Hindu',    'Guru',               'Guru Agama Hindu',    'PNS',        'S1', 'III/d', 'Penata Tk. I',      'disetujui', 'manual', false],
            ['Hendra Gunawan, S.Kom.',     'L', 'Islam',    'Tenaga Kependidikan', 'Teknisi Lab Komputer', 'Honorer',   'S1', null,    null,                'disetujui', 'import', false],
            ['Fitriani, A.Md.',            'P', 'Islam',    'Tenaga Kependidikan', 'Pustakawan',          'Honorer',    'D3', null,    null,                'disetujui', 'manual', false],
            ['Yusuf Maulana, S.Pd.',       'L', 'Islam',    'Guru',               'Guru Bahasa Arab',    'PPPK',        'S1', null,    null,                'menunggu',  'import', false],
            ['Kadek Widyastuti, S.Pd.',    'P', 'Hindu',    'Guru',               'Guru Prakarya',       'PPPK',       'S1', 'IX',    '-',                 'disetujui', 'import', false],
            ['Rudi Hartono, S.Pd.',        'L', 'Islam',    'Wakil Kepala Sekolah', 'Wakasek Kesiswaan',  'PNS',        'S1', 'III/d', 'Penata Tk. I',      'disetujui', 'manual', false],
            ['Siti Aminah, S.Pd.',         'P', 'Islam',    'Guru',               'Guru Biologi',        'PNS',        'S1', 'III/c', 'Penata',            'disetujui', 'import', false],
            ['Petrus Kurniawan, S.Pd.',    'L', 'Katolik',  'Guru',               'Guru Fisika',         'PNS',        'S1', null,    null,                'menunggu',  'manual', false],
            ['Rahmawati, S.Pd.',           'P', 'Islam',    'Guru',               'Guru Kimia',          'PPPK',       'S1', 'IX',    '-',                 'disetujui', 'import', false],
            ['I Gede Arta, S.Pd.',         'L', 'Hindu',    'Tenaga Kependidikan', 'Satpam',              'Honorer',    'SMA', '',      null,                'disetujui', 'manual', false],
            ['Dewi Sartika, S.E.',         'P', 'Islam',    'Tenaga Kependidikan', 'Bendahara Sekolah',   'PNS',        'S1', 'III/b', 'Penata Muda Tk. I', 'disetujui', 'import', false],
        ];

        foreach ($data as $i => $d) {
            $nomor = $i + 1;

            Pegawai::updateOrCreate(
                ['sekolah_id' => $sekolah->id, 'nip' => sprintf('1980%014d', 1000 + $nomor)],
                [
                    'status_persetujuan' => $d[9],
                    'sumber' => $d[10],
                    'hapus_diajukan_pada' => $d[11] ? now() : null,
                    'nama' => $d[0],
                    'jenis_kelamin' => $d[1],
                    'agama' => $d[2],
                    'tempat_lahir' => ['Bandung', 'Bogor', 'Garut', 'Denpasar', 'Cirebon'][$i % 5],
                    'tanggal_lahir' => now()->subYears(25 + $i * 3)->subDays($i * 11)->toDateString(),
                    'nik' => sprintf('3201%012d', 200000 + $nomor),
                    'alamat' => 'Jl. Pendidikan No. '.($nomor * 2),
                    'golongan' => $d[7] ?: null,
                    'pangkat' => $d[8],
                    'terhitung_mulai_tanggal' => now()->subYears(2 + $i)->toDateString(),
                    'jabatan' => $d[3],
                    'tugas' => $d[4],
                    'status_kepegawaian' => $d[5],
                    'pendidikan_terakhir' => $d[6],
                    'unit_satuan_pendidikan_terakhir' => 'Universitas Pendidikan Indonesia',
                ]
            );
        }
    }
}
