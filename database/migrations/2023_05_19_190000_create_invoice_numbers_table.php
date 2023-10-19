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
        Schema::create('invoice_numbers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('branchID')->nullable();
            $table->string('year')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('tax')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('categoryID')->nullable();
            $table->integer('active')->default('1');

            $table->string('created_by')->nullable();

            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
            
            $table->foreign('companyID')
            ->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('categoryID')
            ->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('invoice_numbers');
    }
};
