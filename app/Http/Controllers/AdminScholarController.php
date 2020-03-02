<?php

namespace App\Http\Controllers;
use App\Khoa;
use App\HocKyNamHoc;
use App\Scholarship;
use App\Http\Requests\ImportHocBongRequest;
use Excel;
use App\Imports\HocBongImport;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\RequestScholarship;
class AdminScholarController extends Controller
{
	public function index(Request $Request){



		$scholar=Scholarship::with('Khoa:id,tenkhoa','HocKyNamHoc:id,tenhockynamhoc');
        if($Request->tenhb) $scholar->where('tenhb','like','%'.$Request->tenhb.'%')->orWhere('mahb', 'LIKE', '%'.$Request->tenhb.'%') ;

        if($Request->khoa) $scholar->where('idkhoa',$Request->khoa);
        if($Request->hknh) $scholar->where('idhockynamhoc',$Request->hknh);
        $scholar=$scholar->orderBy('id')->paginate(10);
        $ds_khoa=$this->getKhoa();
        $ds_hknh=$this->getHocKyNamHoc();
        $viewData=[
            'scholar'=>$scholar,
            'ds_khoa'=>$ds_khoa,
            'ds_hknh'=>$ds_hknh
        ]; 
        
        return view('admin.hocbong.index',$viewData);
	}
    public function create()
    {
    	$hockynamhoc=$this->getHocKyNamHoc();
    	$ds_khoa=$this->getKhoa();
        return view('admin.hocbong.create',compact('ds_khoa','hockynamhoc'));
    }
    public function store(RequestScholarship $RequestScholarship){
        
        $this->insertOrUpdate($RequestScholarship);
        return redirect()->back();
    }
    public function getKhoa(){
        return Khoa::where('loaikhoaphong_id','=',1)->get();
    }
    public function getHocKyNamHoc(){
        return HocKyNamHoc::all();
    }
    public function insertOrUpdate($RequestScholarship,$id=''){
        $scholar=new Scholarship;
        if($id) $scholar=Scholarship::find($id);
        $scholar->mahb=$RequestScholarship->mahb;
        $scholar->tenhb=$RequestScholarship->tenhb;
        $scholar->tendvtt=$RequestScholarship->tendvtt;
        $scholar->idhockynamhoc=$RequestScholarship->idhockynamhoc;
        $scholar->idkhoa=$RequestScholarship->idkhoa;
        $scholar->soluong=$RequestScholarship->soluong;
        $scholar->gthb=$RequestScholarship->gthb;

        $scholar->save();




    }
    public function update(RequestScholarship $RequestScholarship,$id){
        $this->insertOrUpdate($RequestScholarship,$id);
        return redirect()->back();

    }
    public function edit($id){
        $scholar=Scholarship::find($id);
        $hockynamhoc=$this->getHocKyNamHoc();
        $ds_khoa=$this->getKhoa();
        return view('admin.hocbong.update',compact('scholar','hockynamhoc','ds_khoa'));
    }
    
    public function action(Request $request,$action,$id){
        if($action){
            $category=Scholarship::find($id);
            switch ($action) {
                case 'delete':
                    $category->delete();
                    break;
                
                
            }
        }
        return Redirect()->back();

    }
   
    public function adminimport(){
        return view('admin.hocbong.import');
    }
    public function adminimportstore(ImportHocBongRequest $request)
    {
       
        
        $MAX_ROW = 100000;

        if($request->hasFile('input_file')){
            $path = $request->file('input_file')->getRealPath();

            $reader = Excel::load($request->file('input_file')->getRealPath());

            $numRow = $reader->get()->count();
            $numRow = min($numRow, $MAX_ROW);

            // Lấy số dòng
            $numColumn = 10;
            $reader->takeRows($numRow);

            // Lấy & giới hạn số cột
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

                    // Lưu sinh viên
                    $HocBong = self::storeHocBong($HocBong);

                   
                    
                }
                return redirect()->route('admin_hocbong_import')->with('success', "Import thành công.");
            }
            else
            {
                return redirect()->route('admin_hocbong_import')->withInput()->with(['message'=>$arrayMessage['message']]);
            }
        }
        else
            return redirect()->back()->with(['danger'=>"Không tìm thấy file để import.<br>Vui lòng refresh (hoặc nhấn F5) và chọn/nhập lại thông tin"]);
    }
    
    public function storeHocBong($HocBong)
    {
        try {
            $hocbong = new Scholarship();

            $hocbong->mahb = $HocBong['mahb'];
            $hocbong->tenhb = $HocBong['tenhb'];
            $hocbong->tendvtt = $HocBong['tendvtt'];

            $khoa = KhoaController::GetidKhoaByTen($HocBong['tenkhoa']);
            $hocbong->idkhoa = $khoa?$khoa->id:"";



            $hocbong->gthb = $HocBong['gthb'];
            $hocbong->soluong = $HocBong['soluong'];
            $hocbong->save();
            
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

    
        $HocBongExist = Scholarship::where('mahb', '=', $HocBong['mahb'])->get();
        if(count($HocBongExist) > 0)
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Mã HB đã tồn tại; ";
        }
        
        

        return $arrayMessage;
    }

}
