<?php

namespace App\Http\Controllers;

use App\HeDaoTao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HeDaoTaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_HeDaoTao = HeDaoTao::all();
        return view('admin.hedaotao', ['DanhSach_HeDaoTao' => $DanhSach_HeDaoTao]);
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
        if(HeDaoTaoController::isExistMaHeDaoTao($request->MaHeDaoTao))
        {
            $result = array('status' => false, 'message' => " - Mã hệ đào tạo đã tồn tại.");
            return $result;
        }

        if(HeDaoTaoController::isExistTenHeDaoTao($request->TenHeDaoTao))
        {
            $result = array('status' => false, 'message' => " - Tên hệ đào tạo đã tồn tại.");
            return $result;
        }

        try {
            $HeDaoTao = new HeDaoTao();
            $HeDaoTao->mahe = $request->MaHeDaoTao;
            $HeDaoTao->tenhe = $request->TenHeDaoTao;
            $HeDaoTao->save();

            /** 
             * Write log
             */
            try {
                $objnew = HeDaoTao::find($HeDaoTao->id)->toArray();
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
     * @param  \App\HeDaoTao  $heDaoTao
     * @return \Illuminate\Http\Response
     */
    public function show(HeDaoTao $heDaoTao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HeDaoTao  $heDaoTao
     * @return \Illuminate\Http\Response
     */
    public function edit(HeDaoTao $heDaoTao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HeDaoTao  $heDaoTao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HeDaoTao $heDaoTao)
    {
        if(HeDaoTaoController::isExistMaHeDaoTaoUpdate($request->id, $request->MaHeDaoTao))
        {
            $result = array('status' => false, 'message' => " - Mã hệ đào tạo đã tồn tại.");
            return $result;
        }

        if(HeDaoTaoController::isExistTenHeDaoTaoUpdate($request->id, $request->TenHeDaoTao))
        {
            $result = array('status' => false, 'message' => " - Tên hệ đào tạo đã tồn tại.");
            return $result;
        }

        try {
            $objold = HeDaoTao::find($request->id)->toArray();
            $HeDaoTao = HeDaoTao::find($request->id);
            $HeDaoTao->mahe = $request->MaHeDaoTao;
            $HeDaoTao->tenhe = $request->TenHeDaoTao;
            $HeDaoTao->save();

            // Write log
            try {
                $objnew = HeDaoTao::find($HeDaoTao->id)->toArray();
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
     * @param  \App\HeDaoTao  $heDaoTao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        $isNotForeignKey = HeDaoTaoController::isNotForeignKey($id);

        if($isNotForeignKey['status'])
        {
            if(is_numeric($id))
            {
                if(HeDaoTaoController::isExistId($id))
                    try {
                        $objold = HeDaoTao::find($id)->toArray();
                        HeDaoTao::destroy($id);

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
        else
        {
            return $isNotForeignKey;
        }
    }

    public static function isNotForeignKey($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        if(count(HeDaoTao::find($id)->nganh))
        {
            $result = array('status' => false, 'message' => "Dữ liệu còn liên kết ở danh sách ngành đào tạo.\nVui lòng xóa dữ liệu liên kết ở danh sách ngành (nếu muốn xóa hệ đào tạo này).");
            return $result;
        }

        $result = array('status' => true, 'message' => "Không có khóa ngoại");
        return $result;
        
    }

    public static function isExistId($id)
    {
        $HeDaoTao = HeDaoTao::find($id);
        if(count($HeDaoTao)>0)
            return true;
        return false;
    }
    public static function isExistMaHeDaoTao($Ma)
    {
        $HeDaoTao = HeDaoTao::where('mahe', $Ma)->first();
        if(count($HeDaoTao)>0)
            return true;
        return false;
    }
    public static function isExistMaHeDaoTaoUpdate($id, $Ma)
    {
        $HeDaoTao = HeDaoTao::where('mahe', $Ma)->where('id','<>', $id)->first();
        if(count($HeDaoTao)>0)
            return true;
        return false;
    }
    public static function isExistTenHeDaoTao($Ten)
    {
        $HeDaoTao = HeDaoTao::where('tenhe', $Ten)->first();
        if(count($HeDaoTao)>0)
            return true;
        return false;
    }
    public static function isExistTenHeDaoTaoUpdate($id, $Ten)
    {
        $HeDaoTao = HeDaoTao::where('tenhe', $Ten)->where('id','<>', $id)->first();
        if(count($HeDaoTao)>0)
            return true;
        return false;
    }

    public static function getHeDaoTao($id)
    {
        return HeDaoTao::find($id);
    }
}
