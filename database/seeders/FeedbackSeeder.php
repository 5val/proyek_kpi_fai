<?php

namespace Database\Seeders;

use App\Models\Praktikum;
use Illuminate\Database\Seeder;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Fasilitas;
use App\Models\Unit;
use App\Models\Kelas;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        $kategoriMap = [
            'mahasiswa' => [1, 3, 4, 5],
            'dosen' => [3, 6],
        ];

        $mahasiswa = User::where('role', 'mahasiswa')->get();
        $dosen = User::where('role', 'dosen')->get();

        // Target collections
        $dosenTargets = User::where('role', 'dosen')->pluck('id')->toArray();
        $fasilitasTargets = Fasilitas::pluck('id')->toArray();
        $unitTargets = Unit::pluck('id')->toArray();
        $praktikumTargets = Praktikum::pluck('id')->toArray();

        foreach (range(1, 50) as $i) {

            // tentukan pengirim
            $pengirim = rand(0,1) === 1
                ? $mahasiswa->random()
                : $dosen->random();

            // tentukan kategori sesuai role
            $allowedKategori = $kategoriMap[$pengirim->role];
            $kategoriId = collect($allowedKategori)->random();

            // tentukan target berdasarkan kategori
            $targetId = null;
            $targetType = null;

            switch ($kategoriId) {

                case 1: // dosen dinilai oleh mahasiswa
                    $targetId = collect($dosenTargets)->random();
                    $targetType = 'App\Models\Dosen';
                    break;

                case 3: // fasilitas
                    $targetId = collect($fasilitasTargets)->random();
                    $targetType = 'App\Models\Fasilitas';
                    break;

                case 4: // unit BAA/BAK/BAU
                    $targetId = collect($unitTargets)->random();
                    $targetType = 'App\Models\Unit';
                    break;

                case 5: // praktikum = kelas
                    $targetId = collect($praktikumTargets)->random();
                    $targetType = 'App\Models\Praktikum';
                    break;

                case 6: // manajemen kampus → target NULL (sesuai permintaan)
                    $targetId = 1;
                    $targetType = 'App\Models\Kampus';
                    break;
            }

            Feedback::create([
                'pengirim_id' => $pengirim->id,
                'kategori_id' => $kategoriId,
                'target_id'   => $targetId,
                'target_type' => $targetType,
                'isi'         => fake()->sentence(),
                'foto'        => null,
                'is_anonymous'=> fake()->boolean(50) ? 1 : 0,
                'status'      => 0,
            ]);
        }
    }
}
