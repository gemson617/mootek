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
        Schema::create('vendor_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('serviceID')->nullable();
            $table->unsignedBigInteger('vendor_ID')->nullable();


            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('companyID')
                    ->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('serviceID')
                    ->references('id')->on('services')->onDelete('cascade');
            $table->foreign('vendor_ID')
                    ->references('id')->on('vendors')->onDelete('cascade');
            $table->string('vendor_amount')->nullable();
            $table->string('vendor_paid')->nullable();
            $table->string('balance')->nullable();
            $table->string('payment_date')->nullable();
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
        Schema::dropIfExists('vendor_payment_histories');
    }
};
