<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'periode';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_periode',
        'tahun',
        'semester', // 'gasal' atau 'genap'
    ];

    /**
     * Mendapatkan kelas-kelas yang ada pada periode ini.
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'periode_id');
    }

    /**
     * Mendapatkan data penilaian yang ada pada periode ini.
     */
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'periode_id');
    }
}

