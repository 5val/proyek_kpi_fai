<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kampus extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'kampus';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_kampus',
        'alamat',
        'no_telp',
        'email',
    ];

    /**
     * Menentukan apakah model harus memiliki timestamp.
     *
     * @var bool
     */
    public $timestamps = false; // Diasumsikan tabel ini tidak butuh created_at/updated_at
}

