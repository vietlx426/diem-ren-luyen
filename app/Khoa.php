<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Khoa extends Model
{
    protected $table = 'khoa';

    public function bomons()
    {
    	return $this->hasMany('App\BoMon', 'idkhoa');
    }
    
}
