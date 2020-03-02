<?php

namespace App\Http\Controllers;

use App\TrangThaiTieuChi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrangThaiTieuChiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_TrangThaiTieuChi = TrangThaiTieuChi::all();
        return view('subadmin.trangthaitieuchi', ['DanhSach_TrangThaiTieuChi' => $DanhSach_TrangThaiTieuChi]);
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
        if(TrangThaiTieuChiController::isExistTenTrangThaiTieuChi($request->TenTrangThaiTieuChi))
        {
            $result = array('status' => false, 'message' => " - Tên trạng thái tiêu chí đã tồn tại.");
            return $result;
        }

        try {
            $TrangThaiTieuChi = new TrangThaiTieuChi();
            $TrangThaiTieuChi->tentrangthai = $request->TenTrangThaiTieuChi;
            $TrangThaiTieuChi->save();

            /** 
             * Write log
             */
            try {
                $objnew = TrangThaiTieuChi::find($TrangThaiTieuChi->id)->toArray();
                LogController::storeobjectlog('', $objnew, LogLoaiHoatDong::NewInsertRecord, '');
                
            } catch (Exception $e) {}
            /** 
             * End Write log
             */

            $result = array('status' => true, 'message' => "Thêm thành công!");
            return $result;
        } catch (Exception $e) {
            $result = array('status' => false, 'message' => "Thêm thất bại! <br>".$e);
            return $result;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TrangThaiTieuChi  $trangThaiTieuChi
     * @return \Illuminate\Http\Response
     */
    public function show(TrangThaiTieuChi $trangThaiTieuChi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TrangThaiTieuChi  $trangThaiTieuChi
     * @return \Illuminate\Http\Response
     */
    public function edit(TrangThaiTieuChi $trangThaiTieuChi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TrangThaiTieuChi  $trangThaiTieuChi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrangThaiTieuChi $trangThaiTieuChi)
    {
        if(TrangThaiTieuChiController::isExistTenTrangThaiTieuChiUpdate($request->id, $request->TenTrangThaiTieuChi))
        {
            $result = array('status' => false, 'message' => " - Tên trạng thái tiêu chí đã tồn tại.");
            return $result;
        }

        try {
            $objold = TrangThaiTieuChi::find($request->id)->toArray();
            $TrangThaiTieuChi = TrangThaiTieuChi::find($request->id);
            $TrangThaiTieuChi->tentrangthai = $request->TenTrangThaiTieuChi;
            $TrangThaiTieuChi->save();

            // Write log
            try {
                $objnew = TrangThaiTieuChi::find($TrangThaiTieuChi->id)->toArray();
                LogController::storeobjectlog($objold, $objnew, LogLoaiHoatDong::UpdateRecord, '');
                
            } catch (Exception $e) {}
            // End Write log

            $result = array('status' => true, 'message' => "Cập nhật thành công.");
            return $result;
        } catch (Exception $e) {
            $result = array('status' => false, 'message' => "Cập nhật thất bại.<br>".$e);
            return $result;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TrangThaiTieuChi  $trangThaiTieuChi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        $isNotForeignKey = TrangThaiTieuChiController::isNotForeignKey($id);

        if($isNotForeignKey['status'])
        {
            if(is_numeric($id))
            {
                if(TrangThaiTieuChiController::isExistId($id))
                    try {
                        $objold = TrangThaiTieuChi::find($id)->toArray();
                        TrangThaiTieuChi::destroy($id);

                        // Write log
                        try {
                            LogController::storeobjectlog($objold, '', LogLoaiHoatDong::DeleteRecord, '');
                            
                        } catch (Exception $e) {}
                        // End Write log

                        $result = array('status' => true, 'message' => "Xóa thành công.");
                        return $result;
                    } catch (Exception $e) {
                        $result = array('status' => false, 'message' => "Xóa thất bại.<br>".$e);
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
        else
        {
            return $isNotForeignKey;
        }
    }

    public static function isNotForeignKey($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        if(count(TrangThaiTieuChi::find($id)->tieuchi))
        {
            $result = array('status' => false, 'message' => "Dữ liệu còn liên kết ở danh sách tiêu chí.\nVui lòng xóa dữ liệu liên kết ở danh sách tiêu chí trước (nếu muốn xóa hệ đào tạo này).");
            return $result;
        }

        $result = array('status' => true, 'message' => "Không có khóa ngoại");
        return $result;
    }

    public static function isExistId($id)
    {
        $TrangThaiTieuChi = TrangThaiTieuChi::find($id);
        if(count($TrangThaiTieuChi)>0)
            return true;
        return false;
    }

    public static function isExistTenTrangThaiTieuChi($Ten)
    {
        $TrangThaiTieuChi = TrangThaiTieuChi::where('tentrangthai', $Ten)->first();
        if(count($TrangThaiTieuChi)>0)
            return true;
        return false;
    }
    
    public static function isExistTenTrangThaiTieuChiUpdate($id, $Ten)
    {
        $TrangThaiTieuChi = TrangThaiTieuChi::where('tentrangthai', $Ten)->where('id','<>', $id)->first();
        if(count($TrangThaiTieuChi)>0)
            return true;
        return false;
    }
}
