<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SinhVien extends Model
{
    protected $table = 'sinhvien';

    public function lop()
    {
    	return $this->belongsTo('App\Lop', 'lop_id');
    }

    public function lylich()
    {
    	return $this->hasMany('App\LyLich', 'sinhvien_id');
    }

    public function profile()
    {
    	return $this->hasMany('App\LyLich', 'sinhvien_id');
    }

    public function gioitinh()
    {
        return $this->belongsTo('App\GioiTinh', 'gioitinh');
    }

    //Học bổng
    protected $gt=[
        1=>[
            'name'=>'Nam',
            'class'=>''
        ],
        2=>[
            'name'=>'Nữ',
            'class'=>''
        ],
    ];
    public function getGioitinh(){
        return array_get($this->gt,$this->gioitinh,'[N\A]');
    }
    public function HocKyNamHoc(){
        return $this->belongsTo(HocKyNamHoc::class,'hockynamhoc_id');
    }
    public function hocbong()
    {
        return $this->hasMany('App\LichSuHocBong', 'id');
    }

    

}
