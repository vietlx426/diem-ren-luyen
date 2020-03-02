<?php

namespace App\Http\Controllers;

use App\NamHoc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\NamHocRequest;
use DB;
use App\SinhVien;
use App\Lop;

class NamHocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_NamHoc = NamHoc::all();
        return view('admin.namhoc',['DanhSach_NamHoc' => $DanhSach_NamHoc]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.namhoc_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NamHocRequest $request)
    {
        $Ma = trim($request->MaNamHoc);
        $Ten = trim($request->TenNamHoc);
        $result = NamHocController::checkNotExistMa_Ten($Ma, $Ten);

        if($result['status']) // Kiểm tra không tồn tại mã và tên
        {
            try {
                $NamHoc = new NamHoc();
                $NamHoc->manamhoc = $Ma;
                $NamHoc->tennamhoc = $Ten;
                $NamHoc->save();

                // Write log
                try {
                    $objnew = NamHoc::find($NamHoc->id)->toArray();
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
     * @param  \App\NamHoc  $namHoc
     * @return \Illuminate\Http\Response
     */
    public function show(NamHoc $namHoc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NamHoc  $namHoc
     * @return \Illuminate\Http\Response
     */
    public function edit(NamHoc $namHoc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NamHoc  $namHoc
     * @return \Illuminate\Http\Response
     */
    public function update(NamHocRequest $request)
    {
        $Id = $request->id;
        $Ma = trim($request->MaNamHoc);
        $Ten = trim($request->TenNamHoc);
        $result = NamHocController::checkNotExistMa_TenUpdate($Id, $Ma, $Ten);

        if($result['status']) // Kiểm tra không tồn tại mã và tên
        {
            try {
                $objold = NamHoc::find($Id)->toArray();
                $NamHoc = NamHoc::find($Id);
                $NamHoc->manamhoc = $Ma;
                $NamHoc->tennamhoc = $Ten;
                $NamHoc->save();

                // Write log
                try {
                    $objnew = NamHoc::find($NamHoc->id)->toArray();
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
     * @param  \App\NamHoc  $namHoc
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        // code

        if(is_numeric($id))
        {
            if(NamHocController::isExistId($id))
                try {
                    $objold = NamHoc::find($id)->toArray();
                    NamHoc::destroy($id);

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

    public static function checkNotExistMa_Ten($Ma, $Ten)
    {
        if(NamHocController::isExistMaNamHoc($Ma))
        {
            $result = array('status' => false, 'message' => "Mã năm học đã tồn tại!");
            return $result;
        }

        if(NamHocController::isExistTenNamHoc($Ten))
        {
            $result = array('status' => false, 'message' => "Tên năm học đã tồn tại!");
            return $result;
        }

        $result = array('status' => true, 'message' => "");
        return $result;
    }
    public static function checkNotExistMa_TenUpdate($Id, $Ma, $Ten)
    {
        if(NamHocController::isExistMaNamHocUpdate($Id, $Ma))
        {
            $result = array('status' => false, 'message' => "Mã năm học đã tồn tại!");
            return $result;
        }

        if(NamHocController::isExistTenNamHocUpdate($Id, $Ten))
        {
            $result = array('status' => false, 'message' => "Tên năm học đã tồn tại!");
            return $result;
        }

        $result = array('status' => true, 'message' => "");
        return $result;
    }

    public static function isExistId($id)
    {
        $NamHoc = NamHoc::find($id);
        if(count($NamHoc)>0)
            return true;
        return false;
    }

    public static function isExistMaNamHoc($Ma)
    {
        $NamHoc = DB::table('nam_hocs')->where('manamhoc', $Ma)->first();
        if(count($NamHoc)>0)
            return true;
        return false;
    }
    public static function isExistMaNamHocUpdate($Id, $Ma)
    {
        $NamHoc = DB::table('nam_hocs')->where('manamhoc', $Ma)->where('id','<>',$Id)->first();
        if(count($NamHoc)>0)
            return true;
        return false;
    }

    public static function isExistTenNamHoc($Ten)
    {
        $NamHoc = DB::table('nam_hocs')->where('tennamhoc', $Ten)->first();
        if(count($NamHoc)>0)
            return true;
        return false;
    }
    public static function isExistTenNamHocUpdate($Id, $Ten)
    {
        $NamHoc = DB::table('nam_hocs')->where('tennamhoc', $Ten)->where('id','<>',$Id)->first();
        if(count($NamHoc)>0)
            return true;
        return false;
    }

    public static function NamHocBatDau($idSinhVien = '')
    {
        $sinhVien = SinhVien::find($idSinhVien);
        $namBatDau = $sinhVien->lop->khoahoc->nambatdau;
        $namKetThuc = $sinhVien->lop->khoahoc->namketthuc;
        $namHocBatDau = NamHoc::where('tennamhoc', 'like', $namBatDau.'%')->first();
        return $namHocBatDau;
    }

    public static function NamHocBatDauCuaLop($idLop = '')
    {
        $lop = Lop::find($idLop);
        $namBatDau = $lop->khoahoc->nambatdau;
        $namKetThuc = $lop->khoahoc->namketthuc;
        $namHocBatDau = NamHoc::where('tennamhoc', 'like', $namBatDau.'%')->first();
        return $namHocBatDau;
    }
}
