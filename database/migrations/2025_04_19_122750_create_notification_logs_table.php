<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sent_by')->constrained('users')->onDelete('cascade');
            $table->enum('notification_type', ['job_alert', 'event', 'application_update']);
            $table->text('content');
            $table->integer('recipient_count');
            $table->timestamp('sent_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_logs');
    }
};