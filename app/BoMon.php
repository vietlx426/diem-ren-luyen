<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoMon extends Model
{
    protected $table = 'bomon';

    public function khoa()
    {
    	return $this->belongsTo('App\Khoa', 'idkhoa');
    }

    public function nganh()
    {
    	return $this->hasMany('App\Nganh', 'idbomon');
    }
}
