<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_penilaian', function (Blueprint $table) {
            $table->id();

            // Ubah foreignId menjadi kolom biasa
            $table->unsignedBigInteger('penilaian_id');
            $table->unsignedBigInteger('indikator_id');

            $table->integer('score');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penilaian');
    }
};
