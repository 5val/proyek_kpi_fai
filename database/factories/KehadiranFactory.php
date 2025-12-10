<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KehadiranFactory extends Factory
{
    public function definition()
    {
        return [
            'kelas_id' => null,
            'pertemuan_ke' => $this->faker->numberBetween(1, 14),
            'mahasiswa_nrp' => null,
            'is_present' => $this->faker->boolean(90),
            'remarks' => null,
        ];
    }
}
