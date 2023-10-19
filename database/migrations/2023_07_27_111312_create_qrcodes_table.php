<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->unsignedBigInteger('companyID')->nullable();
            $table->foreign('companyID')
            ->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->string('product')->nullable();
            $table->string('prefix_no')->nullable();
            $table->string('start_no')->nullable();
            $table->string('end_no')->nullable();
            $table->string('serial')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qrcodes');
    }
};
