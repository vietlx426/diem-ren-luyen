<?php

namespace App\Http\Controllers;

use App\DangKyHoatDongSuKien;
use App\HoatDongSuKien;
use App\SinhVien;
use Excel;
use Illuminate\Http\Request;
use App\HoatDongSuKienTieuChi;
use App\BangDiemRenLuyen;
use Carbon\Carbon;
use DB;
use DateTime;
use Auth;


class DangKyHoatDongSuKienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DS_DKHoatDongSuKien = DangKyHoatDongSuKien::join('sinhvien','sinhVien.id','=','dangkyhoatdongsukien.sinhvien_id')
                        ->join('hoatdongsukien','hoatdongsukien.id','=','dangkyhoatdongsukien.hoatdongsukien_id')
                        ->select('sinhvien.*','hoatdongsukien.tenhoatdongsukien','dangkyhoatdongsukien.*')->get();
        ;
        return view('subadmin.sinhvienhoatdongsukien',['DS_DKHoatDongSuKien'=>$DS_DKHoatDongSuKien]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function Admin_ImportStudent($idhoatdongsukien)
    {
        $hoatDongSuKien = HoatDongSuKien::find($idhoatdongsukien);

        return view('admin.hoatdongsukien_danhsachsinhvien_import', ['hoatDongSuKien'=>$hoatDongSuKien]);
    }

    public function Admin_storeImportStudent(Request $request)
    {
        $hdsk_id = $request->HDSK;
        if($request->hasFile('input_file')){
            $path = $request->file('input_file')->getRealPath();
            $reader = Excel::load($request->file('input_file')->getRealPath());
            $numRow = $reader->get()->count();
            $numColumn = 5;
            // Lấy số dòng
            $reader->takeRows($numRow);
            // Lấy & giới hạn số cột
            $reader->takeColumns($numColumn);
            $countRowExcel = 1;
            $arrayMessage = array('result' => true, 'message' => "" );
            foreach ($reader->toArray() as $key => $SinhVien) {
                $countRowExcel++;
                $resultMessage = self::validateSinhVienImport($SinhVien,$hdsk_id);
                if($resultMessage['result'] == false)
                {
                    $arrayMessage['result'] = false;
                    $arrayMessage['message'] .= "&#13; Dòng " . $countRowExcel . ": " . $resultMessage['message'];
                }
            }

            if($arrayMessage['result'])
            {
                foreach ($reader->toArray() as $key => $SinhVien) {
                    // Lưu sinh viên
                    $sinhVien = self::storeSinhVien($SinhVien, $hdsk_id);
                }
                return redirect()->route('admin_hoatdongsukien')->with('success', "Import thành công");
            }
            else
                return redirect()->route('admin_hdsk_importsv')->withInput()->with(['message'=>$arrayMessage['message']]);
        }
        else
            return redirect()->back()->with(['danger'=>"Không tìm thấy file để import.<br>Vui lòng refresh (hoặc nhấn F5) và chọn/nhập lại thông tin"]);
    }

    public function ImportStudent()
    {
        $dsHDSK = HoatDongSuKien::all();

        return view('subadmin.hoatdongsukien_danhsachsinhvien_import', ['dsHDSK'=>$dsHDSK]);
    }

    public function storeImportStudent(Request $request)
    {
        $hdsk_id = $request->HDSK;
        if($request->hasFile('input_file')){
            $path = $request->file('input_file')->getRealPath();
            $reader = Excel::load($request->file('input_file')->getRealPath());
            $numRow = $reader->get()->count();
            $numColumn = 5;
            // Lấy số dòng
            $reader->takeRows($numRow);

            // Lấy & giới hạn số cột
            $reader->takeColumns($numColumn);
            $countRowExcel = 1;
            $arrayMessage = array('result' => true, 'message' => "" );
            foreach ($reader->toArray() as $key => $SinhVien) {
                $countRowExcel++;
                $resultMessage = self::validateSinhVienImport($SinhVien,$hdsk_id);
                if($resultMessage['result'] == false)
                {
                    $arrayMessage['result'] = false;
                    $arrayMessage['message'] .= "&#13; Dòng " . $countRowExcel . ": " . $resultMessage['message'];
                }
            }
            if($arrayMessage['result'])
            {
                foreach ($reader->toArray() as $key => $SinhVien) {
                    // Lưu sinh viên
                    $sinhVien = self::storeSinhVien($SinhVien, $hdsk_id);
                }
                return redirect()->route('hoatdongsukien');
            }
            else
            {
                return redirect()->route('sv_hdsk_import')->withInput()->with(['message'=>$arrayMessage['message']]);
            }
        }
        else
            return redirect()->back()->with(['danger'=>"Không tìm thấy file để import.<br>Vui lòng refresh (hoặc nhấn F5) và chọn/nhập lại thông tin"]);
    }

    public function validateSinhVienImport($SinhVien,$hdsk_id)
    {
        
        $arrayMessage = array('result' => true, 'message' => "" );

        // Kiểm tra họ
         if(empty(trim($SinhVien['mssv'])))
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Không có MSSV; ";
        }
        // if(empty(trim($SinhVien['ho'])))
        // {
        //     $arrayMessage['result'] = false;
        //     $arrayMessage['message'] .= "Không có họ; ";
        // }

        // Kiểm tra tên
        if(empty(trim($SinhVien['ten'])))
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Không có tên; ";
        }
        $idsv = SinhVien::where('mssv', 'like', $SinhVien['mssv'])->first();

        // 1. Kiểm tra mssv
        $SinhVienExist = DangKyHoatDongSuKien::where('sinhvien_id','=',$idsv->id)->where('hoatdongsukien_id','=',$hdsk_id)->get();
        if(count($SinhVienExist) > 0)
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Sinh viên tham gia hoạt động này đã tồn tại; ";
        }
        return $arrayMessage;
    }

    public function storeSinhVien($SinhVien, $hdsk_id)
    {
        try {
            $dkhdsk = new DangKyHoatDongSuKien();
            $idsv = SinhVien::where('mssv', 'like', $SinhVien['mssv'])->first();
            $dkhdsk->sinhvien_id = $idsv->id;
            $dkhdsk->hoatdongsukien_id = $hdsk_id;
            $dkhdsk->dangky = 1;
            $dkhdsk->thamdu = 1;
            $getthoigianthamgia = HoatDongSuKien::where('id','=',$hdsk_id)->first();

            try {
                $dkhdsk->thoigianthamgia =  $getthoigianthamgia->thoigianbatdau;
            } catch (Exception $e) {}

            

            $dkhdsk->save();
            
            return $dkhdsk;

        } catch (Exception $e) {
            return false;
        }
    }
    function excel($idhoatdongsukien)
    {
        $DS_DKHoatDongSuKien = DB::table('dangkyhoatdongsukien')->leftjoin('sinhvien','sinhVien.id','=','dangkyhoatdongsukien.sinhvien_id')
            -> leftjoin('hoatdongsukien','hoatdongsukien.id','=','dangkyhoatdongsukien.hoatdongsukien_id')
            -> where('hoatdongsukien.id', '=', $idhoatdongsukien)
            -> select('sinhvien.mssv','sinhvien.hochulot','sinhvien.ten','hoatdongsukien.tenhoatdongsukien','dangkyhoatdongsukien.*')->get()->toArray();
        $HoatDongSuKien = HoatDongSuKien::find($idhoatdongsukien);
        $STT =0;
        $DKHDSK_array[] = array('STT','MSSV','HỌ','TÊN', 'THỜI GIAN THAM GIA');
        foreach ($DS_DKHoatDongSuKien as $dkhdsk) {
            $DKHDSK_array[]=array(
            'STT' => ++$STT,   
            '<b>MSSV</b>' => $dkhdsk->mssv,
            '<b>HỌ</b>' => $dkhdsk->hochulot,
            'TÊN' => $dkhdsk->ten,
            // 'TÊN HOẠT ĐỘNG SỰ KIỆN' => $dkhdsk->tenhoatdongsukien,
            'THỜI GIAN THAM GIA' => date('d/m/Y',strtotime($dkhdsk->thoigianthamgia))
            );
        }
        $fileName = "DanhSachSinhVien_" . $HoatDongSuKien->tenhoatdongsukien;
        $sheetName = "DanhSachSinhVien";
        Excel::create($fileName, function($excel) use($DKHDSK_array, $sheetName, $HoatDongSuKien){
            $excel->setTitle('DANH SÁCH SINH VIÊN THAM GIA HOẠT ĐỘNG SỰ KIỆN');
            $excel->sheet($sheetName, function($sheet) use($DKHDSK_array, $HoatDongSuKien){
                // Tên hoạt động sự kiện
                $sheet->mergeCells('A1:E1');
                $sheet->cells('A1', function($cells) use ($HoatDongSuKien){
                    $cells->setValue($HoatDongSuKien->tenhoatdongsukien);

                    // Set font size
                    $cells->setFontSize(14);
                    // Set font weight to bold
                    $cells->setFontWeight('bold');
                    // Set alignment to center
                    $cells->setAlignment('center');
                    // Set vertical alignment to middle
                    $cells->setValignment('center');
                });

                // Thời gian diễn ra hoạt động sự kiện
                $sheet->cells('A2', function($cells) use ($HoatDongSuKien){
                    $cells->setValue("Thời gian: " . date('h:i A d/m/Y ',strtotime($HoatDongSuKien->thoigianbatdau)));
                    // Set font weight to bold
                    $cells->setFontWeight('bold');
                });

                // Địa điểm diễn ra hoạt động sự kiện
                $sheet->cells('A3', function($cells) use ($HoatDongSuKien){

                    $cells->setValue("Địa điểm: " . $HoatDongSuKien->diadiem);

                    // Set font weight to bold
                    $cells->setFontWeight('bold');
                }); 

                $sheet->fromArray($DKHDSK_array,'DANH SÁCH SINH VIÊN THAM GIA HOẠT ĐỘNG SỰ KIỆN','A5',false,false);
            });
        })->download('xlsx');
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DangKyHoatDongSuKien  $dangKyHoatDongSuKien
     * @return \Illuminate\Http\Response
     */
    public function show($idhoatdongsukien)
    {
        $HoatDongSuKien = HoatDongSuKien::find($idhoatdongsukien);

        $DS_DKHoatDongSuKien = DangKyHoatDongSuKien::join('sinhvien','sinhvien.id','=','dangkyhoatdongsukien.sinhvien_id')
                        -> join('hoatdongsukien','hoatdongsukien.id','=','dangkyhoatdongsukien.hoatdongsukien_id')
                        -> where('hoatdongsukien.id', '=', $idhoatdongsukien)
                        -> select('sinhvien.*','hoatdongsukien.tenhoatdongsukien','dangkyhoatdongsukien.*')->get();
        ;
        return view('subadmin.hoatdongsukien_danhsachsinhvien',['HoatDongSuKien' => $HoatDongSuKien, 'DS_DKHoatDongSuKien'=>$DS_DKHoatDongSuKien]);
    }

    public function admin_show($idhoatdongsukien)
    {
        $HoatDongSuKien = HoatDongSuKien::find($idhoatdongsukien);

        $DS_DKHoatDongSuKien = DangKyHoatDongSuKien::join('sinhvien','sinhvien.id','=','dangkyhoatdongsukien.sinhvien_id')
                        -> join('hoatdongsukien','hoatdongsukien.id','=','dangkyhoatdongsukien.hoatdongsukien_id')
                        -> where('hoatdongsukien.id', '=', $idhoatdongsukien)
                        -> select('sinhvien.*','hoatdongsukien.tenhoatdongsukien','dangkyhoatdongsukien.*')->get();
        ;
        return view('admin.hoatdongsukien_danhsachsinhvien',['HoatDongSuKien' => $HoatDongSuKien, 'DS_DKHoatDongSuKien'=>$DS_DKHoatDongSuKien]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DangKyHoatDongSuKien  $dangKyHoatDongSuKien
     * @return \Illuminate\Http\Response
     */
    public function edit(DangKyHoatDongSuKien $dangKyHoatDongSuKien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DangKyHoatDongSuKien  $dangKyHoatDongSuKien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DangKyHoatDongSuKien $dangKyHoatDongSuKien)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DangKyHoatDongSuKien  $dangKyHoatDongSuKien
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(is_numeric($id))
        {
            if(DangKyHoatDongSuKienController::isExistId($id))
                try {

                    $objold = DangKyHoatDongSuKien::find($id)->toArray();
                    
                    
                    DangKyHoatDongSuKien::destroy($id);

                    // Write log
                    try {
                        LogController::storeobjectlog($objold, '', LogLoaiHoatDong::DeleteRecord, '');
                        
                    } catch (Exception $e) {
                        
                    }
                    // End Write log

                    $result = array('status' => true, 'message' => "Xóa thành công.");
                    return $result;
                } catch (Exception $e) {
                    $result = array('status' => false, 'message' => $e);
                    return $result;
                }
            else
            {
                $result = array('status' => false, 'message' => "Không tìm thấy dữ liệu để xóa.");
                return $result;
            }
        }
        else
        {
            $result = array('status' => false, 'message' => "Dữ liệu xóa không hợp lệ.");
            return $result;
        }
    }
    
    public static function isExistId($Id)
    {
        $DKHoatDongSuKien = DangKyHoatDongSuKien::find($Id);
        if(count($DKHoatDongSuKien)>0)
            return true;
        return false;
    }

    public static function getDangKyHoatDongSuKien($idHoatDongSuKien='')
    {
        if(Auth::check())
        {
            if(Auth::user()->idloaiuser == 3)
            {
                $idSinhVien = Auth::user()->cbgvsv_id;

                $dangKyHoatDongSuKien = DangKyHoatDongSuKien::where('sinhvien_id', '=', $idSinhVien)
                    -> where('hoatdongsukien_id', '=', $idHoatDongSuKien)
                    -> first();
                return $dangKyHoatDongSuKien;
            }
        }
        return NULL;
    }

    public function sinhvien_store(Request $request)
    {
        if(Auth::check() && Auth::user()->idloaiuser == 3)
        {
            try {
                if($request->dangky)
                {
                    $dangKyHoatDongSuKien = DangKyHoatDongSuKien::firstOrCreate(array('sinhvien_id' => Auth::user()->cbgvsv_id, 'hoatdongsukien_id' => $request->idhoatdongsukien));
                    $dangKyHoatDongSuKien->dangky = 1;
                    $dangKyHoatDongSuKien->save();
                }
                else
                    DangKyHoatDongSuKien::where('sinhvien_id', '=', Auth::user()->cbgvsv_id)-> where('hoatdongsukien_id', '=', $request->idhoatdongsukien)-> delete();
                return redirect()->route('sinhvien_hoatdongsukien')->with('success', "Lưu thành công!");
            } catch (Exception $e) {
                return redirect()->route('sinhvien_hoatdongsukien')->with('warning', "Lưu không thành công! Vui lòng thử lại");
            }
        }
        else
            return redirect()->route('home');
    }

    public static function isAllAddedMark($idHoatDongSuKien)
    {
        $dsSinhVienThamGiaHoatDongDuKien_ChuaCongDiem = DangKyHoatDongSuKien::where('hoatdongsukien_id', '=', $idHoatDongSuKien)
            ->where('trangthaicongdiem', '<>', 1)
            ->get();
        return count($dsSinhVienThamGiaHoatDongDuKien_ChuaCongDiem) == 0 ? true : false;
    }

    public function CongDiemChoSinhVienThamGiaHoatDongSuKien($idHoatDongSuKien)
    {
        $hoatDongSuKien = HoatDongSuKien::find($idHoatDongSuKien);
        $hoatDongSuKienTieuChi = HoatDongSuKienTieuChi::where('hoatdongsukien_id', '=', $idHoatDongSuKien)->first();
        $tieuChi = $hoatDongSuKienTieuChi->tieuchi;
        if($tieuChi)
            if(floatval($hoatDongSuKienTieuChi->diemcong) > floatval(0))
            {
                $diem = floatval($hoatDongSuKienTieuChi->diemcong);
                $idHocKyNamHoc = $hoatDongSuKien->hocky_namhoc_id;
                $dsSinhVienThamGiaHoatDongDuKien_ChuaCongDiem = DangKyHoatDongSuKien::where('hoatdongsukien_id', '=', $idHoatDongSuKien)->where('trangthaicongdiem', '<>', 1)->get();
                foreach ($dsSinhVienThamGiaHoatDongDuKien_ChuaCongDiem as $key => $sinhVienThamGiaHoatDongDuKien_ChuaCongDiem) {
                    $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)->where('sinhvien_id', '=', $sinhVienThamGiaHoatDongDuKien_ChuaCongDiem->sinhvien_id)->where('tieuchi_id', '=', $tieuChi->id)->first();
                    if(!$bangDiemRenLuyen)
                        $bangDiemRenLuyen = BangDiemRenLuyen::create(array('hocky_namhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$sinhVienThamGiaHoatDongDuKien_ChuaCongDiem->sinhvien_id, 'tieuchi_id'=>$tieuChi->id, 'maxdiem'=>$tieuChi->diemtoida, 'diem'=>$tieuChi->diemmacdinh));
                    $bangDiemRenLuyen->diem += $diem;
                    $bangDiemRenLuyen->save();
                    $sinhVienThamGiaHoatDongDuKien_ChuaCongDiem->trangthaicongdiem = 1;
                    $sinhVienThamGiaHoatDongDuKien_ChuaCongDiem->save();
                    ServiceTieuChiMinhChungController::UpdateDiemTieuChiCha($tieuChi, $idHocKyNamHoc, $sinhVienThamGiaHoatDongDuKien_ChuaCongDiem->sinhvien_id);
                }
                return redirect()->route('admin_hoatdongsukien')->with('success', "Đã thực hiện cộng điểm thành công cho hoạt động " .  $hoatDongSuKien->tenhoatdongsukien);
            }
            else
                return redirect()->route('admin_hoatdongsukien_edit', ['id'=>$idHoatDongSuKien])->with('warning', "Hoat động sự kiện có điểm cộng <= 0 <br>Vui lòng sửa điểm cộng phù hợp");
        else
            return redirect()->route('admin_hoatdongsukien_edit', ['id'=>$idHoatDongSuKien])->with('warning', "Hoat động sự kiện chưa được gán tiêu chí để cộng điểm");
    }

}
