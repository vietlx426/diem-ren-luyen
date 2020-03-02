<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Khoa;
use App\Lop;
use App\SinhVien;

class ServiceHinhTheController extends Controller
{
    public function adminindex()
    {
		$DanhSach_Khoa = Khoa::where('loaikhoaphong_id', '=', 1)-> orderBy('tenkhoa', 'asc')->get();
		return view('admin.hinhthe_search', ['DanhSach_Khoa' => $DanhSach_Khoa]);
    }

    public function HinhTheByLopExport(Request $arrayNganhKhoaLopID)
    {
        try {
            
            $idLop = $arrayNganhKhoaLopID->LopID[0];
            // $idLop=16;
            $lop = Lop::find($idLop);

            // Excel file
            $fileName = "1_DanhSachSinhVien" . ($lop ? "_" . $lop->tenlop : '');
            $fileExtend ="xls";
            
            $subFolder = "lop_" . $idLop;
            $zipFile = $subFolder . ".zip";
            $picPathCard = env('PIC_PATH_CARD');
            $sourcePath = $picPathCard . $subFolder;
            $destinationPath = $picPathCard .'temp_download/';
            $fullZipFile = $destinationPath .  $zipFile;
            $fullExcelFile = $destinationPath .  $fileName . "." . $fileExtend;
            $dsSinhVien = self::getSinhVienByLop($idLop);

            SinhVienController::DeleteFile($fullZipFile);
            SinhVienController::createStoreFile($dsSinhVien, $fileName, $fileExtend, $destinationPath);

            // Create zip file
            $files = $sourcePath;
            $zip = \Zipper::make($fullZipFile);
            $zip->add($files);
            $zip->add($fullExcelFile);
            $zip->close();
            return response()->download($fullZipFile);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withInput()->with("warning", "Không tìm thấy file<br>" . $th->getMessage());
        }

        // $arrayNganhKhoaLopID->LopID[0];

        // $fileName = "DanhSachSinhVien";
        // $fileExtend ="xls";
        // $DanhSach_SinhVien = self::getSinhVienByKhoaNganhLop($arrayNganhKhoaLopID);
        // return self::createFile($DanhSach_SinhVien, $fileName, $fileExtend);
    }

    public function getSinhVienByLop($idLop = '')
    {
        $dsSinhVien = SinhVien::where('lop_id', '=', $idLop)->get();
        return $dsSinhVien;
    }
}
