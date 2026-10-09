<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('nss')->unique();
            $table->string('npsn')->unique();
            $table->string('nama_sekolah')->unique();
            $table->string('nama_kepala_sekolah');
            $table->char('akreditasi');
            $table->string('status_sekolah');
            $table->date('tanggal_sk_pendirian');
            $table->string('tanggal_sk_izin_oprasional');
            $table->string('implementasi_kurikulum');

            $table->string('alamat');
            $table->string('rt_rw');
            $table->string('desa_kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
            $table->string('kode_pos');

            $table->integer('laus_tanah');
            $table->integer('laus_bangunan');
            $table->string('tipe_internet')->nullable();
            $table->string('internet_provider')->nullable();
            $table->integer('bandwith_internet')->nullable();
            $table->string('sumber_listrik')->nullable();
            $table->integer('daya_listrik')->nullable();
            $table->string('sumber_air')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolahs');
    }
};
