<?php

namespace App\Http\Controllers;

use App\Lop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\KhoaHoc;
use App\Nganh;
use App\HocKyNamHoc;
use App\GiaoVuKhoa;
use App\ChuyenVienQuanLyLop;
use Auth;


class LopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_Lop = Lop::all();

        // $DanhSach_BoMon = BoMon::all();
        $DanhSach_KhoaHoc = KhoaHoc::all();
        $DanhSach_Nganh = Nganh::orderBy('tennganh', 'asc')->get();

        return view('admin.lop',['DanhSach_Lop' => $DanhSach_Lop, 'DanhSach_KhoaHoc' => $DanhSach_KhoaHoc, 'DanhSach_Nganh' => $DanhSach_Nganh]);
    }

    public function subadmin_index()
    {
        $dsLop = Lop::orderBy('tenlop', 'asc')->get();

        return view('subadmin.loplist',['dsLop' => $dsLop]);
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
        $MaLop = trim($request->malop);
        $TenLop = trim($request->tenlop);
        $result = self::isNotExistMaLopTenLop($MaLop, $TenLop);


        if($result['status'])
        {
            try {
                $Lop = new Lop();
                $Lop->malop = $MaLop;
                $Lop->tenlop = $TenLop;
                $Lop->khoahoc_id = $request->idkhoahoc;
                $Lop->nganh_id = $request->idnganh;

                $Lop->save();

                // Write log
                try {
                    $objnew = Lop::find($Lop->id)->toArray();
                    LogController::storeobjectlog('', $objnew, LogLoaiHoatDong::NewInsertRecord, '');
                    
                } catch (Exception $e) {
                    
                }
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
            return $result;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lop  $lop
     * @return \Illuminate\Http\Response
     */
    public function show(Lop $lop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lop  $lop
     * @return \Illuminate\Http\Response
     */
    public function edit(Lop $lop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lop  $lop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $Id = $request->id;
        $MaLop = trim($request->malop);
        $TenLop = trim($request->tenlop);
        $IDKhoaHoc = trim($request->idkhoahoc);
        $IDNganh = trim($request->idnganh);
        $result = self::isNotExistMaLopTenLopUpdate($Id, $MaLop, $TenLop);

        if($result['status'])
        {
            try {
                $objold = Lop::find($Id)->toArray();
                $Lop = Lop::find($Id);

                $Lop->malop = $MaLop;
                $Lop->tenlop = $TenLop;
                $Lop->khoahoc_id = $IDKhoaHoc;
                $Lop->nganh_id = $IDNganh;

                $Lop->save();

                // Write log
                try {
                    $objnew = Lop::find($Lop->id)->toArray();
                    LogController::storeobjectlog($objold, $objnew, LogLoaiHoatDong::UpdateRecord, '');
                    
                } catch (Exception $e) {
                    
                }
                // End Write log

                $result = array('status' => true, 'message' => "Cập nhật thành công!");
                return $result;
            } catch (Exception $e) {
                $result = array('status' => false, 'message' => $e);
                return $result;
            }
        }
        else
        {
            return $result;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lop  $lop
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        // code

        if(is_numeric($id))
        {
            if(self::isExistId($id))
                try {

                    $objold = Lop::find($id)->toArray();
                    Lop::destroy($id);

                    // Write log
                    try {
                        LogController::storeobjectlog($objold, '', LogLoaiHoatDong::DeleteRecord, '');
                    } catch (Exception $e) {
                        
                    }
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

    /**
     * Check Exist Id lớp from storage.
     *
     * @param  $Id
     * @return True/False
     */
    public static function isExistId($Id)
    {
        $Lop = Lop::find($Id);
        if(count($Lop)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Mã lớp và Tên lớp from storage.
     *
     * @param  $MaLop, $TenLop
     * @return Array(statust, message)
     */
    public static function isNotExistMaLopTenLop($MaLop, $TenLop)
    {
        $request_malop = self::isExistMaLop($MaLop);
        $request_tenlop = self::isExistTenLop($TenLop);

        $status = true;
        $message = "";
        if($request_malop)
        {
            $status = false;
            $message .= "<br> - Mã lớp đã tồn tại!";
        }

        if($request_tenlop)
        {
            $status = false;
            $message .= "<br> - Tên lớp đã tồn tại!";
        }

        $result = array('status' => $status, 'message' => $message);
        return $result;
    }

    /**
     * Check Exist Mã lớp và Tên lớp from storage to update.
     *
     * @param  $MaLop, $TenLop
     * @return Array(statust, message)
     */
    public static function isNotExistMaLopTenLopUpdate($Id, $MaLop, $TenLop)
    {
        $request_malop = self::isExistMaLopUpdate($Id, $MaLop);
        $request_tenlop = self::isExistTenLopUpdate($Id, $TenLop);

        $status = true;
        $message = "";

        if($request_malop)
        {
            $status = false;
            $message .= "<br> - Mã lớp đã tồn tại!";
        }

        if($request_tenlop)
        {
            $status = false;
            $message .= "<br> - Tên lớp đã tồn tại!";
        }

        $result = array('status' => $status, 'message' => $message);
        return $result;
    }

    /**
     * Check Exist Mã lớp from storage.
     *
     * @param  $MaLop
     * @return True, False
     */
    public static function isExistMaLop($MaLop)
    {
        $DanhSach_Lop = Lop::where('malop', '=', $MaLop)->select('malop')->get();
        if(count($DanhSach_Lop)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Mã lớp from storage to update.
     *
     * @param  $MaLop
     * @return True, False
     */
    public static function isExistMaLopUpdate($Id, $MaLop)
    {
        $DanhSach_Lop = Lop::where('malop', '=', $MaLop)
            -> where('id', '<>', $Id)
            -> select('malop')->get();
        if(count($DanhSach_Lop)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Tên lớp from storage.
     *
     * @param  $TenLop
     * @return True, False
     */
    public static function isExistTenLop($TenLop)
    {
        $DanhSach_Lop = Lop::where('tenlop', '=', $TenLop)->select('tenlop')->get();
        if(count($DanhSach_Lop)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Tên lớp from storage to update.
     *
     * @param  $TenLop
     * @return True, False
     */
    public static function isExistTenLopUpdate($Id, $TenLop)
    {
        $DanhSach_Lop = Lop::where('tenlop', '=', $TenLop)
            -> where('id','<>', $Id)
            -> select('tenlop')->get();
        if(count($DanhSach_Lop)>0)
            return true;
        return false;
    }


    public static function getNganh($lop_id)
    {
        return Lop::find($lop_id)->nganh->id;
    }

    public static function getKhoaHocID($lop_id)
    {
        return Lop::find($lop_id)->khoahoc->id;
    }

    public function getLop($nganh_id)
    {
        $DanhSach_Lop = Lop::where('nganh_id', '=', $nganh_id)
            -> select('id', 'tenlop')
            -> get();
        print_r($DanhSach_Lop->toArray());
    }

    public function getLopByNganh(Request $arrayNganhID)
    {
        $DanhSach_Lop = Lop::whereIn('nganh_id', $arrayNganhID->NganhID)
            -> orderBy('tenlop', 'asc')
            -> get();

        if($DanhSach_Lop)
        {
            return $DanhSach_Lop->toArray();
        }
        return $DanhSach_Lop;
    }

    public static function getArrayAllLopID()
    {
        $DS_LopID = Lop::select('id')->get();
        $arrayLopID = array();

        if($DS_LopID)
        {
            foreach ($DS_LopID as $key => $value) {
                array_push($arrayLopID, $value->id);
            }
        }

        return $arrayLopID;
    }

    public static function getLopByKhoa($idKhoa)
    {
        $dsLop = Lop::join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            -> join('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('bomon.idkhoa', '=', $idKhoa)
            -> where('khoahoc.namketthuc', '>=', date('Y'))
            -> select('lop.*')
            -> orderBy('lop.tenlop', 'asc')
            -> get();

        return $dsLop;
    }

    public static function LopCount()
    {
        return count(Lop::all());
    }

    public function giaovukhoa_hockynamhoc_lop($idHocKyNamHoc='')
    {
        if(Auth::check())
        {
            $idCBGV = Auth::user()->cbgvsv_id;
            $giaoVuKhoa = GiaoVuKhoa::where('cbgv_id', '=', $idCBGV)
                -> where('trangthai_id', '=', 1)
                -> select('khoa_id')
                -> get();
            if(Auth::user()->idloaiuser == 1 && $giaoVuKhoa)
            {
                $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
                try {
                    $namBatDau = intval(trim(explode("-",$hocKyNamHoc->namhoc->tennamhoc)[0]));
                    $namKetThuc = intval(trim(explode("-",$hocKyNamHoc->namhoc->tennamhoc)[1]));
                    
                } catch (Exception $e) {
                    
                }

                $dsLop = Lop::leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
                    -> leftjoin('nganh', 'nganh.id', '=', 'lop.nganh_id')
                    -> leftjoin('bomon', 'bomon.id', '=', 'nganh.idbomon')
                    -> leftjoin('khoa', 'khoa.id', '=', 'bomon.idkhoa')
                    -> where('khoahoc.nambatdau', '<=', $namBatDau)
                    -> where('khoahoc.namketthuc', '>=', $namKetThuc)
                    -> whereIn('khoa.id', $giaoVuKhoa)
                    -> select('lop.*')
                    -> orderBy('lop.tenlop','asc')
                    -> get();
                return view('giaovukhoa.bangdiemrenluyen_hockynamhoc_lop', ['dsLop'=>$dsLop, 'hocKyNamHoc'=>$hocKyNamHoc]);
            }
            return redirect()->back()->with('danger', "Người không có quyền trên hệ thống!");
        }
        return redirect()->route('home');
    }

    public function subadmin_hockynamhoc_lop($idHocKyNamHoc='')
    {
        if(Auth::check())
        {
            $idCBGV = Auth::user()->cbgvsv_id;
            $dsLop = ChuyenVienQuanLyLop::where('cbgv_id', '=', $idCBGV)
                -> where('trangthai_id', '=', 1)
                -> select('lop_id')->get();

            if(Auth::user()->idloaiuser == 1 && count($dsLop) > 0)
            {
                $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
                try {
                    $namBatDau = intval(trim(explode("-",$hocKyNamHoc->namhoc->tennamhoc)[0]));
                    $namKetThuc = intval(trim(explode("-",$hocKyNamHoc->namhoc->tennamhoc)[1]));
                    
                } catch (Exception $e) {
                    
                }

                $dsLop = Lop::whereIn('lop.id', $dsLop)
                    -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
                    -> where('khoahoc.nambatdau', '<=', $namBatDau)
                    -> where('khoahoc.namketthuc', '>=', $namKetThuc)
                    -> select('lop.*')
                    -> orderBy('lop.tenlop','asc')
                    -> get();
                
                return view('subadmin.bangdiemrenluyen_hockynamhoc_lop', ['dsLop'=>$dsLop, 'hocKyNamHoc'=>$hocKyNamHoc]);
            }
            return redirect()->back()->with('danger', "Người không có quyền trên hệ thống!");
        }
        return redirect()->route('home');
    }
}
