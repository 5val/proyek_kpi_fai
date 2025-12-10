<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    public function definition()
    {
        return [
            'code' => strtoupper($this->faker->bothify('K##')),
            'mata_kuliah_id' => null,
            'program_studi_id' => 1,
            'periode_id' => 1,
            'dosen_nidn' => null,
            'sks' => $this->faker->randomElement([2,3]),
            'has_praktikum' => $this->faker->boolean(40),
            'minimum_grade' => $this->faker->randomElement(['A','B','C']),
            'is_active' => 1,
        ];
    }
}
