<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('photo_profile')->nullable();
            $table->string('company_name');
            $table->string('alamat_perusahaan')->nullable();
            $table->string('business_registration_number')->nullable();
            $table->string('industry')->nullable();
            $table->string('company_website')->nullable();
            $table->string('organization_type')->nullable();
            $table->string('staff_strength')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('company_profile')->nullable();

            $table->string('salutation')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('job_title')->nullable();
            $table->string('department')->nullable();
            $table->string('phone')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employers');
    }
};
