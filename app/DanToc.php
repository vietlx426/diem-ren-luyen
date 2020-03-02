<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DanToc extends Model
{
    protected $table = 'dantoc';

    public function lylich()
    {
    	return $this->hasMany('App\LyLich', 'dantoc_id');
    }
}
