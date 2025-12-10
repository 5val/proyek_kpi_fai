<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MataKuliahFactory extends Factory
{
    public function definition()
    {
        return [
            'code' => strtoupper($this->faker->bothify('MK###')),
            'name' => $this->faker->words(3, true),
            'is_active' => 1,
        ];
    }
}
