<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrangThaiTieuChi extends Model
{
    protected $table = 'trangthaitieuchi';

    public function tieuchi()
    {
    	return $this->hasMany('App\TieuChi', 'idtrangthai');
    }
}
