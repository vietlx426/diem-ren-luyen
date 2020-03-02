<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GioiTinh;

class GioiTinhController extends Controller
{
    public static function getGioiTinh($id)
    {
    	return GioiTinh::find($id);
    }
}
