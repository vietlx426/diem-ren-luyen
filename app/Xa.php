<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Xa extends Model
{
    protected $table = 'xa';

    public function huyen()
    {
    	return $this->belongsTo('App\Huyen', 'huyen_id');
    }
}

