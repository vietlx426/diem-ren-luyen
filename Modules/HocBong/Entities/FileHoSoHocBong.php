<?php

namespace Modules\HocBong\Entities;

use Illuminate\Database\Eloquent\Model;

class FileHoSoHocBong extends Model
{
    protected $table='hocbong_hoso_file';
    protected $fillable = ['id','id_hoso', 'url '];
    public function hoso_hocbong()
    {
    	return $this->belongsTo('Modules\HocBong\Entities\HoSoHocBong', 'id_hoso');
    }
}
