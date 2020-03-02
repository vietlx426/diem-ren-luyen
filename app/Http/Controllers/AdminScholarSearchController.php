<?php

namespace App\Http\Controllers;
use App\SinhVien;
use App\Khoa;
use App\HocBong;
use App\TraoHocBong;
use App\HocKyNamHoc;
use App\Scholarship;
use App\LichSuHocBong;
use Illuminate\Http\Request;
use DB;

class AdminScholarSearchController extends Controller
{
    public function StudentSearch(Request $Request,$idHocKyHienChon = ''){

    	$students=SinhVien::with('HocKyNamHoc:id,tenhockynamhoc','Lop:id,tenlop')
    	->leftjoin('bangdiemhoctap','bangdiemhoctap.sinhvien_id','=','sinhvien.id')
        ->leftjoin('bangdiemrenluyen','bangdiemrenluyen.sinhvien_id','=','sinhvien.id')
        ->leftjoin('hocky_namhoc','hocky_namhoc.id','=','bangdiemhoctap.hockynamhoc_id')
        // ->leftjoin('lichsu_hocbong','lichsu_hocbong.id_sinhvien','=','sinhvien.id')
        ->where('hocky_namhoc.idtrangthaihocky','=',2)

    	->select('sinhvien.*','bangdiemhoctap.*','bangdiemrenluyen.sinhvien_diem','sinhvien.id as idsv');
       
        // if($Request->lop) $students->where('lop_id',$Request->lop);
        //DHT
        if($Request->diemnhohon) $students->where('bangdiemhoctap.diem','<=',$Request->diemnhohon);
        if($Request->diemtrong1) $students->whereBetween('bangdiemhoctap.diem',[$Request->diemtrong1,$Request->diemtrong2]);
        if($Request->diemtren) $students->where('bangdiemhoctap.diem','>=',$Request->diemtren);
        //DRL
        if($Request->diemrlnhohon) $students->where('bangdiemrenluyen.sinhvien_diem','<=',$Request->diemrlnhohon);
        if($Request->diemrltrong1) $students->whereBetween('bangdiemrenluyen.sinhvien_diem',[$Request->diemrltrong1,$Request->diemrltrong2]);
        if($Request->diemrltren) $students->where('bangdiemrenluyen.sinhvien_diem','>=',$Request->diemrltren);



     	$students=$students->take(100)->get();
        $scholar_history=LichSuHocBong::with('HocBong:id,tenhb')
        ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')

        ->where('hocky_namhoc.idtrangthaihocky','=',2)
        ->get();
        $ds_khoa=$this->getKhoa();

        $DanhSach_Khoa = Khoa::where('loaikhoaphong_id', '=', 1)-> orderBy('tenkhoa', 'asc')->get();
        $HocKyNamHoc_HienTai = HocKyNamHoc::where('idtrangthaihocky', '=', 2)->first();
        if($idHocKyHienChon=='')
            $hocKyNamHoc_HienChon = $HocKyNamHoc_HienTai;
        else
            $hocKyNamHoc_HienChon = HocKyNamHoc::find($idHocKyHienChon);
        $viewData=[
            'students'=>$students,
            'ds_khoa'=>$ds_khoa,
            'DanhSach_Khoa'=>$DanhSach_Khoa,
            'scholar_history'=>$scholar_history,
            'hocKyNamHoc_HienChon'=>$hocKyNamHoc_HienChon
        ]; 

    	return view('admin.hocbong.search',$viewData);
    }
    public function getSinhVien(){
        return SinhVien::all();
    }
    public function getKhoa(){
        return Khoa::where('loaikhoaphong_id','=',1)->get();;
    }
    public function getBoMon($id)
    {        
        $bomon = DB::table("bomon")->where("idkhoa",$id)->pluck("tenbomon","id");
        return json_encode($bomon);
    }
    public function getNganh($id) 
    {        
        $nganh = DB::table("nganh")->where("idbomon",$id)->pluck("tennganh","id");
        return json_encode($nganh);
    }
    public function getLop($id) 
    {        
        $lop = DB::table("lop")->where("nganh_id",$id)->pluck("tenlop","id");
        return json_encode($lop);
    }
    public function getTraoHocBong($id){
        $ds_hocbong=$this->getDSHocBong();
        $test=$id;
        return view('admin.hocbong.award',compact('ds_hocbong','test'));
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
