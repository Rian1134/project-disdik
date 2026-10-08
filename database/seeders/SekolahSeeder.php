<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user pertama, kalau belum ada buat user baru
        $user = User::first() ?? User::factory()->create();

        $sekolahs = [
            [
                'nss' => '201130601001',
                'npsn' => '10600001',
                'nama_sekolah' => 'SMP Negeri 1 Palembang',
                'nama_kepala_sekolah' => 'Drs. Ahmad Fauzi, M.Pd.',
                'akreditasi' => 'A',
                'status_sekolah' => 'Negeri',
                'tanggal_sk_pendirian' => '1985-07-01',
                'tanggal_sk_izin_oprasional' => '1985-08-15',
                'implementasi_kurikulum' => 'Kurikulum Merdeka',
                'alamat' => 'Jl. Merdeka No. 10',
                'rt_rw' => '005/002',
                'desa_kelurahan' => 'Talang Semut',
                'kecamatan' => 'Bukit Kecil',
                'kabupaten' => 'Kota Palembang',
                'provinsi' => 'Sumatera Selatan',
                'kode_pos' => '30135',
                'laus_tanah' => 4500,
                'laus_bangunan' => 2200,
                'tipe_internet' => 1,
                'internet_provider' => 1,
                'bandwith_internet' => 50,
                'sumber_listrik' => 'PLN',
                'daya_listrik' => 13200,
                'sumber_air' => 'PDAM',
            ],
            [
                'nss' => '201130601002',
                'npsn' => '10600002',
                'nama_sekolah' => 'SMP Negeri 2 Palembang',
                'nama_kepala_sekolah' => 'Siti Rahmawati, S.Pd., M.M.',
                'akreditasi' => 'A',
                'status_sekolah' => 'Negeri',
                'tanggal_sk_pendirian' => '1990-07-01',
                'tanggal_sk_izin_oprasional' => '1990-09-10',
                'implementasi_kurikulum' => 'Kurikulum Merdeka',
                'alamat' => 'Jl. Sudirman No. 25',
                'rt_rw' => '003/001',
                'desa_kelurahan' => 'Sungai Pangeran',
                'kecamatan' => 'Ilir Timur I',
                'kabupaten' => 'Kota Palembang',
                'provinsi' => 'Sumatera Selatan',
                'kode_pos' => '30114',
                'laus_tanah' => 3800,
                'laus_bangunan' => 1800,
                'tipe_internet' => 1,
                'internet_provider' => 2,
                'bandwith_internet' => 30,
                'sumber_listrik' => 'PLN',
                'daya_listrik' => 10600,
                'sumber_air' => 'PDAM',
            ],
            [
                'nss' => '201130601003',
                'npsn' => '10600003',
                'nama_sekolah' => 'SMP Swasta Harapan Bangsa',
                'nama_kepala_sekolah' => 'Budi Santoso, S.Pd.',
                'akreditasi' => 'B',
                'status_sekolah' => 'Swasta',
                'tanggal_sk_pendirian' => '2001-01-15',
                'tanggal_sk_izin_oprasional' => '2001-03-20',
                'implementasi_kurikulum' => 'Kurikulum 2013',
                'alamat' => 'Jl. Kebangsaan No. 7',
                'rt_rw' => '010/004',
                'desa_kelurahan' => 'Kebun Bunga',
                'kecamatan' => 'Sukarami',
                'kabupaten' => 'Kota Palembang',
                'provinsi' => 'Sumatera Selatan',
                'kode_pos' => '30152',
                'laus_tanah' => 2500,
                'laus_bangunan' => 1200,
                'tipe_internet' => 2,
                'internet_provider' => 1,
                'bandwith_internet' => 20,
                'sumber_listrik' => 'PLN',
                'daya_listrik' => 6600,
                'sumber_air' => 'Sumur Bor',
            ],
        ];

        foreach ($sekolahs as $data) {
            Sekolah::updateOrCreate(
                ['npsn' => $data['npsn']],
                $data + ['user_id' => $user->id]
            );
        }
    }
}