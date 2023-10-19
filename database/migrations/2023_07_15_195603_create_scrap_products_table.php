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
        Schema::create('scrap_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scrap_id')->nullable();
            $table->string('product')->nullable();
            $table->string('qty')->nullable();
            $table->foreign('scrap_id')
            ->references('id')->on('scraps')->onDelete('cascade');     
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
        Schema::dropIfExists('scrap_products');
    }
};
