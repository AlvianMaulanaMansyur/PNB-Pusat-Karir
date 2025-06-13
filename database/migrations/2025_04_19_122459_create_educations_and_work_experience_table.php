<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('institution');
            $table->string('degree');
            $table->string('major');
            $table->year('start_year');
            $table->year('end_year');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('company');
            $table->string('position');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('educations');
        Schema::dropIfExists('work_experiences');
    }
};