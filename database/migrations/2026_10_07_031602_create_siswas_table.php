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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sekolah_id');
            $table->foreign('sekolah_id')->references('id')->on('sekolahs')->onDelete('cascade');

            $table->string('nik');
            $table->string('nisn');
            $table->string('nama_siswa');
            $table->string('kelas');
            $table->char('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->string('status_tempat_tinggal');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_ayah');
            $table->string('pekerjaan_ibu');
            $table->string('kisaran_penghasilan_ayah');
            $table->string('kisaran_penghasilan_ibu');
            $table->integer('jumlah_saudara');
            $table->string('bantuan_pendidikan');
            $table->string('status_pelajar');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
