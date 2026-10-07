<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan cache permission Spatie agar perubahan langsung terbaca
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'approval',

            'view-sekolah',
            'create-sekolah',
            'show-sekolah',
            'edit-sekolah',

            'view-siswa',
            'create-siswa',
            'show-siswa',
            'edit-siswa',

            'view-guru',
            'create-guru',
            'show-guru',
            'edit-guru',

            'view-tenaga-kependidikan',
            'create-tenaga-kependidikan',
            'show-tenaga-kependidikan',
            'edit-tenaga-kependidikan',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // firstOrCreate: aman dijalankan berulang kali (tidak error duplicate)
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $roleUser = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Admin: semua permission
        $roleAdmin->syncPermissions($permissions);

        // User: kelola sarana + lihat/ubah data user.
        // Izin update-* TIDAK diberikan lewat role; diatur admin per user (halaman Kelola Izin).
        $roleUser->syncPermissions([
           
        ]);
    }
}
