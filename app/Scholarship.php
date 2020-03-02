<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $table='hocbong';
    protected $guarded=[''];
    public function khoa(){
    	return $this->belongsTo(Khoa::class,'idkhoa');
    }
    public function HocKyNamHoc(){
    	return $this->belongsTo(HocKyNamHoc::class,'idhockynamhoc');
    }
}
