<?php

namespace Modules\HocBong\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\HocBong;
use App\NamHoc;
use App\Lop;
use App\Khoa;
use App\HocKyNamHoc;
use Carbon\Carbon;
use Modules\HocBong\Entities\HocBongExport;
use DB;
use Maatwebsite\Excel\Facades\Excel;
 
class ExportController extends Controller
{
    public function xuatExcel($id, Request $request)
    {
    	
    	

    	$HocBong=HocBong::join('hocky_namhoc','hocky_namhoc.id','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.idnamhoc',$id)->select('tenhb','hocbong.id as idhb')->get();
        
        $title=NamHoc::where('id',$id)->first();
         Excel::create('Thống kê học bổng năm học '.$title->tennamhoc, function($excel) use($HocBong) {

         	foreach ($HocBong as $key => $hb) 
         	{
         		
         		


	        	$excel->setTitle('Danh sách sinh viên nhận học bổng');
	        	$excel->sheet($hb->tenhb,function($sheet) use($hb) {

	         		$data= DB::table('lichsu_hocbong')
	         		->join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
	         		->join('bangdiemhoctap','bangdiemhoctap.sinhvien_id','=','sinhvien.id')
	         		->join('bangdiemrenluyen','bangdiemrenluyen.sinhvien_id','=','sinhvien.id')
	         		->join('lop','lop.id','=','sinhvien.lop_id')
	         		->where('lichsu_hocbong.id_hocbong',$hb->idhb)
	         		->select('*','bangdiemhoctap.diem as diemht','bangdiemrenluyen.diem as drl')
	         		->groupBy('sinhvien.id')
	         		->get()
	         		->toArray();
	         		$data_array[] = array('MSSV', 'Họ tên SV','Lớp','Điểm học tập','Điểm rèn luyện','Số tiền');
			    	foreach ($data as  $dt) 
			    	{
			    		$data_array[] = array(
				       'MSSV'  		  => $dt->mssv,
				       'Họ tên sinh viên'    => $dt->hochulot.' '.$dt->ten,
				       'Lớp'    	  => $dt->tenlop,
				       'Điểm học tập'    	  => $dt->diemht,
				       'Điểm rèn luyện'    	  => $dt->drl,
				       'Số tiền'      => number_format($dt->giatri,0,',','.'),
				       
			      	);
			    	}
	        		$sheet->fromArray($data_array,null,'A1',false,false);
	        	});
        	
        	}
        	
        	
        })->export('xlsx');
    }
    public function xuatExcelByHocKy($id, Request $request)
    {
    	
    	$HocBong=HocBong::join('hocky_namhoc','hocky_namhoc.id','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.id',$id)->select('tenhb','hocbong.id as idhb')->get();
        
        $title=HocKyNamHoc::where('id',$id)->first();
         Excel::create('Thống kê học bổng '.$title->tenhockynamhoc, function($excel) use($HocBong) {

         	foreach ($HocBong as $key => $hb) 
         	{
         		
         		


	        	$excel->setTitle('Danh sách sinh viên nhận học bổng');
	        	$excel->sheet($hb->tenhb,function($sheet) use($hb) {

	         		$data= DB::table('lichsu_hocbong')
	         		->join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
	         		->join('bangdiemhoctap','bangdiemhoctap.sinhvien_id','=','sinhvien.id')
	         		->join('bangdiemrenluyen','bangdiemrenluyen.sinhvien_id','=','sinhvien.id')
	         		->join('lop','lop.id','=','sinhvien.lop_id')
	         		->where('lichsu_hocbong.id_hocbong',$hb->idhb)
	         		->select('*','bangdiemhoctap.diem as diemht','bangdiemrenluyen.diem as drl')
	         		->groupBy('sinhvien.id')
	         		->get()
	         		->toArray();
	         		$data_array[] = array('MSSV', 'Họ tên SV','Lớp','Điểm học tập','Điểm rèn luyện','Số tiền');
			    	foreach ($data as  $dt) 
			    	{
			    		$data_array[] = array(
				       'MSSV'  		  => $dt->mssv,
				       'Họ tên sinh viên'    => $dt->hochulot.' '.$dt->ten,
				       'Lớp'    	  => $dt->tenlop,
				       'Điểm học tập'    	  => $dt->diemht,
				       'Điểm rèn luyện'    	  => $dt->drl,
				       'Số tiền'      => number_format($dt->giatri,0,',','.'),
				       
			      	);
			    	}
	        		$sheet->fromArray($data_array,null,'A1',false,false);
	        	});
        	
        	}
        	
        	
        })->export('xlsx');
    }
    public function xuatExcelByKhoaByNamhoc($id,$idnamhoc)
    {
    	$hknh = HocKyNamHoc::where('idnamhoc',$idnamhoc)->first();
    	$khoa = self::getKhoa($id);
    	$dsLop=self::getDsLop($id);
    	Excel::create('Thống kê học bổng khoa '.$khoa->tenkhoa.' '.$hknh->namhoc->tennamhoc, function($excel) use($dsLop,$idnamhoc) {

         	foreach ($dsLop as $key => $lop) 
         	{
         		

	        	$excel->setTitle('Danh sách sinh viên nhận học bổng');
	        	$excel->sheet($lop->tenlop,function($sheet) use($lop,$idnamhoc) {

	         		$data= DB::table('lichsu_hocbong')
	         		->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
	         		->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
	         		->join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
	         		->join('bangdiemhoctap','bangdiemhoctap.sinhvien_id','=','sinhvien.id')
	         		->join('bangdiemrenluyen','bangdiemrenluyen.sinhvien_id','=','sinhvien.id')
	         		->join('lop','lop.id','=','sinhvien.lop_id')
	         		->where('lop.id',$lop->id)
	         		->where('hocky_namhoc.idnamhoc',$idnamhoc)
	         		->select('*','bangdiemhoctap.diem as diemht','bangdiemrenluyen.diem as drl')
	         		->groupBy('sinhvien.id')
	         		->get()
	         		->toArray();
	         		$data_array[] = array('MSSV', 'Họ tên SV','Lớp','Điểm học tập','Điểm rèn luyện','Số tiền');
			    	foreach ($data as  $dt) 
			    	{
			    		$data_array[] = array(
				       'MSSV'  		  => $dt->mssv,
				       'Họ tên sinh viên'    => $dt->hochulot.' '.$dt->ten,
				       'Lớp'    	  => $dt->tenlop,
				       'Điểm học tập'    	  => $dt->diemht,
				       'Điểm rèn luyện'    	  => $dt->drl,
				       'Số tiền'      => number_format($dt->giatri,0,',','.'),
				       
			      	);
			    	}
	        		$sheet->fromArray($data_array,null,'A1',false,false);
	        	});
        	
        	}
        	
        	
        })->export('xlsx');
    }
    public function xuatExcelByKhoaByHocKy($id,$idhk)
    {	
    	$hknh = HocKyNamHoc::where('id',$idhk)->first();
    	$khoa = self::getKhoa($id);
    	$dsLop=self::getDsLop($id);
    	Excel::create('Thống kê khoa '.$khoa->tenkhoa.' '.$hknh->tenhockynamhoc, function($excel) use($dsLop,$idhk) {

         	foreach ($dsLop as $key => $lop) 
         	{
         		

	        	$excel->setTitle('Danh sách sinh viên nhận học bổng');
	        	$excel->sheet($lop->tenlop,function($sheet) use($lop,$idhk) {

	         		$data= DB::table('lichsu_hocbong')
	         		->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
	         		->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')	         		
	         		->join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
	         		->join('bangdiemhoctap','bangdiemhoctap.sinhvien_id','=','sinhvien.id')
	         		->join('bangdiemrenluyen','bangdiemrenluyen.sinhvien_id','=','sinhvien.id')
	         		->join('lop','lop.id','=','sinhvien.lop_id')
	         		->where('lop.id',$lop->id)
	         		->where('hocky_namhoc.id',$idhk)
	         		->select('*','bangdiemhoctap.diem as diemht','bangdiemrenluyen.diem as drl')
	         		->groupBy('sinhvien.id')
	         		->get()
	         		->toArray();
	         		$data_array[] = array('MSSV', 'Họ tên SV','Lớp','Điểm học tập','Điểm rèn luyện','Số tiền');
			    	foreach ($data as  $dt) 
			    	{
			    		$data_array[] = array(
				       'MSSV'  		  => $dt->mssv,
				       'Họ tên sinh viên'    => $dt->hochulot.' '.$dt->ten,
				       'Lớp'    	  => $dt->tenlop,
				       'Điểm học tập'    	  => $dt->diemht,
				       'Điểm rèn luyện'    	  => $dt->drl,
				       'Số tiền'      => number_format($dt->giatri,0,',','.'),
				       
			      	);
			    	}
	        		$sheet->fromArray($data_array,null,'A1',false,false);
	        	});
        	
        	}
        	
        	
        })->export('xlsx');
    }
    public function getKhoa($id)
    {
    	return Khoa::where('id',$id)->first();
    }

    public function getDsLop($id)
    {
    	return Lop::join('nganh','nganh.id','=','lop.nganh_id')
        ->join('bomon','bomon.id','=','nganh.idbomon')
        ->join('khoa','khoa.id','=','bomon.idkhoa')
         ->where('khoa.id','=',$id)->orderBy('lop.tenlop')
         ->select('nganh.*','bomon.*','khoa.*','lop.*','lop.id as lopid')
         ->get();
    }
}
