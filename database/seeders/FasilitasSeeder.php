<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fasilitas;
use App\Models\User;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $dosenIds = User::where('role', 'dosen')->pluck('id')->toArray();

        $namaFasilitas = [
            'Laboratorium Komputer',
            'Laboratorium Jaringan',
            'Laboratorium Multimedia',
            'Laboratorium Elektronika',
            'Ruang Rapat Senat',
            'Ruang Ketua Prodi',
            'Perpustakaan Utama',
            'Perpustakaan Fakultas',
            'Ruang Bimbingan Akademik',
            'Ruang Dosen',
            'Ruang Server',
            'Studio Foto',
            'Studio Musik',
            'Aula Utama',
            'Auditorium',
            'Ruang Seminar',
            'Ruang Kelas A1',
            'Ruang Kelas B2',
            'Ruang Kelas C3',
            'Kantin Mahasiswa',
            'Lapangan Basket',
            'Lapangan Futsal',
            'Ruang UKM',
            'Klinik Kampus',
            'Lobi Utama',
            'Ruang Administrasi',
            'Ruang Keuangan',
            'Parkiran Mobil',
            'Parkiran Motor',
            'Pusat Bahasa',
        ];

        foreach ($namaFasilitas as $name) {
            Fasilitas::create([
                'code' => 'FAS' . fake()->unique()->numerify('###'),
                'name' => $name,
                'kondisi' => fake()->randomElement(['baik', 'perbaikan']),
                'penanggung_jawab' => fake()->randomElement($dosenIds),
                'avg_kpi' => fake()->randomFloat(2, 0, 4),
            ]);
        }
    }
}

