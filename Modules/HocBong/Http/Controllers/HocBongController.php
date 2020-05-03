<?php

namespace Modules\HocBong\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Requests\ImportHocBongRequest;
use App\Http\Requests\RequestScholarship;
use Modules\HocBong\Http\Requests\ThongBaoRequest;
use App\Khoa;
use App\HocKyNamHoc;
use App\HocBong;
use App\HocBongKhoa;
use App\SinhVien;
use App\NamHoc;
use App\LichSuHocBong;
use App\ThongBaoHocBong;
use App\ThongBaoVanBan;
use PDF;
use Auth;
use Carbon\Carbon;

use DB;
use Excel;
class HocBongController extends Controller
{
    public function index(Request $Request,$idHocKyHienChon = ''){
        $HocKyNamHoc_HienTai = HocKyNamHoc::where('idtrangthaihocky', '=', 2)->first();
        if($idHocKyHienChon=='')
            $hocKyNamHoc_HienChon = $HocKyNamHoc_HienTai;
        else
            $hocKyNamHoc_HienChon = HocKyNamHoc::find($idHocKyHienChon);
        
        if($Request->namhoc)
        {
             $ds_hknh=HocKyNamHoc::where('hocky_namhoc.idnamhoc','=',$Request->namhoc)->get();
        }
        else
        {
            $ds_hknh=HocKyNamHoc::where('hocky_namhoc.idnamhoc','=',$HocKyNamHoc_HienTai->idnamhoc)->get();
        }

       

      
       if($Request->namhoc)
       {
        if($Request->hknh)
        {
             $getNamHoc=NamHoc::where('id',$Request->namhoc)->first();
            $scholar=HocBong::with('Khoa:id,tenkhoa','HocKyNamHoc:id,tenhockynamhoc')
           ->join('hocbong_phamvi','hocbong_phamvi.id_hocbong','=','hocbong.id')
           ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
           -> groupBy('hocbong_phamvi.id_hocbong')
           ->where('hocky_namhoc.id','=',$Request->hknh);
        }
        else
        {   $getNamHoc=NamHoc::where('id',$Request->namhoc)->first();
            $scholar=HocBong::with('Khoa:id,tenkhoa','HocKyNamHoc:id,tenhockynamhoc')
           ->join('hocbong_phamvi','hocbong_phamvi.id_hocbong','=','hocbong.id')
           ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
           -> groupBy('hocbong_phamvi.id_hocbong')
           ->where('hocky_namhoc.idnamhoc','=',$Request->namhoc);
        }
       }
       else
       {
         $getNamHoc=NamHoc::where('id',$HocKyNamHoc_HienTai->idnamhoc)->first();
        $scholar=HocBong::with('Khoa:id,tenkhoa','HocKyNamHoc:id,tenhockynamhoc')
           ->join('hocbong_phamvi','hocbong_phamvi.id_hocbong','=','hocbong.id')
           ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
           -> groupBy('hocbong_phamvi.id_hocbong')
           ->where('hocky_namhoc.idnamhoc','=',$HocKyNamHoc_HienTai->idnamhoc);
       }
        if($Request->tenhb) $scholar->where('tenhb','like','%'.$Request->tenhb.'%')->orWhere('mahb', 'LIKE', '%'.$Request->tenhb.'%') ;
       if($Request->khoa){
            $scholar->where('id_khoa',$Request->khoa);
        }
        
        if($Request->hknh){
            $scholar->where('idhockynamhoc',$Request->hknh);
        }



        $scholar=$scholar->select('hocbong.*','hocbong.id as idhb','hocky_namhoc.*')->orderBy('hocky_namhoc.id','desc')->get();
        $getHKNH=HocKyNamHoc::where('id',$Request->hknh)->first();
        
        $ds_khoa=$this->getKhoa();

        
       
        $hocbong_phamvi=HocBongKhoa::all();
        //------------------
        $toantruong=HocBong::join('hocbong_phamvi','hocbong_phamvi.id_hocbong','=','hocbong.id')
        ->get();
        $sl_hbdatrao=HocBong::join('lichsu_hocbong','lichsu_hocbong.id_hocbong','=','hocbong.id')
        ->get();
        $trangthai=HocKyNamHoc::all();
        $dsnamhoc=NamHoc::all();

        
        //--------------------Thống kê----------------------------
        //Toàn trường
       
        if($Request->namhoc){
            if($Request->hknh){
            $soluong_hb=HocBong::join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
            ->where('hocky_namhoc.id','=',$Request->hknh)->get();

             $sl_HBdatrao=LichSuHocBong::join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
            ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
           ->where('hocky_namhoc.id','=',$Request->hknh)->get();

           $sl_hb=HocBongKhoa::join('hocbong','hocbong.id','=','hocbong_phamvi.id_hocbong')
             ->where('hocbong.idhockynamhoc','=',$Request->hknh)
            ->join('khoa','khoa.id','=','hocbong_phamvi.id_khoa')
             ->select('hocbong.*','hocbong_phamvi.*','khoa.*','khoa.id as idkhoa')
            ->get(); 

            $sl_sv=LichSuHocBong::join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
            ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
            ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
           ->where('hocky_namhoc.id','=',$Request->hknh)
            ->join('lop','lop.id','=','sinhvien.lop_id')
            ->join('nganh','nganh.id','=','lop.nganh_id')
            ->join('bomon','bomon.id','=','nganh.idbomon')
            ->join('khoa','khoa.id','=','bomon.idkhoa')
             ->select('lichsu_hocbong.*','lop.*','nganh.*','bomon.*','khoa.*','khoa.id as idk')
            ->get();
            }
            else
            {
                 $soluong_hb=HocBong::join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
                
                ->where('hocky_namhoc.idnamhoc','=',$Request->namhoc)->get();

                 $sl_HBdatrao=LichSuHocBong::join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
                ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
              ->where('hocky_namhoc.idnamhoc','=',$Request->namhoc)->get();

                $sl_hb=HocBongKhoa::join('hocbong','hocbong.id','=','hocbong_phamvi.id_hocbong')
                ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
                ->where('hocky_namhoc.idnamhoc','=',$Request->namhoc)
                ->join('khoa','khoa.id','=','hocbong_phamvi.id_khoa')
                 ->select('hocbong.*','hocbong_phamvi.*','khoa.*','khoa.id as idkhoa')
                ->get(); 
                $sl_sv=LichSuHocBong::join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
                ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
                ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
               ->where('hocky_namhoc.idnamhoc','=',$Request->namhoc)
                ->join('lop','lop.id','=','sinhvien.lop_id')
                ->join('nganh','nganh.id','=','lop.nganh_id')
                ->join('bomon','bomon.id','=','nganh.idbomon')
                ->join('khoa','khoa.id','=','bomon.idkhoa')
                 ->select('lichsu_hocbong.*','lop.*','nganh.*','bomon.*','khoa.*','khoa.id as idk')
                ->get();
            }
        }
        elseif ($Request->hknh) 
        {
            $soluong_hb=HocBong::join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
            ->where('hocky_namhoc.id','=',$Request->hknh)->get();

             $sl_HBdatrao=LichSuHocBong::join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
            ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
           ->where('hocky_namhoc.id','=',$Request->hknh)->get();

           $sl_hb=HocBongKhoa::join('hocbong','hocbong.id','=','hocbong_phamvi.id_hocbong')
             ->where('hocbong.idhockynamhoc','=',$Request->hknh)
            ->join('khoa','khoa.id','=','hocbong_phamvi.id_khoa')
             ->select('hocbong.*','hocbong_phamvi.*','khoa.*','khoa.id as idkhoa')
            ->get(); 

            $sl_sv=LichSuHocBong::join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
            ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
            ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
           ->where('hocky_namhoc.id','=',$Request->hknh)
            ->join('lop','lop.id','=','sinhvien.lop_id')
            ->join('nganh','nganh.id','=','lop.nganh_id')
            ->join('bomon','bomon.id','=','nganh.idbomon')
            ->join('khoa','khoa.id','=','bomon.idkhoa')
             ->select('lichsu_hocbong.*','lop.*','nganh.*','bomon.*','khoa.*','khoa.id as idk')
            ->get();
        }
        else
        {

            $soluong_hb=HocBong::join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->join('nam_hocs','nam_hocs.id','=','hocky_namhoc.idnamhoc')
         ->where('nam_hocs.id','=',$HocKyNamHoc_HienTai->idnamhoc)->get();

          $sl_HBdatrao=LichSuHocBong::join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.idnamhoc','=',$HocKyNamHoc_HienTai->idnamhoc)->get();

        $sl_hb=HocBongKhoa::join('hocbong','hocbong.id','=','hocbong_phamvi.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.idnamhoc','=',$HocKyNamHoc_HienTai->idnamhoc)
        ->join('khoa','khoa.id','=','hocbong_phamvi.id_khoa')
         ->select('hocbong.*','hocbong_phamvi.*','khoa.*','khoa.id as idkhoa')
        ->get(); 
        $sl_sv=LichSuHocBong::join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
        ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.idnamhoc','=',$HocKyNamHoc_HienTai->idnamhoc)
        ->join('lop','lop.id','=','sinhvien.lop_id')
        ->join('nganh','nganh.id','=','lop.nganh_id')
        ->join('bomon','bomon.id','=','nganh.idbomon')
        ->join('khoa','khoa.id','=','bomon.idkhoa')
         ->select('lichsu_hocbong.*','lop.*','nganh.*','bomon.*','khoa.*','khoa.id as idk')
        ->get();
        }
        

        

       

        
        //------------------------------------------------------------------------------------
        //Khoa
        $ds_khoa=Khoa::where('loaikhoaphong_id',1)->get();

        

        

        

    
        //------------------------------------------------------------------------------------
        //Charts
        




        $viewData=[
            'scholar'=>$scholar,
            'ds_khoa'=>$ds_khoa,
            'hocbong_phamvi'=>$hocbong_phamvi,
            'sl_hbdatrao'=>$sl_hbdatrao,
            'hocKyNamHoc_HienChon'=>$hocKyNamHoc_HienChon,
            'trangthai'=>$trangthai,
            'toantruong'=>$toantruong,
            'getNamHoc'=>$getNamHoc,
            'soluong_hb'=>$soluong_hb,
            'dsnamhoc'=>$dsnamhoc,
            'sl_HBdatrao'=>$sl_HBdatrao,
            'sl_hb'=>$sl_hb,
            'sl_sv'=>$sl_sv,
            'getHKNH'=>$getHKNH,
            'ds_hknh'=>$ds_hknh,


        ];
        
        return view('hocbong::admin.index',$viewData);
    }
    public function getHocKyNamHoc(){
        
        return HocKyNamHoc::all();
    }
    public function create()
    {
        // $last = DB::table('hocbong')->select()->latest()->first();
        // $test = Khoa::select('id')->where('tenkhoa', 'like', 'Công nghệ thông tin')->first();
        $getMaHB=HocBong::select()->latest()->first();

        $hockynamhoc=$this->getHocKyNamHoc();
        $ds_khoa=$this->getKhoa();
        return view('hocbong::admin.create',compact('ds_khoa','hockynamhoc'));
    }
    public function store(RequestScholarship $RequestScholarship){
       

        if($RequestScholarship->khoa == null)
        {
            return redirect()->back()->with('danger', "Vui lòng chọn phạm vi của học bổng (Khoa)!");
        }
        else
        {
            try {
                $scholar=new HocBong;
            $scholar->mahb=$RequestScholarship->mahb;
            $scholar->tenhb=$RequestScholarship->tenhb;
            $scholar->tendvtt=$RequestScholarship->tendvtt;
            $scholar->idhockynamhoc=$RequestScholarship->idhockynamhoc;
           
            $scholar->soluong=$RequestScholarship->soluong;
            $scholar->gthb=$RequestScholarship->gthb;
            $scholar->gtmoihocbong=$RequestScholarship->gtmoihocbong;
            $scholar->save();
            
             foreach ($RequestScholarship->khoa as $key => $idKhoa) {
            $hocbong_phamvi = new HocBongKhoa();
            $hocbong_phamvi->id_hocbong = $scholar->id;
            $hocbong_phamvi->id_khoa = $idKhoa;
            
            $hocbong_phamvi->save();


            
            }
            if($RequestScholarship->tieude && $RequestScholarship->noidung)
            {
                $thongbao = new ThongBaoHocBong;
                $thongbao->tieude=$RequestScholarship->tieude;
                
                $thongbao->noidung=$RequestScholarship->noidung;
                $thongbao->id_hocbong=$scholar->id;
                $thongbao->author=Auth::user()->id;
                $thongbao->slug=str_slug($RequestScholarship->tieude);
                $thongbao->status=1;
                $thongbao->created_at=Carbon::now();

                $thongbao->save();
            }
            $index = 0;
            if($RequestScholarship->DinhKem && $RequestScholarship->tenvanban){
                foreach ($RequestScholarship->DinhKem as $key => $url) {
                   if($url !== null)
                   {
                     $vanban = new ThongBaoVanBan;
                    $vanban->id_thongbao=$thongbao->id;
                    $vanban->tenfile=$RequestScholarship->tenvanban[$index];
                    $vanban->url=$url;
                    $vanban->save();

                    $index++;
                   }
                }
            }
            return redirect()->route('hocbong.index')->with('alert_them', 'Đã thêm học bổng thành công! ');
            } catch (Exception $e) {
                 return redirect()->back()->with('alert','Đã có lỗi xảy ra');
            }
        }

          
    }
    public function getKhoa(){
        return Khoa::where('loaikhoaphong_id','=',1)->get();
    }
    
   
    public function update(Request $RequestScholarship,$id){
         
            HocBongKhoa::where('id_hocbong',$id)->delete();
            try {
                $scholar=HocBong::find($id);
            $scholar->mahb=$RequestScholarship->mahb;
            $scholar->tenhb=$RequestScholarship->tenhb;
            $scholar->tendvtt=$RequestScholarship->tendvtt;
            $scholar->idhockynamhoc=$RequestScholarship->idhockynamhoc;
           
            $scholar->soluong=$RequestScholarship->soluong;
            $scholar->gthb=$RequestScholarship->gthb;
            $scholar->gtmoihocbong=$RequestScholarship->gtmoihocbong;
            $scholar->save();
            
            foreach ($RequestScholarship->khoa as $key => $idKhoa) {

            $hocbong_phamvi = new HocBongKhoa();
            $hocbong_phamvi->id_hocbong = $id;
            $hocbong_phamvi->id_khoa = $idKhoa;
            
            $hocbong_phamvi->save();
                
            }


            return redirect()->route('hocbong.index')->with('alert_sua', "Lưu thành công!");
            } catch (Exception $e) {
                return redirect()->back()->with('alert','Đã có lỗi xảy ra');
            }
            
        

    }
    public function edit($id){
        $scholar=HocBong::find($id);
        $hockynamhoc=$this->getHocKyNamHoc();
        $ds_khoa=$this->getKhoa();
        $dsKhoaCuaHocBong = HocBongKhoa::where('id_hocbong', '=', $id)->get();
        return view('hocbong::admin.edit',compact('scholar','hockynamhoc','ds_khoa','dsKhoaCuaHocBong'));
    }
    
    public function destroy($id){
        DB::table('hocbong')->where('id', '=', $id)->delete();
        return Redirect()->back();

    }
   
    public function adminimport(){
        return view('hocbong::admin.import');
    }
    public function adminimportstore(ImportHocBongRequest $request)
    {
       
        
        $MAX_ROW = 100000;

        if($request->hasFile('input_file')){
            $path = $request->file('input_file')->getRealPath();

            $reader = Excel::load($request->file('input_file')->getRealPath());

            $numRow = $reader->get()->count();
            $numRow = min($numRow, $MAX_ROW);

            
            $numColumn = 8;
            $reader->takeRows($numRow);

            
            $reader->takeColumns($numColumn);

            $countRowExcel = 1;
            $arrayMessage = array('result' => true, 'message' => "" );

            foreach ($reader->toArray() as $key => $HocBong) {
                $countRowExcel++;
                $resultMessage = self::validateHocBongImport($HocBong);

                if($resultMessage['result'] == false)
                {
                    $arrayMessage['result'] = false;
                    $arrayMessage['message'] .= "&#13; Dòng " . $countRowExcel . ": " . $resultMessage['message'];
                }
            }
        
            if($arrayMessage['result'])
            {
                foreach ($reader->toArray() as $key => $HocBong) {

                    
                    $HocBong = self::storeHocBong($HocBong);

                   
                    
                }
                return redirect()->route('hocbong.import')->with('success', "Import thành công.");
            }
            else
            {
                return redirect()->route('hocbong.import')->withInput()->with(['message'=>$arrayMessage['message']]);
            }
        }
        else
            return redirect()->back()->with(['danger'=>"Không tìm thấy file để import.<br>Vui lòng refresh (hoặc nhấn F5) và chọn/nhập lại thông tin"]);
    }
    
    public function storeHocBong($HocBong)
    {
        try {
            //------------------import hoc bong-------------
            $hocbong = new HocBong();

            $hocbong->mahb  = $HocBong['mahb'];
            $hocbong->tenhb  = $HocBong['tenhb'];
            $hocbong->tendvtt = $HocBong['tendvtt'];
            
            
            $getIdHKNH = HocKyNamHoc::where('tenhockynamhoc', 'like',$HocBong['hockynamhoc'] )->first();
           
            $hocbong->idhockynamhoc = $getIdHKNH ? $getIdHKNH->id : "";

            $hocbong->gthb = $HocBong['gthb'];
            $hocbong->soluong = $HocBong['soluong'];
            $hocbong->gtmoihocbong = $HocBong['gtmoihocbong'];
            $hocbong->save();

           
//-----------------------import khoa---------------------------

            $tenkhoa=$HocBong['tenkhoa'];

            if($tenkhoa=='Toàn trường')
            {
                $idkhoa_array=collect([1,2,3,4,5,6,7,8,9]);
                foreach ($idkhoa_array as $key => $idKhoa) {
                $hocbong_phamvi = new HocBongKhoa();
                $hocbong_phamvi->id_hocbong = $hocbong->id;
                $hocbong_phamvi->id_khoa = $idKhoa;  
                
                $hocbong_phamvi->save();
                }
            }
            else{
                $arrkhoa=explode('. ', $tenkhoa);
                $collection = collect($arrkhoa);

                $idkhoa_array = $collection->map(function ($item, $key) {
                    $tmp=Khoa::where('tenkhoa', 'like', $item )->first();
                    return $item = $tmp->id;
                });
                
                foreach ($idkhoa_array as $key => $idKhoa) {
                $hocbong_phamvi = new HocBongKhoa();
                $hocbong_phamvi->id_hocbong = $hocbong->id;
                $hocbong_phamvi->id_khoa = $idKhoa;  
                
                $hocbong_phamvi->save();
                }
            }
            return $hocbong;

        } catch (Exception $e) {
            return false;
        }
    }
    public function validateHocBongImport($HocBong)
    {
        $arrayMessage = array('result' => true, 'message' => "" );

        
        if(empty(trim($HocBong['mahb'])))
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Không mã học bổng; ";
        }

      
        if(empty(trim($HocBong['tenhb'])))
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Không có tên học bổng; ";
        }

     
        if(empty(trim($HocBong['tendvtt'])))
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Không có đơn vị tài trợ; ";
        }

    
        $HocBongExist = HocBong::where('mahb', '=', $HocBong['mahb'])->get();
        if(count($HocBongExist) > 0)
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Mã HB đã tồn tại; ";
        }
        
        

        return $arrayMessage;
    }
   public function info($id){

    $ds_sv=SinhVien::join('lichsu_hocbong','lichsu_hocbong.id_sinhvien','=','sinhvien.id')
    ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
    ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
    
    ->where('hocbong.id','=',$id)->orderBy('lop_id')->get();

    $details_hb=HocBong::find($id);
    $khoa=HocBongKhoa::where('id_hocbong',$id)
    ->get();

    $sl_HBdatrao=LichSuHocBong::join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
        ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->where('hocbong.id','=',$id)
        
        ->join('lop','lop.id','=','sinhvien.lop_id')
        ->join('nganh','nganh.id','=','lop.nganh_id')
        ->join('bomon','bomon.id','=','nganh.idbomon')
        ->join('khoa','khoa.id','=','bomon.idkhoa')
         ->select('lichsu_hocbong.*','lop.*','nganh.*','bomon.*','khoa.*','khoa.id as idk')
        ->get();

    
    return view('hocbong::admin.info',compact('ds_sv','details_hb','khoa','sl_HBdatrao'));
   }

  

   
   public function hocbong_export(Request $Request,$id){
        $namhoc = NamHoc::find($id);
        $ds_khoa=$this->getKhoa();
        $sl_sv=LichSuHocBong::join('sinhvien','sinhvien.id','=','lichsu_hocbong.id_sinhvien')
                ->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
                ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
               ->where('hocky_namhoc.idnamhoc','=',$id)
                ->join('lop','lop.id','=','sinhvien.lop_id')
                ->join('nganh','nganh.id','=','lop.nganh_id')
                ->join('bomon','bomon.id','=','nganh.idbomon')
                ->join('khoa','khoa.id','=','bomon.idkhoa')
                 ->select('lichsu_hocbong.*','lop.*','nganh.*','bomon.*','khoa.*','khoa.id as idk')
                ->get();
        $sl_hb=HocBongKhoa::join('hocbong','hocbong.id','=','hocbong_phamvi.id_hocbong')
            ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
             ->where('hocky_namhoc.idnamhoc','=',$id)
            ->join('khoa','khoa.id','=','hocbong_phamvi.id_khoa')
             ->select('hocbong.*','hocbong_phamvi.*','khoa.*','khoa.id as idkhoa')
            ->get(); 
        $soluong_hb=HocBong::join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.idnamhoc','=',$id)->get();

        $sl_HBdatrao=LichSuHocBong::join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.idnamhoc','=',$id)->get();
        
        $dsHocBong = HocBong::join('hocbong_phamvi','hocbong_phamvi.id_hocbong','=','hocbong.id')
       ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
       -> groupBy('hocbong_phamvi.id_hocbong')
       ->select('hocbong.*','hocbong.id as idhb','hocky_namhoc.*')->orderBy('hocky_namhoc.id','desc')
       ->where('hocky_namhoc.idnamhoc','=',$id)->get();
       $toantruong=HocBong::join('hocbong_phamvi','hocbong_phamvi.id_hocbong','=','hocbong.id')
        ->get();
        $hocbong_phamvi=HocBongKhoa::all();

        $pdf = PDF::loadView('hocbong::export.hocbong_export', ['dsHocBong'=>$dsHocBong, 'namhoc'=>$namhoc,'toantruong'=>$toantruong,'hocbong_phamvi'=>$hocbong_phamvi,'soluong_hb'=>$soluong_hb,'sl_HBdatrao'=>$sl_HBdatrao,'ds_khoa'=>$ds_khoa,'sl_sv'=>$sl_sv,'sl_hb'=>$sl_hb], [], [
            'mode'              => 'utf-8',
            'format'           => 'A4',
            'author'           => 'Author',
            'display_mode'     => 'fullpage',
            'margin_left'       => '15.0',
            'margin_right'      => '15.0',
            'margin_top'        => '15.0',
            'margin_bottom'     => '10.0'
        ]);
        
        return $pdf->download('ThongKe_HocBong' .$namhoc->tennamhoc . '.pdf');
   }
   public function hocbong_export_hknh(Request $request,$id){
        $hknh = HocKyNamHoc::find($id);
         $soluong_hb=HocBong::join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.id','=',$id)->get();

        $sl_HBdatrao=LichSuHocBong::join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.id','=',$id)->get();
        
        
        $dsHocBong = HocBong::join('hocbong_phamvi','hocbong_phamvi.id_hocbong','=','hocbong.id')
       ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
       -> groupBy('hocbong_phamvi.id_hocbong')
       ->select('hocbong.*','hocbong.id as idhb','hocky_namhoc.*')->orderBy('hocky_namhoc.id','desc')
       ->where('hocky_namhoc.id','=',$id)->get();
       $toantruong=HocBong::join('hocbong_phamvi','hocbong_phamvi.id_hocbong','=','hocbong.id')
        ->get();
        $hocbong_phamvi=HocBongKhoa::all();

        $pdf = PDF::loadView('hocbong::export.hocbong_export', ['dsHocBong'=>$dsHocBong, 'hknh'=>$hknh,'toantruong'=>$toantruong,'hocbong_phamvi'=>$hocbong_phamvi,'soluong_hb'=>$soluong_hb,'sl_HBdatrao'=>$sl_HBdatrao], [], [
            'mode'              => 'utf-8',
            'format'           => 'A4',
            'author'           => 'Author',
            'display_mode'     => 'fullpage',
            'margin_left'       => '15.0',
            'margin_right'      => '15.0',
            'margin_top'        => '15.0',
            'margin_bottom'     => '10.0'
        ]);
        
        return $pdf->download('ThongKe_HocBong' .$hknh->tenhockynamhoc . '.pdf');
   }
   public function dashboard($idHocKyHienChon = '')
   {
        $HocKyNamHoc_HienTai = HocKyNamHoc::where('idtrangthaihocky', '=', 2)->first();
        if($idHocKyHienChon=='')
            $hocKyNamHoc_HienChon = $HocKyNamHoc_HienTai;
        else
            $hocKyNamHoc_HienChon = HocKyNamHoc::find($idHocKyHienChon);

        $soluong_hb=HocBong::join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
         ->where('hocky_namhoc.idnamhoc','=',$HocKyNamHoc_HienTai->idnamhoc)->get();
         $sl_HBdatrao=LichSuHocBong::join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
        ->where('hocky_namhoc.idnamhoc','=',$HocKyNamHoc_HienTai->idnamhoc)->get();
        $thong_ke_charts=HocBong::join('hocbong_phamvi','hocbong_phamvi.id_hocbong','=','hocbong.id')
        ->join('khoa','khoa.id','=','hocbong_phamvi.id_khoa')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
         ->where('hocky_namhoc.idtrangthaihocky','=',2)
         ->select('hocbong.*','hocky_namhoc.*','khoa.id as idkhoa','khoa.*','hocbong_phamvi.*')
         ->get();
        $thong_ke_charts_column = DB::table('lichsu_hocbong')->join('hocbong','hocbong.id','=','lichsu_hocbong.id_hocbong')
        ->join('hocky_namhoc','hocky_namhoc.id','=','hocbong.idhockynamhoc')
           ->select(
            DB::raw('idnamhoc as idnamhoc'),
            DB::raw('count(*) as number'))
           ->groupBy('idnamhoc')
           ->get();
         $array[]=['Năm học','Số lượng sinh viên'];
         foreach($thong_ke_charts_column as $key => $value)
         {
            $name=NamHoc::where('id',$value->idnamhoc)->first();
            $array[++$key] = [$name->tennamhoc, $value->number];
         }
         $viewData=[
            'soluong_hb'=>$soluong_hb,
            'sl_HBdatrao'=>$sl_HBdatrao,
            'thong_ke_charts'=>$thong_ke_charts,

         ];
        return view('hocbong::admin.dashboard',$viewData)->with('gender', json_encode($array));
   }
   public function GetHKNHByNH($idnamhoc = '')
        {
            $dsHKNH = HocKyNamHoc::where('idnamhoc', '=', $idnamhoc)->get();
            return $dsHKNH;
        }

   
}
