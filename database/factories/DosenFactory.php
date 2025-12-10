<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DosenFactory extends Factory
{
    public function definition()
    {
        return [
            'code' => strtoupper($this->faker->bothify('DSN#')),
            'nidn' => $this->faker->unique()->numerify('10########'),
            'start_date' => $this->faker->date(),
            'end_date' => null,
            'is_certified' => $this->faker->boolean(),
            'user_id' => null,
            'avg_kpi' => 0.0,
        ];
    }
}
