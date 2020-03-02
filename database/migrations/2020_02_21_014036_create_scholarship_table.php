<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScholarshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hocbong', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('mahb');
            $table->string('tenhb');
            $table->string('tendvtt');
            $table->integer('idhockynamhoc');
            $table->integer('idkhoa');
            $table->integer('gthb')->default(0);

            $table->tinyInteger('soluong')->default(0);

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
        Schema::dropIfExists('scholarship');
    }
}
