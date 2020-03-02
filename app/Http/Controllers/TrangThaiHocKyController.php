<?php

namespace App\Http\Controllers;

use App\TrangThai_HocKy;
use Illuminate\Http\Request;
use App\Http\Requests\TrangThai_HocKyRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LogController;
use DB;

class TrangThaiHocKyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_TrangThaiHocKy = TrangThai_HocKy::all();
        return view('admin.trangthaihocky',['DanhSach_TrangThaiHocKy' => $DanhSach_TrangThaiHocKy]);
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
    public function store(TrangThai_HocKyRequest $request)
    {
        if(TrangThaiHocKyController::isExistTenTrangThaiHocKy($request->TenTrangThaiHocKy))
        {
            $result = array('status' => false, 'message' => "Tên trạng thái đã tồn tại.");
            return $result;
        }

        try {
            $TrangThai_HocKy = new TrangThai_HocKy;
            $TrangThai_HocKy->TenTrangThai = $request->TenTrangThaiHocKy;
            $TrangThai_HocKy->save();

            // Write log
            try {
                $objnew = TrangThai_HocKy::find($TrangThai_HocKy->id)->toArray();
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
     * @param  \App\TrangThai_HocKy  $trangThai_HocKy
     * @return \Illuminate\Http\Response
     */
    public function show(TrangThai_HocKy $trangThai_HocKy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TrangThai_HocKy  $trangThai_HocKy
     * @return \Illuminate\Http\Response
     */
    public function edit(TrangThai_HocKy $trangThai_HocKy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TrangThai_HocKy  $trangThai_HocKy
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, TrangThai_HocKy $trangThai_HocKy)
    public function update(TrangThai_HocKyRequest $request)
    {
        $id = $request->id;
        if(is_numeric($id))
        {
            if(TrangThaiHocKyController::isExist($id))
            {
                $Ten = trim($request->TenTrangThaiHocKy);
                if(TrangThaiHocKyController::isExistTenTrangThaiHocKyUpdate($id, $Ten))
                {
                    $result = array('status' => false, 'message' => "Tên trạng thái học kỳ đã tồn tại.");
                    return $result;
                }
                else
                {
                    try {
                        $objold = TrangThai_HocKy::find($id)->toArray();
                        $TrangThai_HocKy = TrangThai_HocKy::find($id);
                        $TrangThai_HocKy->TenTrangThai = $Ten;
                        $TrangThai_HocKy->save();

                        // Write log
                        try {
                            $objnew = TrangThai_HocKy::find($TrangThai_HocKy->id)->toArray();
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
            }
            else
            {
                $result = array('status' => false, 'message' => "Không tìm thấy dữ liệu để cập nhật.");
                return $result;
            }
        }
        else
        {
            $result = array('status' => false, 'message' => "Dữ liệu cập nhật không hợp lệ.");
            return $result;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TrangThai_HocKy  $trangThai_HocKy
     * @return \Illuminate\Http\Response
     */
    // public function destroy(TrangThai_HocKy $trangThai_HocKy)
    public function destroy($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        // code
        if(is_numeric($id))
        {
            if(TrangThaiHocKyController::isExist($id))
                try {
                    $objold = TrangThai_HocKy::find($id)->toArray();
                    TrangThai_HocKy::destroy($id);

                    // Write log
                    try {
                        LogController::storeobjectlog($objold, '', LogLoaiHoatDong::DeleteRecord, '');
                        
                    } catch (Exception $e) {}
                    // End Write log

                    $result = array('status' => true, 'message' => "Xóa thành công!");
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

    public function isNum($value)
    {
        return is_numeric($value);
    }

    public static function isExist($id)
    {
        $TrangThaiHocKy = TrangThai_HocKy::find($id);
        if(count($TrangThaiHocKy)>0)
            return true;
        return false;
    }

    public static function isExistTenTrangThaiHocKy($Ten)
    {
        $TrangThai = DB::table('trang_thai__hoc_kies')->where('TenTrangThai', $Ten)->first();
        if(count($TrangThai)>0)
            return true;
        return false;
    }
    public static function isExistTenTrangThaiHocKyUpdate($id, $Ten)
    {
        $TrangThai = DB::table('trang_thai__hoc_kies')->where('TenTrangThai', $Ten)->where('id','<>', $id)->first();
        if(count($TrangThai)>0)
            return true;
        return false;
    }
}
