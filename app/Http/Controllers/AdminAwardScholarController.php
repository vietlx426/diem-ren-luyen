<?php

namespace App\Http\Controllers;
use App\HocBong;
use App\TraoHocBong;
use App\LichSuHocBong;
use Illuminate\Http\Request;
use DB;
class AdminAwardScholarController extends Controller
{
    public function create($id){
       
        $ds_hocbong=$this->getDSHocBong();
        $test=$id;
        $idsinhvien = DB::table("sinhvien")->where("mssv",$test)->get();
        return view('admin.hocbong.award',compact('ds_hocbong','test','idsinhvien'));
    }
    public function store(Request $Request, $id){
        $award=new TraoHocBong;

        $award->id_hocbong=$Request->id_hocbong;
        $award->id_sinhvien=$Request->id_sinhvien;
        $award->giatri=$Request->giatri;
        $award->save();
        return redirect()->back();
    }   
    public function getDSHocBong(){
        return HocBong::all();
    }
    public function edit($id){
        
        $history=LichSuHocBong::where('lichsu_hocbong.id_sinhvien', '=', $id)
        ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->select('lichsu_hocbong.*','hocky_namhoc.*','hocbong.*','lichsu_hocbong.id as idhb')
        ->get();
        $count = LichSuHocBong::where('id_sinhvien',$id)->count();
        $countMoney = LichSuHocBong::where('id_sinhvien',$id)->sum('giatri');

        return view('admin.hocbong.history',compact('history','countMoney','count'));
    }
    public function editHistory($id){
        $edit_history=LichSuHocBong::find($id);

        $ds_hocbong=$this->getHB();
        return view('admin.hocbong.edit_history',compact('edit_history','ds_hocbong'));
    }
    public function update(Request $Request,$id){
        $save_history=LichSuHocBong::find($id);
        $save_history->id_hocbong=$Request->id_hocbong;
        $save_history->id_sinhvien=$Request->id_sinhvien;
        $save_history->giatri=$Request->giatri;
        $save_history->save();
        return redirect()->back();

    }
    public function getHB(){
        return HocBong::all();
    }
}
