<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramStudi;
use Carbon\Carbon;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'code' => 'TI',
                'name' => 'Teknik Informatika',
                'short_name' => 'Infor',
            ],
            [
                'id' => 2,
                'code' => 'SIB',
                'name' => 'Sistem Informasi Bisnis',
                'short_name' => 'SIB',
            ],
            [
                'id' => 3,
                'code' => 'DKV',
                'name' => 'Desain Komunikasi Visual',
                'short_name' => 'DKV',
            ],
            [
                'id' => 4,
                'code' => 'TIU',
                'name' => 'Teknik Industri',
                'short_name' => 'Industri',
            ],
            [
                'id' => 5,
                'code' => 'TE',
                'name' => 'Teknik Elektro',
                'short_name' => 'Elektro',
            ],
            [
                'id' => 6,
                'code' => 'DP',
                'name' => 'Desain Produk',
                'short_name' => 'Despro',
            ],
            [
                'id' => 7,
                'code' => 'MBD',
                'name' => 'Manajemen Bisnis Digital',
                'short_name' => 'MBD',
            ]
        ];

        foreach ($data as $item) {
            ProgramStudi::updateOrCreate(
                ['id' => $item['id']],
                [
                    'code' => $item['code'],
                    'name' => $item['name'],
                    'short_name' => $item['short_name'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
