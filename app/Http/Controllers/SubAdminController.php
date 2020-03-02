<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\HocKyNamHoc;
use App\HoatDongSuKien;
use App\BangDiemRenLuyen;
use App\ChuyenVienQuanLyLop;
use App\SinhVien;
use DB;

class SubAdminController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('chuyenvienhethong');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check())
        {
            $idCBGV = Auth::user()->cbgvsv_id;
            $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();

            $countHoatDongSuKien = count(HoatDongSuKien::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)->get());

            $lopQuanLy = ChuyenVienQuanLyLop::where('cbgv_id', '=', $idCBGV)
                -> where('chuyenvien_lop.trangthai_id', '=', 1)
                -> leftjoin('lop', 'lop.id', '=', 'chuyenvien_lop.lop_id')
                -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
                -> where('khoahoc.namketthuc', '>=', date('Y'))
                -> select('chuyenvien_lop.lop_id')
                -> groupBy('chuyenvien_lop.lop_id')
                -> get();

            $countTongSinhVien = count(SinhVien::whereIn('lop_id', $lopQuanLy)->get());

            return view('subadmin.index', [
                'countTongSinhVien' => $countTongSinhVien,
                'countLopQuanLy' => count($lopQuanLy)
            ]);
        }
        else
        {
            return redirect()->route('home');
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
