<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChuyenVienQuanLyLop extends Model
{
    protected $table = 'chuyenvien_lop';

    public function cbgv()
    {
    	return $this->belongsTo('App\CanBoGiangVien', 'cbgv_id');
    }

    public function lop()
    {
    	return $this->belongsTo('App\Lop', 'lop_id');
    }
}
