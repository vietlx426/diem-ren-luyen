<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LyLich extends Model
{
    protected $table = 'lylich';

    public function sinhvien()
    {
    	return $this->belongsTo('App\SinhVien', 'sinhvien_id');
    }

    public function thuongtru()
    {
        return $this->belongsTo('App\Xa', 'xa_id');
    }
    
    public function tamtru()
    {
        return $this->belongsTo('App\Xa', 'tamtru_xa_id');
    }
    
    public function tamtrucha()
    {
        return $this->belongsTo('App\Xa', 'xa_idcha');
    }
    public function thuongtrucha()
    {
        return $this->belongsTo('App\Xa', 'xa_idcha');
    }
    
    public function tamtrume()
    {
        return $this->belongsTo('App\Xa', 'xa_idme');
    }
    
    public function thuongtrume()
    {
        return $this->belongsTo('App\Xa', 'xa_idme');
    }

    public function anhchiem()
    {
    	return $this->hasMany('App\AnhChiEm', 'lylich_id');
    }

    public function dantoc()
    {
    	return $this->belongsTo('App\DanToc', 'dantoc_id');
    }



    public function dantoccha()
    {
    	return $this->belongsTo('App\DanToc', 'dantoc_idcha');
    }


    public function dantocme()
    {
    	return $this->belongsTo('App\DanToc', 'dantoc_idme');
    }

    public function tongiao()
    {
        return $this->belongsTo('App\TonGiao', 'tongiao_id');
    }
}
