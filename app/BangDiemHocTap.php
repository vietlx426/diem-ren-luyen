<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BangDiemHocTap extends Model
{
    protected $table = 'bangdiemhoctap';
    protected $fillable = ['hockynamhoc_id', 'sinhvien_id'];

    public function sinhvien()
    {
        return $this->belongsTo('App\SinhVien', 'sinhvien_id');
    }
}
