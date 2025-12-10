<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    public function definition()
    {
        return [
            'pengirim_id' => null,
            'kategori_id' => 1,
            'target_id' => null,
            'target_type' => null,
            'isi' => $this->faker->sentence(),
            'foto' => null,
            'is_anonymous' => 0,
            'status' => 0,
        ];
    }
}
