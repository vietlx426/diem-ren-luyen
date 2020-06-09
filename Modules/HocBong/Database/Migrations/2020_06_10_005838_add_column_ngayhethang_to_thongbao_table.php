<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNgayhethangToThongbaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hocbong_thongbao', function (Blueprint $table) {
            $table->date('ngay_het_han')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hocbong_thongbao', function (Blueprint $table) {
            $table->dropColumn('ngay_het_han');
        });
    }
}
