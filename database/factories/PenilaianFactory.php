<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PenilaianFactory extends Factory
{
    public function definition()
    {
        return [
            'kategori_id' => 1,
            'penilai_id' => null,
            'dinilai_id' => null,
            'dinilai_type' => null,
            'periode_id' => 1,
            'komentar' => $this->faker->sentence(),
            'avg_score' => $this->faker->randomFloat(1, 2.0, 5.0),
        ];
    }
}
