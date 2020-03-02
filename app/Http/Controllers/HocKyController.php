<?php

namespace App\Http\Controllers;

use App\HocKy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LogController;
use App\Http\Requests\HocKyRequest;
use DB;
use App\HocKyNamHoc;

class HocKyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_HocKy = HocKy::all();
        return view('admin.hocky',['DanhSach_HocKy'=>$DanhSach_HocKy]);
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
    public function store(HocKyRequest $request)
    {
        if(HocKyController::isExistMaHocKy($request->MaHocKy))
        {
            $result = array('status' => false, 'message' => "Mã học kỳ đã tồn tại.");
            return $result;
        }

        if(HocKyController::isExistTenHocKy($request->TenHocKy))
        {
            $result = array('status' => false, 'message' => "Tên học kỳ đã tồn tại.");
            return $result;
        }

        try {
            $HocKy = new HocKy();
            $HocKy->mahocky = $request->MaHocKy;
            $HocKy->TenHocKy = $request->TenHocKy;
            $HocKy->save();

            // Write log
            try {
                $objnew = HocKy::find($HocKy->id)->toArray();
                LogController::storeobjectlog('', $objnew, LogLoaiHoatDong::NewInsertRecord, '');
                
            } catch (Exception $e) {}
            // End Write log

            $result = array('status' => true, 'message' => "Thêm thành công.");
            return $result;
        } catch (Exception $e) {
            $result = array('status' => false, 'message' => $e);
            return $result;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HocKy  $hocKy
     * @return \Illuminate\Http\Response
     */
    public function show(HocKy $hocKy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HocKy  $hocKy
     * @return \Illuminate\Http\Response
     */
    public function edit(HocKy $hocKy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HocKy  $hocKy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HocKy $hocKy)
    {
        if(HocKyController::isExistMaHocKyUpdate($request->id, $request->MaHocKy))
        {
            $result = array('status' => false, 'message' => " - Mã học kỳ đã tồn tại.");
            return $result;
        }

        if(HocKyController::isExistTenHocKyUpdate($request->id, $request->TenHocKy))
        {
            $result = array('status' => false, 'message' => " - Tên học kỳ đã tồn tại.");
            return $result;
        }

        try {
            $objold = HocKy::find($request->id)->toArray();
            $HocKy = HocKy::find($request->id);
            $HocKy->mahocky = $request->MaHocKy;
            $HocKy->TenHocKy = $request->TenHocKy;
            $HocKy->save();

            // Write log
            try {
                $objnew = HocKy::find($HocKy->id)->toArray();
                LogController::storeobjectlog($objold, $objnew, LogLoaiHoatDong::UpdateRecord, '');
                
            } catch (Exception $e) {}
            // End Write log

            $result = array('status' => true, 'message' => "Cập nhật thành công.");
            return $result;
        } catch (Exception $e) {
            $result = array('status' => false, 'message' => $e);
            return $result;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HocKy  $hocKy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        if(is_numeric($id))
        {
            if(HocKyController::isExistId($id))
                try {
                    $hocKyNamHoc = HocKyNamHoc::where('idhocky', '=', $id)->get();
                    if(count($hocKyNamHoc) == 0)
                    {
                        $objold = HocKy::find($id)->toArray();
                        HocKy::destroy($id);

                        // Write log
                        try {
                            LogController::storeobjectlog($objold, '', LogLoaiHoatDong::DeleteRecord, '');
                            
                        } catch (Exception $e) {}
                        // End Write log

                        $result = array('status' => true, 'message' => "Xóa thành công.");
                        return $result;
                    }
                    else
                    {
                        $result = array('status' => false, 'message' => "Không thể xóa. Học kỳ này có liên kết khóa ngoại.");
                        return $result;
                    }
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

    public static function isExistId($id)
    {
        $HocKy = HocKy::find($id);
        if($HocKy)
            return true;
        return false;
    }
     public static function isExistMaHocKy($Ma)
    {
        $HocKy = DB::table('hoc_kies')->where('mahocky', $Ma)->first();
        if($HocKy)
            return true;
        return false;
    }
    public static function isExistMaHocKyUpdate($id, $Ma)
    {
        $HocKy = DB::table('hoc_kies')->where('mahocky', $Ma)->where('id','<>', $id)->first();
        if($HocKy)
            return true;
        return false;
    }
    public static function isExistTenHocKy($Ten)
    {
        $HocKy = DB::table('hoc_kies')->where('tenhocky', $Ten)->first();
        if($HocKy)
            return true;
        return false;
    }
    public static function isExistTenHocKyUpdate($id, $Ten)
    {
        $HocKy = DB::table('hoc_kies')->where('tenhocky', $Ten)->where('id','<>', $id)->first();
        if($HocKy)
            return true;
        return false;
    }
}
