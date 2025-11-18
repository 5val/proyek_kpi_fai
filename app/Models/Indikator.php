<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'indikator';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kategori_id',
        'name',
        'bobot',
    ];

    /**
     * Mendapatkan kategori KPI yang terkait dengan indikator ini.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Mendapatkan detail penilaian yang terkait dengan indikator ini.
     */
    public function detailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class, 'indikator_id');
    }
}

