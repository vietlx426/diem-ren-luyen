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
            $table->increments('id');
            $table->tinyInteger('id_hocbong');
            $table->tinyInteger('id_sinhvien');
            $table->integer('giatri');
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
