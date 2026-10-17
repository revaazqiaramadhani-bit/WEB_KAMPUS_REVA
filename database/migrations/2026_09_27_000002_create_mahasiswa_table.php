<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 25)->unique();
            $table->string('nama');
            $table->string('jenis_kelamin', 20);
            $table->string('email')->nullable();
            $table->unsignedSmallInteger('angkatan');
            $table->text('alamat')->nullable();
            $table->foreignId('prodi_id')->constrained('prodi')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};