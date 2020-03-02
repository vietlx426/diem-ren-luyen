<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BangDiemRenLuyen;
use App\HocKyNamHocBoTieuChi;
use App\TieuChi;
use App\SinhVien;
use App\HocKyNamHoc;
use App\Lop;
use App\ThoiGianDanhGiaDRL;
use App\BoTieuChi;
use App\Khoa;
use App\CoVanHocTap;
use App\Http\Controllers\HocKyNamHocController;
use PDF;
use Excel;
use Carbon\Carbon;


class TestController extends Controller
{

    public function UPDATEDIEM($start, $end)
    {
        $hockyid = 6;
        $tieuchiid = 20;
        $dsBangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $hockyid)->where('tieuchi_id', '=', $tieuchiid)->where('id', '>', $start)->where('id', '<=', $end)->get();
        $dsTieuChiCon = TieuChi::wherein('id', [21, 25, 28])->get();

        foreach ($dsBangDiemRenLuyen as $key => $bangdiem) {
            $diemrl = 0;
            foreach ($dsTieuChiCon as $key => $tieuchi) {
                $bangdiemrl = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $hockyid)->where('tieuchi_id', '=', $tieuchi->id)->where('sinhvien_id', '=', $bangdiem->sinhvien_id)->first();
                if($bangdiemrl)
                {
                    $diemrl += min($bangdiemrl->maxdiem, $bangdiemrl->diem);
                }
                else
                    $diemrl+=$tieuchi->diemmacdinh;
            }
            $bangdiem->diem = $diemrl;
            $bangdiem->save();
            echo "<br> " . $bangdiem->sinhvien_id . ": " . $bangdiem->diem . " - " .$diemrl;
        }
        echo "<br>finished";
    }
    public function testalert(Request $request)
    {
    	// return view('layout.alertmessage.infoalert');
    	// return view('layout.alertmessage.infoalert')->with('status', "Tài khoản hiện tại chưa có trong hệ thống.");
    	return view('home')->with('status', 'Profile updated!');
    }

    public function TestPerformance($max = 0, $show = 0)
    {
        // self::Log("Test output log");
        // dd("sdv");
        $t1 = time();
        $idHocKyNamHoc = 6;
        $idKhoa = 7;
        $boolRessult = true;
        $messages = "";

        if(empty($idHocKyNamHoc))
        {
            $boolRessult = false;
            $messages = "<br> - Vui lòng chọn học kỳ";
        }
        if(empty($idKhoa))
        {
            $boolRessult = false;
            $messages .= "<br> - Vui lòng chọn khoa";
        }
        
        if($boolRessult)
        {
            $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
        
            $namBatDau = intval(trim(explode("-",$hocKyNamHoc->namhoc->tennamhoc)[0]));
            $namKetThuc = intval(trim(explode("-",$hocKyNamHoc->namhoc->tennamhoc)[1]));
                
            $dsLop = Lop::leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
                -> leftjoin('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> leftjoin('bomon', 'bomon.id', '=', 'nganh.idbomon')
                -> where('bomon.idkhoa', '=', $idKhoa)
                -> where('khoahoc.nambatdau', '<=', $namBatDau)
                -> where('khoahoc.namketthuc', '>=', $namKetThuc)
                -> select('lop.*')
                -> orderBy('lop.tenlop','asc')
                -> get();

            if(count($dsLop) > 0)
            {
                $fileName = "BangDiemRenLuyen_".$hocKyNamHoc->tenhockynamhoc;
                $fileExtend ="xls";
                return self::createFile($idHocKyNamHoc, $dsLop, $fileName, $fileExtend);
            }
        }

        // $idHocKyNamHoc = 6;
        // $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $idHocKyNamHoc)->first();;
        // $idHocKyNamHocBoTieuChi = $hocKyNamHocBoTieuChi ? $hocKyNamHocBoTieuChi->botieuchi_id : '';
        // $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $idHocKyNamHocBoTieuChi)
        //     -> where('idtieuchicha', '=', 0)
        //     -> select('id')
        //     -> get();
        // $sinhVien = SinhVien::find(532);
        // for ($i=0; $i < $max; $i++) { 
        //     $diemHocTap = BangDiemHocTapController::GetDiemHocTap($idHocKyNamHoc, $sinhVien->id);
        //     $diemTong = ServiceDanhGiaDiemRenLuyenController::GetTongDiemTheoHocKyDanhSachTieuChiLevel0($sinhVien->id, $idHocKyNamHoc, $dsTieuChi_Level_0);
        //     $xepLoai = XepLoaiDiemRenLuyenController::getXepLoai($diemTong);
        //     if($show)
        //     {
        //         echo "<br><br>";
        //         echo $i . " - ĐRL: " . $diemTong . " - XL: " . $xepLoai;
        //     }
        // }

        $t2 = time();
        echo "<br><br>--------------------- " . $t2 . " - " . $t1 . " ---------------------";
        echo "<br><br>--------------------- Completed ---------------------";
    }

    public function createFile($idHocKyNamHoc, $dsLop, $fileName, $fileExtend)
    {
        $sheetName = "BangDiem";
        $rowNum = 0;

        $arrayTitleSheet = ["STT", "MSSV", "HỌ", "TÊN", "GIỚI TÍNH", "NGÀY SINH", "EMAIL", "LỚP", "KHOA", "ĐIỂM HỌC TẬP", "ĐIỂM RÈN LUYỆN", "XẾP LOẠI"];
        $arrayColumnWidth = array(  'A' => 5, 
                                    'B' => 12, 
                                    'C' => 20, 
                                    'D' => 8, 
                                    'E' => 10, 
                                    'F' => 13, 
                                    'G' => 34, 
                                    'H' => 15, 
                                    'I' => 29, 
                                    'J' => 17, 
                                    'K' => 17, 
                                    'L' => 17, 
                                    'M' => 16, 
                                    'N' => 20, 
                                    'O' => 30, 
                                    'P' => 20, 
                                    'Q' => 30, 
                                );


        Excel::create($fileName, function($excel) use ($sheetName, $idHocKyNamHoc, $dsLop, $arrayTitleSheet, $arrayColumnWidth, $rowNum) {

            $excel->sheet($sheetName, function($sheet) use($idHocKyNamHoc, $dsLop, $arrayTitleSheet, $arrayColumnWidth, $rowNum){
                
                // Set font with ->setStyle()
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Times New Roman',
                        'size'      =>  12
                    )
                ));

                // Set all margins
                $sheet->setPageMargin(0.25);

                // Freeze first row
                $sheet->freezeFirstRow();

                // Set title for table
                $sheet->row(++$rowNum, $arrayTitleSheet);

                // Set width for a single column
                $sheet->setWidth($arrayColumnWidth);

                // Set height for row
                // $sheet->getRowDimension(65000)->setRowHeight(19);

                $STT = intval(0);
                
                $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $idHocKyNamHoc)->first();;
                $idHocKyNamHocBoTieuChi = $hocKyNamHocBoTieuChi ? $hocKyNamHocBoTieuChi->botieuchi_id : '';
                $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $idHocKyNamHocBoTieuChi)
                    -> where('idtieuchicha', '=', 0)
                    -> select('id')
                    -> get();

                foreach ($dsLop as $key => $lop) {
                    $dsSinhVien = SinhVien::where('lop_id', '=', $lop->id)->orderBy('mssv', 'asc')->get();
                    $tenKhoa = $lop->nganh? $lop->nganh->bomon? $lop->nganh->bomon->khoa? $lop->nganh->bomon->khoa->tenkhoa :'' :'' :'';

                    foreach($dsSinhVien as $key => $sinhVien)
                    {
                        $diemHocTap = BangDiemHocTapController::GetDiemHocTap($idHocKyNamHoc, $sinhVien->id);
                        $diemTong = ServiceDanhGiaDiemRenLuyenController::GetTongDiemTheoHocKyDanhSachTieuChiLevel0($sinhVien->id, $idHocKyNamHoc, $dsTieuChi_Level_0);
                        $xepLoai = XepLoaiDiemRenLuyenController::getXepLoai($diemTong);

                        $rowRecord = [
                            ++$STT,
                            $sinhVien->mssv,
                            $sinhVien->hochulot,
                            $sinhVien->ten,
                            GioiTinhController::getGioiTinh($sinhVien->gioitinh)->tengioitinh,
                            Carbon::createFromFormat("Y-m-d", $sinhVien->ngaysinh)->format("d/m/Y"),
                            $sinhVien->email_agu,
                            $lop->tenlop,
                            $tenKhoa,
                            number_format(floatval($diemHocTap), 2, '.', ','),
                            number_format(floatval($diemTong), 2, '.', ','),
                            $xepLoai->tenxeploai
                        ];
                        // Set record data for table
                        $sheet->row(++$rowNum, $rowRecord);
                        // syslog(LOG_INFO, $rowNum. ": " . $rowRecord);
                        self::Log(var_dump($rowNum, true) . ": " . $sinhVien->mssv . " - " .$sinhVien->hochulot . " - " . $sinhVien->ten);

                    }
                }
                
            });

        })->download($fileExtend);
    }

    public static function Log($str)
    {
        $file = \storage_path('logs/drl.log');
        $result = file_put_contents($file, date('Y/m-d h:i:s') . ": " .$str . "\n", FILE_APPEND | LOCK_EX);
        

        // echo $result;

    }
}
