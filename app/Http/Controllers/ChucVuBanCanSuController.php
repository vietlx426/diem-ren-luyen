<?php

namespace App\Http\Controllers;

use App\ChucVuBanCanSu;
use Illuminate\Http\Request;

class ChucVuBanCanSuController extends Controller
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
     * @param  \App\ChucVuBanCanSu  $chucVuBanCanSu
     * @return \Illuminate\Http\Response
     */
    public function show(ChucVuBanCanSu $chucVuBanCanSu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChucVuBanCanSu  $chucVuBanCanSu
     * @return \Illuminate\Http\Response
     */
    public function edit(ChucVuBanCanSu $chucVuBanCanSu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChucVuBanCanSu  $chucVuBanCanSu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChucVuBanCanSu $chucVuBanCanSu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChucVuBanCanSu  $chucVuBanCanSu
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChucVuBanCanSu $chucVuBanCanSu)
    {
        //
    }

    public static function getDanhSachChucVuBanCanSu()
    {
        $DS_ChucVuBanCanSu = ChucVuBanCanSu::all();

        if($DS_ChucVuBanCanSu)
            return $DS_ChucVuBanCanSu->toArray();
        return $DS_ChucVuBanCanSu;
    }

    public static function GetChucVuBanCanSuByTenChucVu($tenChucVu = '')
    {
        return ChucVuBanCanSu::where('tenchucvubancansu', '=', $tenChucVu)->first();
    }
}
