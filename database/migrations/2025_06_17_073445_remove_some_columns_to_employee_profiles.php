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
        Schema::table('employee_profiles', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'phone', 'profile_picture', 'address', ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_profiles', function (Blueprint $table) {
            $table->string('full_name', 100);
            $table->string('phone', 20)->nullable();
            $table->string('profile_picture')->nullable();
            $table->text('address')->nullable();

        });
    }
};
