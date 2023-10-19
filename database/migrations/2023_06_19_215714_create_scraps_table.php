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
        Schema::create('scraps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('companyID')->nullable();
            $table->foreign('companyID')
            ->references('id')->on('companies')->onDelete('cascade');
            $table->string('vendor')->nullable(); 
            $table->date('date'); 
            $table->string('reference')->nullable(); 
            $table->string('price')->nullable();
            $table->string('tax')->nullable();
            $table->string('tax_price')->nullable();
            $table->string('total_price')->nullable(); 

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
        Schema::dropIfExists('scraps');
    }
};
