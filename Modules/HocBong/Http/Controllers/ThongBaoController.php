<?php

namespace Modules\HocBong\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\SinhVien;
use App\Khoa;
use App\ThongBaoHocBong;
use App\ThongBaoVanBan;
use App\TraoHocBong;
use App\HocKyNamHoc;
use App\Scholarship;
use App\LichSuHocBong;
use App\BangDiemRenLuyen;
use App\HocBong;
use Modules\HocBong\Http\Requests\ThongBaoRequest;
use Modules\HocBong\Http\Requests\VanBanRequest;
use Modules\HocBong\Entities\HoSoHocBong;
use Modules\HocBong\Entities\FileHoSoHocBong;
use Modules\HocBong\Entities\HoSoLyDo;
use DB;
use Carbon\Carbon;
use Auth;
class ThongBaoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $dsThongBao=ThongBaoHocBong::join('hocbong','hocbong.id','=','hocbong_thongbao.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->join('users','users.id','=','hocbong_thongbao.author')
        ->where('hocky_namhoc.idtrangthaihocky',2)
        ->select('*','hocbong_thongbao.id as idtb','hocbong_thongbao.created_at as date')
        ->orderBy('hocbong_thongbao.id','desc')
        ->get();

        $DinhKem=ThongBaoVanBan::all();
        $viewData=[
            'dsThongBao'=>$dsThongBao,
            'DinhKem'=>$DinhKem,
        ];
        return view('hocbong::admin.thongbao_index',$viewData);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $dsHocBong=Scholarship::join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.idtrangthaihocky',2)
        ->select('*','hocbong.id as idhb')
        ->get();
        $viewData=[
            'dsHocBong'=>$dsHocBong
        ];

         return view('hocbong::admin.thongbao_create',$viewData);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ThongBaoRequest $request)
    {
        

        try {
        $thongbao = new ThongBaoHocBong;
        $thongbao->tieude=$request->tieude;
        
        $thongbao->noidung=$request->noidung;
        $thongbao->id_hocbong=$request->hocbong;
        $thongbao->ngay_het_han=$request->ngayhethan;
        $thongbao->author=Auth::user()->id;
        $thongbao->slug=str_slug($request->tieude);
        $thongbao->status=1;
        $thongbao->created_at=Carbon::now();
        $thongbao->save();
        $index = 0;
        if($request->DinhKem && $request->tenvanban){
            foreach ($request->DinhKem as $key => $url) {
               if($url !== null)
               {
                 $vanban = new ThongBaoVanBan;
                $vanban->id_thongbao=$thongbao->id;
                $vanban->tenfile=$request->tenvanban[$index];
                $vanban->url=$url;
                $vanban->save();
                $index++;
               }
            }
        }
        
        
        return redirect()->route('hocbong.thongbao')->with('success', "Thêm thành công thành công!");
        } catch (Exception $e) {
            return redirect()->back()->with('alert','Đã có lỗi xảy ra');
        }
    }

    
    public function edit($id)
    {
        $dsHocBong=Scholarship::join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.idtrangthaihocky',2)
        ->select('*','hocbong.id as idhb')
        ->get();
        $thongbao=ThongBaoHocBong::find($id);
        
        $viewData=[
            'thongbao'=>$thongbao,
             'dsHocBong'=>$dsHocBong,
        ];
        return view('hocbong::admin.thongbao_edit',$viewData);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $thongbao=ThongBaoHocBong::find($id);
        $thongbao->tieude=$request->tieude;
        
        $thongbao->noidung=$request->noidung;
        $thongbao->id_hocbong=$request->hocbong;
        $thongbao->author=Auth::user()->id;
        $thongbao->slug=str_slug($request->tieude);
        $thongbao->status=1;
        $thongbao->save();
      
        return redirect()->route('hocbong.thongbao');
        } catch (Exception $e) {
            return redirect()->back()->with('alert','Đã có lỗi xảy ra');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        DB::table('hocbong_thongbao')->where('id', '=', $id)->delete();
        return redirect()->route('hocbong.thongbao');
    }
    public function offThongBao($id){
        DB::table('hocbong_thongbao')->where('id',$id)->update(['status'=>0]);
        return redirect()->back();
    }
    public function onThongBao($id){
        DB::table('hocbong_thongbao')->where('id',$id)->update(['status'=>1]);
        return redirect()->route('hocbong.thongbao');
    }
    public function dsVanBan($id){
        $dsVanBan=ThongBaoVanBan::where('id_thongbao',$id)->get();
        $idThongBao=$id;
        $viewData=[
            'dsVanBan'=>$dsVanBan,
            'idThongBao'=>$idThongBao,
        ];
        return view('hocbong::admin.vanban_index',$viewData);
    }
    public function postThemVanBan(Request $request){
        try {
            $vanban = new ThongBaoVanBan;
            $vanban->id_thongbao=$request->MaThongBao;
            $vanban->tenfile=$request->TenVanBan;
            $vanban->url=$request->DinhKem;
            $vanban->save();
             return redirect()->route('vanban.index',$request->MaThongBao)->with('success', "Thêm thành công!");

        } catch (Exception $e) {
            return redirect()->back()->with('alert','Đã có lỗi xảy ra');
        }
        
                 
        
    }
    public function postSuaVanBan(Request $request){
        try {
            $vanban = ThongBaoVanBan::find($request->IDVanBan_edit);
        $vanban->tenfile=$request->TenVanBan_edit;
        $vanban->url=$request->DinhKem_edit;
        $vanban->save();
        return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('alert','Đã có lỗi xảy ra');
        }
        
    }
    public function XoaVanBan($id)
    {
        DB::table('hocbong_thongbao_vanban')->where('id', '=', $id)->delete();
        return redirect()->back();
    }
    public function getDSHoSo(){
        $dsHoSo=HoSoHocBong::all();
        $fileHoSo=FileHoSoHocBong::all();
        $dshocky = HocKyNamHoc::all();

        $viewData=[
            'dsHoSo' => $dsHoSo,
            'fileHoSo' => $fileHoSo,
            'dshocky' => $dshocky,
        ];
        return view('hocbong::admin.hoso_index',$viewData);
    }
    public function getFile($id, Request $request){
        $file=FileHoSoHocBong::where('id',$id)->first();
        $root= "/diem-ren-luyen/Modules/HocBong/uploads/hoso/";
        $getHocBong = HocBong::where('id',$file->hoso_hocbong->id_hocbong)->first();
        $tenhocky = $getHocBong->HocKyNamHoc->tenhockynamhoc;
        $mahb = $getHocBong->mahb;
        
        $mssv = SinhVien::find($file->hoso_hocbong->id_sinhvien);
    
        $folder_file = $tenhocky.'/'.$mahb.'/'.$mssv->mssv.'/';
        $path=config('app.url').$root.$folder_file.$file->url;
        return redirect($path);
    }
    
    public function traoHBOnHoSo(Request $request){
        try {
            $statusHoso = HoSoHocBong::where('id',$request->IDHoSo)->update(['status' => 1]);
            $traohb = new LichSuHocBong;
            $traohb->id_hocbong=$request->IDHB;
            $traohb->id_sinhvien=$request->IDSV;
            $traohb->giatri=$request->GTHB;
            $traohb->save();
        
        return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('alert','Đã có lỗi xảy ra');
        }
    }

    public function tuchoiHoSo(Request $request){
        try {
            $reject = HoSoHocBong::find($request->IDHoSo1);
            $reject->status = 2;
            $reject->noidung=$request->lydo;
            $reject->save();
        
        return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('alert','Đã có lỗi xảy ra');
        }
    }
}
