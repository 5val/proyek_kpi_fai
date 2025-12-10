<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Kinerja Dosen',
                'description' => 'Penilaian performa mengajar dosen oleh mahasiswa.',
                'target_role' => 'dosen',
                'created_at' => '2025-11-02 19:02:40',
                'updated_at' => '2025-11-18 11:06:06',
            ],
            [
                'id' => 3,
                'name' => 'Fasilitas',
                'description' => 'Penilaian performa fasilitas kampus.',
                'target_role' => 'fasilitas',
                'created_at' => '2025-11-02 19:02:40',
                'updated_at' => '2025-11-18 11:07:15',
            ],
            [
                'id' => 4,
                'name' => 'Kinerja Unit',
                'description' => 'Penilaian performa unit layanan, seperti BAU, BAK, BAA, UKM, UKK.',
                'target_role' => 'unit',
                'created_at' => '2025-11-02 19:02:40',
                'updated_at' => '2025-11-18 11:07:35',
            ],
            [
                'id' => 5,
                'name' => 'Praktikum',
                'description' => 'Penilaian praktikum yang dilaksanakan oleh mahasiswa.',
                'target_role' => 'praktikum',
                'created_at' => '2025-11-02 19:02:40',
                'updated_at' => '2025-11-18 11:08:16',
            ],
            [
                'id' => 6,
                'name' => 'Manajemen Kampus',
                'description' => 'Penilaian kualitas manajemen kampus dalam mengatur dan mendukung kegiatan kampus.',
                'target_role' => 'kampus',
                'created_at' => '2025-12-03 10:43:27',
                'updated_at' => '2025-12-03 10:44:10',
            ],
        ];

        Kategori::insert($data);
    }
}
