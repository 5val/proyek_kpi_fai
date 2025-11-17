<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'mata_kuliah';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
    ];

    /**
     * Mendapatkan kelas-kelas yang terkait dengan mata kuliah ini.
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'mata_kuliah_id');
    }
}

