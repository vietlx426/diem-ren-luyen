<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TieuChiMinhChung extends Model
{
    protected $table = 'tieuchiminhchung';

    public function tieuchi()
    {
        return $this->belongsTo('App\TieuChi', 'tieuchi_id');
    }
}
