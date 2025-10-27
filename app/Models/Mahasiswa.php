<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'mahasiswa';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nim', // 'mahasiswa_nrp' di tabel lain
        'program_studi',
        'angkatan',
        'ipk',
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
     * Mendapatkan user yang terkait dengan mahasiswa ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mendapatkan data enrollment (pendaftaran kelas) mahasiswa ini.
     */
    public function enrollment()
    {
        // Menggunakan 'nim' sebagai foreign key lokal
        return $this->hasMany(Enrollment::class, 'mahasiswa_nrp', 'nim');
    }

    /**
     * Mendapatkan data kehadiran mahasiswa ini.
     */
    public function kehadiran()
    {
        // Menggunakan 'nim' sebagai foreign key lokal
        return $this->hasMany(Kehadiran::class, 'mahasiswa_nrp', 'nim');
    }

    /**
     * Mendapatkan semua penilaian untuk mahasiswa ini (polimorfik).
     */
    public function penilaian()
    {
        return $this->morphMany(Penilaian::class, 'dinilai');
    }
}

