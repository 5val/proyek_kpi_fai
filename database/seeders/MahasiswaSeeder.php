<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\ProgramStudi;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        // ambil semua id program studi
        $programStudiIds = ProgramStudi::pluck('id')->toArray();

        // ambil semua user dengan role mahasiswa
        $users = User::where('role', 'mahasiswa')->get();

        foreach ($users as $u) {
            Mahasiswa::create([
                'user_id' => $u->id,
                'nrp' => fake()->numerify("22#######"),
                'angkatan' => fake()->numberBetween(2020, 2025),
                'program_studi_id' => fake()->randomElement($programStudiIds),
                'ipk' => fake()->randomFloat(2, 2, 4),
            ]);
        }
    }
}
