<?php

namespace Modules\HocBong\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\HocBong;
use App\TraoHocBong;
use Session;
use App\Http\Requests\RequestAwardScholarship;
use Illuminate\Support\Facades\Input;
use App\LichSuHocBong;
use App\SinhVien;
use DB;
use App\Page;

class TraoHocBongController extends Controller
{
    public function create(Request $Request,$id){
        
        
    
        
        $infoSinhvien = SinhVien::find($id);

        $ds_hocbong=SinhVien::where('sinhvien.id','=',$id)
        ->join('lop','lop.id','=','sinhvien.lop_id')
        ->join('nganh','nganh.id','=','lop.nganh_id')
        ->join('bomon','bomon.id','=','nganh.idbomon')
        ->join('khoa','khoa.id','=','bomon.idkhoa')
        ->join('hocbong_phamvi','hocbong_phamvi.id_khoa','=','khoa.id')
        ->join('hocbong','hocbong.id','=','hocbong_phamvi.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
         ->where('hocky_namhoc.idtrangthaihocky','=',2)
        ->select('sinhvien.*','lop.*','nganh.*','bomon.*','khoa.*','hocbong.*','hocky_namhoc.*','hocbong.id as idhb')
        ->get();
        return view('hocbong::award',compact('ds_hocbong','infoSinhvien'));
    }
    public function store(RequestAwardScholarship $Request){
        $budget=HocBong::where('hocbong.id','=',$Request->id_hocbong)->first();
        $budget_recent=LichSuHocBong::where('lichsu_hocbong.id_hocbong','=',$Request->id_hocbong)->sum('giatri');
        $info_student=SinhVien::where('id','=',$Request->id_sinhvien)->first();

        


        $check=LichSuHocBong::where('lichsu_hocbong.id_hocbong','=',$Request->id_hocbong)
        ->where('lichsu_hocbong.id_sinhvien','=',$Request->id_sinhvien)->first();
        if($Request->giatri <= (($budget->gthb) - $budget_recent)){
            if(!$check)
            {
               try {
                    $award=new TraoHocBong;

                $award->id_hocbong=$Request->id_hocbong;
                $award->id_sinhvien=$Request->id_sinhvien;

                $award->giatri=$Request->giatri;
                
                $award->save();
                return redirect()->route('hocbong.timkiem.sinhvien')->with('alert', 'Đã trao học bổng \"'.$budget->tenhb.' cho sinh viên '.$info_student->hochulot.' '.$info_student->ten);
               } catch (Exception $e) {
                   return redirect()->back()->with('alert','Đã có lỗi xảy ra');
               }

            }
            else{
                 Session::put('message','Sinh viên này đã nhận học bổng '.$check->HocBong->tenhb.' trong học kỳ hiện tại');
                  return redirect()->back();
            }
        }
        else
       {
       Session::put('message','Giá trị học bổng vượt quá số tiền còn lại của học bổng (Còn lại: '.number_format((($budget->gthb) - $budget_recent),'0',',','.').'đ )');
    return redirect()->back();
       }

        
    }   
    public function getDSHocBong(){
        
        return HocBong::all();
        
        
    }
    public function edit($id){
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
        // $countMoney = LichSuHocBong::where('id_sinhvien',$id)->sum('giatri');

        return view('hocbong::history',compact('history','idsinhvien','getHB','count'));
    }
    public function editHistory($id){
        $edit_history=LichSuHocBong::find($id);

        $ds_hocbong=$this->getHB();
        return view('hocbong::edit_history',compact('edit_history','ds_hocbong'));
    }
    public function deleteHistory($id){
        $deleteHistory=LichSuHocBong::where('id',$id)->delete();
        return redirect()->back();
    }
    public function update(Request $Request,$id){
        try {
            $save_history=LichSuHocBong::find($id);
        $save_history->id_hocbong=$Request->id_hocbong;
        $save_history->id_sinhvien=$Request->id_sinhvien;
        $save_history->giatri=$Request->giatri;
        $save_history->save();
        
        return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('alert','Đã có lỗi xảy ra');
        }
        
    }
    public function getHB(){
        return HocBong::all();
    }

    public function testTrao(Request $request)
    {
        if($request->giatri)
        {
            $idhb=$request->inputidhb;
        $arrayMessage = array('result' => true, 'message' => "" );

        foreach ($request->inputidsv as $key => $check) {
                
                $resultMessage = self::validateTraoHB($check,$idhb);

                if($resultMessage['result'] == false)
                {
                    $arrayMessage['result'] = false;
                    $arrayMessage['message'] .="&#13;  " . $resultMessage['message'];
                }
        }    

        if($arrayMessage['result'])
            {
                $index = 0;
                foreach ($request->giatri as $key => $gt) {
                if($gt!==null){
                $data = new LichSuHocBong;
                $data->id_hocbong=$request->inputidhb;
                $data->giatri=$gt;
                $data->id_sinhvien=$request->inputidsv[$index];
                $data->save();

                $index++;
            }
            }
                return redirect()->back()->with('alert', 'Đã thêm học bổng thành công! ');
            }
            else
            {
                return redirect()->back()->withInput()->with(['message'=>$arrayMessage['message']]);
            }
        }
        else
        {
             return redirect()->back()->with('alert', 'Vui lòng chọn sinh viên cần trao học bổng');
        }



    }
    public function validateTraoHB($check,$idhb)
    {
        $arrayMessage = array('result' => true, 'message' => "" );


    
        $HocBongExist = LichSuHocBong::where('id_sinhvien', '=', $check)->where('id_hocbong','=',$idhb)->first();

        if(isset($HocBongExist))
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Sinh viên ".$HocBongExist->infosv->hochulot." ".$HocBongExist->infosv->ten. " (".$HocBongExist->infosv->mssv.")"." đã nhận ".$HocBongExist->infoHB->tenhb." ở học kỳ này, vui lòng chọn lại!";
        }
        
        return $arrayMessage;
    }
}
