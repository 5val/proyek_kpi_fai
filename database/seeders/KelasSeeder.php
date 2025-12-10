<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\Dosen;
use App\Models\ProgramStudi;
use App\Models\Periode;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $mataKuliahs = MataKuliah::pluck('id')->toArray();
        $dosenNidn = Dosen::pluck('nidn')->toArray();
        $programStudis = ProgramStudi::pluck('id')->toArray();
        $periodes = Periode::pluck('id')->toArray();

        for ($i = 1; $i <= 50; $i++) {
            Kelas::create([
                // Kode kelas 4 digit, mirip format nyata
                'code' => 'K' . fake()->unique()->numerify('###'),

                // Relasi foreign key
                'mata_kuliah_id' => fake()->randomElement($mataKuliahs),
                'program_studi_id' => fake()->randomElement($programStudis),
                'periode_id' => fake()->randomElement($periodes),

                // Dosen pengampu
                'dosen_nidn' => fake()->randomElement($dosenNidn),

                // SKS (umumnya 2–4)
                'sks' => fake()->numberBetween(2, 4),

                // Apakah kelas punya praktikum
                'has_praktikum' => fake()->boolean(30),

                // Minimum grade 0–100
                'minimum_grade' => fake()->numberBetween(50, 80),

                // is_active default dari database
            ]);
        }
    }
}
