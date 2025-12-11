<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $timestamp = now();

        /* =========================
         * MATA KULIAH (IDs 1..20)
        ========================== */
        $mkNames = [
            'Algoritma & Pemrograman',
            'Struktur Data',
            'Basis Data',
            'Jaringan Komputer',
            'Sistem Operasi',
            'Rekayasa Perangkat Lunak',
            'Interaksi Manusia-Komputer',
            'Pemrograman Web',
            'Pemrograman Mobile',
            'Kecerdasan Buatan',
            'Pembelajaran Mesin',
            'Keamanan Informasi',
            'Sistem Tertanam',
            'Grafika Komputer',
            'Pemodelan & Simulasi',
            'Manajemen Proyek TI',
            'Bisnis Digital',
            'Desain Produk',
            'Elektronika',
            'Pengantar Bisnis'
        ];

        $data = [];

        foreach ($mkNames as $index => $name) {
            $id = $index + 1;
            // Logic Code: ID 1 -> MK101, ID 20 -> MK120
            $codeNum = 100 + $id; 

            $data[] = [
                'id' => $id,
                'code' => "MK{$codeNum}",
                'name' => $name,
                'is_active' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        DB::table('mata_kuliah')->insert($data);
    }
}