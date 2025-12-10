<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MahasiswaFactory extends Factory
{
    public function definition()
    {
        return [
            'nrp' => $this->faker->unique()->numerify('07########'),
            'program_studi_id' => 1,
            'points_balance' => 0,
            'class_group' => $this->faker->randomElement(['A', 'B', 'C']),
            'ipk' => $this->faker->randomFloat(2, 2.00, 4.00),
            'user_id' => null,
            'avg_kpi' => 0.0,
        ];
    }
}
