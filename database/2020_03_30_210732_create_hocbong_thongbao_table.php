<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHocbongThongbaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hocbong_thongbao', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('tieude');
            $table->string('slug')->index();
            $table->text('noidung');
            $table->integer('id_hocbong')->index();
            $table->text('status')->default(1);
            $table->text('quantrong')->default(0);
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
        Schema::dropIfExists('hocbong_thongbao');
    }
}
