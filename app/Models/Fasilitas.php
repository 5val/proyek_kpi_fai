<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fasilitas extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'fasilitas';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'kategori', // Misal: Ruang Kelas, Lab, Perpustakaan
        'kondisi',
        'penanggung_jawab',
        'is_active',
    ];

    /**
     * Mendapatkan semua penilaian untuk fasilitas ini (polimorfik).
     */
    public function penilaian()
    {
        return $this->morphMany(Penilaian::class, 'dinilai');
    }
}

