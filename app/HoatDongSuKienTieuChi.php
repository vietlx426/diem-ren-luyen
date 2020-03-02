<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoatDongSuKienTieuChi extends Model
{
    protected $table = 'hoatdongsukientieuchi';

    // protected $fillable = ['hoatdongsukien_id'];

    public function tieuchi()
    {
        return $this->belongsTo('App\TieuChi', 'tieuchi_id');
    }
}
