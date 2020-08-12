<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_name');
            $table->string('payment_code');
            $table->string('payment_logo');
            $table->string('payment_description')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_user')->nullable();
            $table->string('api_url')->nullable();
            $table->integer('mark_up_price')->nullable();
            $table->integer('minimum_price')->nullable();
            $table->integer('status');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('payment_channels');
    }
}