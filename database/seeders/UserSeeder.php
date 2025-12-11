<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Password default: 123456
        $pwd = Hash::make('123456'); 
        $timestamp = now();

        /* =============================================
         * 1) INSERT USERS: ADMIN (IDs 1..5)
         * ============================================= */
        $admins = [];
        for ($i = 1; $i <= 5; $i++) {
            $admins[] = [
                'id' => $i,
                'name' => "Admin $i",
                'email' => "admin{$i}@istts.ac.id",
                'phone_number' => "08120000000{$i}",
                'password' => $pwd,
                'role' => 'admin',
                'is_active' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        DB::table('users')->insert($admins);


        /* =============================================
         * 2) INSERT USERS: DOSEN (IDs 6..25)
         * ============================================= */
        $dosenNames = [
            'Dr. Budi Santoso','Prof. Citra Lestari','Dr. Ahmad Dahlan','Dewi Puspita','Eko Prasetyo',
            'Fajar Nugroho','Gita Permata','Hadi Wijaya','Indah Cahyani','Joko Susilo',
            'Lina Marlina','Maya Sari','Nico Pratama','Olivia Putri','Putra Adi',
            'Qori Aulia','Rina Amelia','Sari Dewi','Teguh Wijaya','Umar Bakri'
        ];

        $dosenUsers = [];
        for ($i = 0; $i < 20; $i++) {
            $id = 6 + $i; // ID dimulai dari 6
            $dosenUsers[] = [
                'id' => $id,
                'name' => $dosenNames[$i],
                'email' => "dosen" . ($i + 1) . "@istts.ac.id",
                'phone_number' => "0812100000" . str_pad($id, 2, "0", STR_PAD_LEFT),
                'password' => $pwd,
                'role' => 'dosen',
                'is_active' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        DB::table('users')->insert($dosenUsers);


        /* =============================================
         * 3) INSERT USERS: MAHASISWA (IDs 26..125)
         * ============================================= */
        $mhsNames = [
            'Aditya Pratama','Bella Kurnia','Cahya Putra','Dina Lestari','Eko Susanto',
            'Fitri Handayani','Gilang Saputra','Hanna Tri','Ilham Ridwan','Jasmine Putri',
            'Kevin Wijaya','Lia Andriana','Mikhail Ardi','Nadia Salsabila','Oki Prasetyo',
            'Putri Ramadhani','Qomarudin','Rani Maharani','Sandi Kurniawan','Tia Nur',
            'Uli Hidayat','Vina Safitri','Wawan Setiawan','Xavier Rahman','Yulia Citra',
            'Zaki Mubarok','Alya Prameswari','Bima Santoso','Citra Dewi','Dedi Pranata',
            'Erlangga','Fiona Aulia','Gusti Putra','Hani Irma','Irfan Maulana',
            'Jefrianto','Kiki Amelia','Lutfi','Maya','Nico',
            'Oni','Pipit','Qila','Rizal','Sasha',
            'Tono','Umi','Vero','Widi','Xena',
            'Yusuf','Zara','Arman','Beni','Cindy',
            'Dewi','Evan','Fani','Gina','Hendra',
            'Ika','Johan','Kurnia','Lala','Mita',
            'Nanda','Owen','Putra','Qori','Riza',
            'Santi','Tegar','Ulfah','Viki','Wulan',
            'Xavier','Yosef','Zulkifli','Angga','Bela',
            'Candra','Dian','Edo','Fadil','Gilang',
            'Hilda','Irfan','Joko','Kiki','Lukas',
            'Maya','Nia','Oka','Panca','Qiana',
            'Rafi','Sasa','Tari','Udin','Vina',
        ];

        $mahasiswaUsers = [];
        for ($i = 0; $i < 100; $i++) {
            $id = 26 + $i; // ID dimulai dari 26
            $mahasiswaUsers[] = [
                'id' => $id,
                'name' => $mhsNames[$i],
                'email' => "mhs" . ($i + 1) . "@istts.ac.id",
                'phone_number' => "0812200000" . str_pad($id, 3, "0", STR_PAD_LEFT),
                'password' => $pwd,
                'role' => 'mahasiswa',
                'is_active' => 1,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        // Insert dalam chunk agar tidak overload jika query terlalu panjang
        foreach (array_chunk($mahasiswaUsers, 50) as $chunk) {
            DB::table('users')->insert($chunk);
        }


        /* =============================================
         * 4) INSERT TABLE: DOSEN (Relasi ke User 6..25)
         * ============================================= */
        $dosenTable = [];
        for ($i = 0; $i < 20; $i++) {
            $userId = 6 + $i;
            $dosenTable[] = [
                // 'id' => auto increment, biarkan database handle atau set manual 1..20
                'code' => "DSN-" . str_pad($i + 1, 3, "0", STR_PAD_LEFT),
                'nidn' => "00112233" . str_pad($i + 1, 2, "0", STR_PAD_LEFT),
                'start_date' => date('Y-m-d', strtotime("-" . rand(3, 12) . " years")),
                'end_date' => null,
                'is_certified' => rand(0, 1),
                'user_id' => $userId,
                'avg_kpi' => 0.0,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        DB::table('dosen')->insert($dosenTable);


        /* =============================================
         * 5) INSERT TABLE: MAHASISWA (Relasi ke User 26..125)
         * ============================================= */
        $mahasiswaTable = [];
        $classGroups = ['A', 'B', 'C'];
        
        for ($i = 0; $i < 100; $i++) {
            $userId = 26 + $i;
            $nrpSequence = $i + 1;
            
            $mahasiswaTable[] = [
                'nrp' => "220000" . str_pad($nrpSequence, 3, "0", STR_PAD_LEFT),
                'program_studi_id' => 1, // Default IF sesuai SQL insert
                'points_balance' => 0,
                'class_group' => $classGroups[array_rand($classGroups)],
                'ipk' => rand(300, 400) / 100, // IPK antara 3.00 - 4.00
                'user_id' => $userId,
                'avg_kpi' => 0.0,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        foreach (array_chunk($mahasiswaTable, 50) as $chunk) {
            DB::table('mahasiswa')->insert($chunk);
        }
    }
}