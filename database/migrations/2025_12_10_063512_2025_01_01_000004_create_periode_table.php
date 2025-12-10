<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode', 100);
            $table->year('tahun')->nullable();
            $table->enum('semester', ['gasal','genap','pendek'])->nullable();
            $table->timestamps();

            $table->unique('nama_periode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};
