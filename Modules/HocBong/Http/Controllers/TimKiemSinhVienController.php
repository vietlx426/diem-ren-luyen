<?php

namespace Modules\HocBong\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\SinhVien;
use App\Khoa;
use App\HocBong;
use App\TraoHocBong;
use App\HocKyNamHoc;
use App\Scholarship;
use App\LichSuHocBong;
use App\BangDiemRenLuyen;
use App\HocBongKhoa;

use DB;
class TimKiemSinhVienController extends Controller
{
    public function StudentSearch(Request $Request,$idHocKyHienChon = ''){
        //test
        $students=SinhVien::with('HocKyNamHoc:id,tenhockynamhoc','Lop:id,tenlop')
        ->leftjoin('bangdiemhoctap','bangdiemhoctap.sinhvien_id','=','sinhvien.id')
        ->leftjoin('hocky_namhoc as hknh1','hknh1.id','=','bangdiemhoctap.hockynamhoc_id')
        ->leftjoin('bangdiemrenluyen','bangdiemrenluyen.sinhvien_id','=','sinhvien.id')
        
        ->leftjoin('hocky_namhoc as hknh2','hknh2.id','=','bangdiemrenluyen.hocky_namhoc_id')
        ->where('hknh1.idtrangthaihocky','=',2)->where('hknh2.idtrangthaihocky','=',2)
        ->select('sinhvien.*','bangdiemhoctap.*','bangdiemrenluyen.sinhvien_diem as drl','sinhvien.id as idsv')
        ;
    
        
        //DHT
         if($Request->hocbong)
         {
            
            if($Request->hoctapdieukien1)
            $students->where('bangdiemhoctap.diem', $Request->hoctapdieukien1, $Request->hoctapdieukien1value);
        if($Request->hoctapdieukien1 && $Request->hoctapdieukien2)
            $students->where('bangdiemhoctap.diem', $Request->hoctapdieukien2, $Request->hoctapdieukien2value);
        
         if(!$Request->hoctapdieukien1 && $Request->hoctapdieukien2)
             $students->where('bangdiemhoctap.diem', $Request->hoctapdieukien2, $Request->hoctapdieukien2value);
        
         
            $getIDKhoa=HocBongKhoa::where('id_hocbong',$Request->hocbong)->pluck('id_khoa');
             $students->join('lop','lop.id','=','sinhvien.lop_id')
            ->join('nganh','nganh.id','=','lop.nganh_id')
            ->join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            ->join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            ->whereIn('khoa.id',$getIDKhoa);
         
        
        //DRL
         if($Request->renluyendieukien1)
            $students->where('bangdiemrenluyen.sinhvien_diem', $Request->renluyendieukien1, $Request->renluyendieukien1value);
        if($Request->renluyendieukien1 && $Request->renluyendieukien2)
            $students->where('bangdiemrenluyen.sinhvien_diem', $Request->renluyendieukien2, $Request->renluyendieukien2value);
        
         if(!$Request->renluyendieukien1 && $Request->renluyendieukien2)
             $students->where('bangdiemrenluyen.sinhvien_diem', $Request->renluyendieukien2, $Request->renluyendieukien2value);
          $students=$students->orderBy('mssv')->get();
         }

         else
         {
            $students=[];
         }
        
        


        if($Request->hocbong){
            $getTenHB=HocBong::where('id',$Request->hocbong)->first();
        }
        else
        {
            $getTenHB=null;
        }
        $scholar_history=LichSuHocBong::with('HocBong:id,tenhb')
        ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')

        ->where('hocky_namhoc.idtrangthaihocky','=',2)
        ->get();
        
        $ds_hocbong=HocBong::join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
         ->where('hocky_namhoc.idtrangthaihocky','=',2)
         ->select('*','hocbong.id as idhb')
         ->get();
        $ds_khoa = Khoa::where('loaikhoaphong_id', '=', 1)-> orderBy('tenkhoa', 'asc')->get();
        $HocKyNamHoc_HienTai = HocKyNamHoc::where('idtrangthaihocky', '=', 2)->first();
        if($idHocKyHienChon=='')
            $hocKyNamHoc_HienChon = $HocKyNamHoc_HienTai;
        else
            $hocKyNamHoc_HienChon = HocKyNamHoc::find($idHocKyHienChon);

        $viewData=[
            'students'=>$students,
            'ds_khoa'=>$ds_khoa,
            'getTenHB'=>$getTenHB,
            'scholar_history'=>$scholar_history,
            'ds_hocbong'=>$ds_hocbong,
            'hocKyNamHoc_HienChon'=>$hocKyNamHoc_HienChon
        ]; 

        return view('hocbong::admin.search',$viewData);
    }
    public function showStudent($id)
    {

    }
    public function getSinhVien(){
        return SinhVien::all();
    }
    
    
    public function getTraoHocBong($id){
        $ds_hocbong=$this->getDSHocBong();
        $test=$id;
        return view('hocbong::admin.award',compact('ds_hocbong','test'));
    }
    public function postTraoHocBong(Request $Request, $id){
        $award=new TraoHocBong;

        $award->idhocbong=$Request->idhocbong;
        $award->id_sinhvien=$Request->id_sinhvien;
        $award->giatri=$Request->giatri;
        $award->save();
    }   
    public function getDSHocBong(){
        return HocBong::all();
    }
    public function getHB(){
        return Scholarship::all();
    }
    public function category(){
        return $this->belongsTo(Scholarship::class,'id_hocbong');
    }
   
}
