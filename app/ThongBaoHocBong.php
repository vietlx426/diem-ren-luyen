<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThongBaoHocBong extends Model
{
    protected $table = 'hocbong_thongbao';
    
    public function vanban()
    {
    	return $this->hasMany('App\ThongBaoVanBan');
    }
}
