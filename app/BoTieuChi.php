<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoTieuChi extends Model
{
    protected $table = 'botieuchi';

    public function tieuchi()
    {
        return $this->hasMany('App\TieuChi', 'botieuchi_id');
    }

    public function hockynamhocbotieuchi()
    {
        return $this->hasMany('App\HocKyNamHocBoTieuChi', 'botieuchi_id');
    }
}
