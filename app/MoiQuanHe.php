<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoiQuanHe extends Model
{
    protected $table = 'moiquanhe';

    public function anhchiemsinhvien()
    {
    	return $this->hasMany('App\AnhChiEmSinhVien', 'moiquanhe_id');
    }

    public function anhchiemsinhvienregister()
    {
    	return $this->hasMany('App\AnhChiEmSinhVienRegister', 'moiquanhe_id');
    }
}
