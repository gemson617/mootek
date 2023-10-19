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
        Schema::create('email_template', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stage_id')->unsigned()->nullable();
            $table->foreign('stage_id')->references('id')->on('stage_master')->onDelete('cascade');
            $table->string('email_name')->nullable();
            $table->string('email_body')->nullable();
            //$table->enum('status',[0,1])->comment("0->Active,1->In-Active")->nullable();
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
        Schema::dropIfExists('email_template');
    }
};
