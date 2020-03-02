<?php

namespace App\Http\Controllers;

use App\BacDaoTao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BacDaoTaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_BacDaoTao = BacDaoTao::all();
        return view('admin.bacdaotao', ['DanhSach_BacDaoTao' => $DanhSach_BacDaoTao]);
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
        if(BacDaoTaoController::isExistMaBacDaoTao($request->MaBacDaoTao))
        {
            $result = array('status' => false, 'message' => " - Mã bậc đào tạo đã tồn tại.");
            return $result;
        }

        if(BacDaoTaoController::isExistTenBacDaoTao($request->TenBacDaoTao))
        {
            $result = array('status' => false, 'message' => " - Tên bậc đào tạo đã tồn tại.");
            return $result;
        }

        try {
            $BacDaoTao = new BacDaoTao();
            $BacDaoTao->mabac = $request->MaBacDaoTao;
            $BacDaoTao->tenbac = $request->TenBacDaoTao;
            $BacDaoTao->save();

            // Write log
            try {
                $objnew = BacDaoTao::find($BacDaoTao->id)->toArray();
                LogController::storeobjectlog('', $objnew, LogLoaiHoatDong::NewInsertRecord, '');
                
            } catch (Exception $e) {}
            // End Write log

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
     * @param  \App\BacDaoTao  $bacDaoTao
     * @return \Illuminate\Http\Response
     */
    public function show(BacDaoTao $bacDaoTao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BacDaoTao  $bacDaoTao
     * @return \Illuminate\Http\Response
     */
    public function edit(BacDaoTao $bacDaoTao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BacDaoTao  $bacDaoTao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BacDaoTao $bacDaoTao)
    {
        if(BacDaoTaoController::isExistMaBacDaoTaoUpdate($request->id, $request->MaBacDaoTao))
        {
            $result = array('status' => false, 'message' => " - Mã bậc đào tạo đã tồn tại.");
            return $result;
        }

        if(BacDaoTaoController::isExistTenBacDaoTaoUpdate($request->id, $request->TenBacDaoTao))
        {
            $result = array('status' => false, 'message' => " - Tên bậc đào tạo đã tồn tại.");
            return $result;
        }

        try {
            $objold = BacDaoTao::find($request->id)->toArray();
            $BacDaoTao = BacDaoTao::find($request->id);
            $BacDaoTao->mabac = $request->MaBacDaoTao;
            $BacDaoTao->tenbac = $request->TenBacDaoTao;
            $BacDaoTao->save();

            // Write log
            try {
                $objnew = BacDaoTao::find($BacDaoTao->id)->toArray();
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
     * @param  \App\BacDaoTao  $bacDaoTao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        if(!count(BacDaoTao::find($id)->nganh))
        {
            if(!count(BacDaoTao::find($id)->khoahoc))
            {
                if(is_numeric($id))
                {
                    if(BacDaoTaoController::isExistId($id))
                        try {
                            $objold = BacDaoTao::find($id)->toArray();
                            BacDaoTao::destroy($id);

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
                $result = array('status' => false, 'message' => "Dữ liệu còn liên kết ở danh sách khóa học.\nVui lòng xóa dữ liệu liên kết ở danh sách khóa học (nếu muốn xóa bậc đào tạo này).");
                return $result;
            }
        }
        else
        {
            $result = array('status' => false, 'message' => "Dữ liệu còn liên kết ở danh sách ngành đào tạo.\nVui lòng xóa dữ liệu liên kết ở danh sách ngành (nếu muốn xóa bậc đào tạo này).");
            return $result;
        }
    }

    public static function isExistId($id)
    {
        $BacDaoTao = BacDaoTao::find($id);
        if(count($BacDaoTao)>0)
            return true;
        return false;
    }
    public static function isExistMaBacDaoTao($Ma)
    {
        $BacDaoTao = BacDaoTao::where('mabac', $Ma)->first();
        if(count($BacDaoTao)>0)
            return true;
        return false;
    }
    public static function isExistMaBacDaoTaoUpdate($id, $Ma)
    {
        $BacDaoTao = BacDaoTao::where('mabac', $Ma)->where('id','<>', $id)->first();
        if(count($BacDaoTao)>0)
            return true;
        return false;
    }
    public static function isExistTenBacDaoTao($Ten)
    {
        $BacDaoTao = BacDaoTao::where('tenbac', $Ten)->first();
        if(count($BacDaoTao)>0)
            return true;
        return false;
    }
    public static function isExistTenBacDaoTaoUpdate($id, $Ten)
    {
        $BacDaoTao = BacDaoTao::where('tenbac', $Ten)->where('id','<>', $id)->first();
        if(count($BacDaoTao)>0)
            return true;
        return false;
    }

    public static function getBacDaoTao($id)
    {
        return BacDaoTao::find($id);
    }
}
