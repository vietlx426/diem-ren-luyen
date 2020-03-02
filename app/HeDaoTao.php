<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeDaoTao extends Model
{
    protected $table = 'hedaotao';

    public function nganh()
    {
    	return $this->hasMany('App\Nganh', 'idhedaotao');
    }
}
