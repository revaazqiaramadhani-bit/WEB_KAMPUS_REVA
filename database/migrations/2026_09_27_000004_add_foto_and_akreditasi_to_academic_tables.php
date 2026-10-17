<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prodi', function (Blueprint $table) {
            $table->string('akreditasi', 30)->nullable();
            $table->string('foto')->nullable();
        });

        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('foto')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn('foto');
        });

        Schema::table('prodi', function (Blueprint $table) {
            $table->dropColumn(['akreditasi', 'foto']);
        });
    }
};