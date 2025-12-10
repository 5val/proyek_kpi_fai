<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IndikatorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Sample indikator',
            'bobot' => 10,
            'kategori_id' => 1,
        ];
    }
}
