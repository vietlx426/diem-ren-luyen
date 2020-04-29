<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HocBongKhoa extends Model
{
    protected $table="hocbong_phamvi";
    public function tenkhoa(){
    	return $this->belongsTo(Khoa::class,'id_khoa');
    }
    public function belong(){
    	return $this->belongsTo(Scholarship::class,'id_hocbong');
    }
    
}
