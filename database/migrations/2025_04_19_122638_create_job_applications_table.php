<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();

            $table->foreignId('job_id')->constrained('job_listings')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->timestamp('applied_at')->useCurrent();
            $table->enum('status', ['pending', 'reviewed', 'interview', 'accepted', 'rejected'])->default('pending');
            $table->text('cover_letter')->nullable();
            $table->string('cv_file')->nullable();
            $table->text('employer_notes')->nullable();
            $table->enum('interview_status', ['not_scheduled', 'scheduled', 'completed'])->nullable();
            $table->timestamp('interview_date')->nullable();
            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_applications');
    }
};
