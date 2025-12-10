<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_periode' => 'Sample',
            'tahun' => 2024,
            'semester' => 'gasal',
        ];
    }
}
