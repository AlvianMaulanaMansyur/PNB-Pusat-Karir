<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['whatsapp', 'email']);
            $table->string('name');
            $table->text('content'); // Template dengan placeholder {nama}, {judul_loker}, dll
            $table->timestamps();
        });
        
        Schema::create('broadcasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users');
            $table->foreignId('template_id')->constrained('notification_templates');
            $table->text('custom_message')->nullable();
            $table->json('targets'); // {user_ids: [1,2,3], groups: ['alumni_2023']}
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_templates');
        Schema::dropIfExists('broadcasts');
    }
};