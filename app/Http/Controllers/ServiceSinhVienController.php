<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceImportSinhVienRequest;
use App\Lop;
use App\SinhVien;
use App\User;
use App\UserGroup;
use App\Tinh;
use App\Huyen;
use App\Xa;
use App\LyLich;
use Carbon\Carbon;
use Excel;
use DB;

class ServiceSinhVienController extends Controller
{
    public function ImportStudent()
    {
		$dsLop = Lop::orderBy('khoahoc_id', 'desc')->orderBy('tenlop', 'acs')->get();

		return view('admin.sinhvien_import', ['dsLop'=>$dsLop]);
    }

    public function storeImportStudent(ServiceImportSinhVienRequest $request)
    {
		$group_id_SinhVien  = 8;
		// $lop_id = $request->lop;
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

			foreach ($reader->toArray() as $key => $SinhVien) {
				$countRowExcel++;
				$resultMessage = self::validateSinhVienImport($SinhVien);

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
					$sinhVien = self::storeSinhVien($SinhVien);

					// Tạo user/pass
					if($sinhVien || count($sinhVien) > 0)
					{
						$user = self::storeUser($SinhVien, $sinhVien->id);
					}

					// Add user to group sinh viên
					if($user || count($user) > 0)
					{
						self::storeUserGroup($user->id, $group_id_SinhVien);
					}
				}
				return redirect()->route('admin_sinhvien_import')->with('success', "Import thành công.");
			}
			else
			{
				return redirect()->route('admin_sinhvien_import')->withInput()->with(['message'=>$arrayMessage['message']]);
			}
		}
		else
			return redirect()->back()->with(['danger'=>"Không tìm thấy file để import.<br>Vui lòng refresh (hoặc nhấn F5) và chọn/nhập lại thông tin"]);
    }

    public function validateSinhVienImport($SinhVien)
    {
		$arrayMessage = array('result' => true, 'message' => "" );

		// Kiểm tra họ
		if(empty(trim($SinhVien['ho'])))
		{
			$arrayMessage['result'] = false;
			$arrayMessage['message'] .= "Không có họ; ";
		}

		// Kiểm tra tên
		if(empty(trim($SinhVien['ten'])))
		{
			$arrayMessage['result'] = false;
			$arrayMessage['message'] .= "Không có tên; ";
		}

		// Kiểm tra email
		if(empty(trim($SinhVien['email'])))
		{
			$arrayMessage['result'] = false;
			$arrayMessage['message'] .= "Không có email; ";
		}

		// 1. Kiểm tra mssv
		$SinhVienExist = SinhVien::where('mssv', '=', $SinhVien['mssv'])->get();
		if(count($SinhVienExist) > 0)
		{
			$arrayMessage['result'] = false;
			$arrayMessage['message'] .= "MSSV đã tồn tại; ";
		}

		// 2. Kiểm tra email
		$SinhVienExist = SinhVien::where('email_agu', '=', $SinhVien['email'])->get();
		if(count($SinhVienExist) > 0)
		{
			$arrayMessage['result'] = false;
			$arrayMessage['message'] .= "EMAIL đã tồn tại; ";
		}

		// 3. Kiểm tra số cmnd
		$SinhVienExist = SinhVien::where('cmnd', '=', $SinhVien['cmnd'])->get();
		if(count($SinhVienExist) > 0)
		{
			$arrayMessage['result'] = false;
			$arrayMessage['message'] .= "CMND đã tồn tại; ";
		}
		
		// 4. Kiểm tra lớp
		$LopExist = Lop::where('tenlop', '=', $SinhVien['lop'])->get();
		if(count($LopExist) == 0)
		{
			$arrayMessage['result'] = false;
			$arrayMessage['message'] .= "Lớp " . $SinhVien['lop'] . " chưa có trên hệ thống;";
		}

		return $arrayMessage;
    }

    public function storeSinhVien($SinhVien)
    {
		try {
			$sinhVien = new SinhVien();

			$sinhVien->mssv = $SinhVien['mssv'];
			$sinhVien->hochulot = $SinhVien['ho'];
			$sinhVien->ten = $SinhVien['ten'];

			if(strcmp(strtoupper(trim($SinhVien['gioi_tinh'])) , "NAM") == 0)
			{
				$sinhVien->gioitinh = 1;
			}
			else
			{
				$sinhVien->gioitinh = 2;
			}

			try {
				$sinhVien->ngaysinh = date("Y-m-d", strtotime($SinhVien['ngay_sinh']));
			} catch (Exception $e) {}

			$sinhVien->email_agu = $SinhVien['email'];
			$sinhVien->cmnd = $SinhVien['cmnd'];
			$lop = ServiceLopController::GetClassByClassName($SinhVien['lop']);
			$sinhVien->lop_id = $lop?$lop->id:"";
			$sinhVien->diemtrungtuyen = $SinhVien['diem_trung_tuyen'];

			$sinhVien->save();
			
			return $sinhVien;

		} catch (Exception $e) {
			return false;
		}
    }

    public function storeUser($SinhVien, $SinhVien_id)
    {
		try {
			$user = new User();
			$user->name = $SinhVien['ho'] . " " . $SinhVien['ten'];
			$user->email = $SinhVien['email'];
			$user->password = bcrypt($SinhVien['cmnd']);
			$user->cbgvsv_id = $SinhVien_id;
			$user->idloaiuser = 3;
			$user->idtrangthaiuser = 1;

			$user->save();

			return $user;
		} catch (Exception $e) {
			return false;
		}
    }

    public function storeUserGroup($User_id, $Group_id)
    {
		try {
			$user_Group = new UserGroup();

			$user_Group->idUser = $User_id;
			$user_Group->idGroup = $Group_id;

			$user_Group->save();

			return $user_Group;
		} catch (Exception $e) {
			return false;
		}
    }

    public static function SinhVienCount()
    {
        return count(SinhVien::all());
	}

	public static function GetSinhVienByMSSV($mssv = '')
	{
		return SinhVien::where('mssv', '=', $mssv)->first();
	}

	public static function DanhSachSinhVienTheoHocKyNamHocKhoa($idHocKyNamHoc, $idKhoa)
	{
		$hocKyNamHoc = HocKyNamHocController::HocKyNamHoc($idHocKyNamHoc);
        
		$namBatDau = intval(trim(explode("-",$hocKyNamHoc->namhoc->tennamhoc)[0]));
		$namKetThuc = intval(trim(explode("-",$hocKyNamHoc->namhoc->tennamhoc)[1]));

		$hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChiController::HocKyNamHocBoTieuChi($idHocKyNamHoc);
		$idHocKyNamHocBoTieuChi = $hocKyNamHocBoTieuChi ? $hocKyNamHocBoTieuChi->botieuchi_id : '';
		$dsTieuChi_Level_0 = TieuChiController::TieuChiLevel0($idHocKyNamHocBoTieuChi);
				
		return $dsSinhVien;
	}

	public function getSinhVienByTinhHuyenXa(Request $arrayKhoaHocKhoaTinhHuyenXaID)
	{
		// return $arrayKhoaHocKhoaTinhHuyenXaID->khoaHoc[0] . " - " . $arrayKhoaHocKhoaTinhHuyenXaID->khoa[0];
		$arrayKhoaHocKhoaTinhHuyenXaID->khoaHoc = [1, 2];
		$arrayKhoaHocKhoaTinhHuyenXaID->khoa = [1];

		if($arrayKhoaHocKhoaTinhHuyenXaID->khoaHoc && $arrayKhoaHocKhoaTinhHuyenXaID->khoa)
		{
			$arrSinhVienID = SinhVien::join('lop', 'lop.id', '=', 'sinhvien.lop_id')
				-> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
				-> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
				-> whereIn('lop.khoahoc_id', $arrayKhoaHocKhoaTinhHuyenXaID->khoaHoc)
				-> whereIn('bomon.idkhoa', $arrayKhoaHocKhoaTinhHuyenXaID->khoa)
				-> select('sinhvien.id')
				-> groupBy('sinhvien.id')
				-> get();
		}
		else
		{
			if($arrayKhoaHocKhoaTinhHuyenXaID->khoaHoc)
			{
				$arrSinhVienID = SinhVien::join('lop', 'lop.id', '=', 'sinhvien.lop_id')
					-> whereIn('lop.khoahoc_id', $arrayKhoaHocKhoaTinhHuyenXaID->khoaHoc)
					-> select('sinhvien.id')
					-> groupBy('sinhvien.id')
					-> get();
			}
			else
			{
				if($arrayKhoaHocKhoaTinhHuyenXaID->khoa)
				{
					$arrSinhVienID = SinhVien::join('lop', 'lop.id', '=', 'sinhvien.lop_id')
						-> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
						-> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
						-> whereIn('bomon.idkhoa', $arrayKhoaHocKhoaTinhHuyenXaID->khoa)
						-> select('sinhvien.id')
						-> groupBy('sinhvien.id')
						-> get();
				}
				else
				{
					$arrSinhVienID = SinhVien::select('sinhvien.id')-> get();
				}
			}
		}
	
		if(count($arrSinhVienID))
			$arrSinhVienID = array_column($arrSinhVienID->toArray(), 'id');


		// $arrayKhoaHocKhoaTinhHuyenXaID->tinhID = [57, 58];
		// OK Tỉnh
		if($arrayKhoaHocKhoaTinhHuyenXaID->tinhID)
			$dsSinhVienTheoTinh = Tinh::whereIn('tinh.id', $arrayKhoaHocKhoaTinhHuyenXaID->tinhID)
				-> join('huyen', 'huyen.tinh_id', '=', 'tinh.id')
				-> join('xa', 'xa.huyen_id', '=', 'huyen.id')
				-> join(DB::raw('(select * from lylich where id in (select max(id) as max_id from lylich group by sinhvien_id)) as lylich'), 'lylich.xa_id', '=', 'xa.id')
				-> whereIn('lylich.sinhvien_id', $arrSinhVienID)
				-> select('tinh.tentinh', DB::raw('count(lylich.sinhvien_id) as soluongsinhvien'))
				-> groupBy('tinh.tentinh')
				-> get();
		else
			$dsSinhVienTheoTinh = Tinh::join('huyen', 'huyen.tinh_id', '=', 'tinh.id')
				-> join('xa', 'xa.huyen_id', '=', 'huyen.id')
				-> join(DB::raw('(select * from lylich where id in (select max(id) as max_id from lylich group by sinhvien_id)) as lylich'), 'lylich.xa_id', '=', 'xa.id')
				-> whereIn('lylich.sinhvien_id', $arrSinhVienID)
				-> select('tinh.tentinh', DB::raw('count(lylich.sinhvien_id) as soluongsinhvien'))
				-> groupBy('tinh.tentinh')
				-> get();

		// $arrayKhoaHocKhoaTinhHuyenXaID->huyenID = [640, 641];
		// OK Huyện
		if($arrayKhoaHocKhoaTinhHuyenXaID->huyenID)
			$dsSinhVienTheoHuyen = Huyen::whereIn('huyen.id', $arrayKhoaHocKhoaTinhHuyenXaID->huyenID)
				-> join('xa', 'xa.huyen_id', '=', 'huyen.id')
				-> join(DB::raw('(select * from lylich where id in (select max(id) as max_id from lylich group by sinhvien_id)) as lylich'), 'lylich.xa_id', '=', 'xa.id')
				-> whereIn('lylich.sinhvien_id', $arrSinhVienID)
				-> select('huyen.tenhuyen', DB::raw('count(lylich.sinhvien_id) as soluongsinhvien'))
				-> groupBy('huyen.tenhuyen')
				-> get();
		else
			if($arrayKhoaHocKhoaTinhHuyenXaID->tinhID)
				$dsSinhVienTheoHuyen = Tinh::whereIn('tinh.id', $arrayKhoaHocKhoaTinhHuyenXaID->tinhID)
					-> join('huyen', 'huyen.tinh_id', '=', 'tinh.id')
					-> join('xa', 'xa.huyen_id', '=', 'huyen.id')
					-> join(DB::raw('(select * from lylich where id in (select max(id) as max_id from lylich group by sinhvien_id)) as lylich'), 'lylich.xa_id', '=', 'xa.id')
					-> whereIn('lylich.sinhvien_id', $arrSinhVienID)
					-> select('huyen.tenhuyen', DB::raw('count(lylich.sinhvien_id) as soluongsinhvien'))
					-> groupBy('huyen.tenhuyen')
					-> get();
			else
				$dsSinhVienTheoHuyen = Tinh::join('huyen', 'huyen.tinh_id', '=', 'tinh.id')
					-> join('xa', 'xa.huyen_id', '=', 'huyen.id')
					-> join(DB::raw('(select * from lylich where id in (select max(id) as max_id from lylich group by sinhvien_id)) as lylich'), 'lylich.xa_id', '=', 'xa.id')
					-> whereIn('lylich.sinhvien_id', $arrSinhVienID)
					-> select('huyen.tenhuyen', DB::raw('count(lylich.sinhvien_id) as soluongsinhvien'))
					-> groupBy('huyen.tenhuyen')
					-> get();


		// $arrayKhoaHocKhoaTinhHuyenXaID->xaID = [10427, 10428];
		// OK Xã
		if($arrayKhoaHocKhoaTinhHuyenXaID->xaID)
			$dsSinhVienTheoXa = Xa::whereIn('xa.id', $arrayKhoaHocKhoaTinhHuyenXaID->xaID)
				-> join(DB::raw('(select * from lylich where id in (select max(id) as max_id from lylich group by sinhvien_id)) as lylich'), 'lylich.xa_id', '=', 'xa.id')
				-> whereIn('lylich.sinhvien_id', $arrSinhVienID)
				-> select('xa.tenxa', DB::raw('count(lylich.sinhvien_id) as soluongsinhvien'))
				-> groupBy('xa.tenxa')
				-> get();
		else
			if($arrayKhoaHocKhoaTinhHuyenXaID->huyenID)
				$dsSinhVienTheoXa = Huyen::whereIn('huyen.id', $arrayKhoaHocKhoaTinhHuyenXaID->huyenID)
					-> join('xa', 'xa.huyen_id', '=', 'huyen.id')
					-> join(DB::raw('(select * from lylich where id in (select max(id) as max_id from lylich group by sinhvien_id)) as lylich'), 'lylich.xa_id', '=', 'xa.id')
					-> whereIn('lylich.sinhvien_id', $arrSinhVienID)
					-> select('xa.tenxa', DB::raw('count(lylich.sinhvien_id) as soluongsinhvien'))
					-> groupBy('xa.tenxa')
					-> get();
			else
				if($arrayKhoaHocKhoaTinhHuyenXaID->tinhID)
					$dsSinhVienTheoXa = Tinh::whereIn('tinh.id', $arrayKhoaHocKhoaTinhHuyenXaID->tinhID)
						-> join('huyen', 'huyen.tinh_id', '=', 'tinh.id')
						-> join('xa', 'xa.huyen_id', '=', 'huyen.id')
						-> join(DB::raw('(select * from lylich where id in (select max(id) as max_id from lylich group by sinhvien_id)) as lylich'), 'lylich.xa_id', '=', 'xa.id')
						-> whereIn('lylich.sinhvien_id', $arrSinhVienID)
						-> select('xa.tenxa', DB::raw('count(lylich.sinhvien_id) as soluongsinhvien'))
						-> groupBy('xa.tenxa')
						-> get();
				else
					$dsSinhVienTheoXa = Tinh::join('huyen', 'huyen.tinh_id', '=', 'tinh.id')
						-> join('xa', 'xa.huyen_id', '=', 'huyen.id')
						-> join(DB::raw('(select * from lylich where id in (select max(id) as max_id from lylich group by sinhvien_id)) as lylich'), 'lylich.xa_id', '=', 'xa.id')
						-> whereIn('lylich.sinhvien_id', $arrSinhVienID)
						-> select('xa.tenxa', DB::raw('count(lylich.sinhvien_id) as soluongsinhvien'))
						-> groupBy('xa.tenxa')
						-> get();
		return array('dsSinhVienTheoTinh' => $dsSinhVienTheoTinh, 'dsSinhVienTheoHuyen' => $dsSinhVienTheoHuyen, 'dsSinhVienTheoXa' => $dsSinhVienTheoXa);
	}
}
