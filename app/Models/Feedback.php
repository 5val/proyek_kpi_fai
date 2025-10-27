<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'feedback';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pengirim_id',
        'subjek', // Ditambahkan berdasarkan UI
        'isi', // Ditambahkan berdasarkan UI (menggantikan 'komentar')
        'kategori',
        'foto',
        'is_anonymous',
        'status', // Belum Ditanggapi, Sudah Ditanggapi
    ];

    /**
     * Atribut yang harus di-cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_anonymous' => 'boolean',
    ];

    /**
     * Mendapatkan user (pengirim) feedback ini.
     * Menggunakan 'pengirim_id' sebagai foreign key.
     */
    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }
}

