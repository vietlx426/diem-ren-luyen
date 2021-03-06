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
use App\GiaoVuKhoa;
use Maatwebsite\Excel\Facades\Excel;

use DB;
class GiaoVuKhoaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $Request)
    {
        $idGVK=Auth::user()->cbgvsv_id;
      $dsLop = GiaoVuKhoa::where('cbgv_id', '=', $idGVK)
            -> where('trangthai_id', '=', 1)
            -> join('bomon', 'bomon.idkhoa', '=', 'giaovukhoa.khoa_id')
            -> join('nganh', 'nganh.idbomon', '=', 'bomon.id')
            -> join('lop', 'lop.nganh_id', '=', 'nganh.id')
            -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date('Y'))
            -> select('lop.*')
            -> orderBy('lop.tenlop', 'asc')
            -> get();
      $idKhoa=GiaoVuKhoa::where('cbgv_id',$idGVK)->where('trangthai_id',1)->first();
      $ds_hknh=HocKyNamHoc::all();
      $ThongBao=ThongBaoHocBong::join('hocbong', 'hocbong.id', '=', 'hocbong_thongbao.id_hocbong')
      ->join('hocky_namhoc','hocky_namhoc.id','hocbong.idhockynamhoc')
      ->join('hocbong_phamvi', 'hocbong_phamvi.id_hocbong', '=', 'hocbong.id')
      ->join('khoa', 'khoa.id', '=', 'hocbong_phamvi.id_khoa')
      ->where('hocky_namhoc.idtrangthaihocky',2)
      ->where('hocbong_thongbao.status','=',1)
       ->where('khoa.id','=',$idKhoa->khoa_id)
       ->orderBy('hocbong_thongbao.id','desc')
       ->select('*','hocbong_thongbao.id as idthongbao','hocbong_thongbao.created_at as ngaytao')->get();
       $getHKNH='';
       if($Request->hknh){
        $getHKNH=HocKyNamHoc::where('id',$Request->hknh)->first();
      }
      else {
         $getHKNH=HocKyNamHoc::where('idtrangthaihocky',2)->first();
      }
      return view('hocbong::giaovukhoa.index',compact('dsLop','ThongBao','ds_hknh','getHKNH'));
    }

    

    public function giaovukhoa_hocbong_sinhvien($id,$idhk,Request $Request){
      $dsSinhVien = SinhVien::where('lop_id', '=',$id)
      ->join('lichsu_hocbong','lichsu_hocbong.id_sinhvien','=','sinhvien.id')
      ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
      ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
      ->where('idhockynamhoc',$idhk);
      // $getHKNH='';
      // if($Request->hknh){
      //   $dsSinhVien->where('idhockynamhoc',$Request->hknh);
      //   $getHKNH=HocKyNamHoc::where('id',$Request->hknh)->first();
      // }
      // else {
      //   $dsSinhVien->where('idtrangthaihocky',2);
      //    $getHKNH=HocKyNamHoc::where('idtrangthaihocky',2)->first();
      // }
      $dsSinhVien=$dsSinhVien->orderBy('ten','asc')->select('*','sinhvien.id as idsv')->groupBy('idsv')->get();

      $ds_hknh=HocKyNamHoc::all();

      $viewData=[
         'dsSinhVien'=>$dsSinhVien,
        'ds_hknh'=>$ds_hknh,
      

      ];

      return view('hocbong::giaovukhoa.student_scholarship',$viewData);
    }
    public function giaovukhoa_hocbong_lichsu($id){
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

      return view('hocbong::giaovukhoa.student_scholarship_history',compact('history','count','idsinhvien','getHB'));
    }
    public function giaovukhoa_thongbao($id){
      $ThongBao=ThongBaoHocBong::where('hocbong_thongbao.id','=',$id)->first();
      $DinhKem=ThongBaoVanBan::where('hocbong_thongbao_vanban.id_thongbao','=',$id)->get();
      $author=DB::table('users')->where("id",$ThongBao->author)->first();
      $viewData=[
         'ThongBao'=>$ThongBao,
        'author'=>$author,
      'DinhKem'=>$DinhKem,

      ];
      return view('hocbong::giaovukhoa.thongbao',$viewData);
    }
    public function giaovukhoa_download($id){
      $vanban=ThongBaoVanBan::where('id',$id)->first();
    
      $path=config('app.url')."/diem-ren-luyen/images/upload/files/".$vanban->url;
      return redirect($path);
    }
    public function giaovukhoa_download_excel($idhk){
      $idGVK=Auth::user()->cbgvsv_id;
      $dsLop = GiaoVuKhoa::where('cbgv_id', '=', $idGVK)
            -> where('trangthai_id', '=', 1)
            -> join('bomon', 'bomon.idkhoa', '=', 'giaovukhoa.khoa_id')
            -> join('nganh', 'nganh.idbomon', '=', 'bomon.id')
            -> join('lop', 'lop.nganh_id', '=', 'nganh.id')
            -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date('Y'))
            -> select('*','lop.id as idlop')
            -> get();
        $getHKNH = HocKyNamHoc::find($idhk);
         Excel::create('Thống kê học bổng '.$getHKNH->tenhockynamhoc, function($excel) use($dsLop,$idhk) {

         	foreach ($dsLop as $key => $lop) 
         	{
	          $excel->setTitle('Danh sách sinh viên nhận học bổng');
	        	$excel->sheet($lop->tenlop,function($sheet) use($lop,$idhk) {

	         		$data= DB::table('lichsu_hocbong')
	         		->join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
	         		->join('bangdiemhoctap','bangdiemhoctap.sinhvien_id','=','sinhvien.id')
               ->join('bangdiemrenluyen','bangdiemrenluyen.sinhvien_id','=','sinhvien.id')
               ->where('bangdiemhoctap.hockynamhoc_id',$idhk)
              ->where('bangdiemrenluyen.hocky_namhoc_id',$idhk)
	         		->join('lop','lop.id','=','sinhvien.lop_id')
	         		->where('lop.id',$lop->idlop)
	         		->select('*','bangdiemhoctap.diem as diemht','bangdiemrenluyen.diem as drl', DB::raw('SUM(giatri) AS sum'))
	         		->groupBy('sinhvien.id')
	         		->get()
               ->toArray();
	         		$data_array[] = array('MSSV', 'Họ tên SV','Lớp','Điểm học tập','Điểm rèn luyện','Học bổng','Số tiền');
			    	foreach ($data as  $dt) 
			    	{
              $dshb = LichSuHocBong::where('id_sinhvien',$dt->id_sinhvien)
           ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
           ->where('hocbong.idhockynamhoc',$idhk)
           ->pluck('tenhb')->toArray();
			    		$data_array[] = array(
				       'MSSV'  		  => $dt->mssv,
				       'Họ tên sinh viên'    => $dt->hochulot.' '.$dt->ten,
				       'Lớp'    	  => $dt->tenlop,
				       'Điểm học tập'    	  => $dt->diemht,
               'Điểm rèn luyện'    	  => $dt->drl,
               'Học bổng'    	  => implode('. ',$dshb),
				       'Số tiền'      => number_format($dt->sum,0,',','.'),
				       
			      	);
			    	}
	        		$sheet->fromArray($data_array,null,'A1',false,false);
	        	});
        	
        	}
        	
        	
        })->export('xlsx'); 
    }
}
