<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHocbongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hocbong', function (Blueprint $table) {
            $table->Increments('id')->unsigned();
            $table->string('mahb')->nullable();
            $table->string('tenhb')->nullable();
            $table->string('tendvtt')->nullable();
            $table->integer('idhockynamhoc')->index();
            $table->integer('gthb')->default(0);
            $table->integer('gtmoihocbong')->default(0);
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
        Schema::dropIfExists('hocbong');
    }
}
