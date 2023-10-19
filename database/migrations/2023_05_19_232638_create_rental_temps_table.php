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
        Schema::create('rental_temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            
            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('companyID')
                    ->references('id')->on('companies')->onDelete('cascade');
           
            
            
            $table->string('rentID')->nullable();
            $table->string('customerId')->nullable();
            $table->string('serialID')->nullable();
            $table->string('hsn')->nullable();
            $table->string('categoryID')->nullable();
            $table->string('brandID')->nullable();
            $table->string('productID')->nullable();
            $table->string('description')->nullable();
            $table->string('rent_price')->nullable();
            $table->string('rent_month')->nullable();
            $table->string('dayweekmonth')->nullable();
            $table->string('rent_date')->nullable();
            $table->text('rentdescription')->nullable();
            $table->string('created_by')->nullable();
            
            $table->integer('active')->default('1');
            $table->integer('edit')->default('0');
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
        Schema::dropIfExists('rental_temps');
    }
};
