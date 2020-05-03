<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LichSuHocBong extends Model
{
    protected $table='lichsu_hocbong';
    protected $fillable = ['id_hocbong', 'id_sinhvien', 'giatri'];
    public function HocBong()
    {
        return $this->belongsTo('App\HocBong', 'id_hocbong');
    }
    public function infosv()
    {
    	return $this->belongsTo('App\SinhVien', 'id_sinhvien');
    }
    
}
