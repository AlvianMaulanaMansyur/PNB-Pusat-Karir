<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('full_name', 100);
            $table->string('phone', 20)->nullable();
            $table->string('profile_picture')->nullable();
            $table->text('address')->nullable();
            $table->text('summary')->nullable(); // tentang saya
            $table->string('linkedin')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_profiles');
    }
};
