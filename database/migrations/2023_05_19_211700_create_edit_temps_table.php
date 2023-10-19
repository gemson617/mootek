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
        Schema::create('edit_temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('purchase_orderID')->nullable();
           $table->string('serial')->nullable();
           $table->string('hsn')->nullable();
           $table->unsignedBigInteger('categoryID')->nullable();
           $table->unsignedBigInteger('brandID')->nullable();
           $table->string('product_name')->nullable();
           $table->string('description')->nullable();
           $table->string('price')->nullable();
           $table->string('quantity')->nullable();
           $table->string('created_by')->nullable();

           $table->integer('active')->default('1');


            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
        $table->foreign('companyID')
            ->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('purchase_orderID')
            ->references('id')->on('purchase_orders')->onDelete('cascade');
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
        Schema::dropIfExists('edit_temps');
    }
};
