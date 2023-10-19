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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('companyID')->nullable();
            $table->timestamp('email_verified_at')->useCurrent();
            $table->string('role_id');
            $table->string('designation')->nullable();
            $table->string('mobile')->nullable();
            $table->string('remarks')->nullable();
            $table->string('security')->nullable();
            $table->string('security_giveask')->nullable();
            $table->enum('status', ['1', '2']);
            $table->string('email')->unique();
            $table->timestamp('last_seen')->useCurrent();
            $table->string('password');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
