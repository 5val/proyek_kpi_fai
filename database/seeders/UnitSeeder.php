<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $timestamp = now();

        $units = [
            [
                'id' => 1,
                'type' => 'BAA',
                'penanggung_jawab_id' => 1,
                'name' => 'Biro Administrasi Akademik',
                'avg_kpi' => 3.5,
                'is_active' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'id' => 2,
                'type' => 'BAK',
                'penanggung_jawab_id' => 2,
                'name' => 'Biro Administrasi Kemahasiswaan',
                'avg_kpi' => 3.5,
                'is_active' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'id' => 3,
                'type' => 'BAU',
                'penanggung_jawab_id' => 3,
                'name' => 'Biro Administrasi Keuangan',
                'avg_kpi' => 3.4,
                'is_active' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ];

        DB::table('unit')->insert($units);
    }
}