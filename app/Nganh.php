<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nganh extends Model
{
    protected $table = 'nganh';

    public function bomon()
    {
    	return $this->belongsTo('App\BoMon', 'idbomon');
    }

    public function bacdaotao()
    {
    	return $this->belongsTo('App\BacDaoTao', 'idbacdaotao');
    }
    
    public function hedaotao()
    {
    	return $this->belongsTo('App\HeDaoTao', 'idhedaotao');
    }
    
    public function lop()
    {
    	return $this->hasMany('App\Lop', 'nganh_id');
    }
}
