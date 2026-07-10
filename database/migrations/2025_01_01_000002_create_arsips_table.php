<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('judul');
            $table->string('nomor_arsip')->nullable();
            $table->date('tanggal_arsip');
            $table->text('deskripsi')->nullable();
            $table->string('file_path');
            $table->string('file_asli')->nullable();
            $table->timestamps();

            $table->index(['judul', 'nomor_arsip']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};
