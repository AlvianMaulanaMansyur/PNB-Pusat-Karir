<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('nama_lowongan');
            $table->text('deskripsi');
            $table->string('posisi');
            $table->string('gaji');
            $table->string('kualifikasi');
            $table->string('benefit');
            $table->string('responsibility');
            $table->string('detailkualifikasi');
            $table->string('jenislowongan'); // Contoh: Full Time, Freelance, dsb
            $table->date('deadline');
            $table->string('poster')->nullable(); // Path ke file poster
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
