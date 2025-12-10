<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    public function definition()
    {
        return [
            'kelas_id' => null,
            'mahasiswa_nrp' => null,
        ];
    }
}
