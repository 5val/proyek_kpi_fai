<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Mahasiswa;
use App\Models\Kelas;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswas = Mahasiswa::pluck('nrp')->toArray();
        $kelass = Kelas::pluck('id')->toArray();

        for ($i = 1; $i <= 200; $i++) {
            Enrollment::create([
                'mahasiswa_nrp' => fake()->randomElement($mahasiswas),
                'kelas_id' => fake()->randomElement($kelass),
            ]);
        }
    }
}
