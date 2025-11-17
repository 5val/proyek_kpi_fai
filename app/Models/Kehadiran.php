<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'kehadiran';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kelas_id',
        'pertemuan_ke', // Ditambahkan berdasarkan UI
        'mahasiswa_nrp', // NIM mahasiswa
        'is_present', // Ditambahkan berdasarkan UI (Hadir, Izin, Sakit, Absen)
        'remarks',
    ];

    /**
     * Mendapatkan kelas yang terkait dengan kehadiran ini.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Mendapatkan mahasiswa yang terkait dengan kehadiran ini.
     */
    public function mahasiswa()
    {
        // Menggunakan 'mahasiswa_nrp' sebagai foreign key
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nrp', 'nim');
    }
}

