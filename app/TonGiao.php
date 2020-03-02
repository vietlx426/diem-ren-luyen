<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TonGiao extends Model
{
    protected $table = 'tongiao';

    public function lylich()
    {
    	return $this->hasMany('App\LyLich', 'tongiao_id');
    }
}
