<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade');
            $table->string('title', 100);
            $table->text('description');
            $table->text('requirements');
            $table->string('location', 100);
            $table->enum('job_type', ['full_time', 'part_time', 'internship', 'contract']);
            $table->string('salary_range', 100)->nullable();
            $table->timestamp('posted_at')->useCurrent();
            $table->date('deadline')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('approved_by_admin')->default(false);
            $table->text('rejection_reason')->nullable(); // Alasan jika ditolak
            $table->timestamp('approval_date')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_listings');
    }
};