<?php

namespace App\Http\Controllers;

use App\Xa;
use Illuminate\Http\Request;
use App\Huyen;
use DB;

class XaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Xa  $xa
     * @return \Illuminate\Http\Response
     */
    public function show(Xa $xa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Xa  $xa
     * @return \Illuminate\Http\Response
     */
    public function edit(Xa $xa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Xa  $xa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Xa $xa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Xa  $xa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Xa $xa)
    {
        //
    }

    public function getXa($huyen_id)
    {
        $DanhSach_Xa = Huyen::find($huyen_id)->xa->sortBy('tenhxa');
        if($DanhSach_Xa)
        {
            $result = array('status' => true, 'Data' => $DanhSach_Xa);
        }
        else
        {
        $result = array('status' => false, 'Data' => "Huyện chưa có xã hoặc hệ thống bị lỗi, vui lòng liên hệ quản trị hệ thống.");
        }
        return $result;
    }

    public function getXaByHuyen(Request $arrayHuyenID)
    {
        $dsXa = Xa::whereIn('huyen_id', $arrayHuyenID->huyenID)
            -> orderBy('tenxa', 'asc')
            -> get();

        if($dsXa)
            return $dsXa->toArray();

        return $dsXa;
    }

    public static function getDiaChi($xaId = '')
    {
        $diaChi = Xa::where('xa.id', '=', $xaId)
            -> join('huyen', 'huyen.id', '=', 'xa.huyen_id')
            -> join('tinh', 'tinh.id', '=', 'huyen.tinh_id')
            -> select(DB::Raw('concat(xa.tenxa, ", ", huyen.tenhuyen, ", ", tinh.tentinh) as diachi'))
            -> first();
        return $diaChi ? (", " . $diaChi->diachi) : '';
    }
}
