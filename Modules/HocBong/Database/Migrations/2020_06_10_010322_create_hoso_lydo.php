<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHosoLydo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hocbong_hoso_lydo', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_hoso')->unsigned();
            $table->text('noidung');
            $table->foreign('id_hoso')->references('id')->on('hocbong_hoso')->onDelete('cascade');
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
        Schema::dropIfExists('hocbong_hoso_lydo');
    }
}
