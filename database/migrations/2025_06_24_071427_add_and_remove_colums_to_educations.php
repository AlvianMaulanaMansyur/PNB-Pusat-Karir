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
        Schema::table('educations', function (Blueprint $table) {
            $table->dropColumn('degree');
            $table->dropColumn('major');
            $table->dropColumn('start_year');
            $table->dropColumn('end_year');

            $table->string('degrees')->after('institution');
            $table->string('dicipline')->after('degrees');
            $table->date('end_date')->after('dicipline');
        });
    }


    public function down(): void
    {
        Schema::table('educations', function (Blueprint $table) {
            $table->dropColumn(['degrees', 'dicipline', 'end_date']);

            $table->string('degree')->after('institution');
            $table->string('major')->after('degree');
            $table->year('start_year')->after('major');
            $table->year('end_year')->after('start_year');
        });
    }
};
