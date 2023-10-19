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
        Schema::create('edit_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('branchID')->nullable();
            $table->unsignedBigInteger('customerID')->nullable();


            $table->string('invoice')->nullable();
            $table->string('taxable_price')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('balance')->nullable();
            $table->string('mop')->nullable();
            $table->string('terms')->nullable();
            $table->string('reference')->nullable();
            $table->text('name')->nullable();
            $table->string('created_by')->nullable();
            $table->integer('active')->default('1');

            $table->foreign('customerID')
            ->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('companyID')
                ->references('id')->on('companies')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('branchID')
            ->references('id')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edit_details');
    }
};
