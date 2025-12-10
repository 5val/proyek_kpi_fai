<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kampus;

class KampusSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama jika ada
        Kampus::truncate();

        Kampus::create([
            'id' => 1,
            'name' => 'Institut Sains dan Teknologi Terpadu Surabaya',
            'alamat' => 'Ngagel Jaya Tengah 73-77 Surabaya, Jawa Timur, 60284',
            'no_telp' => '081230272723',
            'email' => 'web_admin@istts.ac.id',
        ]);
    }
}
