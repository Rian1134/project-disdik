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
        Schema::create('list_prestasis', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sekolah_id');
            $table->foreign('sekolah_id')->references('id')->on('sekolahs')->onDelete('cascade');

            $table->string('jenis');
            $table->string('prestasi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_prestasis');
    }
};
