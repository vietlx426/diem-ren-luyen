<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HocKyNamHocBoTieuChi extends Model
{
    protected $table = 'hockynamhocbotieuchi';

    public function hockynamhoc()
    {
        return $this->belongsTo('App\HocKyNamHoc', 'hockynamhoc_id');
    }

    public function botieuchi()
    {
        return $this->belongsTo('App\BoTieuChi', 'botieuchi_id');
    }
}
