<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DetailPenilaianFactory extends Factory
{
    public function definition()
    {
        return [
            'penilaian_id' => null,
            'indikator_id' => null,
            'score' => $this->faker->numberBetween(1, 5),
        ];
    }
}
