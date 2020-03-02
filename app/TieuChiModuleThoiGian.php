<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TieuChiModuleThoiGian extends Model
{
    protected $table = 'tieuchimodulethoigian';

    protected $fillable = ['hockynamhoc_id', 'tieuchi_id', 'module_id'];
}
