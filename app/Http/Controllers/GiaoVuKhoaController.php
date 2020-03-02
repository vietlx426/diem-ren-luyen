<?php

namespace App\Http\Controllers;

use App\GiaoVuKhoa;
use Illuminate\Http\Request;
use App\Http\Requests\GiaoVuKhoaRequest;
use Auth;
use DB;
use App\HoatDongSuKien;
use App\BangDiemRenLuyen;
use App\SinhVien;

class GiaoVuKhoaController extends Controller
{
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

            $lopQuanLy = GiaoVuKhoa::where('cbgv_id', '=', $idCBGV)
                -> where('giaovukhoa.trangthai_id', '=', 1)
                -> leftjoin('bomon', 'bomon.idkhoa', '=', 'giaovukhoa.khoa_id')
                -> leftjoin('nganh', 'nganh.idbomon', '=', 'bomon.id')
                -> leftjoin('lop', 'lop.nganh_id', '=', 'nganh.id')
                -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
                -> where('khoahoc.namketthuc', '>=', date('Y'))
                -> select('lop.id')
                -> groupBy('lop.id')
                -> get();

            $sinhVienDaDanhGia = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
                -> leftjoin('sinhvien', 'sinhvien.id', '=', 'bangdiemrenluyen.sinhvien_id')
                -> whereIn('sinhvien.lop_id', $lopQuanLy)
                -> groupBy('bangdiemrenluyen.sinhvien_id')
                -> select('bangdiemrenluyen.sinhvien_id', DB::raw('sum(bangdiemrenluyen.sinhvien_diem) as totalsinhviendiem'))
                -> havingRaw('totalsinhviendiem > 0')
                -> get();

            $countTongSinhVien = count(SinhVien::whereIn('lop_id', $lopQuanLy)->get());

            $lopDaDanhGia = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
                -> leftjoin('sinhvien', 'sinhvien.id', '=', 'bangdiemrenluyen.sinhvien_id')
                -> whereIn('sinhvien.lop_id', $lopQuanLy)
                -> groupBy('sinhvien.lop_id')
                -> select('sinhvien.lop_id', DB::raw('sum(bangdiemrenluyen.bancansu_diem) as totalbancansudiem'))
                -> havingRaw('totalbancansudiem > 0')
                -> get();


            return view('giaovukhoa.index', [
                'countHoatDongSuKien' => $countHoatDongSuKien,
                'countSinhVienDaDanhGia' => count($sinhVienDaDanhGia),
                'countTongSinhVien' => $countTongSinhVien,
                'countLopDaDanhGia' => count($lopDaDanhGia),
                'countLopQuanLy' => count($lopQuanLy)
            ]);
        }
        else
        {
            return redirect()->route('home');
        }
    }


    public function subadmin_index()
    {
        $dsGiaoVuKhoa = GiaoVuKhoa::where('trangthai_id', '=', 1)->get();

        return view('subadmin.giaovukhoalist',['dsGiaoVuKhoa' => $dsGiaoVuKhoa]);
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

    public function subadmin_create()
    {
        $dsCanBoGiangVien = CanBoGiangVienController::DanhSachCanBoGiangVien();
        $dsKhoa = KhoaController::getDanhSachKhoa();

        return view('subadmin.giaovukhoacreate', ['dsCanBoGiangVien'=>$dsCanBoGiangVien, 'dsKhoa'=>$dsKhoa]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($idCBGV, $idKhoa, $idHocKyNamHoc)
    {
        try {
            $giaoVuKhoa = new GiaoVuKhoa();
            $giaoVuKhoa->cbgv_id = $idCBGV;
            $giaoVuKhoa->khoa_id = $idKhoa;
            $giaoVuKhoa->hockynamhoc_id_batdau = $idHocKyNamHoc;
            $giaoVuKhoa->trangthai_id = 1;
            $giaoVuKhoa->save();
        } catch (Exception $e) {
            
        }
        return true;
    }

    public function subadmin_store(GiaoVuKhoaRequest $request)
    {
        $idCBGV = $request->cbgv;
        $idKhoa = $request->khoa;
        $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        
        // 1. Kiểm tra tồn tại
        if(self::isExistGiaoVuKhoa($idCBGV, $idKhoa, $idHocKyNamHocHienHanh))
        {
            return redirect()->back()->withInput()->with('warning', 'Giảng viên phụ trách khoa này đã tồn tại.');
        }
        else
        {
            // 2. Store
            self::store($idCBGV, $idKhoa, $idHocKyNamHocHienHanh);
            return redirect()->route('subadmin_giaovukhoa')->with('success', 'Lưu thành công!');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\GiaoVuKhoa  $giaoVuKhoa
     * @return \Illuminate\Http\Response
     */
    public function show(GiaoVuKhoa $giaoVuKhoa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GiaoVuKhoa  $giaoVuKhoa
     * @return \Illuminate\Http\Response
     */
    public function edit(GiaoVuKhoa $giaoVuKhoa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GiaoVuKhoa  $giaoVuKhoa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GiaoVuKhoa $giaoVuKhoa)
    {
        //
    }

    public function subadmin_updatestatus($idGiaoVuKhoa)
    {
        try {
            $giaoVuKhoa = GiaoVuKhoa::find($idGiaoVuKhoa);
            $giaoVuKhoa->trangthai_id = 2;
            $giaoVuKhoa->save();
        } catch (Exception $e) {
            return redirect()->route('subadmin_giaovukhoa')->with('success', 'Xóa không thành công!');
        }
        return redirect()->route('subadmin_giaovukhoa')->with('success', 'Xóa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GiaoVuKhoa  $giaoVuKhoa
     * @return \Illuminate\Http\Response
     */
    public function destroy(GiaoVuKhoa $giaoVuKhoa)
    {
        //
    }

    // Functions my define
    public function giaovukhoa_lop()
    {
        $idCBGVSV = Auth::user()->cbgvsv_id;
        $listLop = GiaoVuKhoa::where('cbgv_id', '=', $idCBGVSV)
            -> where('trangthai_id', '=', 1)
            -> join('bomon', 'bomon.idkhoa', '=', 'giaovukhoa.khoa_id')
            -> join('nganh', 'nganh.idbomon', '=', 'bomon.id')
            -> join('lop', 'lop.nganh_id', '=', 'nganh.id')
            -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date('Y'))
            -> select('lop.*')
            -> orderBy('lop.tenlop', 'asc')
            -> get();
        return view('giaovukhoa.loplist', ['listLop'=>$listLop]);
    }

    public function giaovukhoa_lop_danhgiadiemrenluyen()
    {
        $idCBGVSV = Auth::user()->cbgvsv_id;
        $listLop = GiaoVuKhoa::where('cbgv_id', '=', $idCBGVSV)
            -> where('trangthai_id', '=', 1)
            -> join('bomon', 'bomon.idkhoa', '=', 'giaovukhoa.khoa_id')
            -> join('nganh', 'nganh.idbomon', '=', 'bomon.id')
            -> join('lop', 'lop.nganh_id', '=', 'nganh.id')
            -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date('Y'))
            -> select('lop.*')
            -> orderBy('lop.tenlop', 'asc')
            -> get();
        return view('giaovukhoa.danhgiadiemrenluyen_loplist', ['listLop'=>$listLop]);
    }

    public function isExistGiaoVuKhoa($idCBGV, $idKhoa, $idHocKyNamHoc)
    {
        $giaoVuKhoa = GiaoVuKhoa::where('cbgv_id', '=', $idCBGV)
            -> where('khoa_id', '=', $idKhoa)
            -> where('hockynamhoc_id_batdau', '=', $idHocKyNamHoc)
            -> where('trangthai_id', '=', 1)
            -> get();
        return count($giaoVuKhoa)>0? true : false;
    }

    public static function isGiaoVuKhoa($idCBGV='')
    {
        $giaoVuKhoa = GiaoVuKhoa::where('cbgv_id', '=', $idCBGV)
            -> where('trangthai_id', '=', 1)
            -> get();
        return count($giaoVuKhoa) ? true : false;
    }
}
