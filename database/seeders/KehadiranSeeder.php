<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\Enrollment;

class KehadiranSeeder extends Seeder
{
    public function run(): void
    {
        $kelasList = Kelas::all();

        foreach ($kelasList as $kelas) {

            // Ambil mahasiswa yang benar-benar ikut kelas itu
            $enrolledMahasiswa = Enrollment::where('kelas_id', $kelas->id)
                ->pluck('mahasiswa_nrp')
                ->toArray();

            // Jika tidak ada mahasiswa, skip kelas
            if (empty($enrolledMahasiswa)) continue;

            foreach ($enrolledMahasiswa as $nrp) {

                // generate kehadiran pertemuan 1–14
                for ($pertemuan = 1; $pertemuan <= 14; $pertemuan++) {

                    Kehadiran::create([
                        'kelas_id' => $kelas->id,
                        'mahasiswa_nrp' => $nrp,
                        'pertemuan_ke' => $pertemuan,

                        // hadir kemungkinan lebih besar
                        'is_present' => fake()->boolean(85), // 85% hadir

                        // remarks kosong atau kecil kemungkinan ada catatan
                        'remarks' => fake()->boolean(10) 
                            ? fake()->sentence()
                            : null,
                    ]);
                }
            }
        }
    }
}
