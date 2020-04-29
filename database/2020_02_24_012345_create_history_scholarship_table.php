<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryScholarshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lichsu_hocbong', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->tinyInteger('id_hocbong')->index();
            $table->tinyInteger('id_sinhvien')->index();
            $table->integer('giatri')->default(0);
            $table->foreign('id_thongbao')->references('id')->on('hocbong')->onDelete('cascade');
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
        Schema::dropIfExists('lichsu_hocbong');
    }
}
