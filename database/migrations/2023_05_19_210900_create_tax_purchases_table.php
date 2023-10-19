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
        Schema::create('tax_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();

            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('companyID')
                    ->references('id')->on('companies')->onDelete('cascade');
            
            $table->string('invoice_number')->nullable();
            $table->string('seial_number')->nullable(); 
            $table->text('category')->nullable();
            $table->text('brand')->nullable();
            $table->text('product')->nullable();
            $table->text('description')->nullable();
            $table->string('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('created_by')->nullable();

            $table->integer('active')->default('1'); 
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
        Schema::dropIfExists('tax_purchases');
    }
};
