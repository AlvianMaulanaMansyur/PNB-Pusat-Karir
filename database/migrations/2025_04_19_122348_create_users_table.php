<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->enum('role', ['admin', 'employer', 'employee']);
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('last_login')->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('email_verification_token')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
