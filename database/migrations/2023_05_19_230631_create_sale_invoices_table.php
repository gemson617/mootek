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
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('branchID')->default('1');
            $table->string('invoiceID')->nullable();
            
            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('branchID')
                    ->references('id')->on('companies')->onDelete('cascade');
           
                    $table->string('invoice')->nullable();
                    $table->string('taxable_price')->nullable();
                    $table->string('discount')->nullable();
                    $table->string('tax')->nullable();
                    $table->string('grand_total')->nullable();
                    $table->string('purchase_id')->nullable();

                    
                    $table->string('collected')->default('0');
                    $table->string('balance')->default('0');
                    
                    $table->string('mop')->nullable();

                    $table->text('reference')->nullable();
                    $table->text('terms')->nullable();
                    $table->string('customerID')->nullable();
                    $table->string('created_by')->nullable();
                    $table->string('invoice_path')->nullable();
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
        Schema::dropIfExists('sale_invoices');
    }
};
