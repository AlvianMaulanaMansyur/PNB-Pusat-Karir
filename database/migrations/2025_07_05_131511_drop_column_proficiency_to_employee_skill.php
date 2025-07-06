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
        Schema::table('employee_skill', function (Blueprint $table) {
            $table->dropColumn('proficiency_level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_skill', function (Blueprint $table) {
            $table->string('proficiency_level')->nullable()->after('skill_id');
            $table->dropTimestamps();
        });
    }
};
