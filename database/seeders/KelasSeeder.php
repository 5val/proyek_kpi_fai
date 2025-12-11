<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $timestamp = now();

        /* =============================================
         * INSERT TABLE: KELAS (50 Data Presisi)
         * ============================================= */
        
        $kelasData = [
            ['id'=>1, 'code'=>'K01', 'mata_kuliah_id'=>1, 'program_studi_id'=>1, 'periode_id'=>1, 'dosen_nidn'=>'0011223301', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>2, 'code'=>'K02', 'mata_kuliah_id'=>2, 'program_studi_id'=>1, 'periode_id'=>1, 'dosen_nidn'=>'0011223302', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>3, 'code'=>'K03', 'mata_kuliah_id'=>3, 'program_studi_id'=>2, 'periode_id'=>2, 'dosen_nidn'=>'0011223303', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>4, 'code'=>'K04', 'mata_kuliah_id'=>4, 'program_studi_id'=>2, 'periode_id'=>1, 'dosen_nidn'=>'0011223304', 'sks'=>2, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>5, 'code'=>'K05', 'mata_kuliah_id'=>5, 'program_studi_id'=>3, 'periode_id'=>5, 'dosen_nidn'=>'0011223305', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>6, 'code'=>'K06', 'mata_kuliah_id'=>6, 'program_studi_id'=>3, 'periode_id'=>1, 'dosen_nidn'=>'0011223306', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>7, 'code'=>'K07', 'mata_kuliah_id'=>7, 'program_studi_id'=>4, 'periode_id'=>1, 'dosen_nidn'=>'0011223307', 'sks'=>2, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>8, 'code'=>'K08', 'mata_kuliah_id'=>8, 'program_studi_id'=>4, 'periode_id'=>2, 'dosen_nidn'=>'0011223308', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>9, 'code'=>'K09', 'mata_kuliah_id'=>9, 'program_studi_id'=>5, 'periode_id'=>5, 'dosen_nidn'=>'0011223309', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>10, 'code'=>'K10', 'mata_kuliah_id'=>10, 'program_studi_id'=>5, 'periode_id'=>1, 'dosen_nidn'=>'0011223310', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>11, 'code'=>'K11', 'mata_kuliah_id'=>11, 'program_studi_id'=>6, 'periode_id'=>2, 'dosen_nidn'=>'0011223311', 'sks'=>2, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>12, 'code'=>'K12', 'mata_kuliah_id'=>12, 'program_studi_id'=>6, 'periode_id'=>1, 'dosen_nidn'=>'0011223312', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>13, 'code'=>'K13', 'mata_kuliah_id'=>13, 'program_studi_id'=>7, 'periode_id'=>5, 'dosen_nidn'=>'0011223313', 'sks'=>2, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>14, 'code'=>'K14', 'mata_kuliah_id'=>14, 'program_studi_id'=>7, 'periode_id'=>1, 'dosen_nidn'=>'0011223314', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>15, 'code'=>'K15', 'mata_kuliah_id'=>15, 'program_studi_id'=>1, 'periode_id'=>2, 'dosen_nidn'=>'0011223315', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>16, 'code'=>'K16', 'mata_kuliah_id'=>16, 'program_studi_id'=>2, 'periode_id'=>1, 'dosen_nidn'=>'0011223316', 'sks'=>2, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>17, 'code'=>'K17', 'mata_kuliah_id'=>17, 'program_studi_id'=>3, 'periode_id'=>1, 'dosen_nidn'=>'0011223317', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>18, 'code'=>'K18', 'mata_kuliah_id'=>18, 'program_studi_id'=>4, 'periode_id'=>5, 'dosen_nidn'=>'0011223318', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>19, 'code'=>'K19', 'mata_kuliah_id'=>19, 'program_studi_id'=>5, 'periode_id'=>2, 'dosen_nidn'=>'0011223319', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>20, 'code'=>'K20', 'mata_kuliah_id'=>20, 'program_studi_id'=>6, 'periode_id'=>1, 'dosen_nidn'=>'0011223320', 'sks'=>2, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>21, 'code'=>'K21', 'mata_kuliah_id'=>1, 'program_studi_id'=>1, 'periode_id'=>1, 'dosen_nidn'=>'0011223301', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>22, 'code'=>'K22', 'mata_kuliah_id'=>2, 'program_studi_id'=>2, 'periode_id'=>1, 'dosen_nidn'=>'0011223302', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>23, 'code'=>'K23', 'mata_kuliah_id'=>3, 'program_studi_id'=>2, 'periode_id'=>2, 'dosen_nidn'=>'0011223303', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>24, 'code'=>'K24', 'mata_kuliah_id'=>4, 'program_studi_id'=>3, 'periode_id'=>1, 'dosen_nidn'=>'0011223304', 'sks'=>2, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>25, 'code'=>'K25', 'mata_kuliah_id'=>5, 'program_studi_id'=>3, 'periode_id'=>5, 'dosen_nidn'=>'0011223305', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>26, 'code'=>'K26', 'mata_kuliah_id'=>6, 'program_studi_id'=>4, 'periode_id'=>1, 'dosen_nidn'=>'0011223306', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>27, 'code'=>'K27', 'mata_kuliah_id'=>7, 'program_studi_id'=>4, 'periode_id'=>1, 'dosen_nidn'=>'0011223307', 'sks'=>2, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>28, 'code'=>'K28', 'mata_kuliah_id'=>8, 'program_studi_id'=>5, 'periode_id'=>2, 'dosen_nidn'=>'0011223308', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>29, 'code'=>'K29', 'mata_kuliah_id'=>9, 'program_studi_id'=>5, 'periode_id'=>5, 'dosen_nidn'=>'0011223309', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>30, 'code'=>'K30', 'mata_kuliah_id'=>10, 'program_studi_id'=>6, 'periode_id'=>1, 'dosen_nidn'=>'0011223310', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>31, 'code'=>'K31', 'mata_kuliah_id'=>11, 'program_studi_id'=>6, 'periode_id'=>2, 'dosen_nidn'=>'0011223311', 'sks'=>2, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>32, 'code'=>'K32', 'mata_kuliah_id'=>12, 'program_studi_id'=>7, 'periode_id'=>1, 'dosen_nidn'=>'0011223312', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>33, 'code'=>'K33', 'mata_kuliah_id'=>13, 'program_studi_id'=>1, 'periode_id'=>5, 'dosen_nidn'=>'0011223313', 'sks'=>2, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>34, 'code'=>'K34', 'mata_kuliah_id'=>14, 'program_studi_id'=>2, 'periode_id'=>1, 'dosen_nidn'=>'0011223314', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>35, 'code'=>'K35', 'mata_kuliah_id'=>15, 'program_studi_id'=>3, 'periode_id'=>2, 'dosen_nidn'=>'0011223315', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>36, 'code'=>'K36', 'mata_kuliah_id'=>16, 'program_studi_id'=>4, 'periode_id'=>1, 'dosen_nidn'=>'0011223316', 'sks'=>2, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>37, 'code'=>'K37', 'mata_kuliah_id'=>17, 'program_studi_id'=>5, 'periode_id'=>1, 'dosen_nidn'=>'0011223317', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>38, 'code'=>'K38', 'mata_kuliah_id'=>18, 'program_studi_id'=>6, 'periode_id'=>5, 'dosen_nidn'=>'0011223318', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>39, 'code'=>'K39', 'mata_kuliah_id'=>19, 'program_studi_id'=>7, 'periode_id'=>2, 'dosen_nidn'=>'0011223319', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>40, 'code'=>'K40', 'mata_kuliah_id'=>20, 'program_studi_id'=>1, 'periode_id'=>1, 'dosen_nidn'=>'0011223320', 'sks'=>2, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>41, 'code'=>'K41', 'mata_kuliah_id'=>1, 'program_studi_id'=>2, 'periode_id'=>1, 'dosen_nidn'=>'0011223301', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>42, 'code'=>'K42', 'mata_kuliah_id'=>2, 'program_studi_id'=>3, 'periode_id'=>1, 'dosen_nidn'=>'0011223302', 'sks'=>2, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>43, 'code'=>'K43', 'mata_kuliah_id'=>3, 'program_studi_id'=>4, 'periode_id'=>5, 'dosen_nidn'=>'0011223303', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>44, 'code'=>'K44', 'mata_kuliah_id'=>4, 'program_studi_id'=>5, 'periode_id'=>1, 'dosen_nidn'=>'0011223304', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>45, 'code'=>'K45', 'mata_kuliah_id'=>5, 'program_studi_id'=>6, 'periode_id'=>2, 'dosen_nidn'=>'0011223305', 'sks'=>2, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>46, 'code'=>'K46', 'mata_kuliah_id'=>6, 'program_studi_id'=>7, 'periode_id'=>1, 'dosen_nidn'=>'0011223306', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>47, 'code'=>'K47', 'mata_kuliah_id'=>7, 'program_studi_id'=>1, 'periode_id'=>1, 'dosen_nidn'=>'0011223307', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>48, 'code'=>'K48', 'mata_kuliah_id'=>8, 'program_studi_id'=>2, 'periode_id'=>5, 'dosen_nidn'=>'0011223308', 'sks'=>2, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>49, 'code'=>'K49', 'mata_kuliah_id'=>9, 'program_studi_id'=>3, 'periode_id'=>1, 'dosen_nidn'=>'0011223309', 'sks'=>3, 'has_praktikum'=>1, 'minimum_grade'=>'70', 'is_active'=>1],
            ['id'=>50, 'code'=>'K50', 'mata_kuliah_id'=>10, 'program_studi_id'=>4, 'periode_id'=>2, 'dosen_nidn'=>'0011223310', 'sks'=>3, 'has_praktikum'=>0, 'minimum_grade'=>'70', 'is_active'=>1],
        ];

        // Tambahkan timestamp
        foreach ($kelasData as &$row) {
            $row['created_at'] = $timestamp;
            $row['updated_at'] = $timestamp;
        }

        // Insert ke tabel kelas
        DB::table('kelas')->insert($kelasData);

        /* =============================================
         * INSERT TABLE: PRAKTIKUM
         * (Otomatis generate berdasarkan kelas yang has_praktikum = 1)
         * ============================================= */
        
        $kpiValues = [
            1 => 3.5,  2 => 3.2,  3 => 3.8,  6 => 2.9,  8 => 3.4,
            9 => 3.1,  12 => 3.6, 14 => 3.3, 17 => 3.0, 19 => 3.7,
            21 => 3.5, 23 => 3.2, 24 => 3.9, 26 => 3.1, 28 => 3.4,
            30 => 3.0, 32 => 3.6, 34 => 3.3, 36 => 2.8, 38 => 3.5,
            40 => 3.2, 42 => 3.1, 43 => 3.7, 45 => 3.4, 47 => 3.6, 
            49 => 3.3
        ];

        $praktikumData = [];
        foreach ($kelasData as $kelas) {
            if ($kelas['has_praktikum'] == 1) {
                // Ambil nilai dari array kpiValues berdasarkan ID kelas.
                // Jika ID tidak ada di list (jaga-jaga), default ke 3.0
                $nilaiKpi = $kpiValues[$kelas['id']] ?? 3.0;

                $praktikumData[] = [
                    'kelas_id' => $kelas['id'],
                    'avg_kpi' => $nilaiKpi,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }
        }

        if (!empty($praktikumData)) {
            DB::table('praktikum')->insert($praktikumData);
        }
    }
}