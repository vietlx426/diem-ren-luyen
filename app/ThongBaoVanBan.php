<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThongBaoVanBan extends Model
{
    protected $table = 'hocbong_thongbao_vanban';
    protected $fillable = ['id','id_thongbao', 'tenfile', 'url'];

    public function thongbao()
    {
    	return $this->belongsTo('App\ThongBaoHocBong', 'id_thongbao');
    }
}
