<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();

            // Ubah foreignId menjadi kolom int biasa
            $table->unsignedBigInteger('pengirim_id');
            $table->unsignedBigInteger('kategori_id');

            $table->unsignedBigInteger('target_id')->nullable();
            $table->string('target_type')->nullable();

            $table->text('isi')->nullable();
            $table->string('foto')->nullable();

            $table->boolean('is_anonymous')->default(0);
            $table->boolean('status')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
