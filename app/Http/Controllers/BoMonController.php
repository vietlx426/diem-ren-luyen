<?php

namespace App\Http\Controllers;

use App\BoMon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LogLoaiHoatDong;
use App\Http\Requests\BoMonRequest;
use DB;

class BoMonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // print($request->ip());
        $DanhSach_BoMon = DB::table('bomon')
            -> leftjoin('khoa','khoa.id', '=', 'bomon.idkhoa')
            -> select('bomon.*', 'khoa.tenkhoa')
            -> get();
        $DanhSach_Khoa = KhoaController::getDanhSachKhoa();

        return view('admin.bomon', ['DanhSach_BoMon' => $DanhSach_BoMon, 'DanhSach_Khoa' => $DanhSach_Khoa]);
    }

    public function subadmin_index()
    {
        $dsBoMon = BoMon::orderBy('tenbomon', 'asc')->get();

        return view('subadmin.bomonlist',['dsBoMon' => $dsBoMon]);
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
    public function store(BoMonRequest $request)
    {
        $MaBoMon = trim($request->mabomon);
        $TenBoMon = trim($request->tenbomon);
        $result = BoMonController::isNotExistMaBoMonTenBoMon($MaBoMon, $TenBoMon);
         
        if($result['status'])
        {
            try {
                $BoMon = new BoMon();
                $BoMon->mabomon = $MaBoMon;
                $BoMon->tenbomon = $TenBoMon;
                $BoMon->idkhoa = $request->idkhoa;
                $BoMon->stt = BoMonController::getSTTDefault();
                $BoMon->save();

                // Write log
                try {
                    $objnew = BoMon::find($BoMon->id)->toArray();
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
    public function update(BoMonRequest $request)
    {
        $Id = $request->id;
        $MaBoMon = trim($request->mabomon);
        $TenBoMon = trim($request->tenbomon);
        $IDKhoa = trim($request->idkhoa);
        $result = BoMonController::isNotExistMaBoMonTenBoMonUpdate($Id, $MaBoMon, $TenBoMon);
         
        if($result['status'])
        {
            try {
                $objold = BoMon::find($Id)->toArray();
                $BoMon = BoMon::find($Id);
                $BoMon->mabomon = $MaBoMon;
                $BoMon->tenbomon = $TenBoMon;
                $BoMon->idkhoa = $IDKhoa;
                $BoMon->save();

                // Write log
                try {
                    $objnew = BoMon::find($BoMon->id)->toArray();
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
            if(BoMonController::isExistId($id))
                try {

                    $objold = BoMon::find($id)->toArray();
                    BoMon::destroy($id);

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
     * Check Exist Id bộ môn from storage.
     *
     * @param  $Id
     * @return True/False
     */
    public static function isExistId($Id)
    {
        $BoMon = BoMon::find($Id);
        if(count($BoMon)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Mã bộ môn và Tên bộ môn from storage.
     *
     * @param  $MaBoMon, $TenBoMon
     * @return Array(statust, message)
     */
    public static function isNotExistMaBoMonTenBoMon($MaBoMon, $TenBoMon)
    {
        $request_mabomon = BoMonController::isExistMaBoMon($MaBoMon);
        $request_tenbomon = BoMonController::isExistTenBoMon($TenBoMon);

        $status = true;
        $message = "";
        if($request_mabomon)
        {
            $status = false;
            $message .= "<br> - Mã bộ môn đã tồn tại!";
        }

        if($request_tenbomon)
        {
            $status = false;
            $message .= "<br> - Tên bộ môn đã tồn tại!";
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
    public static function isNotExistMaBoMonTenBoMonUpdate($Id, $MaBoMon, $TenBoMon)
    {
        $request_mabomon = BoMonController::isExistMaBoMonUpdate($Id, $MaBoMon);
        $request_tenbomon = BoMonController::isExistTenBoMonUpdate($Id, $TenBoMon);

        $status = true;
        $message = "";

        if($request_mabomon)
        {
            $status = false;
            $message .= "<br> - Mã bộ môn đã tồn tại!";
        }

        if($request_tenbomon)
        {
            $status = false;
            $message .= "<br> - Tên bộ môn đã tồn tại!";
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
    public static function isExistMaBoMon($MaBoMon)
    {
        $DanhSach_BoMon = BoMon::where('mabomon', '=', $MaBoMon)->select('mabomon')->get();
        if(count($DanhSach_BoMon)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Mã bộ môn from storage to update.
     *
     * @param  $MaBoMon
     * @return True, False
     */
    public static function isExistMaBoMonUpdate($Id, $MaBoMon)
    {
        $DanhSach_BoMon = BoMon::where('mabomon', '=', $MaBoMon)
            -> where('id', '<>', $Id)
            -> select('mabomon')->get();
        if(count($DanhSach_BoMon)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Tên bộ môn from storage.
     *
     * @param  $TenBoMon
     * @return True, False
     */
    public static function isExistTenBoMon($TenBoMon)
    {
        $DanhSach_BoMon = BoMon::where('tenbomon', '=', $TenBoMon)->select('tenbomon')->get();
        if(count($DanhSach_BoMon)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Tên bộ môn from storage to update.
     *
     * @param  $TenBoMon
     * @return True, False
     */
    public static function isExistTenBoMonUpdate($Id, $TenBoMon)
    {
        $DanhSach_BoMon = BoMon::where('tenbomon', '=', $TenBoMon)
            -> where('id','<>', $Id)
            ->select('tenbomon')->get();
        if(count($DanhSach_BoMon)>0)
            return true;
        return false;
    }

    /**
     * Get  STT to insert to storage.
     *
     * @param  null
     * @return $STT
     */
    public static function getSTTDefault()
    {
        $MaxSTT = BoMonController::getMaxSTTDefault();

        return ($MaxSTT + 1);
    }

    /**
     * Get  Max STT from storage.
     *
     * @param  null
     * @return $MaxSTT
     */
    public static function getMaxSTTDefault()
    {
        $MaxSTT = BoMon::max('stt');
        if((int)$MaxSTT >= 0)
            return $MaxSTT;
        return 0;
    }

    public static function getKhoaID($bomon_id)
    {
        return BoMon::find($bomon_id)->khoa->id;
    }

    public function GetBoMonByKhoa($idKhoa = '')
    {
        $dsBoMon = BoMon::where('idkhoa', '=', $idKhoa)->get();
        return $dsBoMon;
    }
}
