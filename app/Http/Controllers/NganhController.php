<?php

namespace App\Http\Controllers;

use App\Nganh;
use App\BoMon;
use App\BacDaoTao;
use App\HeDaoTao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NganhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DanhSach_Nganh = Nganh::leftjoin('bacdaotao', 'bacdaotao.id', '=', 'nganh.idbacdaotao')
            -> leftjoin('hedaotao', 'hedaotao.id', '=', 'nganh.idhedaotao')
            -> select('nganh.*', 'bacdaotao.tenbac', 'hedaotao.tenhe')
            -> get();

        $DanhSach_BoMon = BoMon::all();
        $DanhSach_BacDaoTao = BacDaoTao::all();
        $DanhSach_HeDaoTao = HeDaoTao::all();

        return view('admin.nganh',['DanhSach_Nganh' => $DanhSach_Nganh, 'DanhSach_BoMon' => $DanhSach_BoMon, 'DanhSach_BacDaoTao' => $DanhSach_BacDaoTao, 'DanhSach_HeDaoTao' => $DanhSach_HeDaoTao]);
    }

    public function subadmin_index()
    {
        $dsNganh = Nganh::orderBy('tennganh', 'asc')->get();

        return view('subadmin.nganhdaotaolist',['dsNganh' => $dsNganh]);
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
        $MaNganh = trim($request->manganh);
        $TenNganh = trim($request->tennganh);
        $result = NganhController::isNotExistMaNganhTenNganh($MaNganh, $TenNganh);
         
        if($result['status'])
        {
            try {
                $Nganh = new Nganh();
                $Nganh->manganh = $MaNganh;
                $Nganh->tennganh = $TenNganh;
                $Nganh->kyhieunganh = $request->kyhieunganh;
                $Nganh->idbomon = $request->idbomon;
                $Nganh->idbacdaotao = $request->idbacdaotao;
                $Nganh->idhedaotao = $request->idhedaotao;
                // $Nganh->stt = BoMonController::getSTTDefault();
                $Nganh->save();

                // Write log
                try {
                    $objnew = Nganh::find($Nganh->id)->toArray();
                    LogController::storeobjectlog('', $objnew, LogLoaiHoatDong::NewInsertRecord, '');
                    
                } catch (Exception $e) {
                    
                }
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
     * @param  \App\Nganh  $nganh
     * @return \Illuminate\Http\Response
     */
    public function show(Nganh $nganh)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nganh  $nganh
     * @return \Illuminate\Http\Response
     */
    public function edit(Nganh $nganh)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nganh  $nganh
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $Id = $request->id;
        $MaNganh = trim($request->manganh);
        $TenNganh = trim($request->tennganh);
        $KyHieuNganh = trim($request->kyhieunganh);
        $IDBoMon = trim($request->idbomon);
        $IDBacDaoTao = trim($request->idbacdaotao);
        $IDHeDaoTao = trim($request->idhedaotao);
        $result = self::isNotExistMaNganhTenNganhUpdate($Id, $MaNganh, $TenNganh);
         
        if($result['status'])
        {
            try {
                $objold = Nganh::find($Id)->toArray();
                $Nganh = Nganh::find($Id);
                $Nganh->manganh = $MaNganh;
                $Nganh->tennganh = $TenNganh;
                $Nganh->kyhieunganh = $KyHieuNganh;
                $Nganh->idbomon = $IDBoMon;
                $Nganh->idbacdaotao = $IDBacDaoTao;
                $Nganh->idhedaotao = $IDHeDaoTao;
                $Nganh->save();

                // Write log
                try {
                    $objnew = Nganh::find($Nganh->id)->toArray();
                    LogController::storeobjectlog($objold, $objnew, LogLoaiHoatDong::UpdateRecord, '');
                    
                } catch (Exception $e) {
                    
                }
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
     * @param  \App\Nganh  $nganh
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(is_numeric($id))
        {
            if(self::isExistId($id))
                try {
                    $nganh = Nganh::find($id);
                    if(count($nganh->lop)==0)
                    {
                        // $objold = Nganh::find($id)->toArray();
                        $objold = $nganh->toArray();
                        Nganh::destroy($id);

                        // Write log
                        try {
                            LogController::storeobjectlog($objold, '', LogLoaiHoatDong::DeleteRecord, '');
                            
                        } catch (Exception $e) {
                            
                        }
                        // End Write log

                        $result = array('status' => true, 'message' => "Xóa thành công.");
                        return $result;
                    }
                    else
                    {
                     $result =  array('status' => false, 'message' => "Có một số lớp thuộc ngành này nên không thể xóa.");
                     return $result;
                    }

                } catch (Exception $e) {
                    $result = array('status' => false, 'message' => $e->getMessage());
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

    /**
     * Check Exist Id ngành from storage.
     *
     * @param  $Id
     * @return True/False
     */
    public static function isExistId($Id)
    {
        $Nganh = Nganh::find($Id);
        if(count($Nganh)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Mã ngành và Tên ngành from storage.
     *
     * @param  $MaNganh, $TenNganh
     * @return Array(statust, message)
     */
    public static function isNotExistMaNganhTenNganh($MaNganh, $TenNganh)
    {
        $request_manganh = self::isExistMaNganh($MaNganh);
        // $request_tennganh = self::isExistTenNganh($TenNganh);

        $status = true;
        $message = "";
        if($request_manganh)
        {
            $status = false;
            $message .= "<br> - Mã ngành đã tồn tại!";
        }

        // if($request_tennganh)
        // {
        //     $status = false;
        //     $message .= "<br> - Tên ngành đã tồn tại!";
        // }

        $result = array('status' => $status, 'message' => $message);
        return $result;
    }

    /**
     * Check Exist Mã ngành và Tên ngành from storage to update.
     *
     * @param  $MaNganh, $TenNganh
     * @return Array(statust, message)
     */
    public static function isNotExistMaNganhTenNganhUpdate($Id, $MaNganh, $TenNganh)
    {
        $request_manganh = self::isExistMaNganhUpdate($Id, $MaNganh);
        $request_tennganh = self::isExistTenNganhUpdate($Id, $TenNganh);

        $status = true;
        $message = "";

        if($request_manganh)
        {
            $status = false;
            $message .= "<br> - Mã ngành đã tồn tại!";
        }

        if($request_tennganh)
        {
            $status = false;
            $message .= "<br> - Tên ngành đã tồn tại!";
        }

        $result = array('status' => $status, 'message' => $message);
        return $result;
    }

    /**
     * Check Exist Mã ngành from storage.
     *
     * @param  $MaNganh
     * @return True, False
     */
    public static function isExistMaNganh($MaNganh)
    {
        $DanhSach_Nganh = Nganh::where('manganh', '=', $MaNganh)->select('manganh')->get();
        if(count($DanhSach_Nganh)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Mã ngành from storage to update.
     *
     * @param  $MaNganh
     * @return True, False
     */
    public static function isExistMaNganhUpdate($Id, $MaNganh)
    {
        $DanhSach_Nganh = Nganh::where('manganh', '=', $MaNganh)
            -> where('id', '<>', $Id)
            -> select('manganh')->get();
        if(count($DanhSach_Nganh)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Tên ngành from storage.
     *
     * @param  $TenNganh
     * @return True, False
     */
    public static function isExistTenNganh($TenNganh)
    {
        $DanhSach_Nganh = Nganh::where('tennganh', '=', $TenNganh)->select('tennganh')->get();
        if(count($DanhSach_Nganh)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Tên nganh from storage to update.
     *
     * @param  $TenNganh
     * @return True, False
     */
    public static function isExistTenNganhUpdate($Id, $TenNganh)
    {
        $DanhSach_Nganh = Nganh::where('tennganh', '=', $TenNganh)
            -> where('id','<>', $Id)
            ->select('tennganh')->get();
        if(count($DanhSach_Nganh)>0)
            return true;
        return false;
    }

    public static function getBoMonID($nganh_id)
    {
        return Nganh::find($nganh_id)->bomon->id;
    }

    public function getNganhByKhoa(Request $arrayKhoaID)
    {
        $DanhSach_Nganh = Nganh::join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            -> whereIn('bomon.idkhoa', $arrayKhoaID->KhoaID)
            -> leftjoin('bacdaotao', 'bacdaotao.id', '=', 'nganh.idbacdaotao')
            -> select('nganh.*', 'bacdaotao.tenbac')
            -> orderBy('nganh.tennganh', 'asc')
            -> get();

        if($DanhSach_Nganh)
        {
            return $DanhSach_Nganh->toArray();
        }
        return $DanhSach_Nganh;
    }

    public static function getArrayAllNganhID()
    {
        $DS_NganhID = Nganh::select('id')->get();
        $arrayNganhID = array();

        if($DS_NganhID)
        {
            foreach ($DS_NganhID as $key => $value) {
                array_push($arrayNganhID, $value->id);
            }
        }

        return $arrayNganhID;
    }
}
