<?php

namespace App\Http\Controllers;

use App\TonGiao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TonGiaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_TonGiao = TonGiao::all();
        return view('admin.tongiao', ['DanhSach_TonGiao' => $DanhSach_TonGiao]);
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
        if(TonGiaoController::isExistMaTonGiao($request->MaTonGiao))
        {
            $result = array('status' => false, 'message' => " - Mã tôn giáo đã tồn tại.");
            return $result;
        }

        if(TonGiaoController::isExistTenTonGiao($request->TenTonGiao))
        {
            $result = array('status' => false, 'message' => " - Tên tôn giáo đã tồn tại.");
            return $result;
        }

        try {
            $TonGiao = new TonGiao();
            $TonGiao->matongiao = $request->MaTonGiao;
            $TonGiao->tentongiao = $request->TenTonGiao;
            $TonGiao->save();

            /** 
             * Write log
             */
            try {
                $objnew = TonGiao::find($TonGiao->id)->toArray();
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
     * @param  \App\TonGiao  $tonGiao
     * @return \Illuminate\Http\Response
     */
    public function show(TonGiao $tonGiao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TonGiao  $tonGiao
     * @return \Illuminate\Http\Response
     */
    public function edit(TonGiao $tonGiao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TonGiao  $tonGiao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TonGiao $tonGiao)
    {
        if(TonGiaoController::isExistMaTonGiaoUpdate($request->id, $request->MaTonGiao))
        {
            $result = array('status' => false, 'message' => " - Mã dân tộc đã tồn tại.");
            return $result;
        }

        if(TonGiaoController::isExistTenTonGiaoUpdate($request->id, $request->TenTonGiao))
        {
            $result = array('status' => false, 'message' => " - Tên dân tộc đã tồn tại.");
            return $result;
        }

        try {
            $objold = TonGiao::find($request->id)->toArray();
            $TonGiao = TonGiao::find($request->id);
            $TonGiao->matongiao = $request->MaTonGiao;
            $TonGiao->tentongiao = $request->TenTonGiao;
            $TonGiao->save();

            // Write log
            try {
                $objnew = TonGiao::find($TonGiao->id)->toArray();
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
     * @param  \App\TonGiao  $tonGiao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        $isNotForeignKey = TonGiaoController::isNotForeignKey($id);

        if($isNotForeignKey['status'])
        {
            if(is_numeric($id))
            {
                if(TonGiaoController::isExistId($id))
                    try {
                        $objold = TonGiao::find($id)->toArray();
                        TonGiao::destroy($id);

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
        if(count(TonGiao::find($id)->lylich))
        {
            $result = array('status' => false, 'message' => "Dữ liệu còn liên kết ở danh sách lý lịch sinh viên.\nVui lòng xóa dữ liệu liên kết ở danh sách lý lịch sinh viên trước (nếu muốn xóa hệ đào tạo này).");
            return $result;
        }

        $result = array('status' => true, 'message' => "Không có khóa ngoại");
        return $result;
    }

    public static function isExistId($id)
    {
        $TonGiao = TonGiao::find($id);
        if(count($TonGiao)>0)
            return true;
        return false;
    }

    public static function isExistMaTonGiao($Ma)
    {
        $TonGiao = TonGiao::where('matongiao', $Ma)->first();
        if(count($TonGiao)>0)
            return true;
        return false;
    }

    public static function isExistMaTonGiaoUpdate($id, $Ma)
    {
        $TonGiao = TonGiao::where('matongiao', $Ma)->where('id','<>', $id)->first();
        if(count($TonGiao)>0)
            return true;
        return false;
    }

    public static function isExistTenTonGiao($Ten)
    {
        $TonGiao = TonGiao::where('tentongiao', $Ten)->first();
        if(count($TonGiao)>0)
            return true;
        return false;
    }
    
    public static function isExistTenTonGiaoUpdate($id, $Ten)
    {
        $TonGiao = TonGiao::where('tentongiao', $Ten)->where('id','<>', $id)->first();
        if(count($TonGiao)>0)
            return true;
        return false;
    }
}
