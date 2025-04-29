<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('generated_cvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            // $table->foreignId('template_id')->constrained('cv_templates')->onDelete('cascade');
            $table->string('file_path');
            $table->timestamp('generated_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('generated_cvs');
    }
};