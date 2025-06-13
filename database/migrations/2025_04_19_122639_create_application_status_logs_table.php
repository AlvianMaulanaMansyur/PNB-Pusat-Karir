<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('application_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('job_applications');
            $table->enum('status', ['submitted', 'reviewed', 'interview', 'offered', 'rejected']);
            $table->text('notes')->nullable();
            $table->timestamp('changed_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('application_status_logs');
    }
};