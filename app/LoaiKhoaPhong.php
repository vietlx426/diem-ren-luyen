<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoaiKhoaPhong extends Model
{
    protected $table = 'loaikhoaphong';

    public function khoaphong()
    {
    	return $this->hasMany('App\Khoa', 'loaikhoaphong_id');
    }
}
