<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posted_by')->constrained('users')->onDelete('cascade');
            $table->enum('posted_by_role', ['admin', 'employer']);
            $table->string('title', 100);
            $table->enum('event_type', ['webinar', 'jobfair', 'workshop']);
            $table->text('description');
            $table->date('event_date');
            $table->time('event_time');
            $table->string('location', 100);
            $table->boolean('needs_registration')->default(false);
            $table->integer('max_participants')->nullable();
            $table->string('registration_link')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->boolean('is_active')->default(true);
            $table->text('flyer');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};