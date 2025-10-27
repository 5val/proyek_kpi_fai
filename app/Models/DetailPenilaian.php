<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenilaian extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'detail_penilaian';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'penilaian_id',
        'indikator_id',
        'score',
    ];

    /**
     * Mendapatkan data penilaian utama.
     */
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id');
    }

    /**
     * Mendapatkan data indikator KPI yang dinilai.
     */
    public function indikatorKPI()
    {
        return $this->belongsTo(Indikator::class, 'indikator_id');
    }
}

