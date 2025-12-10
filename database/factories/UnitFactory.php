<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['BAA','BAK','BAU']),
            'penanggung_jawab_id' => null,
            'name' => $this->faker->company(),
            'avg_kpi' => 0.0,
            'is_active' => 1,
        ];
    }
}
