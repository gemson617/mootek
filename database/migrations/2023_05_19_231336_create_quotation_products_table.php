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
        Schema::create('quotation_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('quotationID')->nullable();
            $table->string('seial_number')->nullable();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->string('product')->nullable();
            $table->string('description')->nullable();
            $table->string('price')->nullable();
            $table->string('gstamount')->nullable();
            $table->string('tax')->nullable();
            $table->string('gsttaxamount')->nullable();
            $table->string('qty')->nullable();

            $table->integer('active')->default('1');

            
            $table->string('created_by')->nullable();

            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
        $table->foreign('quotationID')
            ->references('id')->on('quotations')->onDelete('cascade');
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
        Schema::dropIfExists('quotation_products');
    }
};
