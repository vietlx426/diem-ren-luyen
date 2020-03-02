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
}
