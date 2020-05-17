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

class SinhVienController extends Controller
{
    public function sinhvien_index_hocbong(){
      $idSV=Auth::user()->cbgvsv_id;
      $dsHKNH = HocKyNamHocController::DanhSachHocKyNamHocCuaSinhVien($idSV);
      $dsHocBong=LichSuHocBong::join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
      ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
      ->where('lichsu_hocbong.id_sinhvien','=',$idSV)->get();
      $idLop=SinhVien::find($idSV);
      $dsThongBao=ThongBaoHocBong::join('hocbong', 'hocbong.id', '=', 'hocbong_thongbao.id_hocbong')
      ->join('hocky_namhoc','hocky_namhoc.id','hocbong.idhockynamhoc')
      ->join('hocbong_phamvi', 'hocbong_phamvi.id_hocbong', '=', 'hocbong.id')
      ->join('khoa', 'khoa.id', '=', 'hocbong_phamvi.id_khoa')
      ->join('bomon', 'bomon.idkhoa', '=', 'khoa.id')
      ->join('nganh', 'nganh.idbomon', '=', 'bomon.id')
      ->join('lop', 'lop.nganh_id', '=', 'nganh.id')
      ->where('hocky_namhoc.idtrangthaihocky',2)
      ->where('hocbong_thongbao.status','=',1)
       ->where('lop.id','=',$idLop->lop_id)
       ->select('*','hocbong_thongbao.id as idthongbao','hocbong_thongbao.created_at as ngaytao')->get();

      $viewData=[
        'dsHKNH'=>$dsHKNH,
        'dsHocBong'=>$dsHocBong,
        'dsThongBao'=>$dsThongBao,
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
    public function sinhvien_thongbao($id){
      $ThongBao=ThongBaoHocBong::where('hocbong_thongbao.id','=',$id)->first();
      $DinhKem=ThongBaoVanBan::where('hocbong_thongbao_vanban.id_thongbao','=',$id)->get();
      $author=DB::table('users')->where("id",$ThongBao->author)->first();
      $viewData=[
         'ThongBao'=>$ThongBao,
        'author'=>$author,
      'DinhKem'=>$DinhKem,

      ];
      return view('hocbong::sinhvien.thongbao',$viewData);
    }

    public function sinhvien_download($id){
      $vanban=ThongBaoVanBan::where('id',$id)->first();
    
      $path=config('app.url')."/diem-ren-luyen/images/upload/files/".$vanban->url;
      return redirect($path);
    }
}
