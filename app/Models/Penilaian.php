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
         'kategori_id', // Kategori KPI yang digunakan
         'penilai_id', // User (Mahasiswa/Dosen) yang menilai
         'dinilai_id', // ID dari model yang dinilai (Dosen, Mhs, Fasilitas, Unit)
         'dinilai_type', // ID dari model yang dinilai (Dosen, Mhs, Fasilitas, Unit)
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
        return $this->morphTo(__FUNCTION__, 'dinilai_type', 'dinilai_id');
    }

    /**
     * Mendapatkan kategori KPI yang terkait dengan penilaian ini.
     */
    public function kategori()
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
    
    public function user()
    {
        return $this->hasMany(User::class, 'dinilai_id');
    }
    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class, 'dinilai_id');
    }
    public function unit()
    {
        return $this->hasMany(Unit::class, 'dinilai_id');
    }
    public function praktikum()
    {
        return $this->hasMany(Praktikum::class, 'dinilai_id');
    }

    public function getDinilaiUserAttribute()
    {
        $model = $this->dinilai;

        if ($model instanceof \App\Models\Dosen) {
            return $model->user;
        }

        if ($model instanceof \App\Models\Mahasiswa) {
            return $model->user;
        }

        if ($model instanceof \App\Models\Praktikum) {
            return (object)[
               'mata_kuliah' => $model->kelas->mataKuliah,
               'program_studi' => $model->kelas->program_studi,
            ];
        }

        return null; // for fasilitas & unit
    }
}

