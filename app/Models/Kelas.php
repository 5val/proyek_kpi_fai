<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'kelas';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mata_kuliah_id',
        'periode_id',
        'dosen_nidn',
    ];

    /**
     * Mendapatkan mata kuliah yang terkait dengan kelas ini.
     */
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    /**
     * Mendapatkan periode yang terkait dengan kelas ini.
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    /**
     * Mendapatkan dosen pengampu kelas ini.
     */
    public function dosen()
    {
        // Menggunakan 'dosen_nidn' sebagai foreign key
        return $this->belongsTo(Dosen::class, 'dosen_nidn', 'nidn');
    }

    /**
     * Mendapatkan data enrollment (peserta) kelas ini.
     */
    public function enrollment()
    {
        return $this->hasMany(Enrollment::class, 'kelas_id');
    }

    /**
     * Mendapatkan data kehadiran kelas ini.
     */
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class, 'kelas_id');
    }

    /**
     * Mendapatkan data praktikum yang terkait dengan kelas ini.
     */
    public function praktikum()
    {
        return $this->hasMany(Praktikum::class, 'kelas_id');
    }
}

