<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'penilaian';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'penilai_id', // User (Mahasiswa/Dosen) yang menilai
        'dinilai_id', // ID dari model yang dinilai (Dosen, Mhs, Fasilitas, Unit)
        'dinilai_type', // Nama model: App\Models\Dosen, App\Models\Fasilitas, dll.
        'kategori_id', // Kategori KPI yang digunakan
        'periode_id', // Periode penilaian
        'komentar',
        'avg_score',
    ];

    /**
     * Mendapatkan user (penilai) yang memberikan penilaian ini.
     */
    public function penilai()
    {
        return $this->belongsTo(User::class, 'penilai_id');
    }

    /**
     * Mendapatkan model yang dinilai (Dosen, Mhs, Fasilitas, Unit, Praktikum).
     */
    public function dinilai()
    {
        return $this->morphTo();
    }

    /**
     * Mendapatkan kategori KPI yang terkait dengan penilaian ini.
     */
    public function kategoriKPI()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Mendapatkan periode yang terkait dengan penilaian ini.
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    /**
     * Mendapatkan rincian (skor per indikator) dari penilaian ini.
     */
    public function detailPenilaian()
    {
        return $this->hasMany(DetailPenilaian::class, 'penilaian_id');
    }
}

