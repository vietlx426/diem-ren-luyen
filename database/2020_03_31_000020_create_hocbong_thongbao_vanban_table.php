<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHocbongThongbaoVanbanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hocbong_thongbao_vanban', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_thongbao');
            $table->string('tenfile');
            $table->string('url');
            $table->foreign('id_thongbao')->references('id')->on('hocbong_thongbao')->onDelete('cascade');
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
        Schema::dropIfExists('hocbong_thongbao_vanban');
    }
}
