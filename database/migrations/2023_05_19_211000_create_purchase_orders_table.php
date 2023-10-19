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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('brandID')->nullable();
            $table->unsignedBigInteger('invoiceID')->nullable();
            $table->string('invoice')->nullable();
            $table->string('taxable_price')->nullable();
            $table->string('discount')->nullable();
            $table->string('tax')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('collected')->nullable();
            $table->string('balance')->nullable();
            $table->string('mop')->nullable();
            $table->text('reference')->nullable();
            $table->string('terms')->nullable();
            $table->integer('customerID')->nullable();
            $table->integer('active')->default('1');

            $table->string('created_by')->nullable();
            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
        $table->foreign('brandID')
            ->references('id')->on('brands')->onDelete('cascade');
        $table->foreign('companyID')
            ->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('invoiceID')
            ->references('id')->on('invoice_numbers')->onDelete('cascade');
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
        Schema::dropIfExists('purchase_orders');
    }
};
