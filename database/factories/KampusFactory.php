<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KampusFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => 'Institut Sains dan Teknologi Terpadu Surabaya',
            'alamat' => 'Ngagel Jaya Tengah 73-77 Surabaya, Jawa Timur, 60284',
            'no_telp' => '081230272723',
            'email' => 'web_admin@istts.ac.id',
        ];
    }
}
