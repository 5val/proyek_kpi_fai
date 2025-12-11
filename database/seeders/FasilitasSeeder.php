<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $timestamp = now();

        /* =============================================
         * INSERT TABLE: FASILITAS (30 Data)
         * ============================================= */
        
        $fasilitas = [
            ['id'=>1,  'code'=>'FAS001', 'name'=>'Perpustakaan Pusat',       'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>6,  'avg_kpi'=>2.8, 'is_active'=>1],
            ['id'=>2,  'code'=>'FAS002', 'name'=>'Laboratorium Komputer 1',  'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>7,  'avg_kpi'=>3.0, 'is_active'=>1],
            ['id'=>3,  'code'=>'FAS003', 'name'=>'Laboratorium Komputer 2',  'kategori'=>'Akademik',     'kondisi'=>'perbaikan', 'penanggung_jawab'=>8,  'avg_kpi'=>2.2, 'is_active'=>0],
            ['id'=>4,  'code'=>'FAS004', 'name'=>'Kantin Utama',             'kategori'=>'Umum',         'kondisi'=>'baik',      'penanggung_jawab'=>9,  'avg_kpi'=>3.1, 'is_active'=>1],
            ['id'=>5,  'code'=>'FAS005', 'name'=>'Sport Center',             'kategori'=>'Olahraga',     'kondisi'=>'baik',      'penanggung_jawab'=>10, 'avg_kpi'=>3.3, 'is_active'=>1],
            ['id'=>6,  'code'=>'FAS006', 'name'=>'Auditorium',               'kategori'=>'Umum',         'kondisi'=>'baik',      'penanggung_jawab'=>11, 'avg_kpi'=>3.0, 'is_active'=>1],
            ['id'=>7,  'code'=>'FAS007', 'name'=>'Poliklinik',               'kategori'=>'Kesehatan',    'kondisi'=>'perbaikan', 'penanggung_jawab'=>12, 'avg_kpi'=>2.0, 'is_active'=>1],
            ['id'=>8,  'code'=>'FAS008', 'name'=>'Masjid Kampus',            'kategori'=>'Umum',         'kondisi'=>'baik',      'penanggung_jawab'=>13, 'avg_kpi'=>3.5, 'is_active'=>1],
            ['id'=>9,  'code'=>'FAS009', 'name'=>'Taman Belajar',            'kategori'=>'Umum',         'kondisi'=>'baik',      'penanggung_jawab'=>14, 'avg_kpi'=>3.2, 'is_active'=>1],
            ['id'=>10, 'code'=>'FAS010', 'name'=>'Ruang Rapat Senat',        'kategori'=>'Administrasi', 'kondisi'=>'baik',      'penanggung_jawab'=>15, 'avg_kpi'=>3.1, 'is_active'=>1],
            ['id'=>11, 'code'=>'FAS011', 'name'=>'Laboratorium Jaringan',    'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>16, 'avg_kpi'=>3.0, 'is_active'=>1],
            ['id'=>12, 'code'=>'FAS012', 'name'=>'Laboratorium AI',          'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>17, 'avg_kpi'=>3.4, 'is_active'=>1],
            ['id'=>13, 'code'=>'FAS013', 'name'=>'Studio Desain',            'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>18, 'avg_kpi'=>3.1, 'is_active'=>1],
            ['id'=>14, 'code'=>'FAS014', 'name'=>'Ruang Sidang',             'kategori'=>'Administrasi', 'kondisi'=>'baik',      'penanggung_jawab'=>19, 'avg_kpi'=>2.9, 'is_active'=>1],
            ['id'=>15, 'code'=>'FAS015', 'name'=>'Kantin Kecil',             'kategori'=>'Umum',         'kondisi'=>'baik',      'penanggung_jawab'=>20, 'avg_kpi'=>3.0, 'is_active'=>1],
            ['id'=>16, 'code'=>'FAS016', 'name'=>'Gudang Peralatan',         'kategori'=>'Umum',         'kondisi'=>'perbaikan', 'penanggung_jawab'=>6,  'avg_kpi'=>2.1, 'is_active'=>1],
            ['id'=>17, 'code'=>'FAS017', 'name'=>'Laboratorium Elektronika', 'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>7,  'avg_kpi'=>3.3, 'is_active'=>1],
            ['id'=>18, 'code'=>'FAS018', 'name'=>'Ruang Kelas A1',           'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>8,  'avg_kpi'=>3.2, 'is_active'=>1],
            ['id'=>19, 'code'=>'FAS019', 'name'=>'Ruang Kelas B2',           'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>9,  'avg_kpi'=>3.0, 'is_active'=>1],
            ['id'=>20, 'code'=>'FAS020', 'name'=>'Perpustakaan Cabang',      'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>10, 'avg_kpi'=>2.8, 'is_active'=>1],
            ['id'=>21, 'code'=>'FAS021', 'name'=>'Laboratorium Praktikum',   'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>11, 'avg_kpi'=>3.6, 'is_active'=>1],
            ['id'=>22, 'code'=>'FAS022', 'name'=>'Ruang Diskusi',            'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>12, 'avg_kpi'=>3.2, 'is_active'=>1],
            ['id'=>23, 'code'=>'FAS023', 'name'=>'Kantin Teknik',            'kategori'=>'Umum',         'kondisi'=>'perbaikan', 'penanggung_jawab'=>13, 'avg_kpi'=>2.7, 'is_active'=>1],
            ['id'=>24, 'code'=>'FAS024', 'name'=>'Lapangan Olahraga',        'kategori'=>'Olahraga',     'kondisi'=>'baik',      'penanggung_jawab'=>14, 'avg_kpi'=>3.4, 'is_active'=>1],
            ['id'=>25, 'code'=>'FAS025', 'name'=>'Ruang Multimedia',         'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>15, 'avg_kpi'=>3.3, 'is_active'=>1],
            ['id'=>26, 'code'=>'FAS026', 'name'=>'Kantor Dosen',             'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>16, 'avg_kpi'=>3.0, 'is_active'=>1],
            ['id'=>27, 'code'=>'FAS027', 'name'=>'Studio Fotografi',         'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>17, 'avg_kpi'=>3.1, 'is_active'=>1],
            ['id'=>28, 'code'=>'FAS028', 'name'=>'Laboratorium Mekanik',     'kategori'=>'Akademik',     'kondisi'=>'perbaikan', 'penanggung_jawab'=>18, 'avg_kpi'=>2.5, 'is_active'=>0],
            ['id'=>29, 'code'=>'FAS029', 'name'=>'Ruang Presentasi',         'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>19, 'avg_kpi'=>3.2, 'is_active'=>1],
            ['id'=>30, 'code'=>'FAS030', 'name'=>'Ruang Tutorial',           'kategori'=>'Akademik',     'kondisi'=>'baik',      'penanggung_jawab'=>20, 'avg_kpi'=>3.0, 'is_active'=>1],
        ];

        // Tambahkan timestamp ke setiap row
        foreach ($fasilitas as &$row) {
            $row['created_at'] = $timestamp;
            $row['updated_at'] = $timestamp;
        }

        DB::table('fasilitas')->insert($fasilitas);
    }
}