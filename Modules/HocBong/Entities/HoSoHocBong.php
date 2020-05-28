<?php

namespace Modules\HocBong\Entities;

use Illuminate\Database\Eloquent\Model;

class HoSoHocBong extends Model
{
    protected $table='hocbong_hoso';
    protected $fillable = ['id','id_hocbong ', 'id_sinhvien ', 'status'];
    
    public function hocbong()
    {
    	return $this->belongsTo('App\HocBong', 'id_hocbong');
    }
    public function sinhvien()
    {
    	return $this->belongsTo('App\SinhVien', 'id_sinhvien');
    }
}
