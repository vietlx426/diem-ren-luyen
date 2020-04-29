<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LichSuHocBong extends Model
{
    protected $table='lichsu_hocbong';
    public function HocBong()
    {
        return $this->belongsTo('App\Scholarship', 'id_hocbong');
    }
    public function infosv()
    {
    	return $this->belongsTo('App\SinhVien', 'id_sinhvien');
    }
    public function infoHB()
    {
    	return $this->belongsTo('App\HocBong', 'id_hocbong');
    }
}
