<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Periode;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'nama_periode' => 'Gasal 2024/2025',
                'tahun' => 2024,
                'semester' => 'gasal',
                'created_at' => '2025-11-09 19:01:45',
                'updated_at' => '2025-11-09 19:01:45',
            ],
            [
                'id' => 2,
                'nama_periode' => 'Genap 2024/2025',
                'tahun' => 2025,
                'semester' => 'genap',
                'created_at' => '2025-11-09 19:02:01',
                'updated_at' => '2025-11-09 19:02:01',
            ],
            [
                'id' => 3,
                'nama_periode' => 'Pendek 2024/2025',
                'tahun' => 2025,
                'semester' => 'pendek',
                'created_at' => '2025-11-09 19:02:13',
                'updated_at' => '2025-11-09 19:02:13',
            ],
            [
                'id' => 5,
                'nama_periode' => 'Gasal 2025/2026',
                'tahun' => 2025,
                'semester' => 'gasal',
                'created_at' => '2025-11-09 19:02:34',
                'updated_at' => '2025-11-09 19:02:34',
            ],
        ];

        Periode::insert($data);
    }
}
