<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KampusSeeder::class,
            PeriodeSeeder::class,
            UnitSeeder::class,
            UserSeeder::class,
            ProgramStudiSeeder::class,
            MataKuliahSeeder::class,
            FasilitasSeeder::class,
            KategoriSeeder::class,
            IndikatorSeeder::class,
            DosenSeeder::class,
            MahasiswaSeeder::class,
            KelasSeeder::class,
            PraktikumSeeder::class,
            EnrollmentSeeder::class,
            PenilaianSeeder::class,
            DetailPenilaianSeeder::class,
            KehadiranSeeder::class,
            FeedbackSeeder::class,
        ]);
    }
}
