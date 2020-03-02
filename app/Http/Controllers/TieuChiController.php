<?php

namespace App\Http\Controllers;

use App\TieuChi;
use App\LoaiDiem;
use App\TrangThaiTieuChi;
use App\HocKyNamHoc;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TieuChiRequest;
use App\BoTieuChi;
use App\HocKyNamHocBoTieuChi;
use App\BangDiemRenLuyen;
use App\ModuleTinhDiem;
use App\TieuChiModuleThoiGian;

/**
* Constant for status
*/
class TrangThaiTieuChiConst
{
    
    const CongDiem = 1;
    const KhongCongDiem = 2;
    const An = 3;
}

class TieuChiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // TODO: Can delete
    public function index()
    {
        $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
        $dsTieuChi = self::GetTieuChiPhanCap($hocKyNamHocHienHanh->id);
        $DanhSach_LoaiDiem = LoaiDiem::all();
        $DanhSach_TrangThai = TrangThaiTieuChi::all();
        $DanhSach_HocKyNamHoc = HocKyNamHoc::all();

        $DanhSach_TieuChi_Level_0 = TieuChi::where('idtieuchicha', '=', 0)
            -> leftjoin('hocky_namhoc', 'hocky_namhoc.id', '=', 'tieuchi.idhocky_namhoc')
            -> where('hocky_namhoc.idtrangthaihocky', '=', 2)
            -> select('tieuchi.*')
            -> get();

        $totalMarks = 0;
        foreach ($DanhSach_TieuChi_Level_0 as $key => $tieuChi_Level_0) {
            $totalMarks += intval($tieuChi_Level_0->diemtoida);
        }

        return view('admin.tieuchi', ['DanhSach_LoaiDiem' => $DanhSach_LoaiDiem, 'DanhSach_TrangThai' => $DanhSach_TrangThai, 'DanhSach_HocKyNamHoc' => $DanhSach_HocKyNamHoc,'DanhSach_TieuChi' => $dsTieuChi, 'countTieuChi_Level_0' => count($DanhSach_TieuChi_Level_0), 'totalMarks' => $totalMarks]);
    }

    public function adminindex($idBoTieuChi)
    {
        $DanhSach_LoaiDiem = LoaiDiem::all();
        $DanhSach_TrangThai = TrangThaiTieuChi::all();
        $boTieuChi = BoTieuChi::find($idBoTieuChi);

        $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $idBoTieuChi)->where('idtieuchicha', '=', 0)->select('tieuchi.*')->get();
        $totalMarks = $dsTieuChi_Level_0->sum('diemtoida');

        return view('admin.botieuchi_tieuchilist', ['DanhSach_LoaiDiem' => $DanhSach_LoaiDiem, 'DanhSach_TrangThai' => $DanhSach_TrangThai, 'boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks]);
    }

    public function truongdonviindex($idBoTieuChi)
    {
        $DanhSach_LoaiDiem = LoaiDiem::all();
        $DanhSach_TrangThai = TrangThaiTieuChi::all();
        $boTieuChi = BoTieuChi::find($idBoTieuChi);

        $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $idBoTieuChi)->where('idtieuchicha', '=', 0)->select('tieuchi.*')->get();
        $totalMarks = $dsTieuChi_Level_0->sum('diemtoida');

        return view('truongdonvi.botieuchi_tieuchilist', ['DanhSach_LoaiDiem' => $DanhSach_LoaiDiem, 'DanhSach_TrangThai' => $DanhSach_TrangThai, 'boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks]);
    }

    public function adminindextieuchi()
    {
        $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
        $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $hocKyNamHocHienHanh->id)->first();
        $boTieuChi = $hocKyNamHocBoTieuChi->botieuchi;

        $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $boTieuChi->id)->where('idtieuchicha', '=', 0)->select('tieuchi.*')->get();
        $totalMarks = $dsTieuChi_Level_0->sum('diemtoida');

        return view('admin.tieuchilist', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks]);
    }


    public function truongdonviindextieuchi()
    {
        $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
        $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $hocKyNamHocHienHanh->id)->first();
        $boTieuChi = $hocKyNamHocBoTieuChi?$hocKyNamHocBoTieuChi->botieuchi:'';

        $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $boTieuChi?$boTieuChi->id:'')->where('idtieuchicha', '=', 0)->select('tieuchi.*')->get();
        $totalMarks = $dsTieuChi_Level_0->sum('diemtoida');
        if($boTieuChi)
            return view('truongdonvi.tieuchilist', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks]);
        return view('truongdonvi.tieuchilist');
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

    public function admincreate($idBoTieuChi, $idTieuChiCha='')
    {
        $tieuChiCha = TieuChi::find($idTieuChiCha);
        $dsLoaiDiem = LoaiDiem::all();
        $dsTrangThai = TrangThaiTieuChi::all();
        $dsModule = ModuleTinhDiem::orderBy('modulename', 'asc')->get();

        return view('admin.botieuchi_tieuchicreate', ['idBoTieuChi'=>$idBoTieuChi, 'tieuChiCha'=>$tieuChiCha, 'dsLoaiDiem'=>$dsLoaiDiem, 'dsTrangThai'=>$dsTrangThai, 'dsModule'=>$dsModule]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idTieuChiCha = (int)trim($request->idtieuchicha);
        $TenTieuChi = trim($request->tentieuchi);
        $STT = (int)TieuChiController::getDefaultSTT($idTieuChiCha, $idHocKyNamHoc);

        $result_NotExist_TenTieuChi = TieuChiController::checkNotExist_TenTieuChi($idTieuChiCha, $TenTieuChi);

        if($result_NotExist_TenTieuChi['status']) // Kiểm tra không tồn tại tên tiêu chí
        {
            try {
                $TieuChi = new TieuChi();
                $TieuChi->idhocky_namhoc = $idHocKyNamHoc;
                $TieuChi->chimuctieuchi = $request->muc;
                $TieuChi->tentieuchi = $TenTieuChi;
                $TieuChi->idtieuchicha = $idTieuChiCha;
                $TieuChi->idloaidiem = (int)$request->idloaidiem;
                $TieuChi->diemtoida = $request->diemtoida;
                $TieuChi->idtrangthai = (int)$request->idtrangthai;
                $TieuChi->stt = $STT;
                $TieuChi->save();
                $result = array('status' => true, 'message' => "Thêm thành công!");
                return $result;
            } catch (Exception $e) {
                $result = array('status' => false, 'message' => $e);
                return $result;
            }
        }
        else
        {
            return $result_NotExist_TenTieuChi;
        }
    }

    public function adminstore(TieuChiRequest $request)
    {
        try {
            $tieuChi = new TieuChi();
            $tieuChi->botieuchi_id = $request->idbotieuchi;
            $tieuChi->chimuctieuchi = $request->chimuc;
            $tieuChi->tentieuchi = $request->noidungtieuchi;
            $tieuChi->tentieuchitomtat = $request->noidungtieuchitomtat;
            if(isset($request->idtieuchicha))
                $tieuChi->idtieuchicha = $request->idtieuchicha?$request->idtieuchicha:0;
            $tieuChi->idloaidiem = $request->loaidiem;
            $tieuChi->diemtoida = $request->diemtoida;
            $tieuChi->diemmacdinh = $request->diemmacdinh;
            // $tieuChi->idtrangthai = $request->trangthai;
            $tieuChi->module_id = $request->module;
            $tieuChi->save();

            return redirect()->route('admin_botieuchi_tieuchi_index', ['idbotieuchi'=>$request->idbotieuchi])->with('success', "Lưu thành công");
            
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('danger', "Lưu không thành công<br>" . $th->getMessage());
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TieuChi  $tieuChi
     * @return \Illuminate\Http\Response
     */
    public function show(TieuChi $tieuChi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TieuChi  $tieuChi
     * @return \Illuminate\Http\Response
     */
    public function edit(TieuChi $tieuChi)
    {
        //
    }

    public function adminedit($idBoTieuChi, $idTieuChi='')
    {
        // $tieuChiCha = TieuChi::find($idTieuChiCha);
        $tieuChi = TieuChi::find($idTieuChi);
        $dsLoaiDiem = LoaiDiem::all();
        $dsTrangThai = TrangThaiTieuChi::all();
        $dsModule = ModuleTinhDiem::orderBy('modulename', 'asc')->get();


        return view('admin.botieuchi_tieuchiedit', ['idBoTieuChi'=>$idBoTieuChi, 'tieuChi'=>$tieuChi, 'dsLoaiDiem'=>$dsLoaiDiem, 'dsTrangThai'=>$dsTrangThai, 'dsModule'=>$dsModule]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TieuChi  $tieuChi
     * @return \Illuminate\Http\Response
     */
    public function update(TieuChiRequest $request)
    {
        $IdTieuChi = $request->id;
        $IdTieuChiCha = $request->idtieuchicha;
        $IdHocKyNamHoc = TieuChiController::getIdHocKyNamHoc($IdTieuChi);
        $TieuChi = TieuChi::find($IdTieuChi);
        $TenTieuChi = $request->tentieuchi;

        $IdTieuChiChaOld = TieuChiController::getIdTieuChiCha($IdTieuChi);

        $result_NotExist_TenTieuChi = TieuChiController::checkNotExist_TenTieuChiUpdate($request->id, $IdTieuChiCha, $IdHocKyNamHoc, $TenTieuChi);

        if($result_NotExist_TenTieuChi['status']) // Kiểm tra không tồn tại tên tiêu chí
        {
            try {
                $TieuChi = TieuChi::find($IdTieuChi);
                $TieuChi->chimuctieuchi = $request->muc;
                $TieuChi->tentieuchi = $TenTieuChi;
                $TieuChi->idtieuchicha = $IdTieuChiCha;
                $TieuChi->idloaidiem = (int)$request->idloaidiem;
                $TieuChi->diemtoida = $request->diemtoida;
                $TieuChi->idtrangthai = (int)$request->idtrangthai;
                if($IdTieuChiChaOld != $IdTieuChiCha)
                {
                    $STT = (int)TieuChiController::getDefaultSTT($IdTieuChiCha, $IdHocKyNamHoc);
                    $TieuChi->stt = $STT;
                }
                // $TieuChi->stt = $STT;
                $TieuChi->save();
                $result = array('status' => true, 'message' => "Cập nhật thành công!");
                return $result;
            } catch (Exception $e) {
                $result = array('status' => false, 'message' => $e);
                return $result;
            }
        }
        else
        {
            return $result_NotExist_TenTieuChi;
        }
    }

    public function adminupdate(TieuChiRequest $request)
    {
        try {
            $tieuChi = TieuChi::find($request->idtieuchi);
            $tieuChi->chimuctieuchi = $request->chimuc;
            $tieuChi->tentieuchi = $request->noidungtieuchi;
            $tieuChi->tentieuchitomtat = $request->noidungtieuchitomtat;
            $tieuChi->idloaidiem = $request->loaidiem;
            $tieuChi->diemtoida = $request->diemtoida;
            $tieuChi->diemmacdinh = $request->diemmacdinh;
            // $tieuChi->idtrangthai = $request->trangthai;
            $tieuChi->module_id = $request->module;

            $tieuChi->save();

            return redirect()->route('admin_botieuchi_tieuchi_index', ['idbotieuchi'=>$request->idbotieuchi])->with('success', "Lưu thành công");
            
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('danger', "Lưu không thành công<br>" . $th->getMessage());
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TieuChi  $tieuChi
     * @return \Illuminate\Http\Response
     */
    public function destroy($idTieuChi)
    {
        if(Auth::check() && ServiceUserController::isGroupOfUserCurrent(env('GROUP_CHUYENVIENHETHONG')))
        {
            if(is_numeric($idTieuChi))
            {
                if(self::isExistId($idTieuChi))
                    try {
                        $objold = TieuChi::find($idTieuChi)->toArray();
                        TieuChi::destroy($idTieuChi);

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
            $result = array('status' => false, 'message' => "Người dùng này không có quyền xóa.");
        }
    }

    public function admindestroy($idBoTieuChi, $idTieuChi)
    {
        try {
            if(count(HocKyNamHocBoTieuChi::where('botieuchi_id', '=', $idBoTieuChi)->get()) == 0)
                if(count(TieuChi::where('idtieuchicha', '=', $idTieuChi)->get()) == 0)
                {
                    TieuChi::destroy($idTieuChi);
                    return redirect()->route('admin_botieuchi_tieuchi_index', ['idbotieuchi'=>$idBoTieuChi])->with('success', "Xóa thành công");
                }
                else
                    return redirect()->route('admin_botieuchi_tieuchi_index', ['idbotieuchi'=>$idBoTieuChi])->with('warning', "Không thể xóa vì tiêu chí còn tiều chí con");
            else
                return redirect()->route('admin_botieuchi_tieuchi_index', ['idbotieuchi'=>$idBoTieuChi])->with('warning', "Không thể xóa vì bộ tiêu chí đã được áp dụng");
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('danger', "Xóa không thành công<br>" . $th->getMessage());
        }
    }

    public function isExistId($idTieuChi)
    {
        $TieuChi = TieuChi::find($idTieuChi);
        if(count($TieuChi)>0)
            return true;
        return false;
    }

    /**
     * Get default stt for storage.
     *
     * @param  $IdTieuChiCha, $IdHocKyNamHoc
     * @return $id
     */
    public static function getDefaultSTT($IdTieuChiCha, $IdHocKyNamHoc=null)
    {
        if($IdHocKyNamHoc === null)
        {
            $IdHocKyNamHoc = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        }
        $MaxSTTCurrent = TieuChiController::getMaxSTT($IdTieuChiCha, $IdHocKyNamHoc);

        if((int)$MaxSTTCurrent>=0)
            return ((int)$MaxSTTCurrent + 1);
        else
            return (0);
    }

    /**
     * Get max stt in storage.
     *
     * @param  $IdTieuChiCha, $IdHocKyNamHoc
     * @return $id
     */
    public static function getMaxSTT($IdTieuChiCha, $IdHocKyNamHoc)
    {
        $MaxSTT = TieuChi::where('idtieuchicha', '=', $IdTieuChiCha)
            -> where('idhocky_namhoc', '=', $IdHocKyNamHoc)
            -> max('stt');
        return $MaxSTT;
    }

    /**
     * Get IdHocKyNamHoc in storage.
     *
     * @param  $Id
     * @return $IdHocKyNamhoc
     */
    public static function getIdHocKyNamHoc($Id)
    {
        $IdHocKyNamhoc = TieuChi::find($Id)->idhocky_namhoc;
        return $IdHocKyNamhoc;
    }

    /**
     * Get IdTieuChiCha in storage.
     *
     * @param  $Id
     * @return $IdTieuChiCha
     */
    public static function getIdTieuChiCha($Id)
    {
        $IdTieuChiCha = TieuChi::find($Id)->idtieuchicha;
        return $IdTieuChiCha;
    }

    
    /**
     * Get max stt in storage.
     *
     * @param  $IdTieuChiCha, $IdHocKyNamHoc, $TenTieuChi
     * @return true/false
     */
    public static function checkNotExist_TenTieuChi($IdTieuChiCha, $TenTieuChi)
    {
        $DanhSach_TieuChi = TieuChi::where('idtieuchicha', '=', $IdTieuChiCha)
            -> where('tentieuchi', '=', $TenTieuChi)
            -> get();

        if(count($DanhSach_TieuChi)>0)
            $result = array('status' => false, 'message' => "Đã tồn tại tiêu chí!");
        else
            $result = array('status' => true, 'message' => "");

        return $result;
    }

    /**
     *
     * @param  $Id, $IdTieuChiCha, $IdHocKyNamHoc, $TenTieuChi
     * @return true/false
     */
    public static function checkNotExist_TenTieuChiUpdate($Id, $IdTieuChiCha, $IdHocKyNamHoc, $TenTieuChi)
    {
        $DanhSach_TieuChi = TieuChi::where('idtieuchicha', '=', $IdTieuChiCha)
            -> where('idhocky_namhoc', '=', $IdHocKyNamHoc)
            -> where('tentieuchi', '=', $TenTieuChi)
            -> where('id', '<>', $Id)
            -> get();

        if(count($DanhSach_TieuChi)>0)
            $result = array('status' => false, 'message' => "Đã tồn tại tiêu chí!");
        else
            $result = array('status' => true, 'message' => "");

        return $result;
    }

    /**
     * Get a listing of the resource.
     * @param  $IdHocKyNamHoc
     * @return \App\Http\TieuChi
     */
    public static function getTieuChi($IdHocKyNamHoc)
    {
        $DanhSach_TieuChi = TieuChi::where('idhocky_namhoc', '=', $IdHocKyNamHoc)
            -> where('idtrangthai', '<>', TrangThaiTieuChiConst::An)
            -> get();
        return $DanhSach_TieuChi;
    }

    public static function GetTieuChiPhanCap($idHocKyNamHoc='')
    {
        $dsTieuChi = array();
        $DanhSach_TieuChi = TieuChi::where('idhocky_namhoc', '=', $idHocKyNamHoc)
            -> where('idtrangthai', '<>', TrangThaiTieuChiConst::An)
            -> where('idtieuchicha', '=', 0)
            -> get();
        foreach ($DanhSach_TieuChi as $key => $tieuChi) {
            $dsTieuChi = self::GetTieuChiPhanCap_DeQuy($tieuChi, $dsTieuChi);
        }

        return $dsTieuChi;
    }

    public static function GetTieuChiPhanCap_DeQuy($tieuChi='', &$dsTieuChi)
    {
        array_push($dsTieuChi, $tieuChi);

        $DanhSach_TieuChi = TieuChi::where('idtieuchicha', '=', $tieuChi->id)->get();

        foreach ($DanhSach_TieuChi as $key => $tieuChi) {
            self::GetTieuChiPhanCap_DeQuy($tieuChi, $dsTieuChi);
        }

        return $dsTieuChi;
    }


    public static function getArrayIDTieuChiCuaHocKyHienHanh()
    {
        $idHocKyNamHoc = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        $arrayIDTieuChi = self::getArrayIDTieuChi($idHocKyNamHoc);
        return $arrayIDTieuChi;
    }

    public static function getArrayIDTieuChi_Level_0($idHocKyNamHoc)
    {
        $DanhSach_TieuChi_Level_0 = TieuChi::where('idhocky_namhoc', '=', $idHocKyNamHoc)
            -> where('idtieuchicha', '=', 0)
            -> get();
        return $DanhSach_TieuChi_Level_0;
    }

    public static function getArrayIDTieuChi($idHocKyNamHoc)
    {
        $DanhSach_TieuChi_Level_0 = self::getArrayIDTieuChi_Level_0($idHocKyNamHoc);
            
        $arrayIDTieuChi = array();

        foreach ($DanhSach_TieuChi_Level_0 as $key => $TieuChi) {

            $DanhSach_TieuChi= TieuChi::where('idtieuchicha', '=', $TieuChi->id) -> get();

            array_push($arrayIDTieuChi, $TieuChi->id);
            if(count($DanhSach_TieuChi) >= 0)
                self::getArrayIDTieuChi_Sub($arrayIDTieuChi, $TieuChi->id);
        }
        return $arrayIDTieuChi;
    }

    public static function getArrayIDTieuChiCongDiemTrucTiep($idHocKyNamHoc)
    {
        $DanhSach_TieuChi_Level_0 = self::getArrayIDTieuChi_Level_0($idHocKyNamHoc);
            
        $arrayIDTieuChi = array();

        foreach ($DanhSach_TieuChi_Level_0 as $key => $TieuChi) {

            $DanhSach_TieuChi= TieuChi::where('idtieuchicha', '=', $TieuChi->id) -> get();

            if(count($DanhSach_TieuChi) >= 0)
                self::getArrayIDTieuChiCongDiemTrucTiep_Sub($arrayIDTieuChi, $TieuChi->id);
            else
                array_push($arrayIDTieuChi, array('idTieuChi' => $TieuChi->id, 'idloaidiem' => $TieuChi->idloaidiem, 'diemtoida' => $TieuChi->diemtoida));
        }
        return $arrayIDTieuChi;
    }

    public static function getArrayIDTieuChi_Sub(&$arrayIDTieuChi, $idTieuChi)
    {
        $DanhSach_TieuChi= TieuChi::where('idtieuchicha', '=', $idTieuChi) -> get();

        if(count($DanhSach_TieuChi) == 0)
            return array_push($arrayIDTieuChi, $idTieuChi);

        foreach ($DanhSach_TieuChi as $key => $TieuChi) {
            array_push($arrayIDTieuChi, $TieuChi->id);
        }
    }

    public static function getArrayIDTieuChiCongDiemTrucTiep_Sub(&$arrayIDTieuChi, $idTieuChi)
    {
        $DanhSach_TieuChi= TieuChi::where('idtieuchicha', '=', $idTieuChi) -> get();

        if(count($DanhSach_TieuChi) == 0)
        {
            $TieuChi = TieuChi::where('id', '=', $idTieuChi)->first();

            return array_push($arrayIDTieuChi, array('idTieuChi' => $TieuChi->id, 'idloaidiem' => $TieuChi->idloaidiem, 'diemtoida' => $TieuChi->diemtoida));
        }

        foreach ($DanhSach_TieuChi as $key => $TieuChi) {
            self::getArrayIDTieuChiCongDiemTrucTiep_Sub($arrayIDTieuChi, $TieuChi->id);
        }
    }

    public static function getTieuChiTinhDiem($idHocKyNamHoc)
    {
        $DanhSach_TieuChi_Level_0= TieuChi::where('idtieuchicha', '=', 0)
            -> where('idhocky_namhoc', '=', $idHocKyNamHoc)
            -> get();

        $arrayTieuChiTinhDiem = array();
        foreach ($DanhSach_TieuChi_Level_0 as $key => $tieuChi) {
            self::getTieuChiTinhDiem_Sub($arrayTieuChiTinhDiem, $tieuChi);
        }

        return $arrayTieuChiTinhDiem;
    }

    public static function getTieuChiTinhDiem_Sub(&$arrayTieuChiTinhDiem, $tieuChi)
    {
        $DanhSach_TieuChi= TieuChi::where('idtieuchicha', '=', $tieuChi->id) -> get();

        if(count($DanhSach_TieuChi) == 0)
            return array_push($arrayTieuChiTinhDiem, $tieuChi);
        else
        {
            foreach ($DanhSach_TieuChi as $key => $tieuChi) {
                self::getTieuChiTinhDiem_Sub($arrayTieuChiTinhDiem, $tieuChi);
            }
            return $arrayTieuChiTinhDiem;

        }
    }


    public static function TieuChiCon($idTieuChiCha='', $boTieuChi)
    {
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();
        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text-justify-middle">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text-justify-middle">' . $tieuChi->tentieuchi . '</th> ';
                else
                    echo '<td class="text-justify-middle">' . $tieuChi->tentieuchi . '</td>';
                                    
                echo '<td class="text-center-middle">'. $tieuChi->diemtoida. '</td>' .
                    '<th class="text-center-middle">' . $tieuChi->diemmacdinh . '</th>';

                if($tieuChi->module)
                    echo '<td class="text-justify-middle"><span class="label label-success">' . $tieuChi->module->modulename . '</span></td>';
                else
                    echo '<td class="text-center-middle"></td>';
                
                echo    '<td class="text-right-middle">';
                        if($tieuChi->idloaidiem == 1)
                            echo '<a href="'. route('admin_botieuchi_tieuchi_create',['idbotieuchi'=>$boTieuChi->id, 'idtieuchicha'=>$tieuChi->id]) . '" class="btn btn-primary" title="Thêm tiêu chí con"><i class="fa fa-plus"></i></a>';
                        echo '<a href="'. route('admin_botieuchi_tieuchi_edit',['idbotieuchi'=>$boTieuChi->id, 'idtieuchi'=>$tieuChi->id]) . '" class="btn btn-warning" title="Sửa"><i class="fa fa-edit"></i></a>' .
                        '<a href="' . route('admin_botieuchi_tieuchi_destroy',['idbotieuchi'=>$boTieuChi->id, 'idtieuchi'=>$tieuChi->id]) . '" class="btn btn-danger btn-remove" title="Xóa"><i class="fa fa-trash"></i></a>' .
                    '</td>'.
            '</tr>';
            self::TieuChiCon($tieuChi->id, $boTieuChi);
        }
    }

    public static function TieuChiCon_TruongDonVi($idTieuChiCha='', $boTieuChi)
    {
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();
        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text-justify-middle">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text-justify-middle">' . $tieuChi->tentieuchi . '</th> ';
                else
                    echo '<td class="text-justify-middle">' . $tieuChi->tentieuchi . '</td>';
                echo '<td class="text-center-middle">'. $tieuChi->diemtoida. '</td>' .
                    '<th class="text-center-middle">' . $tieuChi->diemmacdinh . '</th>';

                if($tieuChi->module)
                    echo '<td class="text-justify-middle"><span class="label label-success">' . $tieuChi->module->modulename . '</span></td>';
                else
                    echo '<td class="text-center-middle"></td>';
            echo "</tr>";
            self::TieuChiCon_TruongDonVi($tieuChi->id, $boTieuChi);
        }
    }

    public static function TieuChiConXem($idTieuChiCha='', $boTieuChi)
    {
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();
        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text-justify-middle">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text-justify-middle">' . $tieuChi->tentieuchi . '</th>';
                else
                    echo '<td class="text-justify-middle">' . $tieuChi->tentieuchi . '</td>';
                echo '<td class="text-right-middle">'. $tieuChi->diemtoida. '</td>' .
                    '<th class="text-right-middle">'. $tieuChi->diemmacdinh. '</th>' .
            '</tr>';
            self::TieuChiConXem($tieuChi->id, $boTieuChi);
        }
    }
    
    public static function TieuChiCon_MinhChung($idTieuChiCha='', $boTieuChi, $idHocKy)
    {
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();
        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text-justify-middle">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text-justify-middle">' . $tieuChi->tentieuchi . '</th>'.
                    '<td class="text-right-middle">'. $tieuChi->diemtoida . '</td>'.
                    '<td class="text-right-middle">'. $tieuChi->diemmacdinh . '</td><td></td>';

                else
                {
                    echo    '<td class="text-justify-middle">' . $tieuChi->tentieuchi . '</td>'.
                            '<td class="text-right-middle">'. $tieuChi->diemtoida . '</td>'.
                            '<td class="text-right-middle">'. $tieuChi->diemmacdinh . '</td>';

                    if($tieuChi->module_id == 2)
                        echo '<td class="text-center-middle"><a href="' . route('admin_tieuchi_minhchung_module', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id, 'idmodule'=>$tieuChi->module_id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                    else
                        echo '<td class="text-center-middle"><a href="' . route('admin_tieuchi_minhchung', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                }
            echo '</tr>';
            self::TieuChiCon_MinhChung($tieuChi->id, $boTieuChi, $idHocKy);
        }
    }

    public static function TruongDonVi_TieuChiCon_MinhChung($idTieuChiCha='', $boTieuChi, $idHocKy)
    {
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();
        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text-justify-middle">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text-justify-middle">' . $tieuChi->tentieuchi . '</th>'.
                    '<td class="text-right-middle">'. $tieuChi->diemtoida . '</td>'.
                    '<td class="text-right-middle">'. $tieuChi->diemmacdinh . '</td><td></td>';

                else
                {
                    echo    '<td class="text-justify-middle">' . $tieuChi->tentieuchi . '</td>'.
                            '<td class="text-right-middle">'. $tieuChi->diemtoida . '</td>'.
                            '<td class="text-right-middle">'. $tieuChi->diemmacdinh . '</td>';

                    if($tieuChi->module_id == 2)
                        echo '<td class="text-center-middle"><a href="' . route('truongdonvi_tieuchi_minhchung_module', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id, 'idmodule'=>$tieuChi->module_id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                    else
                        echo '<td class="text-center-middle"><a href="' . route('truongdonvi_tieuchi_minhchung', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                }
            echo '</tr>';
            self::TruongDonVi_TieuChiCon_MinhChung($tieuChi->id, $boTieuChi, $idHocKy);
        }
    }

    public static function Subadmin_TieuChiCon_MinhChung($idTieuChiCha='', $boTieuChi, $idHocKy)
    {
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();
        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text-justify-middle">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text-justify-middle">' . $tieuChi->tentieuchi . '</th>'.
                    '<td class="text-right-middle">'. $tieuChi->diemtoida. '</td><td></td>';

                else
                    echo '<td class="text-justify-middle">' . $tieuChi->tentieuchi . '</td>'.
                    '<td class="text-right-middle">'. $tieuChi->diemtoida. '</td>' .
                    '<td class="text-center-middle"><a href="' . route('subadmin_tieuchi_minhchung', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>'.
            '</tr>';
            self::Subadmin_TieuChiCon_MinhChung($tieuChi->id, $boTieuChi, $idHocKy);
        }
    }

    public static function GiaoVuKhoa_TieuChiCon_MinhChung($idTieuChiCha='', $boTieuChi, $idHocKy)
    {
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();
        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text-justify-middle">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text-justify-middle">' . $tieuChi->tentieuchi . '</th>'.
                    '<td class="text-right-middle">'. $tieuChi->diemtoida . '</td>'.
                    '<td class="text-right-middle">'. $tieuChi->diemmacdinh . '</td><td></td>';

                else
                {
                    echo    '<td class="text-justify-middle">' . $tieuChi->tentieuchi . '</td>'.
                            '<td class="text-right-middle">'. $tieuChi->diemtoida . '</td>'.
                            '<td class="text-right-middle">'. $tieuChi->diemmacdinh . '</td>';

                    if($tieuChi->module_id == 2)
                        echo '<td class="text-center-middle"><a target="_blank" href="' . route('giaovukhoa_tieuchi_minhchung_module', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id, 'idmodule'=>$tieuChi->module_id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                    else
                        echo '<td class="text-center-middle"><a target="_blank" href="' . route('giaovukhoa_tieuchi_minhchung', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                }
            echo '</tr>';
            self::GiaoVuKhoa_TieuChiCon_MinhChung($tieuChi->id, $boTieuChi, $idHocKy);
        }
    }

    public static function CoVanHocTap_TieuChiCon_MinhChung($idTieuChiCha='', $boTieuChi, $idHocKy)
    {
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();
        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text-justify-middle">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text-justify-middle">' . $tieuChi->tentieuchi . '</th>'.
                    '<td class="text-right-middle">'. $tieuChi->diemtoida . '</td>'.
                    '<td class="text-right-middle">'. $tieuChi->diemmacdinh . '</td><td></td>';

                else
                {
                    echo    '<td class="text-justify-middle">' . $tieuChi->tentieuchi . '</td>'.
                            '<td class="text-right-middle">'. $tieuChi->diemtoida . '</td>'.
                            '<td class="text-right-middle">'. $tieuChi->diemmacdinh . '</td>';

                    if($tieuChi->module_id == 2)
                        echo '<td class="text-center-middle"><a target="_blank" href="' . route('covanhoctap_tieuchi_minhchung_module', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id, 'idmodule'=>$tieuChi->module_id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                    else
                        echo '<td class="text-center-middle"><a target="_blank" href="' . route('covanhoctap_tieuchi_minhchung', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                }
            echo '</tr>';
            self::CoVanHocTap_TieuChiCon_MinhChung($tieuChi->id, $boTieuChi, $idHocKy);
        }
    }

    public static function BanCanSu_TieuChiCon_MinhChung($idTieuChiCha='', $boTieuChi, $idHocKy)
    {
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();
        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text-justify-middle">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text-justify-middle">' . $tieuChi->tentieuchi . '</th>'.
                    '<td class="text-right-middle">'. $tieuChi->diemtoida . '</td>'.
                    '<td class="text-right-middle">'. $tieuChi->diemmacdinh . '</td><td></td>';

                else
                {
                    echo    '<td class="text-justify-middle">' . $tieuChi->tentieuchi . '</td>'.
                            '<td class="text-right-middle">'. $tieuChi->diemtoida . '</td>'.
                            '<td class="text-right-middle">'. $tieuChi->diemmacdinh . '</td>';

                    if($tieuChi->module_id == 2)
                        echo '<td class="text-center-middle"><a target="_blank" href="' . route('bancansu_tieuchi_minhchung_module', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id, 'idmodule'=>$tieuChi->module_id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                    else
                        echo '<td class="text-center-middle"><a target="_blank" href="' . route('bancansu_tieuchi_minhchung', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                }
            echo '</tr>';
            self::BanCanSu_TieuChiCon_MinhChung($tieuChi->id, $boTieuChi, $idHocKy);
        }
    }

    public static function SinhVien_TieuChiCon_MinhChung($idTieuChiCha='', $boTieuChi, $idHocKy)
    {
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();
        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text-justify-middle">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text-justify-middle">' . $tieuChi->tentieuchi . '</th>'.
                    '<td class="text-right-middle">'. $tieuChi->diemtoida . '</td>'.
                    '<td class="text-right-middle">'. $tieuChi->diemmacdinh . '</td><td></td>';

                else
                {
                    echo    '<td class="text-justify-middle">' . $tieuChi->tentieuchi . '</td>'.
                            '<td class="text-right-middle">'. $tieuChi->diemtoida . '</td>'.
                            '<td class="text-right-middle">'. $tieuChi->diemmacdinh . '</td>';

                    if($tieuChi->module_id == 2)
                        echo '<td class="text-center-middle"><a target="_blank" href="' . route('sinhvien_tieuchi_minhchung_module', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id, 'idmodule'=>$tieuChi->module_id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                    else
                        echo '<td class="text-center-middle"><a target="_blank" href="' . route('sinhvien_tieuchi_minhchung', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                }
            echo '</tr>';
            self::SinhVien_TieuChiCon_MinhChung($tieuChi->id, $boTieuChi, $idHocKy);
        }
    }

    public static function TieuChiCon_DiemSinhVien($idTieuChiCha='', $boTieuChi, $idHocKy, $idSinhVien)
    {
        $totalMarks = 0;
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();

        foreach ($dsTieuChi as $key => $tieuChi) {
            $tieuChi_BangDiem = BangDiemRenLuyen::where('tieuchi_id', '=', $tieuChi->id)
                ->where('hocky_namhoc_id', '=', $idHocKy)
                ->where('sinhvien_id', '=', $idSinhVien)
                ->first();
            $booCreate_TieuChi_BangDiem = false;
            if(!$tieuChi_BangDiem)
            {
                $booCreate_TieuChi_BangDiem = true;
                $tieuChi_BangDiem = BangDiemRenLuyen::create(array('hocky_namhoc_id'=>$idHocKy, 'sinhvien_id'=>$idSinhVien, 'tieuchi_id'=>$tieuChi->id, 'maxdiem'=>$tieuChi->diemtoida, 'diem'=>$tieuChi->diemmacdinh));
            }
            
            $tieuChi->diem = $tieuChi_BangDiem->diem;
            $totalMarks += $tieuChi_BangDiem->diem;

            if($booCreate_TieuChi_BangDiem)
                ServiceTieuChiMinhChungController::UpdateDiemTieuChiCha($tieuChi, $idHocKy, $idSinhVien);
        }

        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text-justify-middle">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text-justify-middle">' . $tieuChi->tentieuchi . '</th>'.
                    '<th class="text-right-middle col-total-council-faculty">'. $tieuChi->diemtoida. '</th>'.
                    '<th class="text-right-middle col-total-council-university">'. number_format((float)$tieuChi->diem, 2, '.', '') . '</th>' .
                    '<th></th>';
                else
                {
                    echo '<td class="text-justify-middle">' . $tieuChi->tentieuchi;
                    if($tieuChi->module_id == 2 && floatval($tieuChi->diem) < floatval($tieuChi->diemtoida))
                    {
                        if(!SinhVienController::daDangKyNoiTruNgoaiTru($idHocKy, $tieuChi->id, $idSinhVien))
                            echo ' <a href="'. route('sinhvien_profile') .'" title="Đăng ký thông tin nội trú, ngoại trú"><span class="label label-danger">Đăng ký để được cộng điểm</span></a>';
                    }
                    echo '</td>'.
                    '<td class="text-right-middle col-total-council-faculty">'. $tieuChi->diemtoida. '</td>' .
                    '<th class="text-right-middle col-total-council-university">'. number_format((float)$tieuChi->diem, 2, '.', '') . '</th>';
                    if($tieuChi->module_id == 2)
                        echo '<td class="text-center-middle"><a target="_blank" href="' . route('sinhvien_tieuchi_minhchung_module', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id, 'idmodule'=>$tieuChi->module_id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                    else
                        echo '<td class="text-center-middle"><a target="_blank" href="' . route('sinhvien_tieuchi_minhchung', ['idhockynamhoc'=>$idHocKy, 'idtieuchi'=>$tieuChi->id]) . '" class="btn btn-primary" title="Xem minh chứng"><i class="fa fa-eye"></i> </a></td>';
                }
            echo '</tr>';
            self::TieuChiCon_DiemSinhVien($tieuChi->id, $boTieuChi, $idHocKy, $idSinhVien);
        }
    }

    public static function Admin_TieuChiCon_DiemSinhVien($idTieuChiCha='', $boTieuChi, $idHocKy, $idSinhVien)
    {
        $totalMarks = 0;
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();

        foreach ($dsTieuChi as $key => $tieuChi) {
            $tieuChi_BangDiem = BangDiemRenLuyen::where('tieuchi_id', '=', $tieuChi->id)
                ->where('hocky_namhoc_id', '=', $idHocKy)
                ->where('sinhvien_id', '=', $idSinhVien)
                ->first();
            $booCreate_TieuChi_BangDiem = false;
            if(!$tieuChi_BangDiem)
            {
                $booCreate_TieuChi_BangDiem = true;
                $tieuChi_BangDiem = BangDiemRenLuyen::create(array('hocky_namhoc_id'=>$idHocKy, 'sinhvien_id'=>$idSinhVien, 'tieuchi_id'=>$tieuChi->id, 'maxdiem'=>$tieuChi->diemtoida, 'diem'=>$tieuChi->diemmacdinh));
            }
            
            $tieuChi->diem = $tieuChi_BangDiem->diem;
            $totalMarks += $tieuChi_BangDiem->diem;

            if($booCreate_TieuChi_BangDiem)
                ServiceTieuChiMinhChungController::UpdateDiemTieuChiCha($tieuChi, $idHocKy, $idSinhVien);
        }

        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text-justify-middle">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text-justify-middle">' . $tieuChi->tentieuchi . '</th>'.
                    '<th class="text-right-middle col-total-council-faculty">'. $tieuChi->diemtoida. '</th>'.
                    '<th class="text-right-middle col-total-council-university">'. number_format((float)$tieuChi->diem, 2, '.', '') . '</th>';
                else
                {
                    echo '<td class="text-justify-middle">' . $tieuChi->tentieuchi;
                    echo '</td>'.
                    '<td class="text-right-middle col-total-council-faculty">'. $tieuChi->diemtoida. '</td>' .
                    '<th class="text-right-middle col-total-council-university">'. number_format((float)$tieuChi->diem, 2, '.', '') . '</th>';
                }
            echo '</tr>';
            self::Admin_TieuChiCon_DiemSinhVien($tieuChi->id, $boTieuChi, $idHocKy, $idSinhVien);
        }
    }

    public static function TieuChiCon_DiemSinhVien_PrintExport($idTieuChiCha='', $boTieuChi, $idHocKy, $idSinhVien)
    {
        $totalMarks = 0;
        $dsTieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChiCha)->get();

        foreach ($dsTieuChi as $key => $tieuChi) {
            $tieuChi_BangDiem = BangDiemRenLuyen::where('tieuchi_id', '=', $tieuChi->id)
                ->where('hocky_namhoc_id', '=', $idHocKy)
                ->where('sinhvien_id', '=', $idSinhVien)
                ->first();
            
            $tieuChi->diem = $tieuChi_BangDiem?$tieuChi_BangDiem->diem:$tieuChi->diemmacdinh;
            $totalMarks += $tieuChi->diem;
        }

        foreach($dsTieuChi as $tieuChi)
        {
            echo "<tr>" .
                '<th class="text text-justify">' . $tieuChi->chimuctieuchi . '</th>';
                if($tieuChi->idloaidiem == 1)
                    echo '<th class="text text-justify">' . $tieuChi->tentieuchi . '</th>'.
                    '<th class="text text-right col-total-council-faculty">'. $tieuChi->diemtoida . '</th>'.
                    '<th class="text text-right col-total-council-university">'. number_format((float)$tieuChi->diem, 2, '.', '') . '</th>';

                else
                    echo '<td class="text text-justify">' . $tieuChi->tentieuchi . '</td>'.
                    '<td class="text text-right col-total-council-faculty">'. $tieuChi->diemtoida. '</td>' .
                    '<th class="text text-right col-total-council-university">'. number_format((float)$tieuChi->diem, 2, '.', '') . '</th>' .
            '</tr>';
            self::TieuChiCon_DiemSinhVien_PrintExport($tieuChi->id, $boTieuChi, $idHocKy, $idSinhVien);
        }
    }

    public static function TieuChiLevel0($idHocKyNamHocBoTieuChi)
    {
        return TieuChi::where('botieuchi_id', '=', $idHocKyNamHocBoTieuChi)->where('idtieuchicha', '=', 0)-> select('id')->get();
    }

    public static function TongDiemMacDinhTheoHocKyNamHoc($idHocKyNamHoc)
    {
        $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChiController::HocKyNamHocBoTieuChi($idHocKyNamHoc);
        $tongDiemMacDinh = self::TongDiemMacDinhTheoBoTieuChi($hocKyNamHocBoTieuChi? $hocKyNamHocBoTieuChi->botieuchi_id : '');
        return $tongDiemMacDinh;
    }

    public static function TongDiemMacDinhTheoBoTieuChi($idHocKyNamHocBoTieuChi='')
    {
        return TieuChi::where('botieuchi_id', '=', $idHocKyNamHocBoTieuChi)->where('idtieuchicha', '=', 0)->sum('diemmacdinh');
    }
}
