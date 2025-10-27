<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'dosen';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nidn', // 'dosen_nidn' di tabel kelas
    ];

    /**
     * Kunci utama model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id'; // Asumsi user_id unik, atau 'id' jika ada

    /**
     * Tipe kunci utama.
     *
     * @var string
     */
    protected $keyType = 'int';

     /**
     * Apakah kunci utama auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false; // Sesuaikan jika 'user_id' bukan auto-increment

    /**
     * Mendapatkan user yang terkait dengan dosen ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mendapatkan kelas-kelas yang diajar oleh dosen ini.
     */
    public function kelas()
    {
        // Menggunakan 'nidn' sebagai foreign key lokal
        return $this->hasMany(Kelas::class, 'dosen_nidn', 'nidn');
    }

    /**
     * Mendapatkan semua penilaian untuk dosen ini (polimorfik).
     */
    public function penilaian()
    {
        return $this->morphMany(Penilaian::class, 'dinilai');
    }
}

