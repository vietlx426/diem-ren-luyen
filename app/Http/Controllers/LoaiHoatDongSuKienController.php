<?php

namespace App\Http\Controllers;

use App\LoaiHoatDongSuKien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LogLoaiHoatDong;
use App\Http\Requests\LoaiHoatDongSuKienRequest;
use DB;
use App\HoatDongSuKien;

class LoaiHoatDongSuKienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // print($request->ip());
        $DanhSach_LoaiHoatDongSuKien=\App\LoaiHoatDongSuKien::all();
         return view('subadmin.loaihoatdongsukien', ['DanhSach_LoaiHoatDongSuKien' => $DanhSach_LoaiHoatDongSuKien]);
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
        $MaLoaiHoatDongSuKien = trim($request->maloaihoatdongsukien);
        $TenLoaiHoatDongSuKien = trim($request->tenloaihoatdongsukien);
        $result = LoaiHoatDongSuKienController::isNotExistMaHoatDongSuKienTenHoatDongSuKien($MaLoaiHoatDongSuKien, $TenLoaiHoatDongSuKien);
         
        if($result['status'])
        {
            try {
                $LoaiHoatDongSuKien = new LoaiHoatDongSuKien();
                $LoaiHoatDongSuKien->maloaihoatdongsukien = $MaLoaiHoatDongSuKien;
                $LoaiHoatDongSuKien->tenloaihoatdongsukien = $TenLoaiHoatDongSuKien;
                $LoaiHoatDongSuKien->save();

                // Write log
                try {
                    $objnew = LoaiHoatDongSuKien::find($LoaiHoatDongSuKien->id)->toArray();
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
     * @param  \App\BoMon  $boMon
     * @return \Illuminate\Http\Response
     */
    public function show(BoMon $boMon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BoMon  $boMon
     * @return \Illuminate\Http\Response
     */
    public function edit(BoMon $boMon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BoMon  $boMon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $result = array('status' => true, 'message' => "Cập nhật thành công!");
        // 
        $Id = $request->id;
        $MaLoaiHoatDongSuKien = trim($request->maloaihoatdongsukien);
        $TenLoaiHoatDongSuKien = trim($request->tenloaihoatdongsukien);
        $result = LoaiHoatDongSuKienController::isNotExistMaLoaiHoatDongSuKienTenLoaiHoatDongSuKienUpdate($Id, $MaLoaiHoatDongSuKien, $TenLoaiHoatDongSuKien);
         
        if($result['status'])
        {
            try {
                $objold = LoaiHoatDongSuKien::find($Id)->toArray();
                $LoaiHoatDongSuKien = LoaiHoatDongSuKien::find($Id);
                $LoaiHoatDongSuKien->maloaihoatdongsukien = $MaLoaiHoatDongSuKien;
                $LoaiHoatDongSuKien->tenloaihoatdongsukien = $TenLoaiHoatDongSuKien;
               
                $LoaiHoatDongSuKien->save();

                // Write log
                try {
                    $objnew = LoaiHoatDongSuKien::find($LoaiHoatDongSuKien->id)->toArray();
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
     * @param  \App\BoMon  $boMon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        // code

        if(is_numeric($id))
        {
            if(LoaiHoatDongSuKienController::isExistId($id)){
                $result_ktra_khoangoai=LoaiHoatDongSuKienController::checkforeingkey($id);
                if($result_ktra_khoangoai['status'])
                {
                    try {    

                        $objold = LoaiHoatDongSuKien::find($id)->toArray();
                        LoaiHoatDongSuKien::destroy($id);

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
            }
            else
            {
                return $result_ktra_khoangoai;
            }
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
     * Check Exist Id bộ môn from storage.
     *
     * @param  $Id
     * @return True/False
     */
    public static function isExistId($Id)
    {
        $LoaiHoatDongSuKien = LoaiHoatDongSuKien::find($Id);
        if(count($LoaiHoatDongSuKien)>0)
            return true;
        return false;
    }

    public static function checkforeingkey($id){
        $t = HoatDongSuKien::where('loaihoatdongsukien_id','=',$id)->select('loaihoatdongsukien_id')->get();
        if(count($t)>0)
            return $result=array('status'=> false,'message'=>'Loại hoạt động sự kiện này đang được sử dụng bên hoạt động sự kiện');
        return $result=array('status'=> true,'message'=>'');
    }

    /**
     * Check Exist Mã bộ môn và Tên bộ môn from storage.
     *
     * @param  $MaBoMon, $TenBoMon
     * @return Array(statust, message)
     */
    public static function isNotExistMaHoatDongSuKienTenHoatDongSuKien($MaLoaiHoatDongSuKien, $TenLoaiHoatDongSuKien)
    {
        $request_maloaihoatdongsukien = LoaiHoatDongSuKienController::isExistMaLoaiHoatDongSuKien($MaLoaiHoatDongSuKien);
        $request_tenloaihoatdongsukien = LoaiHoatDongSuKienController::isExistTenLoaiHoatDongSuKien($TenLoaiHoatDongSuKien);

        $status = true;
        $message = "";
        if($request_maloaihoatdongsukien)
        {
            $status = false;
            $message .= "<br> - Mã loại hoạt động sự kiện đã tồn tại!";
        }

        if($request_tenloaihoatdongsukien)
        {
            $status = false;
            $message .= "<br> - Tên loại hoạt động sự kiện đã tồn tại!";
        }

        $result = array('status' => $status, 'message' => $message);
        return $result;
    }

    /**
     * Check Exist Mã bộ môn và Tên bộ môn from storage to update.
     *
     * @param  $MaBoMon, $TenBoMon
     * @return Array(statust, message)
     */
    public static function isNotExistMaLoaiHoatDongSuKienTenLoaiHoatDongSuKienUpdate($Id, $MaLoaiHoatDongSuKien, $TenLoaiHoatDongSuKien)
    {
        $request_maloaihoatdongsukien = LoaiHoatDongSuKienController::isExistMaLoaiHoatDongSuKienUpdate($Id, $MaLoaiHoatDongSuKien);
        $request_tenloaihoatdongsukien = LoaiHoatDongSuKienController::isExistTenLoaiHoatDongSuKienUpdate($Id, $TenLoaiHoatDongSuKien);

        $status = true;
        $message = "";

        if($request_maloaihoatdongsukien)
        {
            $status = false;
            $message .= "<br> - Mã loại hoạt động sự kiện đã tồn tại!";
        }

        if($request_tenloaihoatdongsukien)
        {
            $status = false;
            $message .= "<br> - Tên loại hoạt động sự kiện đã tồn tại!";
        }

        $result = array('status' => $status, 'message' => $message);
        return $result;
    }

    /**
     * Check Exist Mã bộ môn from storage.
     *
     * @param  $MaBoMon
     * @return True, False
     */
    public static function isExistMaLoaiHoatDongSuKien($MaLoaiHoatDongSuKien)
    {
        $DanhSach_LoaiHoatDongSuKien = LoaiHoatDongSuKien::where('maloaihoatdongsukien', '=', $MaLoaiHoatDongSuKien)->select('maloaihoatdongsukien')->get();
        if(count($DanhSach_LoaiHoatDongSuKien)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Mã bộ môn from storage to update.
     *
     * @param  $MaBoMon
     * @return True, False
     */
    public static function isExistMaLoaiHoatDongSuKienUpdate($Id, $MaLoaiHoatDongSuKien)
    {
        $DanhSach_LoaiHoatDongSuKien = LoaiHoatDongSuKien::where('maloaihoatdongsukien', '=', $MaLoaiHoatDongSuKien)
            -> where('id', '<>', $Id)
            -> select('maloaihoatdongsukien')->get();
        if(count($DanhSach_LoaiHoatDongSuKien)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Tên bộ môn from storage.
     *
     * @param  $TenBoMon
     * @return True, False
     */
    public static function isExistTenLoaiHoatDongSuKien($TenLoaiHoatDongSuKien)
    {
        $DanhSach_LoaiHoatDongSuKien = LoaiHoatDongSuKien::where('tenloaihoatdongsukien', '=', $TenLoaiHoatDongSuKien)->select('tenloaihoatdongsukien')->get();
        if(count($DanhSach_LoaiHoatDongSuKien)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Tên bộ môn from storage to update.
     *
     * @param  $TenBoMon
     * @return True, False
     */
    public static function isExistTenLoaiHoaTDongSuKienUpdate($Id, $TenLoaiHoatDongSuKien)
    {
        $DanhSach_LoaiHoatDongSuKien = LoaiHoatDongSuKien::where('tenloaihoatdongsukien', '=', $TenLoaiHoatDongSuKien)
            -> where('id','<>', $Id)
            ->select('tenloaihoatdongsukien')->get();
        if(count($DanhSach_LoaiHoatDongSuKien)>0)
            return true;
        return false;
    }

    /**
     * Get  STT to insert to storage.
     *
     * @param  null
     * @return $STT
     */
    /*public static function getSTTDefault()
    {
        $MaxSTT = LoaiHoatDongSuKienController::getMaxSTTDefault();

        return ($MaxSTT + 1);
    }*/

    /**
     * Get  Max STT from storage.
     *
     * @param  null
     * @return $MaxSTT
     */
/*    public static function getMaxSTTDefault()
    {
        $MaxSTT = BoMon::max('stt');
        if((int)$MaxSTT >= 0)
            return $MaxSTT;
        return 0;
    }
*/
    public static function getKhoaID($bomon_id)
    {
        return BoMon::find($bomon_id)->khoa->id;
    }
}
