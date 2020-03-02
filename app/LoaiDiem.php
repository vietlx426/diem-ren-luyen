<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoaiDiem extends Model
{
    protected $table = 'loaidiem';

    public function tieuchi()
    {
    	return $this->hasMany('App\TieuChi', 'idloaidiem');
    }
}
