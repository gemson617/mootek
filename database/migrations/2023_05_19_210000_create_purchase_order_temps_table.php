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
        Schema::create('purchase_order_temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('purchase_orderID')->nullable();
            $table->string('serial')->nullable();
            $table->string('hsn')->nullable();
            $table->text('product_name')->nullable();
            $table->string('price')->nullable();
            $table->string('description')->nullable();

            $table->string('quantity')->nullable();
            $table->integer('edit')->default('0');

            $table->string('categoryID')->nullable();
            $table->string('brandID')->nullable();
            $table->string('created_by')->nullable();
            $table->integer('active')->default('1');

            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
        $table->foreign('purchase_orderID')
            ->references('id')->on('purchases')->onDelete('cascade');
        $table->foreign('companyID')
            ->references('id')->on('companies')->onDelete('cascade');
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
        Schema::dropIfExists('purchase_order_temps');
    }
};
