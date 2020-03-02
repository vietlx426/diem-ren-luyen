<?php

namespace App\Http\Controllers;

use App\XepLoaiDiemRenLuyen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\XepLoaiDiemRenLuyenRequest;

class XepLoaiDiemRenLuyenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_XepLoaiDiemRenLuyen = XepLoaiDiemRenLuyen::all();
        return view('subadmin.xeploaidiemrenluyen', ['DanhSach_XepLoaiDiemRenLuyen' => $DanhSach_XepLoaiDiemRenLuyen]);
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
    public function store(XepLoaiDiemRenLuyenRequest $request)
    {
        if(XepLoaiDiemRenLuyenController::isExistMaXepLoaiDiemRenLuyen($request->MaXepLoaiDiemRenLuyen))
        {
            $result = array('status' => false, 'message' => " - Mã xếp loại đã tồn tại.");
            return $result;
        }

        if(XepLoaiDiemRenLuyenController::isExistTenXepLoaiDiemRenLuyen($request->TenXepLoaiDiemRenLuyen))
        {
            $result = array('status' => false, 'message' => " - Tên xếp loại đã tồn tại.");
            return $result;
        }

        try {
            $XepLoaiDiemRenLuyen = new XepLoaiDiemRenLuyen();
            $XepLoaiDiemRenLuyen->maxeploai = $request->MaXepLoaiDiemRenLuyen;
            $XepLoaiDiemRenLuyen->tenxeploai = $request->TenXepLoaiDiemRenLuyen;
            $XepLoaiDiemRenLuyen->mindiem = intval($request->MinDiemXepLoaiDiemRenLuyen);
            $XepLoaiDiemRenLuyen->maxdiem = intval($request->MaxDiemXepLoaiDiemRenLuyen);
            $XepLoaiDiemRenLuyen->save();

            /** 
             * Write log
             */
            try {
                $objnew = XepLoaiDiemRenLuyen::find($XepLoaiDiemRenLuyen->id)->toArray();
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
     * @param  \App\XepLoaiDiemRenLuyen  $xepLoaiDiemRenLuyen
     * @return \Illuminate\Http\Response
     */
    public function show(XepLoaiDiemRenLuyen $xepLoaiDiemRenLuyen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\XepLoaiDiemRenLuyen  $xepLoaiDiemRenLuyen
     * @return \Illuminate\Http\Response
     */
    public function edit(XepLoaiDiemRenLuyen $xepLoaiDiemRenLuyen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\XepLoaiDiemRenLuyen  $xepLoaiDiemRenLuyen
     * @return \Illuminate\Http\Response
     */
    public function update(XepLoaiDiemRenLuyenRequest $request, XepLoaiDiemRenLuyen $xepLoaiDiemRenLuyen)
    {
        if(XepLoaiDiemRenLuyenController::isExistMaXepLoaiDiemRenLuyenUpdate($request->id, $request->MaXepLoaiDiemRenLuyen))
        {
            $result = array('status' => false, 'message' => " - Mã xếp loại đã tồn tại.");
            return $result;
        }

        if(XepLoaiDiemRenLuyenController::isExistTenXepLoaiDiemRenLuyenUpdate($request->id, $request->TenXepLoaiDiemRenLuyen))
        {
            $result = array('status' => false, 'message' => " - Tên xếp loại đã tồn tại.");
            return $result;
        }

        try {
            $objold = XepLoaiDiemRenLuyen::find($request->id)->toArray();
            $XepLoaiDiemRenLuyen = XepLoaiDiemRenLuyen::find($request->id);
            $XepLoaiDiemRenLuyen->maxeploai = $request->MaXepLoaiDiemRenLuyen;
            $XepLoaiDiemRenLuyen->tenxeploai = $request->TenXepLoaiDiemRenLuyen;
            $XepLoaiDiemRenLuyen->mindiem = intval($request->MinDiemXepLoaiDiemRenLuyen);
            $XepLoaiDiemRenLuyen->maxdiem = intval($request->MaxDiemXepLoaiDiemRenLuyen);
            $XepLoaiDiemRenLuyen->save();

            // Write log
            try {
                $objnew = XepLoaiDiemRenLuyen::find($XepLoaiDiemRenLuyen->id)->toArray();
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
     * @param  \App\XepLoaiDiemRenLuyen  $xepLoaiDiemRenLuyen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        $isNotForeignKey = XepLoaiDiemRenLuyenController::isNotForeignKey($id);

        if($isNotForeignKey['status'])
        {
            if(is_numeric($id))
            {
                if(XepLoaiDiemRenLuyenController::isExistId($id))
                    try {
                        $objold = XepLoaiDiemRenLuyen::find($id)->toArray();
                        XepLoaiDiemRenLuyen::destroy($id);

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
        if(count(XepLoaiDiemRenLuyen::find($id)->bangdiemdanhgia))
        {
            $result = array('status' => false, 'message' => "Dữ liệu còn liên kết ở bảng điểm đánh giá.\nVui lòng xóa dữ liệu liên kết ở bảng điểm đánh giá trước (nếu muốn xóa loại xếp loại này).");
            return $result;
        }

        $result = array('status' => true, 'message' => "Không có khóa ngoại");
        return $result;
        
    }

    public static function isExistId($id)
    {
        $XepLoaiDiemRenLuyen = XepLoaiDiemRenLuyen::find($id);
        if(count($XepLoaiDiemRenLuyen)>0)
            return true;
        return false;
    }
    public static function isExistMaXepLoaiDiemRenLuyen($Ma)
    {
        $XepLoaiDiemRenLuyen = XepLoaiDiemRenLuyen::where('maxeploai', $Ma)->first();
        if(count($XepLoaiDiemRenLuyen)>0)
            return true;
        return false;
    }
    public static function isExistMaXepLoaiDiemRenLuyenUpdate($id, $Ma)
    {
        $XepLoaiDiemRenLuyen = XepLoaiDiemRenLuyen::where('maxeploai', $Ma)->where('id','<>', $id)->first();
        if(count($XepLoaiDiemRenLuyen)>0)
            return true;
        return false;
    }
    public static function isExistTenXepLoaiDiemRenLuyen($Ten)
    {
        $XepLoaiDiemRenLuyen = XepLoaiDiemRenLuyen::where('tenxeploai', $Ten)->first();
        if(count($XepLoaiDiemRenLuyen)>0)
            return true;
        return false;
    }
    public static function isExistTenXepLoaiDiemRenLuyenUpdate($id, $Ten)
    {
        $XepLoaiDiemRenLuyen = XepLoaiDiemRenLuyen::where('tenxeploai', $Ten)->where('id','<>', $id)->first();
        if(count($XepLoaiDiemRenLuyen)>0)
            return true;
        return false;
    }

    public static function getXepLoai($diem='')
    {
        $xepLoai = XepLoaiDiemRenLuyen::where('mindiem', '<=', $diem)
            -> where('maxdiem', '>=', $diem)
            -> first();
        return $xepLoai;
    }
}
