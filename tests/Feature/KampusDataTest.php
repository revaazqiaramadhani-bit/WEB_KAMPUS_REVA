<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KampusDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_detail_shows_the_related_program_study(): void
    {
        $prodi = Prodi::create(['kode_prodi' => 'IF', 'nama_prodi' => 'Informatika', 'jenjang' => 'S1']);
        $mahasiswa = Mahasiswa::create([
            'nim' => '23101001',
            'nama' => 'Reva Putri',
            'jenis_kelamin' => 'Perempuan',
            'angkatan' => 2023,
            'prodi_id' => $prodi->id,
        ]);

        $this->get(route('mahasiswa.show', $mahasiswa))
            ->assertOk()
            ->assertSee('Reva Putri')
            ->assertSee('Informatika')
            ->assertSee('Program studi yang diambil');
    }

    public function test_mahasiswa_can_be_created_with_a_program_study(): void
    {
        $prodi = Prodi::create(['kode_prodi' => 'MN', 'nama_prodi' => 'Manajemen', 'jenjang' => 'S1']);

        $this->post(route('mahasiswa.store'), [
            'nim' => '23102001',
            'nama' => 'Dimas Pratama',
            'jenis_kelamin' => 'Laki-laki',
            'angkatan' => 2023,
            'prodi_id' => $prodi->id,
        ])->assertRedirect();

        $this->assertDatabaseHas('mahasiswa', ['nim' => '23102001', 'prodi_id' => $prodi->id]);
    }

    public function test_photos_and_program_accreditation_can_be_saved_and_displayed(): void
    {
        Storage::fake('public');

        $this->post(route('prodi.store'), [
            'kode_prodi' => 'SI',
            'nama_prodi' => 'Sistem Informasi',
            'jenjang' => 'S1',
            'akreditasi' => 'Unggul',
            'foto' => UploadedFile::fake()->image('prodi.jpg'),
        ])->assertRedirect(route('prodi.index'));

        $prodi = Prodi::where('kode_prodi', 'SI')->firstOrFail();
        $this->assertTrue(Storage::disk('public')->exists($prodi->foto));

        $this->post(route('mahasiswa.store'), [
            'nim' => '24103001',
            'nama' => 'Nabila Rahma',
            'jenis_kelamin' => 'Perempuan',
            'angkatan' => 2024,
            'prodi_id' => $prodi->id,
            'foto' => UploadedFile::fake()->image('mahasiswa.jpg'),
        ])->assertRedirect();

        $mahasiswa = Mahasiswa::where('nim', '24103001')->firstOrFail();
        $this->assertTrue(Storage::disk('public')->exists($mahasiswa->foto));

        $this->get(route('prodi.index'))
            ->assertOk()
            ->assertSee('Unggul')
            ->assertSee('storage/'.$prodi->foto);
        $this->get(route('mahasiswa.index'))
            ->assertOk()
            ->assertSee('Unggul')
            ->assertSee('storage/'.$mahasiswa->foto);
    }

    public function test_deleting_a_program_clears_it_from_students_without_deleting_them(): void
    {
        $prodi = Prodi::create(['kode_prodi' => 'IF', 'nama_prodi' => 'Informatika', 'jenjang' => 'S1']);
        $mahasiswa = Mahasiswa::create([
            'nim' => '23101001',
            'nama' => 'Reva Putri',
            'jenis_kelamin' => 'Perempuan',
            'angkatan' => 2023,
            'prodi_id' => $prodi->id,
        ]);

        $this->delete(route('prodi.destroy', $prodi))
            ->assertRedirect(route('prodi.index'));

        $this->assertDatabaseHas('mahasiswa', [
            'id' => $mahasiswa->id,
            'prodi_id' => null,
        ]);

        $this->get(route('mahasiswa.index'))
            ->assertOk()
            ->assertSee('Belum dipilih');
        $this->get(route('mahasiswa.show', $mahasiswa))
            ->assertOk()
            ->assertSee('Prodi belum dipilih. Mahasiswa ini tetap tersimpan.');
    }
}