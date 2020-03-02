<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrangThaiUser extends Model
{
    protected $table = 'trangthaiuser';

    public function user()
    {
    	return $this->hasMany('App\Users', 'idtrangthaiusser');
    }
}
