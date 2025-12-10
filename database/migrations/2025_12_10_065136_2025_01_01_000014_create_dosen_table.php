<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('nidn')->unique();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->boolean('is_certified')->default(0);

            // Ubah foreignId menjadi kolom int biasa
            $table->unsignedBigInteger('user_id')->nullable();

            $table->decimal('avg_kpi', 2, 1)->default(0.0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
