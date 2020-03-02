<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DangKyHoatDongSuKien extends Model
{
    protected $table = 'dangkyhoatdongsukien';
    protected $fillable = ['sinhvien_id', 'hoatdongsukien_id'];

    public function sinhvien()
    {
        return $this->belongsTo('App\SinhVien', 'sinhvien_id');
    }
}
