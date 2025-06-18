<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->id(); // Kolom ID utama
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('title')->default('Untitled Resume');
            $table->string('slug')->unique(); // Slug unik untuk URL yang user-friendly
            $table->json('resume_data');
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};