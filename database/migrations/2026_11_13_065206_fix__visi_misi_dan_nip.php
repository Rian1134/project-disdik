<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sekolahs', function (Blueprint $table) {
            $table->text('visi')->nullable()->change();
            $table->text('misi')->nullable()->change();
        });

        Schema::table('pegawais', function (Blueprint $table) {
            $table->string('nip')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('sekolahs', function (Blueprint $table) {
            $table->string('visi')->nullable()->change();
            $table->string('misi')->nullable()->change();
        });

        Schema::table('pegawais', function (Blueprint $table) {
            $table->string('nip')->nullable(false)->change();
        });
    }
};