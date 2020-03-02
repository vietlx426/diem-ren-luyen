<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoaiBoMonTo extends Model
{
    protected $table = 'loaibomonto';

    public function bomonto()
    {
    	return $this->hasMany('App\BoMon', 'loaibomonto_id');
    }
}
