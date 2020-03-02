<?php

namespace App\Http\Controllers;

use App\Khoa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LogController;
use App\Http\Requests\KhoaRequest;
// use App\Http\Requests\HocKyNamHocRequest;

class KhoaController extends Controller
{
    public function testhasMany()
    {
        $Khoa = Khoa::find('1')->bomons;
        print_r($Khoa->toArray());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_Khoa = Khoa::all();
        return view('admin.khoa', ['DanhSach_Khoa' => $DanhSach_Khoa]);
    }

    public function subadmin_index()
    {
        $dsKhoa = Khoa::orderBy('tenkhoa', 'asc')->get();

        return view('subadmin.khoalist',['dsKhoa' => $dsKhoa]);
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
    public function store(KhoaRequest $request)
    {
        
        $MaKhoa = trim($request->makhoa);
        $TenKhoa = trim($request->tenkhoa);
        $result = KhoaController::isNotExistMaKhoaTenKhoa($MaKhoa, $TenKhoa);
         
        if($result['status'])
        {
            try {
                $Khoa = new Khoa();
                $Khoa->makhoa = $MaKhoa;
                $Khoa->tenkhoa = $TenKhoa;
                $Khoa->stt = KhoaController::getSTTDefault();
                $Khoa->save();

                // Write log
                try {
                    $objnew = Khoa::find($Khoa->id)->toArray();
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
            return $result;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Khoa  $khoa
     * @return \Illuminate\Http\Response
     */
    public function show(Khoa $khoa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Khoa  $khoa
     * @return \Illuminate\Http\Response
     */
    public function edit(Khoa $khoa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Khoa  $khoa
     * @return \Illuminate\Http\Response
     */
    public function update(KhoaRequest $request)
    {
        $Id = $request->id;
        $MaKhoa = trim($request->makhoa);
        $TenKhoa = trim($request->tenkhoa);
        $result = KhoaController::isNotExistMaKhoaTenKhoaUpdate($Id, $MaKhoa, $TenKhoa);
         
        if($result['status'])
        {
            try {
                $objold = Khoa::find($Id)->toArray();
                $Khoa = Khoa::find($Id);
                $Khoa->makhoa = $MaKhoa;
                $Khoa->tenkhoa = $TenKhoa;
                $Khoa->save();

                // Write log
                try {
                    $objnew = Khoa::find($Khoa->id)->toArray();
                    LogController::storeobjectlog($objold, $objnew, LogLoaiHoatDong::UpdateRecord, '');
                    
                } catch (Exception $e) {}
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
     * @param  \App\Khoa  $khoa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        // code

        if(is_numeric($id))
        {
            if(KhoaController::isExistId($id))
                try {
                    $objold = Khoa::find($id);
                    Khoa::destroy($id);

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

    /**
     * Check Exist Id khoa from storage.
     *
     * @param  $Id
     * @return True/False
     */
    public static function isExistId($Id)
    {
        $Khoa = Khoa::find($Id);
        if(count($Khoa)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Mã khoa và Tên khoa from storage.
     *
     * @param  $MaKhoa, $TenKhoa
     * @return Array(statust, message)
     */
    public static function isNotExistMaKhoaTenKhoa($MaKhoa, $TenKhoa)
    {
        $request_makhoa = KhoaController::isExistMaKhoa($MaKhoa);
        $request_tenkhoa = KhoaController::isExistTenKhoa($TenKhoa);

        $status = true;
        $message = "";
        if($request_makhoa)
        {
            $status = false;
            $message .= "<br> - Mã khoa đã tồn tại!";
        }

        if($request_tenkhoa)
        {
            $status = false;
            $message .= "<br> - Tên khoa đã tồn tại!";
        }

        $result = array('status' => $status, 'message' => $message);
        return $result;
    }

    /**
     * Check Exist Mã khoa và Tên khoa from storage to update.
     *
     * @param  $MaKhoa, $TenKhoa
     * @return Array(statust, message)
     */
    public static function isNotExistMaKhoaTenKhoaUpdate($Id, $MaKhoa, $TenKhoa)
    {
        $request_makhoa = KhoaController::isExistMaKhoaUpdate($Id, $MaKhoa);
        $request_tenkhoa = KhoaController::isExistTenKhoaUpdate($Id, $TenKhoa);

        $status = true;
        $message = "";
        if($request_makhoa)
        {
            $status = false;
            $message .= "<br> - Mã khoa đã tồn tại!";
        }

        if($request_tenkhoa)
        {
            $status = false;
            $message .= "<br> - Tên khoa đã tồn tại!";
        }

        $result = array('status' => $status, 'message' => $message);
        return $result;
    }

    /**
     * Check Exist Mã khoa from storage.
     *
     * @param  $MaKhoa
     * @return True, False
     */
    public static function isExistMaKhoa($MaKhoa)
    {
        $DanhSach_Khoa = Khoa::where('makhoa', '=', $MaKhoa)->select('makhoa')->get();
        if(count($DanhSach_Khoa)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Mã khoa from storage to update.
     *
     * @param  $MaKhoa
     * @return True, False
     */
    public static function isExistMaKhoaUpdate($Id,$MaKhoa)
    {
        $DanhSach_Khoa = Khoa::where('makhoa', '=', $MaKhoa)
            -> where('id', '<>', $Id)
            -> select('makhoa')->get();
        if(count($DanhSach_Khoa)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Tên khoa from storage.
     *
     * @param  $TenKhoa
     * @return True, False
     */
    public static function isExistTenKhoa($TenKhoa)
    {
        $DanhSach_Khoa = Khoa::where('tenkhoa', '=', $TenKhoa)->select('tenkhoa')->get();
        if(count($DanhSach_Khoa)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Tên khoa from storage to update.
     *
     * @param  $TenKhoa
     * @return True, False
     */
    public static function isExistTenKhoaUpdate($Id, $TenKhoa)
    {
        $DanhSach_Khoa = Khoa::where('tenkhoa', '=', $TenKhoa)
            -> where('id','<>', $Id)
            ->select('tenkhoa')->get();
        if(count($DanhSach_Khoa)>0)
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
        $MaxSTT = KhoaController::getMaxSTTDefault();

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
        $MaxSTT = Khoa::max('stt');
        if((int)$MaxSTT >= 0)
            return $MaxSTT;
        return 0;
    }

     /**
     * Get  Khoa from storage.
     *
     * @param  null
     * @return Khoa
     */
    public static function getDanhSachKhoa()
    {
        $DanhSach_Khoa = Khoa::orderBy('tenkhoa', 'asc')->get();
        return $DanhSach_Khoa;
    }

    public static function getArrayAllKhoaID()
    {
        $DS_KhoaID = Khoa::select('id')->get();
        $arrayKhoaID = array();

        if($DS_KhoaID)
        {
            foreach ($DS_KhoaID as $key => $value) {
                array_push($arrayKhoaID, $value->id);
            }
        }

        return $arrayKhoaID;
    }
    
    public static function GetidKhoaByTen($TenKhoa = '')
    {
        
        return Khoa::where('tenkhoa', '=', strtoupper(trim($TenKhoa)))->first();
    }

}
