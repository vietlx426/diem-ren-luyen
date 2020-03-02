<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Huyen extends Model
{
    protected $table = 'huyen';

    public function xa()
    {
    	return $this->hasMany('App\Xa', 'huyen_id');
    }

    public function tinh()
    {
    	return $this->belongsTo('App\Tinh', 'tinh_id');
    }
}
