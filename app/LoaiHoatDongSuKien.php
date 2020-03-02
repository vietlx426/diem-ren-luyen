<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoaiHoatDongSuKien extends Model
{
    protected $table = 'loaihoatdongsukien';

    public function hoatdongsukien()
    {
    	return $this->hasMany('App\HoatDongSuKien', 'loaihoatdongsukien_id');
    }
    public $timestamps = false;

}
