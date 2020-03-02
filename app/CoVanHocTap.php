<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoVanHocTap extends Model
{
    protected $table = 'covanhoctap';

    public function cbgv()
    {
    	return $this->belongsTo('App\CanBoGiangVien', 'canbogiangvien_id');
    }

    public function lop()
    {
    	return $this->belongsTo('App\Lop', 'lop_id');
    }
}
