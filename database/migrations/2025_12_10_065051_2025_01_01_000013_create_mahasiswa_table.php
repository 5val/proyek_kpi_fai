<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();

            $table->string('nrp')->unique();

            // Foreign keys (tanpa constraint)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('program_studi_id');

            $table->integer('angkatan')->nullable();
            $table->boolean('is_active')->default(1);

            // Tambahan dari Factory
            $table->integer('points_balance')->default(0);
            $table->string('class_group', 5)->nullable(); // A/B/C
            $table->decimal('ipk', 3, 2)->nullable();      // 2.00 - 4.00
            $table->decimal('avg_kpi', 3, 2)->default(0);  // 0.00 - 4.00

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
