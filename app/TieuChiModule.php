<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TieuChiModule extends Model
{
    protected $table = 'tieuchimodule';

    public function tieuchi()
    {
        return $this->belongsTo('App\TieuChi', 'tieuchi_id');
    }
}
