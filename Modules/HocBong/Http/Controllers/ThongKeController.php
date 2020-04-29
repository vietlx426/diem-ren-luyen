<?php

namespace Modules\HocBong\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use App\Http\Controllers\HocKyNamHocController;
use App\ThongBaoHocBong;
use App\ThongBaoVanBan;
use App\Scholarship;
use App\HocKyNamHoc;
use App\LichSuHocBong;
use App\HocBongKhoa;
use App\CoVanHocTap;
use App\Khoa;
use App\SinhVien;
use App\GiaoVuKhoa;
use App\Lop;
use App\NamHoc;
use DB;
use Storage;
class ThongKeController extends Controller
{
    
    
    public function faculty($id,$idnamhoc){
        
        $tenkhoa=Khoa::where('id',$id)->first();
        $getNamHoc=NamHoc::find($idnamhoc);
        $soluong_hb=Scholarship::join('hocbong_phamvi','hocbong_phamvi.id_hocbong','=','hocbong.id')
        ->join('khoa','khoa.id','=','hocbong_phamvi.id_khoa')
        ->where('khoa.id','=',$id)
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.idnamhoc','=',$idnamhoc)
        ->get();

       

        $sl_HBdatrao=LichSuHocBong::join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
        ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
         ->where('hocky_namhoc.idnamhoc','=',$idnamhoc)
        ->join('lop','lop.id','=','sinhvien.lop_id')
        ->join('nganh','nganh.id','=','lop.nganh_id')
        ->join('bomon','bomon.id','=','nganh.idbomon')
        ->join('khoa','khoa.id','=','bomon.idkhoa')
        ->where('khoa.id','=',$id)
         ->select('lichsu_hocbong.*','lop.*','nganh.*','bomon.*','khoa.*','khoa.id as idk')
        ->get();

     


        $ds_lop=Lop::join('nganh','nganh.id','=','lop.nganh_id')
        ->join('bomon','bomon.id','=','nganh.idbomon')
        ->join('khoa','khoa.id','=','bomon.idkhoa')
         ->where('khoa.id','=',$id)->orderBy('lop.tenlop')
         ->select('nganh.*','bomon.*','khoa.*','lop.*','lop.id as lopid')
         ->get();

         $sl_SVlop=LichSuHocBong::join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
         ->join('lop','lop.id','=','sinhvien.lop_id')
         ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
         ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.idnamhoc','=',$idnamhoc)
         ->get();



        $viewData=[
            'tenkhoa'=>$tenkhoa,
            'soluong_hb'=>$soluong_hb,
            
            'sl_HBdatrao'=>$sl_HBdatrao,
            'getNamHoc'=>$getNamHoc,
            'ds_lop'=>$ds_lop,
            'sl_SVlop'=>$sl_SVlop,
        ];
        return view('hocbong::admin.statistic_faculty',$viewData);
    }
    public function facultySemester($id,$idhknh){
        $tenkhoa=Khoa::where('id',$id)->first();
        $getHKNH=HocKyNamHoc::find($idhknh);
         $soluong_hb=Scholarship::join('hocbong_phamvi','hocbong_phamvi.id_hocbong','=','hocbong.id')
        ->join('khoa','khoa.id','=','hocbong_phamvi.id_khoa')
        ->where('khoa.id','=',$id)
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.id','=',$idhknh)
        ->get();

        $sl_HBdatrao=LichSuHocBong::join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
        ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
         ->where('hocky_namhoc.id','=',$idhknh)
        ->join('lop','lop.id','=','sinhvien.lop_id')
        ->join('nganh','nganh.id','=','lop.nganh_id')
        ->join('bomon','bomon.id','=','nganh.idbomon')
        ->join('khoa','khoa.id','=','bomon.idkhoa')
        ->where('khoa.id','=',$id)
         ->select('lichsu_hocbong.*','lop.*','nganh.*','bomon.*','khoa.*','khoa.id as idk')
        ->get();
        $ds_lop=Lop::join('nganh','nganh.id','=','lop.nganh_id')
        ->join('bomon','bomon.id','=','nganh.idbomon')
        ->join('khoa','khoa.id','=','bomon.idkhoa')
         ->where('khoa.id','=',$id)->orderBy('lop.tenlop')
         ->select('nganh.*','bomon.*','khoa.*','lop.*','lop.id as lopid')
         ->get();

         $sl_SVlop=LichSuHocBong::join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
         ->join('lop','lop.id','=','sinhvien.lop_id')
         ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
         ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
       ->where('hocky_namhoc.id','=',$idhknh)
         ->get();


        $viewData=[
            'tenkhoa'=>$tenkhoa,
            'soluong_hb'=>$soluong_hb,
            
            'sl_HBdatrao'=>$sl_HBdatrao,
            'getHKNH'=>$getHKNH,
            'ds_lop'=>$ds_lop,
            'sl_SVlop'=>$sl_SVlop,
        ];
        return view('hocbong::admin.statistic_faculty',$viewData);
    }
    
    public function class($id,$idnamhoc){
        $tenlop=Lop::where('id',$id)->first();

         $soluong_hb=LichSuHocBong::join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
         ->join('lop','lop.id','=','sinhvien.lop_id')
        ->where('lop.id','=',$id)
        ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.idnamhoc','=',$idnamhoc)
        ->get();

        $dssv=SinhVien::where('lop_id',$id)
        ->join('lichsu_hocbong','lichsu_hocbong.id_sinhvien','=','sinhvien.id')
        ->groupBy('sinhvien.id')
        ->get();
        $dshb=LichSuHocBong::all();


        



        $viewData=[
            'tenlop'=>$tenlop,
            'dssv'=>$dssv,
            'dshb'=>$dshb,
            'soluong_hb'=>$soluong_hb,
            

        ];
        return view('hocbong::admin.statistic_class',$viewData);
    }
    public function classSemester($id,$idhknh){
        $tenlop=Lop::where('id',$id)->first();

         $soluong_hb=LichSuHocBong::join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
         ->join('lop','lop.id','=','sinhvien.lop_id')
        ->where('lop.id','=',$id)
        ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.id','=',$idhknh)
        ->get();


        



        $viewData=[
            'tenlop'=>$tenlop,
            'soluong_hb'=>$soluong_hb,
            

        ];
        return view('hocbong::admin.statistic_class',$viewData);
    }

    
    public function sinhvien_index_hocbong(){
      $idSV=Auth::user()->cbgvsv_id;
      $dsHKNH = HocKyNamHocController::DanhSachHocKyNamHocCuaSinhVien($idSV);
      $dsHocBong=LichSuHocBong::join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
      ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
      ->where('lichsu_hocbong.id_sinhvien','=',$idSV)->get();

      $viewData=[
        'dsHKNH'=>$dsHKNH,
        'dsHocBong'=>$dsHocBong,
      ];
      return view('hocbong::sinhvien.index',$viewData);
    }
    
    public function sinhvien_chitiet($idhocky){
      $idSV=Auth::user()->cbgvsv_id;
      $dsHocBong=LichSuHocBong::join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
      ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
      ->where('hocky_namhoc.id','=',$idhocky)
      ->where('lichsu_hocbong.id_sinhvien','=',$idSV)
      ->get();
      $getHKNH=HocKyNamHoc::find($idhocky);

      $viewData=[
        'getHKNH'=>$getHKNH,
        'dsHocBong'=>$dsHocBong,
      ];
      return view('hocbong::sinhvien.hocbong_chitiet',$viewData);
    }
   
    
    
    


    

}
