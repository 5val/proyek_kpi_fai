<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'unit';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type', // Misal: BAA, BAK, BAU, UKM
        'penanggung_jawab_id',
    ];

    /**
     * Mendapatkan semua penilaian untuk unit ini (polimorfik).
     */
    public function penilaian()
    {
        return $this->morphMany(Penilaian::class, 'dinilai');
    }
}

