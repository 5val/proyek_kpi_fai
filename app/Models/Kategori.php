<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'kategori';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'target_role', // Misal: Dosen, Mahasiswa, Fasilitas
    ];

    /**
     * Mendapatkan indikator-indikator KPI dalam kategori ini.
     */
    public function indikator()
    {
        return $this->hasMany(Indikator::class, 'kategori_id');
    }

    /**
     * Mendapatkan data penilaian yang menggunakan kategori ini.
     */
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'kategori_id');
    }
}

