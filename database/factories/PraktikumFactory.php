<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PraktikumFactory extends Factory
{
    public function definition()
    {
        return [
            'kelas_id' => null,
            'avg_kpi' => 0.0,
        ];
    }
}
