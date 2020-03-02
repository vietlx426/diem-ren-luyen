<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tinh extends Model
{
    protected $table='tinh';

    public function huyen()
    {
    	return $this->hasMany('App\Huyen', 'tinh_id');
    }
}
