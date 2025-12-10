<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // admin (5)
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => fake('id_ID')->name(),
                'email' => "admin$i@istts.ac.id",
                'role' => 'admin',
                'phone_number' => fake()->numerify('08##########'),
                'password' => bcrypt('123456'),
            ]);
        }

        // dosen (30)
        for ($i = 1; $i <= 30; $i++) {
            User::create([
                'name' => fake('id_ID')->name(),
                'email' => "dosen$i@istts.ac.id",
                'role' => 'dosen',
                'phone_number' => fake()->numerify('08##########'),
                'password' => bcrypt('123456'),
            ]);
        }

        // mahasiswa (100)
        for ($i = 1; $i <= 100; $i++) {
            User::create([
                'name' => fake('id_ID')->name(),
                'email' => "mhs$i@istts.ac.id",
                'role' => 'mahasiswa',
                'phone_number' => fake()->numerify('08##########'),
                'password' => bcrypt('123456'),
            ]);
        }
    }
}
