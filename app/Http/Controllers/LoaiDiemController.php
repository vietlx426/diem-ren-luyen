<?php

namespace App\Http\Controllers;

use App\LoaiDiem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoaiDiemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_LoaiDiem = LoaiDiem::all();
        return view('subadmin.loaidiem', ['DanhSach_LoaiDiem' => $DanhSach_LoaiDiem]);
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
        if(LoaiDiemController::isExistTenLoaiDiem($request->TenLoaiDiem))
        {
            $result = array('status' => false, 'message' => " - Tên loại điểm đã tồn tại.");
            return $result;
        }

        try {
            $LoaiDiem = new LoaiDiem();
            $LoaiDiem->tenloaidiem = $request->TenLoaiDiem;
            $LoaiDiem->save();

            /** 
             * Write log
             */
            try {
                $objnew = LoaiDiem::find($LoaiDiem->id)->toArray();
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
     * @param  \App\LoaiDiem  $loaiDiem
     * @return \Illuminate\Http\Response
     */
    public function show(LoaiDiem $loaiDiem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LoaiDiem  $loaiDiem
     * @return \Illuminate\Http\Response
     */
    public function edit(LoaiDiem $loaiDiem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LoaiDiem  $loaiDiem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoaiDiem $loaiDiem)
    {
        if(LoaiDiemController::isExistTenLoaiDiemUpdate($request->id, $request->TenLoaiDiem))
        {
            $result = array('status' => false, 'message' => " - Tên loại điểm đã tồn tại.");
            return $result;
        }

        try {
            $objold = LoaiDiem::find($request->id)->toArray();
            $LoaiDiem = LoaiDiem::find($request->id);
            $LoaiDiem->tenloaidiem= $request->TenLoaiDiem;
            $LoaiDiem->save();

            // Write log
            try {
                $objnew = LoaiDiem::find($LoaiDiem->id)->toArray();
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
     * @param  \App\LoaiDiem  $loaiDiem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        $isNotForeignKey = LoaiDiemController::isNotForeignKey($id);

        if($isNotForeignKey['status'])
        {
            if(is_numeric($id))
            {
                if(LoaiDiemController::isExistId($id))
                    try {
                        $objold = LoaiDiem::find($id)->toArray();
                        LoaiDiem::destroy($id);

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
        if(count(LoaiDiem::find($id)->tieuchi))
        {
            $result = array('status' => false, 'message' => "Dữ liệu còn liên kết ở danh sách tiêu chí.\nVui lòng xóa dữ liệu liên kết ở danh sách tiêu chí trước (nếu muốn xóa hệ đào tạo này).");
            return $result;
        }

        $result = array('status' => true, 'message' => "Không có khóa ngoại");
        return $result;
    }

    public static function isExistId($id)
    {
        $LoaiDiem = LoaiDiem::find($id);
        if(count($LoaiDiem)>0)
            return true;
        return false;
    }

    public static function isExistTenLoaiDiem($Ten)
    {
        $LoaiDiem = LoaiDiem::where('tenloaidiem', $Ten)->first();
        if(count($LoaiDiem)>0)
            return true;
        return false;
    }
    
    public static function isExistTenLoaiDiemUpdate($id, $Ten)
    {
        $LoaiDiem = LoaiDiem::where('tenloaidiem', $Ten)->where('id','<>', $id)->first();
        if(count($LoaiDiem)>0)
            return true;
        return false;
    }
}
