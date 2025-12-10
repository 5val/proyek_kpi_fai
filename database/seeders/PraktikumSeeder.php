<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Praktikum;

class PraktikumSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil hanya kelas yang punya praktikum
        $kelasWithPraktikum = Kelas::where('has_praktikum', 1)->get();

        foreach ($kelasWithPraktikum as $kelas) {


            Praktikum::factory()
                ->create([
                    'kelas_id' => $kelas->id,
                    // avg_kpi antara 0.00 - 4.00
                    'avg_kpi' => fake()->randomFloat(2, 0, 4), 
                ]);
        }
    }
}
