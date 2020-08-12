<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('thumbnail');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('denom')->nullable();
            $table->string('image')->nullable();
            $table->text('intro')->nullable();
            $table->text('ios_link')->nullable();
            $table->text('android_link')->nullable();
            $table->text('description')->nullable();
            $table->text('promo')->nullable();
            $table->string('status')->default('1');
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
        Schema::dropIfExists('products');
    }
}