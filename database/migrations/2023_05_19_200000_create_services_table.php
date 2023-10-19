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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->unsignedBigInteger('branchID')->default('1');
            $table->unsignedBigInteger('serviceID')->nullable();
            $table->unsignedBigInteger('customerID')->nullable();
            $table->string('product')->nullable();
            $table->string('problem')->nullable();
            $table->string('description')->nullable();

            $table->unsignedBigInteger('engineerID')->nullable();

            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('companyID')
                    ->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('serviceID')
                    ->references('id')->on('services')->onDelete('cascade');
            


            $table->string('recDate')->nullable();
            $table->string('appDate')->nullable();
            $table->string('appPrice')->nullable();
            $table->string('vendor_collected')->default('0');
            $table->string('vendor_balance')->default('0');
            $table->unsignedBigInteger('vendor_status')->default('0');

            $table->string('vendor_status_date')->nullable();
            $table->string('invoice_num')->nullable();
            $table->string('taxable')->nullable();
            $table->string('discount')->nullable();
            $table->string('tax')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('collected')->default('0');
            $table->string('balance')->default('0');
            $table->string('mop')->nullable();
            $table->string('terms')->nullable();

            $table->string('invoiceID')->nullable();

            $table->text('remark')->nullable();

            $table->string('created_by')->nullable();

            $table->string('bil_date')->nullable();
            $table->integer('status')->default('1')->comment('1=completed,2=canclled');
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
        Schema::dropIfExists('services');
    }
};
