<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trx_id');
            $table->integer('user_id')->nullable();
            $table->integer('product_id');
            $table->string('product_code');
            $table->string('game_id')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->integer('total');
            $table->integer('payment_channel_id')->nullable();
            $table->integer('status');
            $table->string('notes')->nullable();
            $table->string('payment_ref')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}