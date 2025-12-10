<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Indikator;

class IndikatorSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['id'=>1,'name'=>'Kesiapan dosen dalam menyampaikan materi','bobot'=>20,'kategori_id'=>1,'created_at'=>'2025-11-02 19:02:40','updated_at'=>'2025-11-18 11:55:39'],
            ['id'=>2,'name'=>'Kejelasan penyampaian materi','bobot'=>20,'kategori_id'=>1,'created_at'=>'2025-11-02 19:02:40','updated_at'=>'2025-11-18 11:55:55'],
            ['id'=>3,'name'=>'Ketepatan waktu mengajar','bobot'=>15,'kategori_id'=>1,'created_at'=>'2025-11-02 19:02:40','updated_at'=>'2025-11-18 11:56:08'],
            ['id'=>4,'name'=>'Interaksi & kemampuan menjawab pertanyaan mahasiswa','bobot'=>15,'kategori_id'=>1,'created_at'=>'2025-11-02 19:02:40','updated_at'=>'2025-11-18 11:56:32'],
            ['id'=>5,'name'=>'Penggunaan metode & media pembelajaran yang efektif','bobot'=>15,'kategori_id'=>1,'created_at'=>'2025-11-02 19:02:40','updated_at'=>'2025-11-18 11:56:46'],
            ['id'=>6,'name'=>'Penilaian yang transparan & sesuai kriteria','bobot'=>15,'kategori_id'=>1,'created_at'=>'2025-11-02 19:02:40','updated_at'=>'2025-11-18 11:56:51'],

            ['id'=>13,'name'=>'Ketersediaan fasilitas','bobot'=>20,'kategori_id'=>3,'created_at'=>'2025-11-18 11:58:43','updated_at'=>'2025-11-18 11:58:43'],
            ['id'=>14,'name'=>'Kebersihan & kenyamanan fasilitas','bobot'=>20,'kategori_id'=>3,'created_at'=>'2025-11-18 11:59:22','updated_at'=>'2025-11-18 11:59:22'],
            ['id'=>15,'name'=>'Keandalan & perawatan fasilitas','bobot'=>15,'kategori_id'=>3,'created_at'=>'2025-11-18 11:59:43','updated_at'=>'2025-11-18 11:59:43'],

            ['id'=>16,'name'=>'Kecepatan pelayanan','bobot'=>20,'kategori_id'=>4,'created_at'=>'2025-11-18 11:59:49','updated_at'=>'2025-11-18 11:59:49'],
            ['id'=>17,'name'=>'Ketepatan & akurasi informasi yang diberikan','bobot'=>20,'kategori_id'=>4,'created_at'=>'2025-11-18 12:00:01','updated_at'=>'2025-11-18 12:00:01'],
            ['id'=>18,'name'=>'Keramahan & profesionalitas staf','bobot'=>15,'kategori_id'=>4,'created_at'=>'2025-11-18 12:00:40','updated_at'=>'2025-11-18 12:00:47'],
            ['id'=>19,'name'=>'Kemudahan akses layanan (offline/online)','bobot'=>15,'kategori_id'=>4,'created_at'=>'2025-11-18 12:00:59','updated_at'=>'2025-11-18 12:00:59'],
            ['id'=>20,'name'=>'Efektivitas penyelesaian keluhan','bobot'=>15,'kategori_id'=>4,'created_at'=>'2025-11-18 12:01:10','updated_at'=>'2025-11-18 12:01:10'],

            ['id'=>21,'name'=>'Kesiapan asisten/lab dan kejelasan instruksi','bobot'=>20,'kategori_id'=>5,'created_at'=>'2025-11-18 12:01:39','updated_at'=>'2025-11-18 12:01:39'],
            ['id'=>22,'name'=>'Relevansi praktikum dengan materi kuliah','bobot'=>15,'kategori_id'=>5,'created_at'=>'2025-11-18 12:02:02','updated_at'=>'2025-11-18 12:02:02'],
            ['id'=>23,'name'=>'Ketersediaan fasilitas praktikum','bobot'=>20,'kategori_id'=>5,'created_at'=>'2025-11-18 12:02:32','updated_at'=>'2025-11-18 12:02:32'],
            ['id'=>24,'name'=>'Efisiensi pelaksanaan praktikum','bobot'=>15,'kategori_id'=>5,'created_at'=>'2025-11-18 12:03:02','updated_at'=>'2025-11-18 12:03:02'],
            ['id'=>25,'name'=>'Penilaian laporan atau hasil praktikum yang objektif','bobot'=>15,'kategori_id'=>5,'created_at'=>'2025-11-18 12:03:07','updated_at'=>'2025-11-18 12:03:07'],

            ['id'=>26,'name'=>'Kejelasan dan kemudahan pemahaman peraturan kampus','bobot'=>20,'kategori_id'=>6,'created_at'=>'2025-12-03 10:46:14','updated_at'=>'2025-12-03 10:46:14'],
            ['id'=>27,'name'=>'Transparansi kebijakan dan pengambilan keputusan','bobot'=>20,'kategori_id'=>6,'created_at'=>'2025-12-03 10:46:36','updated_at'=>'2025-12-03 10:46:36'],
            ['id'=>28,'name'=>'Efektivitas penyampaian informasi manajerial','bobot'=>15,'kategori_id'=>6,'created_at'=>'2025-12-03 10:46:55','updated_at'=>'2025-12-03 10:46:55'],
            ['id'=>29,'name'=>'Responsivitas manajemen terhadap aspirasi','bobot'=>20,'kategori_id'=>6,'created_at'=>'2025-12-03 10:47:46','updated_at'=>'2025-12-03 10:47:46'],
            ['id'=>30,'name'=>'Kinerja kampus dalam pelaksanaan program kerja tahunan','bobot'=>15,'kategori_id'=>6,'created_at'=>'2025-12-03 10:48:06','updated_at'=>'2025-12-03 10:48:06'],
            ['id'=>31,'name'=>'Ketersediaan dan implementasi SOP manajemen kampus','bobot'=>10,'kategori_id'=>6,'created_at'=>'2025-12-03 10:48:23','updated_at'=>'2025-12-03 10:48:23'],
        ];

        Indikator::insert($data);
    }
}
