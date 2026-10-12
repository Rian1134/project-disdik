<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            // 'menunggu' = belum disetujui admin (belum masuk daftar), 'disetujui' = sudah masuk daftar.
            // Default 'disetujui' agar data lama tetap tampil.
            $table->string('status_persetujuan', 20)->default('disetujui')->index()->after('sekolah_id');

            // 'import' = berasal dari upload Excel (wajib persetujuan), 'manual' = isi manual.
            $table->string('sumber', 20)->default('manual')->after('status_persetujuan');

            // Terisi saat user mengajukan penghapusan pegawai hasil import.
            $table->timestamp('hapus_diajukan_pada')->nullable()->after('sumber');
        });
    }

    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropColumn(['status_persetujuan', 'sumber', 'hapus_diajukan_pada']);
        });
    }
};
