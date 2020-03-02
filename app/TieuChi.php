<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TieuChi extends Model
{
    protected $table = 'tieuchi';

    public function botieuchi()
    {
        return $this->belongsTo('App\BoTieuChi', 'botieuchi_id');
    }

    public function module()
    {
        return $this->belongsTo('App\ModuleTinhDiem', 'module_id');
    }
}
