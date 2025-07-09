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
        Schema::table('events', function (Blueprint $table) {
            $table->string('flyer')->after('registration_link');
            $table->dropColumn(['needs_registration', 'posted_by_role', ]);
            $table->timestamps();
            $table->boolean('is_active')->default(true)->after('flyer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('flyer', 'is_active');
            $table->boolean('needs_registration')->default(false);
            $table->enum('posted_by_role', ['admin', 'employer'])->nullable();
        });
    }
};
