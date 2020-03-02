<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BangDiemRenLuyen extends Model
{
    protected $table = 'bangdiemrenluyen';
    protected $fillable = ['hocky_namhoc_id', 'sinhvien_id', 'tieuchi_id', 'maxdiem', 'diem'];

    public function tieuchi()
    {
        return $this->belongsTo('App\TieuChi', 'tieuchi_id');
    }
}
