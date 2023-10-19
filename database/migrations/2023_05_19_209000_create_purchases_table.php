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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('categoryID')->nullable();
            $table->unsignedBigInteger('brandID')->nullable();
            $table->unsignedBigInteger('productID')->nullable();
            $table->unsignedBigInteger('supplierID')->nullable();
            $table->unsignedBigInteger('referenceID')->nullable();


            $table->string('purchaseDate')->nullable();
            $table->string('notes')->nullable();
            $table->string('serial')->nullable();
            $table->string('hsn')->nullable();
            $table->string('purchase_price')->nullable();            
            $table->string('selling_price')->nullable();

            $table->integer('stock')->default('1');
            $table->integer('sale')->default('0');
            $table->integer('rental')->default('0');
            $table->integer('scrap')->default('0');
            $table->string('rent_price')->nullable();
            $table->integer('active')->default('1');
            $table->string('created_by')->nullable();
            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
        
            $table->foreign('companyID')
            ->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('categoryID')
            ->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brandID')
            ->references('id')->on('brands')->onDelete('cascade');
            
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
        Schema::dropIfExists('purchases');
    }
};
