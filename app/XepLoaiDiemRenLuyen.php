<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XepLoaiDiemRenLuyen extends Model
{
    protected $table = 'xeploaidiemrenluyen';

    public function bangdiendanhgia()
    {
    	return $this->hasMany('App\BangDiemDanhGia', 'xeploaidiemrenluyen_id');
    }
}
