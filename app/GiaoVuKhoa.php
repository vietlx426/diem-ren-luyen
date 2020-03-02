<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiaoVuKhoa extends Model
{
    protected $table = 'giaovukhoa';

    public function cbgv()
    {
    	return $this->belongsTo('App\CanBoGiangVien', 'cbgv_id');
    }

    public function khoa()
    {
    	return $this->belongsTo('App\Khoa', 'khoa_id');
    }
}
