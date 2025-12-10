<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->numerify('08##########'),
            'password' => Hash::make('123456'),
            'role' => 'mahasiswa',
            'photo_profile' => null,
            'is_active' => 1,
        ];
    }
}
