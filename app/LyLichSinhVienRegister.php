<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LyLichSinhVienRegister extends Model
{
    protected $table = 'lylichsinhvienregister';

    public function anhchiemsinhvienregister()
    {
    	return $this->hasMany('App\AnhChiEmSinhVienRegister', 'lylichsinhvienregister_id');
    }
}
