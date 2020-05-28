<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHocbongHoso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hocbong_hoso', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('id_hocbong')->unsigned()->index();
            $table->integer('id_sinhvien')->unsigned()->index();
            $table->integer('status');
            $table->foreign('id_hocbong')->references('id')->on('hocbong')->onDelete('cascade');
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
        Schema::dropIfExists('hocbong_hoso');
    }
}
