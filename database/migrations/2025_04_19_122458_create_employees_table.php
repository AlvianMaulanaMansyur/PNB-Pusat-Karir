<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('salutation')->nullable(); // sapaan
            $table->string('first_name');
            $table->string('last_name');
            $table->string('suffix')->nullable(); // akhiran
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('highest_education')->nullable();
            $table->string('main_skill')->nullable();
            $table->string('current_or_previous_industry')->nullable();
            $table->string('current_or_previous_job_function')->nullable();
            $table->string('current_or_previous_job_type')->nullable();
            $table->string('current_or_previous_position')->nullable();
            $table->string('employment_status')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('availability')->nullable();
            $table->timestamps();
            
            // $table->string('nim', 20)->unique();
            // $table->string('major', 100)->nullable();
            // $table->string('username', 100);
            // $table->integer('graduation_year')->nullable();
            // $table->string('resume_file')->nullable();
            // $table->string('elearning_username', 50)->unique()->nullable();
            
            // $table->index('nim');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};