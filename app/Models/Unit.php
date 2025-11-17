<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        'is_active'
    ];

    /**
     * Mendapatkan semua penilaian untuk unit ini (polimorfik).
     */
    public function penilaian()
    {
        return $this->morphMany(Penilaian::class, 'dinilai');
    }

    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'penanggung_jawab_id');
    }
}

