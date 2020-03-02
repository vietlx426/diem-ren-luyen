<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TieuChi;
use App\TieuChiModuleThoiGian;
use App\DiemThuongVuotTieuChi;
use App\BangDiemRenLuyen;

class ServiceModuleController extends Controller
{
    public static function KetQuaHocTapQuyDoi($valueMark='')
    {
        if($valueMark >= 3.6)
            return 10;
        if($valueMark >= 3.2 && $valueMark < 3.6)
            return 8;
        if($valueMark >= 2.5 && $valueMark < 3.2)
            return 6;
        if($valueMark >= 2.0 && $valueMark < 2.5)
            return 4;
            
        return 0;
    }

    public static function KeKhaiLyLich($idSinhVien, $idHocKyNamHoc, $idTieuChiModule)
    {
        $tieuChiModuleThoiGian = TieuChiModuleThoiGian::where('hockynamhoc_id', '=', $idHocKyNamHoc)
            ->where('tieuchimodule_id', '=', $idTieuChiModule)
            ->first();
        if($tieuChiModuleThoiGian)
        {
            $lyLich = LyLich::where('sinhvien_id', '=', $idSinhVien)
                ->where('created_at', '>=', $tieuChiModuleThoiGian->thoigianbatdau)
                ->where('created_at', '<=', $tieuChiModuleThoiGian->thoigianketthuc)
                ->first();
            if($lyLich)
            {
                $tieuChiModule = TieuChiModule::find($idTieuChiModule);
                $diem = $tieuChiModule ? $tieuChiModule->tieuchi->diemtoida : 0;
                return $diem;
            }
            else
                return 0;
        }
        return -1;
    }

    public static function KetQuaSinhHoatCongDanQuyDoi($valueMark='')
    {
        if($valueMark >= 0 && $valueMark <= 10)
            return (float)(floatval($valueMark) * 0.5);
        return 0;
    }

    public static function DiemThuongTieuChiChinhTriXaHoi($idSinhVien, $idHocKyNamHoc)
    {
        $idModule = 4;
        $dsdiemCongVuotTieuChi = DiemThuongVuotTieuChi::where('moduletinhdiem_id', '=', $idModule)->get();
        $dsdiemCongVuotIDTieuChi = DiemThuongVuotTieuChi::where('moduletinhdiem_id', '=', $idModule)->select('congtieuchi_id')->get();

        foreach ($dsdiemCongVuotTieuChi as $key => $diemCongVuotTieuChi) {
            $bangDiemRenLuyen_TieuChi_SinhVien = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                ->where('sinhvien_id', '=', $idSinhVien)
                ->where('tieuchi_id', '=', $diemCongVuotTieuChi->tieuchi_id)
                ->first();
            $diemVuot = $bangDiemRenLuyen_TieuChi_SinhVien ? floatval($bangDiemRenLuyen_TieuChi_SinhVien->diem - $bangDiemRenLuyen_TieuChi_SinhVien->maxdiem) : 0;
            if($diemVuot > $diemCongVuotTieuChi->minvuot && $diemVuot <= $diemCongVuotTieuChi->maxvuot)
            {
                // 1 Xóa các điểm đã cộng
                $dsBangDiemTieuChiDaDuocCongDiem = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    ->where('sinhvien_id', '=', $idSinhVien)
                    ->whereIn('tieuchi_id', $dsdiemCongVuotIDTieuChi)
                    ->where('diemthuong', '=', 1)
                    ->get();
                foreach ($dsBangDiemTieuChiDaDuocCongDiem as $key => $bangDiemTieuChiDaDuocCongDiem) {
                    $bangDiemTieuChiDaDuocCongDiem->diem -= $bangDiemTieuChiDaDuocCongDiem->maxdiem;
                    $bangDiemTieuChiDaDuocCongDiem->diemthuong = 0;
                    $bangDiemTieuChiDaDuocCongDiem->save();
                    ServiceTieuChiMinhChungController::UpdateDiemTieuChiCha($bangDiemTieuChiDaDuocCongDiem->tieuchi, $idHocKyNamHoc, $idSinhVien);
                }
                // 2. Cộng điểm thưởng
                $tieuChiDuocCong = TieuChi::find($diemCongVuotTieuChi->congtieuchi_id);
                $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    ->where('sinhvien_id', '=', $idSinhVien)
                    ->where('tieuchi_id', '=', $diemCongVuotTieuChi->congtieuchi_id)
                    ->first();
                if(!$bangDiemRenLuyen)
                    $bangDiemRenLuyen = BangDiemRenLuyen::create(array('hocky_namhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$idSinhVien, 'tieuchi_id'=>$tieuChiDuocCong->id, 'maxdiem'=>$tieuChiDuocCong->diemtoida, 'diem'=>$tieuChiDuocCong->diemmacdinh));
                $bangDiemRenLuyen->diem += $diemCongVuotTieuChi->diemcong;
                $bangDiemRenLuyen->diemthuong = 1;
                $bangDiemRenLuyen->save();
                ServiceTieuChiMinhChungController::UpdateDiemTieuChiCha($tieuChiDuocCong, $idHocKyNamHoc, $idSinhVien);
            }
        }

        return "";
    }

    public static function DiemThuongTieuChiTinhNguyen($idSinhVien, $idHocKyNamHoc)
    {
        $idModule = 5;
        $dsdiemCongVuotTieuChi = DiemThuongVuotTieuChi::where('moduletinhdiem_id', '=', $idModule)->get();
        $dsdiemCongVuotIDTieuChi = DiemThuongVuotTieuChi::where('moduletinhdiem_id', '=', $idModule)->select('congtieuchi_id')->get();

        foreach ($dsdiemCongVuotTieuChi as $key => $diemCongVuotTieuChi) {
            $bangDiemRenLuyen_TieuChi_SinhVien = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                ->where('sinhvien_id', '=', $idSinhVien)
                ->where('tieuchi_id', '=', $diemCongVuotTieuChi->tieuchi_id)
                ->first();
            $diemVuot = $bangDiemRenLuyen_TieuChi_SinhVien ? floatval($bangDiemRenLuyen_TieuChi_SinhVien->diem - $bangDiemRenLuyen_TieuChi_SinhVien->maxdiem) : 0;
            if($diemVuot > $diemCongVuotTieuChi->minvuot && $diemVuot <= $diemCongVuotTieuChi->maxvuot)
            {
                // 1 Xóa các điểm đã cộng
                $dsBangDiemTieuChiDaDuocCongDiem = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    ->where('sinhvien_id', '=', $idSinhVien)
                    ->whereIn('tieuchi_id', $dsdiemCongVuotIDTieuChi)
                    ->where('diemthuong', '=', 1)
                    ->get();
                foreach ($dsBangDiemTieuChiDaDuocCongDiem as $key => $bangDiemTieuChiDaDuocCongDiem) {
                    $bangDiemTieuChiDaDuocCongDiem->diem -= $bangDiemTieuChiDaDuocCongDiem->maxdiem;
                    $bangDiemTieuChiDaDuocCongDiem->diemthuong = 0;
                    $bangDiemTieuChiDaDuocCongDiem->save();
                    ServiceTieuChiMinhChungController::UpdateDiemTieuChiCha($bangDiemTieuChiDaDuocCongDiem->tieuchi, $idHocKyNamHoc, $idSinhVien);
                }

                $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    ->where('sinhvien_id', '=', $idSinhVien)
                    ->where('tieuchi_id', '=', $diemCongVuotTieuChi->congtieuchi_id)
                    ->first();
                if(!$bangDiemRenLuyen)
                {
                    $tieuChiDuocCong = TieuChi::find($diemCongVuotTieuChi->congtieuchi_id);
                    $bangDiemRenLuyen = BangDiemRenLuyen::create(array('hocky_namhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$idSinhVien, 'tieuchi_id'=>$tieuChiDuocCong->id, 'maxdiem'=>$tieuChiDuocCong->diemtoida, 'diem'=>$tieuChiDuocCong->diemmacdinh));
                }
                $bangDiemRenLuyen->diem += $diemCongVuotTieuChi->diemcong;
                $bangDiemRenLuyen->diemthuong = 1;
                $bangDiemRenLuyen->save();
                ServiceTieuChiMinhChungController::UpdateDiemTieuChiCha($bangDiemRenLuyen->tieuchi, $idHocKyNamHoc, $idSinhVien);
            }
        }

        return "";
    }
}
