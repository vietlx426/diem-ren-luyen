<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoatDongSuKien extends Model
{
    protected $table = 'hoatdongsukien';

    public function loaihoatdongsukien()
    {
    	return $this->belongsTo('App\LoaiHoatDongSuKien','loaihoatdongsukien_id','id');
    }
    public function hoatdongsukiendanhcholop()
    {
    	return $this->hasMany('App\HoatDongSuKienDanhChoLop','hoatdongsukien_id');
    }
    public function hoatdongsukientieuchi()
    {
    	return $this->hasMany('App\HoatDongSuKienTieuChi','hoatdongsukien_id');
    }
}
