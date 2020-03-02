<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KhoaHoc extends Model
{
    protected $table = 'khoahoc';

    public function lop()
    {
    	return $this->hasMany('App\Lop', 'khoahoc_id');
    }

    public function bacdaotao()
    {
        return $this->belongsTo('App\BacDaoTao', 'bacdaotao_id');
    }
}
