<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HocKyNamHoc extends Model
{
    protected $table = 'hocky_namhoc';

    public function hoatdongsukien()
    {
    	return $this->hasMany('App\HoatDongSuKien','hocky_namhoc_id');
    }

    public function namhoc()
    {
    	return $this->belongsTo('App\NamHoc', 'idnamhoc');
    }

    public function hocky()
    {
    	return $this->belongsTo('App\HocKy', 'idhocky');
    }

    public function hockynamhocbotieuchi()
    {
        return $this->hasOne('App\HocKyNamHocBoTieuChi', 'hockynamhoc_id');
    }
    
}
