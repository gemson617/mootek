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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('brandID');
            $table->unsignedBigInteger('categoryID');

            $table->string('created_by')->nullable();
            $table->string('productName')->nullable();
            $table->text('description')->nullable();
            $table->integer('active')->default('1');



            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('brandID')
                ->references('id')->on('brands')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
};
