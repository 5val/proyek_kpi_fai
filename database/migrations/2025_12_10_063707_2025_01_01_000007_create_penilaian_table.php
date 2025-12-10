<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();

            // Ubah semua foreignId menjadi kolom int biasa
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->unsignedBigInteger('penilai_id')->nullable();
            $table->unsignedBigInteger('dinilai_id')->nullable();
            $table->string('dinilai_type')->nullable();

            $table->unsignedBigInteger('periode_id')->nullable();

            $table->text('komentar')->nullable();

            $table->decimal('avg_score', 2, 1)->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
