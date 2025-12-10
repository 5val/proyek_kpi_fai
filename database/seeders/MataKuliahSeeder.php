<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataKuliah;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            "Algoritma dan Pemrograman",
            "Struktur Data",
            "Basis Data",
            "Jaringan Komputer",
            "Sistem Operasi",
            "Pemrograman Berorientasi Objek",
            "Rekayasa Perangkat Lunak",
            "Kalkulus",
            "Matematika Diskrit",
            "Kecerdasan Buatan",
            "Pengembangan Web",
            "Pengembangan Aplikasi Mobile",
            "Sistem Informasi Manajemen",
            "Analisis dan Perancangan Sistem",
            "Pemrograman Framework",
            "Statistika",
            "Keamanan Informasi",
            "Manajemen Proyek TI",
            "Komputasi Awan",
            "Internet of Things",
            "Pengolahan Citra Digital",
            "Machine Learning",
            "Data Mining",
            "Bahasa Indonesia",
            "Agama"
        ];

        foreach ($names as $index => $name) {

            // Generate code seperti "MK001", "MK002", dll
            $code = "MK" . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

            MataKuliah::factory()->create([
                'code' => $code,
                'name' => $name,
            ]);
        }
    }
}
