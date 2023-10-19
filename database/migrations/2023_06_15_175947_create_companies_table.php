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
        if (!Schema::hasTable('users')) {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company')->nullable();
            $table->string('prefix')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->text('address_line1')->nullable();
            $table->text('address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('gst')->nullable();
            $table->string('logo')->nullable();
            $table->integer('lattitude');
            $table->integer('longitude');
            $table->string('created_by')->nullable();
            $table->integer('active')->default(1);
            $table->integer('status')->default(1);
            $table->string('bill');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
