<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanBoGiangVien extends Model
{
    protected $table = 'canbogiangvien';

    public function bomonto()
    {
    	return $this->belongsTo('App\BoMon', 'bomonto_id');
    }
}
