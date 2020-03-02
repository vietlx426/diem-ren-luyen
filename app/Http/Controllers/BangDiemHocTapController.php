<?php

namespace App\Http\Controllers;

use App\BangDiemHocTap;
use Illuminate\Http\Request;

class BangDiemHocTapController extends Controller
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
     * @param  \App\BangDiemHocTap  $bangDiemHocTap
     * @return \Illuminate\Http\Response
     */
    public function show(BangDiemHocTap $bangDiemHocTap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BangDiemHocTap  $bangDiemHocTap
     * @return \Illuminate\Http\Response
     */
    public function edit(BangDiemHocTap $bangDiemHocTap)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BangDiemHocTap  $bangDiemHocTap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BangDiemHocTap $bangDiemHocTap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BangDiemHocTap  $bangDiemHocTap
     * @return \Illuminate\Http\Response
     */
    public function destroy(BangDiemHocTap $bangDiemHocTap)
    {
        //
    }

    // fuction my define
    public static function GetDiemHocTap($idHocKyNamHoc, $idSinhVien)
    {
        $bangDiemHocTap = BangDiemHocTap::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('sinhvien_id', '=', $idSinhVien)->first();
        return $bangDiemHocTap? number_format((float)$bangDiemHocTap->diem, 2, '.', ''):"N/A";
    }
}
