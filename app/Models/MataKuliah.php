<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah';

    protected $fillable = ['kode_mk', 'nama_mk', 'sks', 'semester', 'prodi_id'];

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }
}