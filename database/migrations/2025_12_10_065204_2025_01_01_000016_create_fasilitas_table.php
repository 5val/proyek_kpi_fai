<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();

            $table->string('code', 20)->nullable();
            $table->string('name');
            $table->string('kategori', 50)->nullable();

            $table->enum('kondisi', ['baik', 'perbaikan'])->nullable();

            $table->integer('penanggung_jawab')->nullable();

            $table->decimal('avg_kpi', 2, 1)->default(0.0);

            $table->boolean('is_active')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
