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
        Schema::create('report_job', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_listings')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('report_reason');
            $table->text('detail_reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_job', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->dropForeign(['employee_id']);
            $table->dropColumn(['job_id', 'employee_id', 'report_reason', 'detail_reason', 'created_at', 'updated_at']);
        });
    }
};
