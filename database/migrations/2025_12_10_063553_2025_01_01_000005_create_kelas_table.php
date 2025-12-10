<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();

            $table->char('code', 4)->nullable();

            // Ubah foreignId menjadi unsignedBigInteger biasa
            $table->unsignedBigInteger('mata_kuliah_id');
            $table->unsignedBigInteger('program_studi_id');
            $table->unsignedBigInteger('periode_id');

            $table->string('dosen_nidn', 50);
            $table->tinyInteger('sks')->nullable();

            $table->boolean('has_praktikum')->default(0);

            $table->unsignedTinyInteger('minimum_grade')->nullable();

            $table->boolean('is_active')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
