<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role',
        'photo_profile',
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus di-cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Mendapatkan data mahasiswa yang terkait dengan user ini.
     */
    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'user_id');
    }

    /**
     * Mendapatkan data dosen yang terkait dengan user ini.
     */
    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'user_id');
    }

    /**
     * Mendapatkan feedback yang dikirim oleh user ini.
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'pengirim_id');
    }

    /**
     * Mendapatkan penilaian yang diberikan oleh user ini.
     */
    public function penilaianDiberikan()
    {
        return $this->hasMany(Penilaian::class, 'penilai_id');
    }
}

