<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoBannerSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_banner_section', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('srcUrl');
            $table->string('altText');
            $table->string('href');
            $table->string('starttime');
            $table->string('endtime');
            $table->integer('status');
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
        Schema::dropIfExists('promo_banner_section');
    }
}