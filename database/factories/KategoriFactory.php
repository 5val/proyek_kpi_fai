<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Sample',
            'description' => 'Sample description',
            'target_role' => 'sample',
        ];
    }
}
