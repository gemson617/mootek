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
        Schema::create('quotation_temps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('branchID')->nullable();
            
            $table->string('invoice')->nullable();
            $table->string('taxable_price')->nullable();
            $table->string('tax')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('price')->nullable();
            $table->string('gsttaxamount')->nullable();
            $table->string('gstamount')->nullable();
            $table->string('customerID')->nullable();
            $table->string('tcmonth')->nullable();
            $table->text('mail')->nullable();
            $table->text('billing')->nullable();

            $table->integer('active')->default('1');

            
            $table->string('created_by')->nullable();

            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
        $table->foreign('branchID')
            ->references('id')->on('branches')->onDelete('cascade');
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
        Schema::dropIfExists('quotation_temps');
    }
};
