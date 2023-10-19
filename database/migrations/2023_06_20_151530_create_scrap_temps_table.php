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
        Schema::create('scrap_temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->unsignedBigInteger('companyID')->nullable();
            $table->foreign('companyID')
                ->references('id')->on('companies')->onDelete('cascade');
                $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->string('categoryID')->nullable();
            $table->string('brandID')->nullable();
            $table->string('product_name')->nullable();
            $table->string('price')->nullable();
            $table->string('quantity')->nullable();
            $table->string('serial')->nullable();
            $table->string('purchase_orderID')->nullable();
            $table->string('supplierID')->nullable();

            
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
        Schema::dropIfExists('scrap_temps');
    }
};
