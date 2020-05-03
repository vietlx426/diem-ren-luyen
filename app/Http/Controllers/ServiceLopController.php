<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceImportLopRequest;
use Excel;
use App\Lop;
use App\KhoaHoc;
use App\BacDaoTao;
use App\Nganh;

class ServiceLopController extends Controller
{
    public function showImportClass()
    {
    	return view('admin.lopimport');
    }

    public function storeImportClass(ServiceImportLopRequest $request)
    {
		
    	if($request->hasFile('input_file')){
	        $path = $request->file('input_file')->getRealPath();

	        $reader = Excel::load($request->file('input_file')->getRealPath());

			// Lấy số dòng
            $numRow = $reader->get()->count();
            $reader->takeRows($numRow);

			// Lấy & giới hạn số cột
			$numColumn = 2;
            $reader->takeColumns($numColumn);

            $countRowExcel = 1;
			$arrayMessage = array('result' => true, 'message' => "" );
			
            foreach ($reader->toArray() as $key => $lop) {
            	$countRowExcel++;

            	$resultMessage = self::validateClassImport($lop);

            	if($resultMessage['result'] == false)
            	{
            		$arrayMessage['result'] = false;
					$arrayMessage['message'] .= "&#13; Dòng " . $countRowExcel . ": " . $resultMessage['message'];
            	}
			}
			
            if($arrayMessage['result'])
            {
            	foreach ($reader->toArray() as $key => $lop)
					$lop = self::storeLop($lop);
				
				return redirect()->route('lop')->with('success', "Import thành công.");
            }
            else
            {
            	return redirect()->route('admin_lop_import_show')->withInput()->with(['message'=>$arrayMessage['message']]);
            }
	    }
	    else
	    	return redirect()->back()->with(['danger'=>"Không tìm thấy file để import.<br>Vui lòng refresh (hoặc nhấn F5) và chọn/nhập lại thông tin"]);
	}

	public function storeLop($lop)
    {
    	try {

			$tenLop = trim($lop['ten_lop']);
			$startIndex = 2;
			$subStrLength = strlen($tenLop) - $startIndex;
			$lop = new Lop();
			$lop->malop = substr($tenLop, $startIndex, $subStrLength);
			$lop->tenlop = $tenLop;
			$lop->khoahoc_id = self::GetIDKhoaHoc($tenLop);
			$lop->nganh_id = self::GetIDNganhHoc($tenLop);
			$lop->save();
    		return $lop;
    	} catch (Exception $e) {
    		return false;
    	}
    }
	
	public function validateClassImport($lop)
    {
    	$arrayMessage = array('result' => true, 'message' => "" );
		$tenLop = trim($lop['ten_lop']);

    	// Kiểm tra tên lớp
    	if(empty($tenLop))
    	{
    		$arrayMessage['result'] = false;
    		$arrayMessage['message'] = "Không có tên lớp; ";
		}
		else
			if(self::isExistClassName($tenLop))
			{
				$arrayMessage['result'] = false;
    			$arrayMessage['message'] .= "Đã có lớp " . $tenLop . " trong hệ thống; ";
			}
			else
				if(!self::isExistNganhByClassName($tenLop))
				{
					$arrayMessage['result'] = false;
    				$arrayMessage['message'] .= "Lớp " . $tenLop . " chưa có mã ngành tương ứng trong hệ thống; ";
				}
    	return $arrayMessage;
	}
	
	public function isExistClassName($tenLop = '')
	{
		try {
			$lop = Lop::where('tenlop', '=', $tenLop)->get();
			return empty($lop->toArray()) ? false : true;
		} catch (\Throwable $th) {
			return false;
		}

		
	}
	
	public function isExistNganhByClassName($tenLop = '')
	{
		try {
			$nganhHoc = self::GetNganhByClassName($tenLop);
			return $nganhHoc ? true : false;
		} catch (\Throwable $th) {
			return false;
		}
	}

	public function GetIDKhoaHoc($tenLop = '')
	{
		$maKhoaHoc = substr($tenLop, 0, 4);
		$khoaHoc = KhoaHoc::where('makhoahoc', '=', $maKhoaHoc)->first();

		return $khoaHoc ? $khoaHoc->id : "";
	}

	public function GetIDNganhHoc($tenLop = '')
	{
		$nganhHoc = self::GetNganhByClassName($tenLop);
		return $nganhHoc ? $nganhHoc->id : "";
	}
	
	public function GetNganhByClassName($tenLop = '')
	{
		$kyHieuNganh = substr($tenLop, 4, 2);
		$bac = substr($tenLop, 0, 2);

		$bacDaoTao = BacDaoTao::where('mabac', '=', $bac)->first();
		$idBacDaoTao = $bacDaoTao?$bacDaoTao->id:"";

		$nganhHoc = Nganh::where('kyhieunganh', '=', $kyHieuNganh)
			-> where('idbacdaotao', '=', $idBacDaoTao)
			-> first();

		return $nganhHoc;
	}

	public static function GetClassByClassName($tenLop = '')
	{
		return Lop::where('tenlop', '=', strtoupper(trim($tenLop)))->first();
	}
}
