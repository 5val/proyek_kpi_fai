<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollment', function (Blueprint $table) {
            $table->id();

            // Ubah foreignId menjadi kolom int biasa
            $table->unsignedBigInteger('kelas_id');

            $table->string('mahasiswa_nrp', 50);
            $table->index('mahasiswa_nrp');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollment');
    }
};
