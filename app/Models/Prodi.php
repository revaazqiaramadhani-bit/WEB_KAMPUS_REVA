<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';

    protected $fillable = ['kode_prodi', 'nama_prodi', 'jenjang', 'akreditasi', 'foto'];

    public function mahasiswa(): HasMany
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function mataKuliah(): HasMany
    {
        return $this->hasMany(MataKuliah::class);
    }
}