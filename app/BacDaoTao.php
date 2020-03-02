<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BacDaoTao extends Model
{
    protected $table = 'bacdaotao';

    public function nganh()
    {
    	return $this->hasMany('App\Nganh', 'idbacdaotao');
    }

    public function khoahoc()
    {
    	return $this->hasMany('App\KhoaHoc', 'bacdaotao_id');
    }
}
