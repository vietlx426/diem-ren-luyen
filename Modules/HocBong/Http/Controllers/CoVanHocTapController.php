<?php

namespace Modules\HocBong\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use App\CoVanHocTap;
use App\SinhVien;
use App\HocKyNamHoc;
use App\ThongBaoHocBong;
use App\ThongBaoVanBan;
use App\LichSuHocBong;

use DB;

class CoVanHocTapController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $Request)
    {
        $idCVHT=Auth::user()->cbgvsv_id;
      $CVHT = CoVanHocTap::where('canbogiangvien_id', '=', $idCVHT)
            -> where('trangthai_id', '=', 1)
            -> first();
       $dsSinhVien = SinhVien::where('lop_id', '=', $CVHT->lop_id)
      ->join('lichsu_hocbong','lichsu_hocbong.id_sinhvien','=','sinhvien.id')
      ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
      ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc');
      $getHKNH='';
      if($Request->hknh){
        $dsSinhVien->where('idhockynamhoc',$Request->hknh);
        $getHKNH=HocKyNamHoc::where('id',$Request->hknh)->first();
      }
      else {
        $dsSinhVien->where('idtrangthaihocky',2);
         $getHKNH=HocKyNamHoc::where('idtrangthaihocky',2)->first();
      }
      $dsSinhVien=$dsSinhVien->orderBy('ten','asc')
      ->select('*','sinhvien.id as idsv')
      ->groupBy('idsv')
      ->get();

      $ThongBao=ThongBaoHocBong::join('hocbong', 'hocbong.id', '=', 'hocbong_thongbao.id_hocbong')
      ->join('hocky_namhoc','hocky_namhoc.id','hocbong.idhockynamhoc')
      ->join('hocbong_phamvi', 'hocbong_phamvi.id_hocbong', '=', 'hocbong.id')
      ->join('khoa', 'khoa.id', '=', 'hocbong_phamvi.id_khoa')
      ->join('bomon', 'bomon.idkhoa', '=', 'khoa.id')
      ->join('nganh', 'nganh.idbomon', '=', 'bomon.id')
      ->join('lop', 'lop.nganh_id', '=', 'nganh.id')
      ->where('hocky_namhoc.idtrangthaihocky',2)
      ->where('hocbong_thongbao.status','=',1)
       ->where('lop.id','=',$CVHT->lop_id)
       ->select('*','hocbong_thongbao.id as idthongbao')->get();

      

      
      $ds_hknh=HocKyNamHoc::all();

      $viewData=[
        'ds_hknh'=>$ds_hknh,
        'dsSinhVien'=>$dsSinhVien,
        'getHKNH'=>$getHKNH,
        'ThongBao'=>$ThongBao,

      ];
        return view('hocbong::covanhoctap.index',$viewData);
    }

    public function covanhoctap_thongbao($id){
      $ThongBao=ThongBaoHocBong::where('hocbong_thongbao.id','=',$id)->first();
      $DinhKem=ThongBaoVanBan::where('hocbong_thongbao_vanban.id_thongbao','=',$id)->get();
      $author=DB::table('users')->where("id",$ThongBao->author)->first();
      $viewData=[
         'ThongBao'=>$ThongBao,
        'author'=>$author,
      'DinhKem'=>$DinhKem,

      ];
      return view('hocbong::covanhoctap.thongbao',$viewData);
    }
    public function covanhoctap_hocbong_lichsu($id){
        $idsinhvien = SinhVien::where("id",$id)->first();

        $history=LichSuHocBong::where('lichsu_hocbong.id_sinhvien', '=', $id)
        ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->select('lichsu_hocbong.*','hocky_namhoc.*','hocbong.*','lichsu_hocbong.id as idlshb')
        ->orderBy('hocky_namhoc.id','desc')
        ->groupBy('hocky_namhoc.id')
        ->get();
        $getHB=LichSuHocBong::join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->select('*','lichsu_hocbong.id as idlshb')
        ->get();
        $count = LichSuHocBong::where('id_sinhvien',$id)->get();

      return view('hocbong::covanhoctap.student_scholarship_history',compact('history','count','idsinhvien','getHB'));
    }
    public function covanhoctap_download($id){
      $vanban=ThongBaoVanBan::where('id',$id)->first();
    
      $path=config('app.url')."/diem-ren-luyen/images/upload/files/".$vanban->url;
      return redirect($path);
    }
   

}
