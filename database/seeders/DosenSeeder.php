<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\User;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'dosen')->get();

        foreach ($users as $u) {

            Dosen::create([
                'user_id' => $u->id,
                'nidn' => fake()->numerify('########'),

                // kolom tambahan
                'code' => 'DSN' . fake()->unique()->numerify('###'),
                'start_date' => fake()->dateTimeBetween('-10 years', '-1 years')->format('Y-m-d'),

                // 20% kemungkinan end_date terisi
                'end_date' => fake()->optional(0.2)
                                ->dateTimeBetween('-1 years', 'now')
                                ?->format('Y-m-d'),

                'is_certified' => fake()->boolean(70) ? 1 : 0,

                // avg_kpi 0–4 decimal
                'avg_kpi' => fake()->randomFloat(2, 0, 4),
            ]);
        }
    }
}
