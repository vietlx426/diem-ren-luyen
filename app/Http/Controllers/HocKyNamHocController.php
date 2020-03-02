<?php

namespace App\Http\Controllers;

use App\HocKyNamHoc;
use App\NamHoc;
use App\HocKy;
use App\TrangThai_HocKy;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HocKyNamHocRequest;
class TrangThaiHocKy
{
    const DAHOANTHANH = 1;
    const HIENHANH = 2;
    const SAPTOI = 3;
    const AN = 4;
}

class HocKyNamHocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        $DanhSach_HocKyNamHoc = HocKyNamHoc::
            leftjoin('trang_thai__hoc_kies', 'trang_thai__hoc_kies.id', 'hocky_namhoc.idtrangthaihocky')
            -> select('hocky_namhoc.*', 'trang_thai__hoc_kies.TenTrangThai')
            -> orderBy('hocky_namhoc.id', 'desc')
            -> get();
            
        $DanhSach_NamHoc = NamHoc::take(5)->get();
        $DanhSach_HocKy = HocKy::all();
        $DanhSach_TrangThai = TrangThai_HocKy::all();

        return view('admin.hockynamhoc', ['DanhSach_HocKyNamHoc' => $DanhSach_HocKyNamHoc, 'DanhSach_NamHoc' => $DanhSach_NamHoc, 'DanhSach_HocKy' => $DanhSach_HocKy, 'DanhSach_TrangThai' => $DanhSach_TrangThai]);
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
    public function store(HocKyNamHocRequest $request)
    {
        $result = array('status' => true, 'message' => "Thêm thành công1!");

        $idHocKy = trim($request->idhocky);
        $idNamHoc = trim($request->idnamhoc);
        $idTrangThai = HocKyNamHocController::checkSetDefaultTrangThai(trim($request->idtrangthai));
        $TenHocKyNamHoc = HocKyNamHocController::setTenHocKyNamHoc($idHocKy, $idNamHoc);

        $result_NotExist_HocKyNamHoc = HocKyNamHocController::checkNotExist_HocKyNamHoc($idHocKy, $idNamHoc);

        if($result_NotExist_HocKyNamHoc['status']) // Kiểm tra không tồn tại mã học kỳ và mã năm học
        {
            try {
                $HocKyNamHoc = new HocKyNamHoc();
                $HocKyNamHoc->idhocky = $idHocKy;
                $HocKyNamHoc->idnamhoc = $idNamHoc;
                $HocKyNamHoc->tenhockynamhoc = $TenHocKyNamHoc;//HocKyNamHocController::setTenHocKyNamHoc($idHocKy, $idNamHoc);
                $HocKyNamHoc->idtrangthaihocky = $idTrangThai;
                $HocKyNamHoc->save();

                // Write log
                try {
                    $objnew = HocKyNamHoc::find($HocKyNamHoc->id)->toArray();
                    LogController::storeobjectlog('', $objnew, LogLoaiHoatDong::NewInsertRecord, '');
                    
                } catch (Exception $e) {}
                // End Write log

                $result = array('status' => true, 'message' => "Thêm thành công!");
                return $result;
            } catch (Exception $e) {
                $result = array('status' => false, 'message' => $e);
                return $result;
            }
        }
        else
        {
            return $result_NotExist_HocKyNamHoc;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HocKyNamHoc  $hocKyNamHoc
     * @return \Illuminate\Http\Response
     */
    public function show(HocKyNamHoc $hocKyNamHoc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HocKyNamHoc  $hocKyNamHoc
     * @return \Illuminate\Http\Response
     */
    public function edit(HocKyNamHoc $hocKyNamHoc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HocKyNamHoc  $hocKyNamHoc
     * @return \Illuminate\Http\Response
     */
    public function update(HocKyNamHocRequest $request)
    {
        try {
            $Id = $request->id;
            $idHocKy = trim($request->idhocky);
            $idNamHoc = trim($request->idnamhoc);
            $idTrangThai = HocKyNamHocController::checkSetDefaultTrangThai(trim($request->idtrangthai));
            $TenHocKyNamHoc = HocKyNamHocController::setTenHocKyNamHoc($idHocKy, $idNamHoc);

            $result_NotExist_HocKyNamHoc = HocKyNamHocController::checkNotExist_HocKyNamHocUpdate($Id, $idHocKy, $idNamHoc);

            if($result_NotExist_HocKyNamHoc['status']) // Kiểm tra không tồn tại mã học kỳ và năm học
            {
                try {
                    $objold = HocKyNamHoc::find($Id)->toArray();
                    $HocKyNamHoc = HocKyNamHoc::find($Id);
                    $HocKyNamHoc->idhocky = $idHocKy;
                    $HocKyNamHoc->idnamhoc = $idNamHoc;
                    $HocKyNamHoc->tenhockynamhoc = $TenHocKyNamHoc;
                    $HocKyNamHoc->idtrangthaihocky = $idTrangThai;
                    $HocKyNamHoc->save();

                    // Write log
                    try {
                        $objnew = HocKyNamHoc::find($HocKyNamHoc->id)->toArray();
                        LogController::storeobjectlog($objold, $objnew, LogLoaiHoatDong::UpdateRecord, '');
                        
                    } catch (Exception $e) {}
                    // End Write log

                    $result = array('status' => true, 'message' => "Cập nhật thành công!");
                    return $result;
                } catch (\Throwable $th) {
                    return $result = array('status' => false, 'message' => "Error!<br>".$th->getMessage());
                }
            }
            else
            {
                return $result_NotExist_HocKyNamHoc;
            }
            
        } catch (\Throwable $th) {
            return $result = array('status' => false, 'message' => "Error!<br>".$th->getMessage());
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HocKyNamHoc  $hocKyNamHoc
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        // code

        if(is_numeric($id))
        {
            if(HocKyNamHocController::isExistId($id))
                try {
                    $objold = HocKyNamHoc::find($id)->toArray();
                    HocKyNamHoc::destroy($id);

                    // Write log
                    try {
                        LogController::storeobjectlog($objold, '', LogLoaiHoatDong::DeleteRecord, '');
                        
                    } catch (Exception $e) {}
                    // End Write log

                    $result = array('status' => true, 'message' => "Xóa thành công.");
                    return $result;
                } catch (Exception $e) {
                    $result = array('status' => false, 'message' => $e);
                    return $result;
                }
            else
            {
                $result = array('status' => false, 'message' => "Không tìm thấy dữ liệu để xóa.");
                return $result;
            }
        }
        else
        {
            $result = array('status' => false, 'message' => "Dữ liệu xóa không hợp lệ.");
            return $result;
        }
    }

    public static function isExistID($id)
    {
        $HocKyNamHoc = HocKyNamHoc::Find($id);
        if($HocKyNamHoc)
            return true;
        return flase;
    }

    public static function checkNotExist_HocKyNamHoc($idHocKy, $idNamHoc)
    {
        $DanhSach_HocKyNamHoc = HocKyNamHoc::
               where('idhocky', $idHocKy)
            -> where('idnamhoc', $idNamHoc)
            -> first();

        if($DanhSach_HocKyNamHoc)
            $result = array('status' => false, 'message' => "Đã tồn tại học kỳ - năm học!");
        else
            $result = array('status' => true, 'message' => "Đã tồn tại học kỳ - năm học!");

        return $result;
    }

    public static function checkNotExist_HocKyNamHocUpdate($Id, $idHocKy, $idNamHoc)
    {
        $DanhSach_HocKyNamHoc = HocKyNamHoc::where('id', '<>', $Id)
            -> where('idhocky', $idHocKy)
            -> where('idnamhoc', $idNamHoc)
            -> first();

        if($DanhSach_HocKyNamHoc)
            $result = array('status' => false, 'message' => "Đã tồn tại học kỳ - năm học!");
        else
            $result = array('status' => true, 'message' => "Đã tồn tại học kỳ - năm học!");

        return $result;
    }

    public static function checkSetDefaultTrangThai($idTrangThai)
    {
        if(empty($idTrangThai) || $idTrangThai === "")
            return TrangThaiHocKy::SAPTOI; // Sắp tới.
        
        if($idTrangThai == TrangThaiHocKy::HIENHANH)
            HocKyNamHocController::setAllHienHanhToDaHoanThanh();   // Set all HIEN HANH => DA HOAN THANH
        
        return $idTrangThai;
    }

    public static function setAllHienHanhToDaHoanThanh()
    {
        $id_HienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        
        HocKyNamHoc::where('id',$id_HienHanh)
            -> update(['idtrangthaihocky' => TrangThaiHocKy::DAHOANTHANH]);
    }

    public static function setTenHocKyNamHoc($idHocKy, $idNamHoc)
    {
        $TenHocKy = HocKy::find((int)$idHocKy)->tenhocky;
        $TenNamHoc = NamHoc::find((int)$idNamHoc)->tennamhoc;

        $TenHocKyNamHoc = $TenHocKy . " - Năm học " . $TenNamHoc;
        return $TenHocKyNamHoc;
    }

    /**
     * Get ID HocKyNamHoc hiện hành.
     *
     * @param  null
     * @return \App\HocKyNamHoc $HocKyNamHocHienHanh->id
     */
    public static function getIdHocKyNamHocHienHanh()
    {
        $HocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
        return $HocKyNamHocHienHanh->id;
    }

    /**
     * Get HocKyNamHoc hiện hành.
     *
     * @param  null
     * @return \App\HocKyNamHoc $HocKyNamHocHienHanh
     */
    public static function getHocKyNamHocHienHanh()
    {
        $HocKyNamHocHienHanh = HocKyNamHoc::where('idtrangthaihocky', (int)TrangThaiHocKy::HIENHANH)->first();
        return $HocKyNamHocHienHanh;
    }

    public static function HocKyNamHocBatDauCuaSinhVien($idSinhVien = '')
    {
        $idHocKyI = 1;

        $namHocBatDau = NamHocController::NamHocBatDau($idSinhVien);

        $hocKyNamHocBatDau = HocKyNamHoc::where('idhocky', '=', $idHocKyI)
                -> where('idnamhoc', '=', $namHocBatDau->id)
                -> first();
        if(!$hocKyNamHocBatDau)
            $hocKyNamHocBatDau = HocKyNamHoc::first();
        
        return $hocKyNamHocBatDau;
    }

    public static function HocKyNamHocBatDauCuaLop($idLop = '')
    {
        $idHocKyI = 1; // Học kỳ 1

        $namHocBatDau = NamHocController::NamHocBatDauCuaLop($idLop);

        $hocKyNamHocBatDau = HocKyNamHoc::where('idhocky', '=', $idHocKyI)
                -> where('idnamhoc', '=', $namHocBatDau->id)
                -> first();
        if(!$hocKyNamHocBatDau)
            $hocKyNamHocBatDau = self::getHocKyNamHocHienHanh();
        return $hocKyNamHocBatDau;
    }

    public static function DanhSachHocKyNamHocCuaSinhVien($idSinhVien = '')
    {
        $hocKyNamHocBatDau = self::HocKyNamHocBatDauCuaSinhVien($idSinhVien);
        $dsHocKyNamHoc = HocKyNamHoc::where('id', '>=', $hocKyNamHocBatDau->id)->take(8)->orderBy('id', 'desc')->get();
        return $dsHocKyNamHoc;
    }

    public static function DanhSachHocKyNamHocCuaLop($idLop = '')
    {
        $hocKyNamHocBatDau = self::HocKyNamHocBatDauCuaLop($idLop);
        $dsHocKyNamHoc = HocKyNamHoc::where('id', '>=', $hocKyNamHocBatDau->id)->take(8)->orderBy('id', 'desc')->get();
        return $dsHocKyNamHoc;
    }

    public function giaovukhoa_hockynamhoc()
    {
        $dsHocKyNamHoc = HocKyNamHoc::orderBy('id', 'desc')->get();
        return view('giaovukhoa.bangdiemrenluyen_hockynamhoc', ['dsHocKyNamHoc'=>$dsHocKyNamHoc]);
    }

    public function subadmin_hockynamhoc()
    {
        $dsHocKyNamHoc = HocKyNamHoc::orderBy('id', 'desc')->get();
        return view('subadmin.bangdiemrenluyen_hockynamhoc', ['dsHocKyNamHoc'=>$dsHocKyNamHoc]);
    }

    public static function HocKyNamHoc($idHocKyNamHoc)
    {
        return HocKyNamHoc::find($idHocKyNamHoc);
    }
}
