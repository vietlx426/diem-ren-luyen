<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnhChiEm extends Model
{
    protected $table = 'anhchiem';

    public function lylich()
    {
    	return $this->belongsTo('App\LyLich', 'lylich_id');
    }

    public function moiquanhe()
    {
    	return $this->belongsTo('App\MoiQuanHe', 'moiquanhe_id');
    }
}
