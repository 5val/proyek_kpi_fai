<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramStudiFactory extends Factory
{
    public function definition()
    {
        return [
            'code' => $this->faker->lexify('??'),
            'name' => $this->faker->words(2, true),
            'short_name' => strtoupper($this->faker->lexify('??')),
        ];
    }
}
