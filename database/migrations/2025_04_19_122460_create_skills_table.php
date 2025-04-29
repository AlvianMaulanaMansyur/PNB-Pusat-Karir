<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        
        Schema::create('employee_skill', function (Blueprint $table) {
            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('skill_id')->constrained('skills');
            $table->integer('proficiency_level')->default(1); // 1-5
            $table->primary(['employee_id', 'skill_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('skills');
        Schema::dropIfExists('employee_skill');
    }
};