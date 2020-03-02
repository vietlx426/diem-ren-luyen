<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThoiGianDanhGiaDRL extends Model
{
    protected $table = 'thoigiandanhgiadrl';
    public function hocky_namhoc()
    {
    	return $this->belongsto('App\HocKyNamHoc','hockynamhoc_id','id');
    }
    public function lop()
    {
    	return $this->belongsto('App\Lop','lop_id','id');
    }
}
