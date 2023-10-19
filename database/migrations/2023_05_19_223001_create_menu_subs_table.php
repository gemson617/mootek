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
        Schema::create('menu_subs', function (Blueprint $table) {
            $table->id();
            $table->integer('menuID')->nullable();
            $table->string('subName')->nullable();
            $table->text('menulink')->nullable();
            $table->integer('active')->default('1');

            $table->string('created_by')->nullable();

            
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
        Schema::dropIfExists('menu_subs');
    }
};
