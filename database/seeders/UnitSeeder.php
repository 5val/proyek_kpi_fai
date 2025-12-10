<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;
use App\Models\User;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $dosenIds = User::where('role', 'dosen')->pluck('id')->toArray();
        $names = ['BAA', 'BAK', 'BAU'];

        foreach ($names as $t) {
            Unit::factory()->create([
                'name' => $t,
                'penanggung_jawab_id' => fake()->randomElement($dosenIds),
                'avg_kpi' => fake()->randomFloat(2, 0, 4),
            ]);
        }
    }
}
