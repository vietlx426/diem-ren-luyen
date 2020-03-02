<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lop extends Model
{
    protected $table = 'lop';

    public function nganh()
    {
    	return $this->belongsTo('App\Nganh', 'nganh_id');
    }

    public function khoahoc()
    {
    	return $this->belongsTo('App\KhoaHoc', 'khoahoc_id');
    }

    // public function bacdaotao()
    // {
    // 	return $this->belongsTo('App\BacDaoTao', )
    // }
}
