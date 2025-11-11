<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'enrollment';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kelas_id',
        'mahasiswa_nrp', // NIM mahasiswa
    ];

    /**
     * Mendapatkan kelas yang terkait dengan enrollment ini.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Mendapatkan mahasiswa yang terkait dengan enrollment ini.
     */
    public function mahasiswa()
    {
        // Menggunakan 'mahasiswa_nrp' sebagai foreign key
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nrp', 'nrp');
    }
}

