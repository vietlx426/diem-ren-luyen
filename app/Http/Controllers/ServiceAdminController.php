<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HocKyNamHoc;
use App\SinhVien;
use App\HocKyNamHocBoTieuChi;
use App\TieuChi;
use App\BangDiemRenLuyen;
use DB;

class ServiceAdminController extends Controller
{
    public function index()
    {
		$userTotal = ServiceUserController::UserCount();
		$studentTotal = ServiceSinhVienController::SinhVienCount();
		$classTotal = LopController::LopCount();
		$staffTotal = CanBoGiangVienController::CanBoGiangVienCount();
		$dataStaticalKind = self::StaticalKind();
		return view('admin.index', ['userTotal'=>$userTotal, 'studentTotal'=>$studentTotal, 'classTotal'=>$classTotal, 'staffTotal'=>$staffTotal, 'dataStaticalKind'=>$dataStaticalKind]);
	}
	
	public static function StaticalKind()
	{
		$arrayStaticalKindByHocKyNamHoc = array();
		$dsHocKyNamHoc = HocKyNamHoc::orderBy('id', 'desc')->take(2)->get();
		foreach ($dsHocKyNamHoc as $key => $hocKyNamHoc) {
			$arrayStaticalKind = ['hockynamhoc'=>$hocKyNamHoc->hocky->mahocky . " " . trim($hocKyNamHoc->namhoc->tennamhoc) , 'xuatsac'=>'0', 'tot'=>'0', 'kha'=>'0', 'trungbinh'=>'0', 'yeu'=>'0', 'kem'=>'0'];
			
			$startYear = intval(substr(($hocKyNamHoc->namhoc->tennamhoc), 0, 4));
			$dsSinhVien = SinhVien::leftjoin('lop', 'lop.id', '=', 'sinhvien.lop_id')
				->leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
				->where('namketthuc', '>=', $startYear)
				->select('sinhvien.id')
				->get();

			$hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $hocKyNamHoc->id)->first();
			$idBoTieuChi = $hocKyNamHocBoTieuChi?$hocKyNamHocBoTieuChi->botieuchi_id:'';
			$dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $idBoTieuChi)->where('idtieuchicha', '=', 0)->select('id')->get();
			$dsSinVienDiemTong = self::GetDiemTongSinhVienTheoHocKyNamHoc($dsSinhVien, $hocKyNamHoc->id, $dsTieuChi_Level_0);

			foreach ($dsSinVienDiemTong as $key => $sinhVien) {
				if($sinhVien->diemtong >= 90)
					$arrayStaticalKind['xuatsac'] += 1;
				if($sinhVien->diemtong >= 80 && $sinhVien->diemtong < 90)
					$arrayStaticalKind['tot'] += 1;
				if($sinhVien->diemtong >= 65 && $sinhVien->diemtong < 80)
					$arrayStaticalKind['kha'] += 1;
				if($sinhVien->diemtong >= 50 && $sinhVien->diemtong < 65)
					$arrayStaticalKind['trungbinh'] += 1;
				if($sinhVien->diemtong >= 35 && $sinhVien->diemtong < 50)
					$arrayStaticalKind['yeu'] += 1;
				if($sinhVien->diemtong < 35)
					$arrayStaticalKind['kem'] += 1;
			}
			array_push($arrayStaticalKindByHocKyNamHoc, $arrayStaticalKind);
		}
		
		return $arrayStaticalKindByHocKyNamHoc;
	}

	public static function GetDiemTongSinhVienTheoHocKyNamHoc($dsSinhVien, $idHocKyNamHoc, $dsTieuChi_Level_0)
	{
		$bangDiemTieuChi_Level_0 = BangDiemRenLuyen::whereIn('sinhvien_id', $dsSinhVien)
			->where('hocky_namhoc_id', '=', $idHocKyNamHoc)
			->whereIn('tieuchi_id', $dsTieuChi_Level_0)
			->select("sinhvien_id", DB::raw('sum(diem) as diemtong'))
			->groupBy('sinhvien_id')
			->get();
		return $bangDiemTieuChi_Level_0;
	}
}