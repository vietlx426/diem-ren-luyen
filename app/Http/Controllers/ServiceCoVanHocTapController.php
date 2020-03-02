<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CoVanHocTap;
use Auth;
use App\HoatDongSuKien;
use App\BangDiemRenLuyen;
use App\SinhVien;
use DB;

class ServiceCoVanHocTapController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            $idCBGV = Auth::user()->cbgvsv_id;
            $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
            $countHoatDongSuKien = count(HoatDongSuKien::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)->get());
            $lopQuanLy = CoVanHocTap::where('canbogiangvien_id', '=', $idCBGV)
                -> where('trangthai_id', '=', 1)
                -> leftjoin('lop', 'lop.id', '=', 'covanhoctap.lop_id')
                -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
                -> where('khoahoc.namketthuc', '>=', date('Y'))
                -> select('lop.id')
                -> groupBy('lop.id')
                -> get();
            $countTongSinhVien = count(SinhVien::whereIn('lop_id', $lopQuanLy)->get());
            return view('covanhoctap.index', [
                'countHoatDongSuKien' => $countHoatDongSuKien,
                'countTongSinhVien' => $countTongSinhVien
            ]);
        }
        else
        {
            return redirect()->route('home');
        }
        return view('covanhoctap.index');
    }
}
