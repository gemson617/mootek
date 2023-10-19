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
        Schema::create('edit_rental_temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('customerId')->nullable();
            $table->string('serialID')->nullable();
            $table->unsignedBigInteger('categoryID')->nullable();
            $table->unsignedBigInteger('brandID')->nullable();
            $table->unsignedBigInteger('productID')->nullable();
            $table->string('rentID')->nullable();
           $table->string('hsn')->nullable();
           $table->string('description')->nullable();
           $table->string('rent_price')->nullable();
           $table->string('rent_month')->nullable();
           $table->string('dayweekmonth')->nullable();
           $table->string('rent_date')->nullable();
           $table->text('rentdescription')->nullable();
           $table->string('created_by')->nullable();
           $table->integer('active')->default('1');

           $table->integer('edit');

            
           
            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
        $table->foreign('companyID')
            ->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('customerId')
            ->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('categoryID')
            ->references('id')->on('category')->onDelete('cascade');
            $table->foreign('brandID')
            ->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('productID')
            ->references('id')->on('products')->onDelete('cascade');
            
            
            
            
            
            
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
        Schema::dropIfExists('edit_rental_temps');
    }
};
