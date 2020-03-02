<?php

namespace App\Http\Controllers;

use App\ThoiGianDanhGiaDRL;
use Illuminate\Http\Request;
use App\HocKyNamHoc;
use App\Lop;
use DateTime;
use DB;
use App\Http\Requests\ThoiGianDanhGiaDiemRenLuyenRequest;
class ThoiGianDanhGiaDRLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DS_hocky_namhoc=HocKyNamHoc::where('idtrangthaihocky', '<', 2)->take(3)->orderBy('id', 'desc')->get();
        $HocKy_NamHoc_HienHanh = HocKyNamHoc::where('idtrangthaihocky', '=', 2)->first();

        $DS_ThoiGianDanhGiaDRL_HienHanh = self::getThoiGianDanhGiaDRLTheoHocKy($HocKy_NamHoc_HienHanh->id);

        return view('subadmin.thoigiandanhgiadiemrenluyen',compact('DS_ThoiGianDanhGiaDRL_HienHanh','DS_hocky_namhoc', 'HocKy_NamHoc_HienHanh'));
    }

    public function covanhoctap_index()
    {
        
        $HocKy_NamHoc_HienHanh = HocKyNamHoc::where('idtrangthaihocky', '=', 2)->first();

        $DS_ThoiGianDanhGiaDRL_HienHanh = self::getThoiGianDanhGiaDRLTheoHocKy($HocKy_NamHoc_HienHanh->id);

        return view('covanhoctap.thoigiandanhgiadiemrenluyen',compact('DS_ThoiGianDanhGiaDRL_HienHanh', 'HocKy_NamHoc_HienHanh'));
    }

    public function giaovukhoa_index()
    {
        
        $HocKy_NamHoc_HienHanh = HocKyNamHoc::where('idtrangthaihocky', '=', 2)->first();

        $DS_ThoiGianDanhGiaDRL_HienHanh = self::getThoiGianDanhGiaDRLTheoHocKy($HocKy_NamHoc_HienHanh->id);

        return view('giaovukhoa.thoigiandanhgiadiemrenluyen',compact('DS_ThoiGianDanhGiaDRL_HienHanh', 'HocKy_NamHoc_HienHanh'));
    }

    public static function getThoiGianDanhGiaDRLTheoHocKy($idHocKyNamHoc)
    {
        $DS_ThoiGianDanhGiaDRL=ThoiGianDanhGiaDRL::where('hockynamhoc_id', '=', $idHocKyNamHoc)->orderBy('thoigianbatdau', 'asc')->get();
        return $DS_ThoiGianDanhGiaDRL;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $DS_Lop = Lop::orderBy('tenlop', 'asc')->get();
        $DS_HocKyNamHoc = HocKyNamHoc::all();
        return view('subadmin.thoigiandanhgiadiemrenluyen_add',compact('DS_Lop','DS_HocKyNamHoc'));
    }
    public function edit($id)
    {
        $thoigiandanhgiaDRL = ThoiGianDanhGiaDRL::find($id);
        $DS_Lop = Lop::all();

        $DS_HocKyNamHoc = HocKyNamHoc::wherein('idtrangthaihocky', [2, 3])->get();

        return view('subadmin.thoigiandanhgiadiemrenluyen_edit', compact('thoigiandanhgiaDRL','DS_Lop','DS_HocKyNamHoc'));

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThoiGianDanhGiaDiemRenLuyenRequest $request)
    {
        $hockynamhoc = $request->hockynamhoc;
        $Lops = $request->lop;
        foreach ($Lops as  $Lop) {
             $result = ThoiGianDanhGiaDRLController::isNotExist($hockynamhoc, $Lop);
        }
       
        if($result['status'])
        {

            try{
                foreach ($Lops as $lop) {
                    $TGDGDRL = new ThoiGianDanhGiaDRL();
                    $TGDGDRL->hockynamhoc_id=$request->hockynamhoc;
                    $TGDGDRL->lop_id=$lop;
                    $TGDGDRL->thoigianbatdau=DateTime::createFromFormat('d/m/Y',trim($request->thoigianbatdau));
                    $TGDGDRL->thoigianketthuc=DateTime::createFromFormat('d/m/Y',trim($request->thoigiankethuc));
                    $TGDGDRL->save(); 
                    }    
            
                try {
                    $objnew = ThoiGianDanhGiaDRL::find($TGDGDRL->id)->toArray();
                    LogController::storeobjectlog('', $objnew, LogLoaiHoatDong::NewInsertRecord, '');
                    
                } catch (Exception $e) {
                   
                }
                return redirect()->route('thoigiandanhgiaDRL')->with('success', "Lưu thành công!");
            }catch (Exception $e) {
                return redirect()->route('thoigiandanhgiaDRL')->with('danger', "Lưu chưa được, vui lòng thử lại!");
            }

        }
        else
        {
            foreach ($Lops as $lop) {
                $Lop = Lop::where('id','=',$lop)->select('tenlop')->first();
                    return redirect()->back()->withInput()->with('warning', $Lop->tenlop. " đã tồn tại!");
            }
        
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ThoiGianDanhGiaDRL  $thoiGianDanhGiaDRL
     * @return \Illuminate\Http\Response
     */
    public function show(ThoiGianDanhGiaDRL $thoiGianDanhGiaDRL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ThoiGianDanhGiaDRL  $thoiGianDanhGiaDRL
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ThoiGianDanhGiaDRL  $thoiGianDanhGiaDRL
     * @return \Illuminate\Http\Response
     */
    public function update(ThoiGianDanhGiaDiemRenLuyenRequest $request, $Id)
    {
        $hockynamhoc = $request->hockynamhoc;
        $Lops = $request->lop;
        foreach ($Lops as $lop) {
            $result = ThoiGianDanhGiaDRLController::isNotExist_Update($Id,$hockynamhoc, $lop);    
        }
        
        if($result['status'])
        {
            $objold = ThoiGianDanhGiaDRL::find($Id)->toArray(); 
            $TGDGDRL = ThoiGianDanhGiaDRL::find($Id);
            try{
               $flag = false;
                foreach ($Lops as $lop) {
                if($lop!=$TGDGDRL->lop_id){
                 $TGDGDRL = new ThoiGianDanhGiaDRL();
                 $newid =DB::SELECT(DB::raw("SELECT MAX(id)+1 as id from thoigiandanhgiadrl"));
                 $TGDGDRL->id=$newid[0]->id;
                 $TGDGDRL->lop_id=$lop;
                 $TGDGDRL->hockynamhoc_id=$hockynamhoc;
                 $TGDGDRL->thoigianbatdau=DateTime::createFromFormat('d/m/Y',trim($request->thoigianbatdau));
                 $TGDGDRL->thoigianketthuc=DateTime::createFromFormat('d/m/Y',trim($request->thoigiankethuc));
                 $TGDGDRL->save();
                }
                else{
                $flag=true;
                $TGDGDRL->lop_id=$lop;
                $TGDGDRL->hockynamhoc_id=$hockynamhoc;
                $TGDGDRL->thoigianbatdau=DateTime::createFromFormat('d/m/Y',trim($request->thoigianbatdau));
                $TGDGDRL->thoigianketthuc=DateTime::createFromFormat('d/m/Y',trim($request->thoigiankethuc));
                $TGDGDRL->save();
                }
                }
                if($flag==false){
                 $TGDGDRL = ThoiGianDanhGiaDRL::where('lop_id','=',$TGDGDRL->lop_id)->delete();
                }   
                try {
                    $objnew = ThoiGianDanhGiaDRL::find($TGDGDRL->id)->toArray();
                    LogController::storeobjectlog($objold, $objnew, LogLoaiHoatDong::UpdateRecord, '');
                    
                } catch (Exception $e) {
                   
                }
                return redirect()->route('thoigiandanhgiaDRL')->with('success', "Cập nhật thành công!");
            }catch (Exception $e) {
               return redirect()->route('thoigiandanhgiaDRL')->with('danger', "Cập nhật chưa được, vui lòng thử lại!");
        }

    }
    else
        {
            foreach ($Lops as $lop) {
                $Lop = Lop::where('id','=',$lop)->select('tenlop')->first();
                    return redirect()->back()->withInput()->with('warning', $Lop->tenlop. " đã tồn tại!");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ThoiGianDanhGiaDRL  $thoiGianDanhGiaDRL
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(is_numeric($id))
        {
            if(ThoiGianDanhGiaDRLController::isExistId($id))
                try {

                    $objold = ThoiGianDanhGiaDRL::find($id)->toArray();
                    ThoiGianDanhGiaDRL::destroy($id);

                    // Write log
                    try {
                        LogController::storeobjectlog($objold, '', LogLoaiHoatDong::DeleteRecord, '');
                        
                    } catch (Exception $e) {
                        
                    }
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
    public static function isExistId($Id)
    {
        $TGDGDRL = ThoiGianDanhGiaDRL::find($Id);
        if(count($TGDGDRL)>0)
            return true;
        return false;
    }
     public static function isNotExist($hockynamhoc, $Lop)
    {
        $request_hocky_lop = ThoiGianDanhGiaDRLController::isExistHocKy_Lop($hockynamhoc,$Lop);
       // $request_ngay = ThoiGianDanhGiaDRLController::isExistNgay($ngaybatdau,$ngayketthuc);

        $tenlop =Lop::where('id',$Lop)->select('tenlop')->first();
        $hocky=HocKyNamHoc::where('id',$hockynamhoc)->select('tenhockynamhoc')->first();
        $status = true;
        $message = "";
        if($request_hocky_lop)
        {
            $status = false;
            $message .= "- ".$hocky->tenhockynamhoc." thuốc lớp ".$tenlop->tenlop." đã tồn tại!";
        }
        /*if($request_ngay)
        {
            $status = false;
            $message .= "Ngày kết thúc phải lớn hơn ngày bắt đầu!";
        }*/
        
        $result = array('status' => $status, 'message' => $message);
        return $result;
    }
     public static function isExistHocKy_Lop($hockynamhoc, $Lop)
    {
        $DanhSach_TGDGDRL = ThoiGianDanhGiaDRL::where([['hockynamhoc_id', '=', $hockynamhoc],['lop_id','=',$Lop]])->select('hockynamhoc_id','lop_id')->get();
        if(count($DanhSach_TGDGDRL)>0)
            return true;
        return false;
    }
    public static function isNotExist_Update($Id,$hockynamhoc, $Lop)
    {
        $request_hocky_lop = ThoiGianDanhGiaDRLController::isExistHocKy_Lop_Update($Id,$hockynamhoc,$Lop);
       // $request_ngay = ThoiGianDanhGiaDRLController::isExistNgay($ngaybatdau,$ngayketthuc);

        $tenlop =Lop::where('id',$Lop)->select('tenlop')->first();
        $hocky=HocKyNamHoc::where('id',$hockynamhoc)->select('tenhockynamhoc')->first();
        $status = true;
        $message = "";
        if($request_hocky_lop)
        {
            $status = false;
            $message .= "- ".$hocky->tenhockynamhoc." thuốc lớp ".$tenlop->tenlop." đã tồn tại!";
        }
        /*if($request_ngay)
        {
            $status = false;
            $message .= "Ngày kết thúc phải lớn hơn ngày bắt đầu!";
        }*/
        
        $result = array('status' => $status, 'message' => $message);
        return $result;
    }
     public static function isExistHocKy_Lop_Update($Id,$hockynamhoc, $Lop)
    {
        $DanhSach_TGDGDRL = ThoiGianDanhGiaDRL::where([['hockynamhoc_id', '=', $hockynamhoc],['lop_id','=',$Lop]])->where('id', '<>', $Id)->select('hockynamhoc_id','lop_id')->get();
        if(count($DanhSach_TGDGDRL)>0)
            return true;
        return false;
    }
}
