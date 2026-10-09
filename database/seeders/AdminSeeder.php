<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin', 'password' => bcrypt('12345678')]
        );

        $admin->assignRole('admin');

        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            ['name' => 'User', 'password' => bcrypt('12345678')]
        );

        $user->assignRole('user');

        // Sekolah milik user (1 user = 1 sekolah). firstOrCreate berdasarkan
        // user_id, jadi seeder aman dijalankan berulang tanpa membuat data ganda.
        Sekolah::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nss' => '201130101001',
                'npsn' => '10600001',
                'nama_sekolah' => 'SMP Negeri 1 Contoh',
                'nama_kepala_sekolah' => 'Budi Santoso, S.Pd.',
                'akreditasi' => 'A',
                'status_sekolah' => 'Negeri',
                'tanggal_sk_pendirian' => '2000-01-01',
                'tanggal_sk_izin_oprasional' => '2000-06-01',
                'implementasi_kurikulum' => 'Kurikulum Merdeka',

                'alamat' => 'Jl. Merdeka No. 1',
                'rt_rw' => '001/002',
                'desa_kelurahan' => 'Contoh',
                'kecamatan' => 'Lahat',
                'kabupaten' => 'Lahat',
                'provinsi' => 'Sumatera Selatan',
                'kode_pos' => '31411',

                'laus_tanah' => 2000,
                'laus_bangunan' => 800,
                'tipe_internet' => 'Wifi',
                'internet_provider' => 'Telkom',
                'bandwith_internet' => 20,
                'sumber_listrik' => 'PLN',
                'daya_listrik' => 2200,
                'sumber_air' => 'Sumur',
            ]
        );
    }
}