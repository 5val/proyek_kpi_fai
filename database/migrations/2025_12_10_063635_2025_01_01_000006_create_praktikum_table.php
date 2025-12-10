<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('praktikum', function (Blueprint $table) {
            $table->id();

            // Ubah foreignId menjadi kolom int biasa
            $table->unsignedBigInteger('kelas_id');

            $table->decimal('avg_kpi', 2, 1)->default(0.0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('praktikum');
    }
};
