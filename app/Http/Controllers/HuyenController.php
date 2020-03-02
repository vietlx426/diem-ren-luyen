<?php

namespace App\Http\Controllers;

use App\Huyen;
use Illuminate\Http\Request;
use App\Tinh;

class HuyenController extends Controller
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
     * @param  \App\Huyen  $huyen
     * @return \Illuminate\Http\Response
     */
    public function show(Huyen $huyen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Huyen  $huyen
     * @return \Illuminate\Http\Response
     */
    public function edit(Huyen $huyen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Huyen  $huyen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Huyen $huyen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Huyen  $huyen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Huyen $huyen)
    {
        //
    }

    public function getHuyen($tinh_id)
    {
        $DanhSach_Huyen = Tinh::find($tinh_id)->huyen->sortBy('tenhuyen')->toArray();
        if($DanhSach_Huyen)
        {
            $result = array('status' => true, 'Data' => $DanhSach_Huyen);
        }
        else
        {
        $result = array('status' => false, 'Data' => "Tỉnh chưa có huyện hoặc hệ thống bị lỗi, vui lòng liên hệ quản trị hệ thống.");
        }
        return $result;
    }

    public function getHuyenByTinh(Request $arrayTinhID)
    {
        $dsHuyen = Huyen::whereIn('tinh_id', $arrayTinhID->tinhID)
            -> orderBy('huyen.tenhuyen', 'asc')
            -> get();

        if($dsHuyen)
            return $dsHuyen->toArray();

        return $dsHuyen;
    }

}
