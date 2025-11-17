<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'program_studi';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
         'code',
         'name',
         'short_name',
    ];

    public function mahasiswa()
    {
        // Menggunakan 'nim' sebagai foreign key lokal
        return $this->hasMany(Mahasiswa::class, 'program_studi_id', 'id');
    }
    
    public function kelas()
    {
        // Menggunakan 'nim' sebagai foreign key lokal
        return $this->hasMany(Kelas::class, 'program_studi_id', 'id');
    }
}

