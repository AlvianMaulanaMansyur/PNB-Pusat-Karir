<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('slug')->unique(); // Optional: nama CV atau posisi dilamar
            $table->string('title')->nullable(); // Optional: nama CV atau posisi dilamar
            $table->string('status')->default('draft'); // 'draft', 'completed', etc.

            $table->timestamps();
        });

        Schema::create('cv_personal_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained('cvs')->onDelete('cascade');
            $table->string('full_name')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->text('address')->nullable();
            $table->text('summary')->nullable();
            $table->string('profile_photo')->nullable();
            $table->timestamps();

        });

        Schema::create('cv_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained('cvs')->onDelete('cascade');

            $table->string('company_name')->nullable();
            $table->string('position')->nullable();
            $table->string('location')->nullable();
            $table->text('company_profile')->nullable();

            $table->string('start_month')->nullable();
            $table->year('start_year')->nullable();

            $table->string('end_month')->nullable();
            $table->year('end_year')->nullable();

            $table->boolean('currently_working')->default(false);
            $table->string('portfolio_description')->nullable();

            $table->timestamps();
        });

        Schema::create('cv_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained('cvs')->onDelete('cascade');

            $table->string('school_name')->nullable();
            $table->string('location')->nullable();

            $table->string('start_month')->nullable();
            $table->year('start_year')->nullable();

            $table->string('graduation_month')->nullable();
            $table->year('graduation_year')->nullable();

            $table->string('degree_level')->nullable(); // e.g., "S1 Teknik Informatika"
            $table->text('description')->nullable();

            $table->float('gpa', 2)->nullable(); // e.g., 3.75
            $table->float('gpa_max', 2)->nullable();         // e.g., 4.00

            $table->text('activities')->nullable();

            $table->timestamps();
        });

        Schema::create('cv_organization_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained('cvs')->onDelete('cascade');
        
            $table->string('organization_name')->nullable();          // Organisasi/Nama Acara
            $table->string('position')->nullable();                   // Posisi/Gelar Jabatan
            $table->text('organization_description')->nullable(); // Deskripsi Organisasi (opsional)
            $table->string('location')->nullable();                   // Lokasi Organisasi
        
            $table->string('start_month')->nullable();
            $table->year('start_year')->nullable();
            $table->string('end_month')->nullable();      // Nullable untuk yang masih aktif
            $table->year('end_year')->nullable();
        
            $table->boolean('is_active')->default(false); // Checkbox: masih aktif
            $table->string('job_description')->nullable(); // Deskripsi Pekerjaan
        
            $table->timestamps();
        });
        
        Schema::create('cv_other_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained('cvs')->onDelete('cascade');
        
            $table->string('category')->nullable();             // Kemampuan / Penghargaan / Proyek / Aktivitas / Lainnya
            $table->year('year')->nullable();                   // Tahun
            $table->text('description')->nullable();            // Deskripsi
            $table->string('document_path')->nullable(); // Path ke dokumen/sertifikat yang diunggah (opsional)
        
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('cvs');
        Schema::dropIfExists('cv_personal_information');
        Schema::dropIfExists('cv_work_experiences');
        Schema::dropIfExists('cv_educations');
        Schema::dropIfExists('cv_organization_experiences');
        Schema::dropIfExists('cv_other_experiences');
    }
};
