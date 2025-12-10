<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id();

            // Ubah foreignId menjadi kolom int biasa
            $table->unsignedBigInteger('kelas_id');

            $table->integer('pertemuan_ke')->nullable();

            $table->string('mahasiswa_nrp', 50);
            $table->index('mahasiswa_nrp');

            $table->boolean('is_present')->default(1);

            $table->string('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
    }
};
