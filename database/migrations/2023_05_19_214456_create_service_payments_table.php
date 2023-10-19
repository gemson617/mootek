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
        Schema::create('service_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('customerID')->nullable();
            $table->string('saleID')->nullable();

            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('companyID')
                    ->references('id')->on('companies')->onDelete('cascade');
            
                    $table->foreign('customerID')
                    ->references('id')->on('customers')->onDelete('cascade');
            
            $table->string('grand_total')->nullable();
            $table->string('collected')->nullable();
            $table->string('balance')->nullable();
            $table->string('mop')->nullable();
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
        Schema::dropIfExists('service_payments');
    }
};
