<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Schema::create('industries', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        // });

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

            // Contact Person
            $table->string('salutation')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('job_title')->nullable();
            $table->string('department')->nullable();
            $table->string('phone')->nullable();

            $table->timestamps();

            // $table->foreignId('industry_id')->nullable()->constrained('industries');
            // $table->string('company_name', 100);
            // $table->text('company_description')->nullable();
            // $table->string('company_logo')->nullable();
            // $table->string('website', 100)->nullable();
            // $table->string('company_size', 50)->nullable();
            // $table->enum('verification_status', ['unverified', 'pending', 'verified'])->default('unverified');
            // $table->string('company_email')->nullable()->unique(); // Email perusahaan resmi
            // $table->string('business_license_file')->nullable(); // File legalitas
        });
    }

    public function down()
    {
        Schema::dropIfExists('employers');
    }
};
