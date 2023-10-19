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
        Schema::create('rent_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('branchID')->default('1');
            $table->string('rentalID')->nullable();
            
            
            
            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('companyID')
                    ->references('id')->on('companies')->onDelete('cascade');
           
            
            
            
            $table->string('invoiceID')->nullable();
            $table->string('inID')->nullable();
            $table->string('customerID')->nullable();
            $table->string('taxable_amount')->nullable();
            $table->string('discount')->nullable();
            $table->string('tax')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('collected')->nullable();
            $table->string('balance')->nullable();
            $table->string('mop')->nullable();
            $table->string('terms')->nullable();
            $table->string('dateCreate')->nullable();
            $table->string('created_by')->nullable();

            $table->integer('complete_status')->default('0');
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
        Schema::dropIfExists('rent_invoices');
    }
};
