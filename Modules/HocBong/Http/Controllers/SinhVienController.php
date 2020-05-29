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
use App\HocBong;
use Carbon\Carbon;
use Modules\HocBong\Entities\HoSoHocBong;
use Modules\HocBong\Entities\FileHoSoHocBong;
use Redirect;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;


use App\NamHoc;
use DB;
use Storage;

class SinhVienController extends Controller

{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function sinhvien_index_hocbong(){
      $idSV=Auth::user()->cbgvsv_id;
      $dsHKNH = HocKyNamHocController::DanhSachHocKyNamHocCuaSinhVien($idSV);
      $dsHoSo = HoSoHocBong::where('id_sinhvien',$idSV)->get();
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
       
       ->select('*','hocbong_thongbao.id as idthongbao','hocbong_thongbao.created_at as ngaytao')->orderBy('hocbong_thongbao.id','desc')->get();

      $viewData=[
        'dsHoSo'=>$dsHoSo,
        'dsHKNH'=>$dsHKNH,
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
      $FileDinhKem=ThongBaoVanBan::where('hocbong_thongbao_vanban.id_thongbao','=',$id)->get();
      $author=DB::table('users')->where("id",$ThongBao->author)->first();
      $viewData=[

         'ThongBao'=>$ThongBao,
        'author'=>$author,
      'FileDinhKem'=>$FileDinhKem,

      ];
      return view('hocbong::sinhvien.thongbao',$viewData);
    }
    public function postNopHS(Request $request){
      $input_data = $request->all();

      $validator = Validator::make(
        $input_data, [
        'DinhKem.*' => 'required|mimes:doc,docx,pdf'
        ],[
            'DinhKem.*.required' => 'Vui lòng chọn file đính kèm',
            'DinhKem.*.mimes' => 'Chỉ chấp nhận file pdf, doc, docx',
        ]
    );
    if($request->DinhKem === null){
      return redirect()->back()->with('message', 'Vui lòng chọn file đính kèm'); 
    }
    if ($validator->fails()) {
      // dd($validator->errors()->first());
      $message = $validator->errors()->first();
      return redirect()->back()->with('message', $message);

    }



      
         
        
      
      $idSV=Auth::user()->cbgvsv_id;
      $sinhvien = SinhVien::where('id',$idSV)->first();
      $getHocBong = HocBong::where('id',$request->MaHocBong)->first();
      try {
        $hoso = new HoSoHocBong();
        $hoso->id_hocbong=$request->MaHocBong; 
        $hoso->id_sinhvien=$idSV;
        $hoso->status=0;
        $hoso->created_at=Carbon::now();
        $hoso->save();
        $index = 0;
       
        foreach ($request->DinhKem as $key => $url) {
               if($url !== null)
               {
            

                $file = new FileHoSoHocBong;
                $file->id_hoso=$hoso->id;
                $get_name_file = $url->getClientOriginalName();
                $mssv = $sinhvien->mssv;
                $name_file = current(explode('.',$get_name_file));
                $new_file =  $name_file.' '.$mssv.'.'.$url->getClientOriginalExtension();
                $name_new_file = str_replace(' ', '%20', $new_file);
                $file->url = $name_new_file;
                $tenhocky = $getHocBong->HocKyNamHoc->tenhockynamhoc;
                $root = 'Modules/HocBong/uploads/hoso/';
                $folder_upload = $root.'/'.$tenhocky.'/'.$getHocBong->mahb.'/'.$sinhvien->mssv;
                $url->move($folder_upload,$new_file);
                $file->save();
                $index++;
               }
        }
        
        
        
        return redirect()->back()->with('success', "Nộp hồ sơ thành công!");
        } catch (Exception $e) {
            return redirect()->back()->with('alert','Đã có lỗi xảy ra');
        }
    }

    public function sinhvien_download($id){
      $vanban=ThongBaoVanBan::where('id',$id)->first();
    
      $path=config('app.url')."/diem-ren-luyen/images/upload/files/".$vanban->url;
      return redirect($path);
    }
    public function ketquahocbongall(){
      $idSV=Auth::user()->cbgvsv_id;
      $dsHKNH = HocKyNamHocController::DanhSachHocKyNamHocCuaSinhVien($idSV);

      $dsHocBong=LichSuHocBong::join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
      ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
      ->where('lichsu_hocbong.id_sinhvien','=',$idSV)->get();
      $viewData=[
        'dsHKNH' => $dsHKNH,
        'dsHocBong' => $dsHocBong,
      ];
      return view('hocbong::sinhvien.ketquahocbong_all',$viewData);
    }

}
