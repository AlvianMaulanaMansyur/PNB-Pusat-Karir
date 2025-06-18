<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up()
    {
        Schema::create('employer_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained()->onDelete('cascade');
            $table->string('title'); // Judul notifikasi, misal "Lamaran Baru Masuk"
            $table->text('message'); // Isi pesan notifikasi
            $table->boolean('is_read')->default(false); // Status sudah dibaca
            $table->timestamp('sent_at')->nullable(); // Waktu dikirim
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employer_notifications');
    }
};
