<?php

namespace App\Http\Controllers;

use App\DanToc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DanTocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_DanToc = DanToc::all();
        return view('admin.dantoc', ['DanhSach_DanToc' => $DanhSach_DanToc]);
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
        if(DanTocController::isExistMaDanToc($request->MaDanToc))
        {
            $result = array('status' => false, 'message' => " - Mã dân tộc đã tồn tại.");
            return $result;
        }

        if(DanTocController::isExistTenDanToc($request->TenDanToc))
        {
            $result = array('status' => false, 'message' => " - Tên dân tộc đã tồn tại.");
            return $result;
        }

        try {
            $DanToc = new DanToc();
            $DanToc->madantoc = $request->MaDanToc;
            $DanToc->tendantoc = $request->TenDanToc;
            $DanToc->save();

            /** 
             * Write log
             */
            try {
                $objnew = DanToc::find($DanToc->id)->toArray();
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
     * @param  \App\DanToc  $danToc
     * @return \Illuminate\Http\Response
     */
    public function show(DanToc $danToc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DanToc  $danToc
     * @return \Illuminate\Http\Response
     */
    public function edit(DanToc $danToc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DanToc  $danToc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DanToc $danToc)
    {
        if(DanTocController::isExistMaDanTocUpdate($request->id, $request->MaDanToc))
        {
            $result = array('status' => false, 'message' => " - Mã dân tộc đã tồn tại.");
            return $result;
        }

        if(DanTocController::isExistTenDanTocUpdate($request->id, $request->TenDanToc))
        {
            $result = array('status' => false, 'message' => " - Tên dân tộc đã tồn tại.");
            return $result;
        }

        try {
            $objold = DanToc::find($request->id)->toArray();
            $DanToc = DanToc::find($request->id);
            $DanToc->madantoc = $request->MaDanToc;
            $DanToc->tendantoc = $request->TenDanToc;
            $DanToc->save();

            // Write log
            try {
                $objnew = DanToc::find($DanToc->id)->toArray();
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
     * @param  \App\DanToc  $danToc
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        $isNotForeignKey = DanTocController::isNotForeignKey($id);

        if($isNotForeignKey['status'])
        {
            if(is_numeric($id))
            {
                if(DanTocController::isExistId($id))
                    try {
                        $objold = DanToc::find($id)->toArray();
                        DanToc::destroy($id);

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
        if(count(DanToc::find($id)->lylich))
        {
            $result = array('status' => false, 'message' => "Dữ liệu còn liên kết ở danh sách lý lịch sinh viên.\nVui lòng xóa dữ liệu liên kết ở danh sách lý lịch sinh viên trước (nếu muốn xóa hệ đào tạo này).");
            return $result;
        }

        $result = array('status' => true, 'message' => "Không có khóa ngoại");
        return $result;
        
    }

    public static function isExistId($id)
    {
        $DanToc = DanToc::find($id);
        if(count($DanToc)>0)
            return true;
        return false;
    }
    public static function isExistMaDanToc($Ma)
    {
        $DanToc = DanToc::where('madantoc', $Ma)->first();
        if(count($DanToc)>0)
            return true;
        return false;
    }
    public static function isExistMaDanTocUpdate($id, $Ma)
    {
        $DanToc = DanToc::where('madantoc', $Ma)->where('id','<>', $id)->first();
        if(count($DanToc)>0)
            return true;
        return false;
    }
    public static function isExistTenDanToc($Ten)
    {
        $DanToc = DanToc::where('tendantoc', $Ten)->first();
        if(count($DanToc)>0)
            return true;
        return false;
    }
    public static function isExistTenDanTocUpdate($id, $Ten)
    {
        $DanToc = DanToc::where('tendantoc', $Ten)->where('id','<>', $id)->first();
        if(count($DanToc)>0)
            return true;
        return false;
    }
}
