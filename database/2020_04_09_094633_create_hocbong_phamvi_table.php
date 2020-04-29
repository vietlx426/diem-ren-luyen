<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHocbongPhamviTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('hocbong_phamvi', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_hocbong')->index();
            $table->integer('id_khoa');
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
        Schema::dropIfExists('hocbong_phamvi');
    }
}
