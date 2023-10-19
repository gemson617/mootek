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
        Schema::create('call_managements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->string('callrevdate')->nullable();
            $table->string('name')->nullable();
            $table->string('phnumber')->nullable();
            $table->string('complaint')->nullable();
            $table->string('closedate')->nullable();
            $table->string('callsource')->nullable();
            $table->string('paymentcollected')->nullable();
            $table->string('mop')->nullable();
            $table->string('empname')->nullable();
            $table->integer('active')->default('1');

            $table->text('calldesc')->nullable();
            $table->string('created_by')->nullable();

            $table->foreign('companyID')
            ->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('call_managements');
    }
};
