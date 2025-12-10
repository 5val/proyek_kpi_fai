<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FasilitasFactory extends Factory
{
    public function definition()
    {
        return [
            'code' => strtoupper($this->faker->bothify('F##')),
            'name' => $this->faker->words(2, true),
            'kategori' => $this->faker->randomElement(['ruangan','lab','umum']),
            'kondisi' => $this->faker->randomElement(['baik','perbaikan']),
            'penanggung_jawab' => null,
            'avg_kpi' => 0.0,
            'is_active' => 1,
        ];
    }
}
