<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Prodi;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $informatika = Prodi::firstOrCreate(
            ['kode_prodi' => 'IF'],
            ['nama_prodi' => 'Informatika', 'jenjang' => 'S1'],
        );
        $manajemen = Prodi::firstOrCreate(
            ['kode_prodi' => 'MN'],
            ['nama_prodi' => 'Manajemen', 'jenjang' => 'S1'],
        );

        Mahasiswa::firstOrCreate(
            ['nim' => '23101001'],
            ['nama' => 'Reva Putri', 'jenis_kelamin' => 'Perempuan', 'email' => 'reva@example.test', 'angkatan' => 2023, 'alamat' => 'Bandung', 'prodi_id' => $informatika->id],
        );
        Mahasiswa::firstOrCreate(
            ['nim' => '23102001'],
            ['nama' => 'Dimas Pratama', 'jenis_kelamin' => 'Laki-laki', 'email' => 'dimas@example.test', 'angkatan' => 2023, 'alamat' => 'Bogor', 'prodi_id' => $manajemen->id],
        );

        MataKuliah::firstOrCreate(
            ['kode_mk' => 'IF101'],
            ['nama_mk' => 'Dasar Pemrograman', 'sks' => 3, 'semester' => 1, 'prodi_id' => $informatika->id],
        );
        MataKuliah::firstOrCreate(
            ['kode_mk' => 'MN101'],
            ['nama_mk' => 'Pengantar Manajemen', 'sks' => 3, 'semester' => 1, 'prodi_id' => $manajemen->id],
        );
    }
}
