<?php

namespace App\Http\Controllers;

use App\TieuChiModuleThoiGian;
use Illuminate\Http\Request;
use App\Http\Requests\TieuChiModuleThoiGianRequest;
use Auth;
use DateTime;
use App\LyLich;

class TieuChiModuleThoiGianController extends Controller
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

    public function adminstore(TieuChiModuleThoiGianRequest $request)
    {
        if(Auth::check())
        {
            // try {
                $tieuChiModuleThoiGian = TieuChiModuleThoiGian::firstOrCreate(['hockynamhoc_id'=>$request->idhocky, 'tieuchi_id'=>$request->idtieuchi, 'module_id'=>$request->idmodule]);
                $tieuChiModuleThoiGian->thoigianbatdau = DateTime::createFromFormat('d/m/Y', trim($request->thoigianbatdau));
                $tieuChiModuleThoiGian->thoigianketthuc = DateTime::createFromFormat('d/m/Y', trim($request->thoigianketthuc));
                $tieuChiModuleThoiGian->save();
                return redirect()->route('admin_tieuchi_minhchung_module', ['idhockynamhoc'=>$request->idhocky, 'idtieuchi'=>$request->idtieuchi, 'idmodule'=>$request->idmodule])->with('success', "Lưu thành công");
            // } catch (\Throwable $th) {
            //     return redirect()->back()->withInput()->with('danger', "Lưu không thành công.<br>".$th->getMessage());
            // }
        }
        else
            return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TieuChiModuleThoiGian  $tieuChiModuleThoiGian
     * @return \Illuminate\Http\Response
     */
    public function show(TieuChiModuleThoiGian $tieuChiModuleThoiGian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TieuChiModuleThoiGian  $tieuChiModuleThoiGian
     * @return \Illuminate\Http\Response
     */
    public function edit(TieuChiModuleThoiGian $tieuChiModuleThoiGian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TieuChiModuleThoiGian  $tieuChiModuleThoiGian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TieuChiModuleThoiGian $tieuChiModuleThoiGian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TieuChiModuleThoiGian  $tieuChiModuleThoiGian
     * @return \Illuminate\Http\Response
     */
    public function destroy(TieuChiModuleThoiGian $tieuChiModuleThoiGian)
    {
        //
    }

    // Kiểm tra tiêu chí - module đăng ký nội trú, ngoại trú (lý lịch)
    public static function daDangKyNoiTruNgoaiTru($idHocKyNamHoc, $idTieuChi, $idSinhVien)
    {
        $idModule = 2;
        $tieuChiModuleThoiGian = TieuChiModuleThoiGian::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->where('module_id', '=', $idModule)->first();
        if($tieuChiModuleThoiGian)
        {
            $dateNow = date('Y-m-d');
            if($dateNow >= $tieuChiModuleThoiGian->thoigianbatdau && $dateNow <= $tieuChiModuleThoiGian->thoigianketthuc)
            {
                $lyLichTrongThoiGianQuyDinh = LyLich::where('sinhvien_id', '=', $idSinhVien)->where('created_at', '>=', $tieuChiModuleThoiGian->thoigianbatdau)->where('created_at', '<=', $tieuChiModuleThoiGian->thoigianketthuc)->first();
                if($lyLichTrongThoiGianQuyDinh)
                    return true;
            }
        }
        return false;
    }
}
