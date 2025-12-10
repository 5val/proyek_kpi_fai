<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use App\Models\Kategori;
use App\Models\Penilaian;
use App\Models\Periode;
use App\Models\Praktikum;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class PenilaianSeeder extends Seeder
{
    public function run()
    {
        $periodes = Periode::all();

        // Role groups
        $mahasiswa = User::where('role', 'mahasiswa')->get();
        $dosen = User::where('role', 'dosen')->get();

        // Target collections
        $dosenTargets = User::where('role', 'dosen')->pluck('id')->toArray();
        $fasilitasTargets = Fasilitas::pluck('id')->toArray();
        $unitTargets = Unit::pluck('id')->toArray();
        $praktikumTargets = Praktikum::pluck('id')->toArray();

        // Kategori constraints
        $kategoriMap = [
            'mahasiswa' => [1, 3, 4, 5],
            'dosen' => [3, 6],
        ];

        foreach (range(1, 150) as $i) {

            /** ---------------------------------------------------------
             * GENERATE TANGGAL CREATED DAN DELETED (VARIASI 6 BULAN)
             * --------------------------------------------------------- */
            $createdAt = fake()->dateTimeBetween('-6 months', 'now');

            // 15% kemungkinan soft delete
            $deletedAt = fake()->boolean(15)
                ? fake()->dateTimeBetween($createdAt, 'now')
                : null;

            /** ---------------------------------------------------------
             * TENTUKAN PENILAI
             * --------------------------------------------------------- */
            $penilai = rand(0,1) == 1
                ? $mahasiswa->random()
                : $dosen->random();

            /** ---------------------------------------------------------
             * TENTUKAN KATEGORI
             * --------------------------------------------------------- */
            $allowedKategori = $kategoriMap[$penilai->role];
            $kategoriId = collect($allowedKategori)->random();

            $kategori = Kategori::with('indikator')->find($kategoriId);

            /** ---------------------------------------------------------
             * TENTUKAN TARGET
             * --------------------------------------------------------- */
            switch ($kategoriId) {
                case 1: // nilai dosen
                    $targetId = collect($dosenTargets)->random();
                    $targetType = 'App\Models\Dosen';
                    break;

                case 3: // fasilitas
                    $targetId = collect($fasilitasTargets)->random();
                    $targetType = 'App\Models\Fasilitas';
                    break;

                case 4: // unit
                    $targetId = collect($unitTargets)->random();
                    $targetType = 'App\Models\Unit';
                    break;

                case 5: // praktikum
                    $targetId = collect($praktikumTargets)->random();
                    $targetType = 'App\Models\Praktikum';
                    break;

                case 6: // manajemen kampus
                    $targetId = 1;
                    $targetType = 'App\Models\Kampus';
                    break;
            }

            /** ---------------------------------------------------------
             * INSERT PENILAIAN
             * --------------------------------------------------------- */
            $penilaian = Penilaian::create([
                'kategori_id' => $kategori->id,
                'penilai_id' => $penilai->id,
                'dinilai_id' => $targetId,
                'dinilai_type' => $targetType,
                'periode_id' => $periodes->random()->id,
                'komentar' => fake()->sentence(),
                'avg_score' => fake()->randomFloat(2, 0, 4),

                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            /** ---------------------------------------------------------
             * INSERT DETAIL PENILAIAN
             * --------------------------------------------------------- */
            foreach ($kategori->indikator as $indikator) {

                // created_at detail mengikuti penilaian tapi beda beberapa hari
                $detailCreated = fake()->dateTimeBetween(
                    $createdAt->format('Y-m-d H:i:s'),
                    'now'
                );

                $detailDeleted = fake()->boolean(10)
                    ? fake()->dateTimeBetween($detailCreated, 'now')
                    : null;

                $penilaian->detailPenilaian()->create([
                    'penilaian_id' => $penilaian->id,
                    'indikator_id' => $indikator->id,
                    'score' => fake()->numberBetween(1, 5),

                    'created_at' => $detailCreated,
                    'updated_at' => $detailCreated,
                ]);
            }
        }
    }
}
