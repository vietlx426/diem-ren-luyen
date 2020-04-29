<?php

namespace Modules\HocBong\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\HocBong;
use App\NamHoc;
use Modules\HocBong\Entities\HocBongExport;
use DB;
use Maatwebsite\Excel\Facades\Excel;
 
class ExportController extends Controller
{
    public function testExcel($id, Request $request)
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
	         		->join('lop','lop.id','=','sinhvien.lop_id')
	         		->where('lichsu_hocbong.id_hocbong',$hb->idhb)
	         		->get()
	         		->toArray();
	         		$data_array[] = array('MSSV', 'Họ tên SV','Lớp','Số tiền');
			    	foreach ($data as  $dt) 
			    	{
			    		$data_array[] = array(
				       'MSSV'  		  => $dt->mssv,
				       'Họ tên SV'    => $dt->hochulot.' '.$dt->ten,
				       'Lớp'    	  => $dt->tenlop,
				       'Số tiền'      => number_format($dt->giatri,0,',','.'),
				       
			      	);
			    	}
	        		$sheet->fromArray($data_array,null,'A1',false,false);
	        	});
        	
        	}
        	
        	
        })->export('xlsx');
    }
}
