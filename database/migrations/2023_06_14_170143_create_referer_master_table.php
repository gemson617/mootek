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
        Schema::create('referer_master', function (Blueprint $table) {
            $table->id();
            $table->string('referrer_name')->nullable();
            $table->string('referrer')->nullable();
            $table->enum('status',[0,1])->comment("0->Active,1->In-Active")->nullable();
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
        Schema::dropIfExists('referer_master');
    }
};
