<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SinhVien;
use App\TieuChi;
use App\BangDiemRenLuyen;
use Auth;
use DB;
use Excel;
use App\Lop;
use App\HocKyNamHoc;
use App\HocKyNamHocBoTieuChi;
use App\Khoa;
use App\CoVanHocTap;

class ServiceDanhGiaDiemRenLuyenController extends Controller
{
    public function BanCanSuDanhGiaDiemRenLuyen_show()
    {
        if(Auth::check())
        {
            $lop_id = SinhVien::find(Auth::user()->cbgvsv_id)->lop_id;

            $DS_SinhVien = SinhVien::where('lop_id', '=', $lop_id)->select('id', 'mssv', 'hochulot', 'ten')->orderBy('mssv', 'asc')->get();//->take(5);
            $DS_TieuChi_Level_0 = TieuChi::where('idtieuchicha', '=', 0)->get();

            $MaxLevel = self::CountLevel($DS_TieuChi_Level_0, 0);

            return view('bancansu.danhgiadiemrenluyen', ['DS_SinhVien'=>$DS_SinhVien, 'DS_TieuChi_Level_0'=>$DS_TieuChi_Level_0, 'MaxLevel'=>$MaxLevel]);
        }
        else
        {
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
        }
    }

    public function CoVanHocTapDanhGiaDiemRenLuyen_show()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $idCBGV = $user->cbgvsv_id ? $user->cbgvsv_id : "";

            $coVanHocTap = CoVanHocTap::where('canbogiangvien_id', '=', $idCBGV)
                -> where('trangthai_id', '=', 1)
                -> first();

            $idLop = $coVanHocTap ? $coVanHocTap->lop_id : "";

            $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->select('id', 'mssv', 'hochulot', 'ten')->get();

            $DS_TieuChi_Level_0 = TieuChi::where('idtieuchicha', '=', 0)->get();

            $MaxLevel = self::CountLevel($DS_TieuChi_Level_0, 0);

            return view('covanhoctap.danhgiadiemrenluyen', ['DS_SinhVien'=>$DS_SinhVien, 'DS_TieuChi_Level_0'=>$DS_TieuChi_Level_0, 'MaxLevel'=>$MaxLevel]);
        }
        else
        {
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
        }
        
    }

    public function GiaoVuKhoaDanhGiaDiemRenLuyen_show($idLop)
    {

        if(Auth::check())
        {
            $idHocKyNamHoc = HocKyNamHocController::getIdHocKyNamHocHienHanh();
            $DS_TieuChiCongDiemTrucTiep = TieuChiController::getArrayIDTieuChiCongDiemTrucTiep($idHocKyNamHoc);
            
            $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->select('id', 'mssv', 'hochulot', 'ten')->get();
            $DS_TieuChi_Level_0 = TieuChi::where('idtieuchicha', '=', 0)->get();

            $MaxLevel = self::CountLevel($DS_TieuChi_Level_0, 0);

            return view('giaovukhoa.danhgiadiemrenluyen', ['DS_SinhVien'=>$DS_SinhVien, 'DS_TieuChi_Level_0'=>$DS_TieuChi_Level_0, 'DS_TieuChiCongDiemTrucTiep'=>$DS_TieuChiCongDiemTrucTiep, 'MaxLevel'=>$MaxLevel, 'idLop'=>$idLop]);
        }
        else
        {
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
        }
    }

    public function ChuyenVienDanhGiaDiemRenLuyen_show($idLop)
    {

        if(Auth::check())
        {
            $idHocKyNamHoc = HocKyNamHocController::getIdHocKyNamHocHienHanh();
            $DS_TieuChiCongDiemTrucTiep = TieuChiController::getArrayIDTieuChiCongDiemTrucTiep($idHocKyNamHoc);
            
            $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->select('id', 'mssv', 'hochulot', 'ten')->get();
            $DS_TieuChi_Level_0 = TieuChi::where('idtieuchicha', '=', 0)->get();

            $MaxLevel = self::CountLevel($DS_TieuChi_Level_0, 0);

            return view('subadmin.danhgiadiemrenluyen', ['DS_SinhVien'=>$DS_SinhVien, 'DS_TieuChi_Level_0'=>$DS_TieuChi_Level_0, 'DS_TieuChiCongDiemTrucTiep'=>$DS_TieuChiCongDiemTrucTiep, 'MaxLevel'=>$MaxLevel, 'idLop'=>$idLop]);
        }
        else
        {
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
        }
    }

    public function BanCanSuDanhGiaDiemRenLuyen_store(Request $request)
    {
        
        if(Auth::check())
        {
            if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_BANCANSU')))
            {
                $idsv=Auth::user()->cbgvsv_id;
                $idLop = SinhVien::find($idsv)->lop_id;

                $idHocKyNamHocHienHanh =  HocKyNamHocController::getIdHocKyNamHocHienHanh();

                self::setZeroBangDiem_BanCanSu($idLop, $idHocKyNamHocHienHanh);

                self::checkInsert_DS_SinhVien_TieuChi_ToBangDiem($idLop, $idHocKyNamHocHienHanh);

                self::setNewMark($request, $idLop, $idHocKyNamHocHienHanh);

                self::calculatorMarkForTieuChiTongHop($idLop, $idHocKyNamHocHienHanh);

                return redirect()->route('bancansu_danhgiadiemrenluyen')->with('success', "Lưu thành công!");
            }
            else
                return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cập chức năng này.");

        }
        else
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cập chức năng này.");
    }

    public function CoVanHocTapDanhGiaDiemRenLuyen_store(Request $request)
    {
        
        if(Auth::check())
        {
            $user = Auth::user();
            $idCBGV = $user->cbgvsv_id ? $user->cbgvsv_id : "";

            $coVanHocTap = CoVanHocTap::where('canbogiangvien_id', '=', $idCBGV)
                -> where('trangthai_id', '=', 1)
                -> first();

            $idLop = $coVanHocTap ? $coVanHocTap->lop_id : "";

            $idHocKyNamHocHienHanh =  HocKyNamHocController::getIdHocKyNamHocHienHanh();

            self::setZeroBangDiem_CoVanHocTap($idLop, $idHocKyNamHocHienHanh);

            self::checkInsert_DS_SinhVien_TieuChi_ToBangDiem($idLop, $idHocKyNamHocHienHanh);

            self::setNewMarkAdviser($request, $idLop, $idHocKyNamHocHienHanh);

            self::calculatorMarkForTieuChiTongHopCoVanHocTap($idLop, $idHocKyNamHocHienHanh);

            return redirect()->route('covanhoctap_danhgiadiemrenluyen')->with('success', "Lưu thành công!");
            

        }
        else
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cập chức năng này.");
    }

    public function GiaoVuKhoaDanhGiaDiemRenLuyen_store(Request $request)
    {
        if(Auth::check())
        {
            $idLop = $request->idLop;

            $idHocKyNamHocHienHanh =  HocKyNamHocController::getIdHocKyNamHocHienHanh();

            self::setZeroBangDiem_GiaoVuKhoa($idLop, $idHocKyNamHocHienHanh);

            self::checkInsert_DS_SinhVien_TieuChi_ToBangDiem($idLop, $idHocKyNamHocHienHanh);

            self::setNewMarkCouncilFaculty($request, $idLop, $idHocKyNamHocHienHanh);

            self::calculatorMarkForTieuChiTongHopGiaoVuKhoa($idLop, $idHocKyNamHocHienHanh);

            return redirect()->route('giaovukhoa_danhgiadiemrenluyen_lop', ['id'=>$idLop])->with('success', "Lưu thành công!");
            

        }
        else
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cập chức năng này.");
    }

    public function ChuyenVienDanhGiaDiemRenLuyen_store(Request $request)
    {
        if(Auth::check())
        {
            $idLop = $request->idLop;

            $idHocKyNamHocHienHanh =  HocKyNamHocController::getIdHocKyNamHocHienHanh();

            self::setZeroBangDiem_HoiDongTruong($idLop, $idHocKyNamHocHienHanh);

            self::checkInsert_DS_SinhVien_TieuChi_ToBangDiem($idLop, $idHocKyNamHocHienHanh);

            self::setNewMarkCouncilUniversity($request, $idLop, $idHocKyNamHocHienHanh);

            self::calculatorMarkForTieuChiTongHopHoiDongTruong($idLop, $idHocKyNamHocHienHanh);

            return redirect()->route('subadmin_danhgiadiemrenluyen_lop', ['id'=>$idLop])->with('success', "Lưu thành công!");
            

        }
        else
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cập chức năng này.");
    }

    // public function SubadminDanhGiaDiemRenLuyen_show()
    // {
    //     if(Auth::check())
    //     {
    //         if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_CHUYENVIEN')))
    //         {
    //             $dsKhoa = Khoa::orderBy('tenkhoa', 'asc')->get();

    //             return view('subadmin.danhgiadiemrenluyen', ['dsKhoa'=>$dsKhoa]);
    //         }
    //         else
    //         {
    //             return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
    //         }

    //     }
    //     else
    //     {
    //         return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
    //     }
        
    // }

    // public function SubadminDanhGiaDiemRenLuyen_Lop_show($idLop)
    // {
    //     if(Auth::check())
    //     {
    //         if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_CHUYENVIEN')))
    //         {
    //             $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->select('id', 'mssv', 'hochulot', 'ten')->get();
    //             $DS_TieuChi_Level_0 = TieuChi::where('idtieuchicha', '=', 0)->get();

    //             $MaxLevel = self::CountLevel($DS_TieuChi_Level_0, 0);

    //             return view('subadmin.danhgiadiemrenluyen_lop', ['DS_SinhVien'=>$DS_SinhVien, 'DS_TieuChi_Level_0'=>$DS_TieuChi_Level_0, 'MaxLevel'=>$MaxLevel]);
    //         }
    //         else
    //         {
    //             return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
    //         }

    //     }
    //     else
    //     {
    //         return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
    //     }
        
    // }


    public function setZeroBangDiem_BanCanSu($idLop, $idHocKy)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->get();

        foreach ($DS_SinhVien as $key => $SinhVien) {
            self::setZeroBangDiem_TheoSinhVien($idHocKy, $SinhVien->id);
        }
    }

    public function setZeroBangDiem_CoVanHocTap($idLop, $idHocKy)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->get();

        foreach ($DS_SinhVien as $key => $SinhVien) {
            self::setZeroBangDiemCoVanHocTap_TheoSinhVien($idHocKy, $SinhVien->id);
        }
    }

    public function setZeroBangDiem_GiaoVuKhoa($idLop, $idHocKy)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->get();

        foreach ($DS_SinhVien as $key => $SinhVien) {
            self::setZeroBangDiemGiaoVuKhoa_TheoSinhVien($idHocKy, $SinhVien->id);
        }
    }

    public function setZeroBangDiem_HoiDongTruong($idLop, $idHocKy)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->get();

        foreach ($DS_SinhVien as $key => $SinhVien) {
            self::setZeroBangDiemHoiDongTruong_TheoSinhVien($idHocKy, $SinhVien->id);
        }
    }

    public function setZeroBangDiem_TheoSinhVien($idHocKy, $idSinhVien)
    {
        BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKy)
            -> where('sinhvien_id', '=', $idSinhVien)
            -> update(['bancansu_diem' => 0]);
    }

    public function setZeroBangDiemCoVanHocTap_TheoSinhVien($idHocKy, $idSinhVien)
    {
        BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKy)
            -> where('sinhvien_id', '=', $idSinhVien)
            -> update(['covanhoctap_diem' => 0]);
    }

    public function setZeroBangDiemGiaoVuKhoa_TheoSinhVien($idHocKy, $idSinhVien)
    {
        BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKy)
            -> where('sinhvien_id', '=', $idSinhVien)
            -> update(['hoidongkhoa_diem' => 0]);
    }

    public function setZeroBangDiemHoiDongTruong_TheoSinhVien($idHocKy, $idSinhVien)
    {
        BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKy)
            -> where('sinhvien_id', '=', $idSinhVien)
            -> update(['hoidongtruong_diem' => 0]);
    }

    public function checkInsert_DS_SinhVien_TieuChi_ToBangDiem($idLop, $idHocKyNamHoc)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->get();

        foreach ($DS_SinhVien as $key => $SinhVien) {
            self::checkInsert_SinhVien_TieuChi_ToBangDiem($SinhVien->id, $idHocKyNamHoc);
        }

    }

    public function checkInsert_SinhVien_TieuChi_ToBangDiem($idSinhVien, $idHocKyNamHoc)
    {
        $DS_TieuChi = TieuChi::where('idhocky_namhoc', '=', $idHocKyNamHoc)->get();

        foreach ($DS_TieuChi as $key => $TieuChi) {
            self::checkInsert_SinhVien_TieuChi($idSinhVien, $TieuChi->id, $idHocKyNamHoc);
        }

    }

    public function checkInsert_SinhVien_TieuChi($idSinhVien, $idTieuChi, $idHocKyNamHoc)
    {
        $SinhVien_TieuChi = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            -> where('sinhvien_id', '=', $idSinhVien)
            -> where('tieuchi_id', '=', $idTieuChi)
            -> get();

        if(count($SinhVien_TieuChi) == 0)
        {
            $bangDiemRenLuyen = new BangDiemRenLuyen();

            $bangDiemRenLuyen->hocky_namhoc_id = $idHocKyNamHoc;
            $bangDiemRenLuyen->sinhvien_id = $idSinhVien;
            $bangDiemRenLuyen->tieuchi_id = $idTieuChi;

            $bangDiemRenLuyen->save();
        }
    }

    public function setNewMark($request, $idLop, $idHocKyNamHoc)
    {
        foreach ($request->toArray() as $key => $value) {
            if($key != 'token')
            {
                $idSinhVien = explode("_", $key)[0];
                $idTieuChi = explode("_", $key)[1];
                
                $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    -> where('sinhvien_id', '=', $idSinhVien)
                    -> where('tieuchi_id', '=', $idTieuChi)
                    -> first();


                if($bangDiemRenLuyen)
                {
                    $tieuChi = TieuChi::find($idTieuChi);

                    if($value == 'on' && $tieuChi->idloaidiem == 3)
                    {
                        $bangDiemRenLuyen->bancansu_diem = $tieuChi->diemtoida;
                        $bangDiemRenLuyen->save();
                    }
                    else
                        if($value != 'on' && $tieuChi->idloaidiem == 2)
                        {
                            $bangDiemRenLuyen->bancansu_diem = min($tieuChi->diemtoida, intval($value));
                            $bangDiemRenLuyen->save();
                        }
                }
            }
        }
    }

    public function setNewMarkAdviser($request, $idLop, $idHocKyNamHoc)
    {
        foreach ($request->toArray() as $key => $value) {
            if($key != 'token')
            {
                $idSinhVien = explode("_", $key)[0];
                $idTieuChi = explode("_", $key)[1];
                
                $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    -> where('sinhvien_id', '=', $idSinhVien)
                    -> where('tieuchi_id', '=', $idTieuChi)
                    -> first();


                if($bangDiemRenLuyen)
                {
                    $tieuChi = TieuChi::find($idTieuChi);

                    if($value == 'on' && $tieuChi->idloaidiem == 3)
                    {
                        $bangDiemRenLuyen->covanhoctap_diem = $tieuChi->diemtoida;
                        $bangDiemRenLuyen->save();
                    }
                    else
                        if($value != 'on' && $tieuChi->idloaidiem == 2)
                        {
                            $bangDiemRenLuyen->covanhoctap_diem = min($tieuChi->diemtoida, intval($value));
                            $bangDiemRenLuyen->save();
                        }
                }
            }
        }
    }

    public function setNewMarkCouncilFaculty($request, $idLop, $idHocKyNamHoc)
    {
        foreach ($request->toArray() as $key => $value) {
            if($key != 'token' && $key != 'idLop')
            {
                $idSinhVien = explode("_", $key)[0];
                $idTieuChi = explode("_", $key)[1];
                
                $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    -> where('sinhvien_id', '=', $idSinhVien)
                    -> where('tieuchi_id', '=', $idTieuChi)
                    -> first();


                if($bangDiemRenLuyen)
                {
                    $tieuChi = TieuChi::find($idTieuChi);

                    if($value == 'on' && $tieuChi->idloaidiem == 3)
                    {
                        $bangDiemRenLuyen->hoidongkhoa_diem = $tieuChi->diemtoida;
                        $bangDiemRenLuyen->save();
                    }
                    else
                        if($value != 'on' && $tieuChi->idloaidiem == 2)
                        {
                            $bangDiemRenLuyen->hoidongkhoa_diem = min($tieuChi->diemtoida, intval($value));
                            $bangDiemRenLuyen->save();
                        }
                }
            }
        }
    }

    public function setNewMarkCouncilUniversity($request, $idLop, $idHocKyNamHoc)
    {
        foreach ($request->toArray() as $key => $value) {
            if($key != 'token' && $key != 'idLop')
            {
                $idSinhVien = explode("_", $key)[0];
                $idTieuChi = explode("_", $key)[1];
                
                $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    -> where('sinhvien_id', '=', $idSinhVien)
                    -> where('tieuchi_id', '=', $idTieuChi)
                    -> first();


                if($bangDiemRenLuyen)
                {
                    $tieuChi = TieuChi::find($idTieuChi);

                    if($value == 'on' && $tieuChi->idloaidiem == 3)
                    {
                        $bangDiemRenLuyen->hoidongtruong_diem = $tieuChi->diemtoida;
                        $bangDiemRenLuyen->save();
                    }
                    else
                        if($value != 'on' && $tieuChi->idloaidiem == 2)
                        {
                            $bangDiemRenLuyen->hoidongtruong_diem = min($tieuChi->diemtoida, intval($value));
                            $bangDiemRenLuyen->save();
                        }
                }
            }
        }
    }

    public function calculatorMarkForTieuChiTongHop($idLop, $idHocKyNamHoc)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->get();

        $DanhSach_TieuChi_Level_0 = TieuChi::where('idhocky_namhoc', '=', $idHocKyNamHoc)
            -> where('idtieuchicha', '=', 0)
            -> get();

        foreach ($DanhSach_TieuChi_Level_0 as $key => $TieuChi) {
            if($TieuChi->idloaidiem == 1)
            {
                foreach ($DS_SinhVien as $key => $SinhVien) {
                    self::calculatorMarkForTieuChiTongHop_Sub($idHocKyNamHoc, $SinhVien->id, $TieuChi->id);
                }
            }
        }
    }

    public function calculatorMarkForTieuChiTongHopCoVanHocTap($idLop, $idHocKyNamHoc)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->get();

        $DanhSach_TieuChi_Level_0 = TieuChi::where('idhocky_namhoc', '=', $idHocKyNamHoc)
            -> where('idtieuchicha', '=', 0)
            -> get();

        foreach ($DanhSach_TieuChi_Level_0 as $key => $TieuChi) {
            if($TieuChi->idloaidiem == 1)
            {
                foreach ($DS_SinhVien as $key => $SinhVien) {
                    self::calculatorMarkForTieuChiTongHopCoVanHocTap_Sub($idHocKyNamHoc, $SinhVien->id, $TieuChi->id);
                }
            }
        }
    }

    public function calculatorMarkForTieuChiTongHopGiaoVuKhoa($idLop, $idHocKyNamHoc)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->get();

        $DanhSach_TieuChi_Level_0 = TieuChi::where('idhocky_namhoc', '=', $idHocKyNamHoc)
            -> where('idtieuchicha', '=', 0)
            -> get();

        foreach ($DanhSach_TieuChi_Level_0 as $key => $TieuChi) {
            if($TieuChi->idloaidiem == 1)
            {
                foreach ($DS_SinhVien as $key => $SinhVien) {
                    self::calculatorMarkForTieuChiTongHopGiaoVuKhoa_Sub($idHocKyNamHoc, $SinhVien->id, $TieuChi->id);
                }
            }
        }
    }

    public function calculatorMarkForTieuChiTongHopHoiDongTruong($idLop, $idHocKyNamHoc)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->get();

        $DanhSach_TieuChi_Level_0 = TieuChi::where('idhocky_namhoc', '=', $idHocKyNamHoc)
            -> where('idtieuchicha', '=', 0)
            -> get();

        foreach ($DanhSach_TieuChi_Level_0 as $key => $TieuChi) {
            if($TieuChi->idloaidiem == 1)
            {
                foreach ($DS_SinhVien as $key => $SinhVien) {
                    self::calculatorMarkForTieuChiTongHopHoiDongTruong_Sub($idHocKyNamHoc, $SinhVien->id, $TieuChi->id);
                }
            }
        }
    }

    public function calculatorMarkForTieuChiTongHop_Sub($idHocKyNamHoc, $idSinhVien, $idTieuChi)
    {
        $DanhSach_TieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChi)->get();

        $totalMark = 0;

        foreach ($DanhSach_TieuChi as $key => $TieuChi) {
            if($TieuChi->idloaidiem == 1)
            {
                $totalMark += self::calculatorMarkForTieuChiTongHop_Sub($idHocKyNamHoc, $idSinhVien, $TieuChi->id);
            }
            else
            {
                $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    -> where('sinhvien_id', '=', $idSinhVien)
                    -> where('tieuchi_id', '=', $TieuChi->id)
                    -> first();

                $totalMark += intval($bangDiemRenLuyen->bancansu_diem);
            }
        }

        $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            -> where('sinhvien_id', '=', $idSinhVien)
            -> where('tieuchi_id', '=', $idTieuChi)
            -> first();
        
        $tieuChi = TieuChi::find($idTieuChi);

        $bangDiemRenLuyen->bancansu_diem = min(intval($tieuChi->diemtoida), $totalMark);
        $bangDiemRenLuyen->save();

        return $totalMark;
    }

    public function calculatorMarkForTieuChiTongHopCoVanHocTap_Sub($idHocKyNamHoc, $idSinhVien, $idTieuChi)
    {
        $DanhSach_TieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChi)->get();

        $totalMark = 0;

        foreach ($DanhSach_TieuChi as $key => $TieuChi) {
            if($TieuChi->idloaidiem == 1)
            {
                $totalMark += self::calculatorMarkForTieuChiTongHopCoVanHocTap_Sub($idHocKyNamHoc, $idSinhVien, $TieuChi->id);
            }
            else
            {
                $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    -> where('sinhvien_id', '=', $idSinhVien)
                    -> where('tieuchi_id', '=', $TieuChi->id)
                    -> first();

                $totalMark += intval($bangDiemRenLuyen->covanhoctap_diem);
            }
        }

        $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            -> where('sinhvien_id', '=', $idSinhVien)
            -> where('tieuchi_id', '=', $idTieuChi)
            -> first();
        
        $tieuChi = TieuChi::find($idTieuChi);

        $bangDiemRenLuyen->covanhoctap_diem = min(intval($tieuChi->diemtoida), $totalMark);
        $bangDiemRenLuyen->save();

        return $totalMark;
    }

    public function calculatorMarkForTieuChiTongHopGiaoVuKhoa_Sub($idHocKyNamHoc, $idSinhVien, $idTieuChi)
    {
        $DanhSach_TieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChi)->get();

        $totalMark = 0;

        foreach ($DanhSach_TieuChi as $key => $TieuChi) {
            if($TieuChi->idloaidiem == 1)
            {
                $totalMark += self::calculatorMarkForTieuChiTongHopGiaoVuKhoa_Sub($idHocKyNamHoc, $idSinhVien, $TieuChi->id);
            }
            else
            {
                $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    -> where('sinhvien_id', '=', $idSinhVien)
                    -> where('tieuchi_id', '=', $TieuChi->id)
                    -> first();

                $totalMark += intval($bangDiemRenLuyen->hoidongkhoa_diem);
            }
        }

        $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            -> where('sinhvien_id', '=', $idSinhVien)
            -> where('tieuchi_id', '=', $idTieuChi)
            -> first();
        
        $tieuChi = TieuChi::find($idTieuChi);

        $bangDiemRenLuyen->hoidongkhoa_diem = min(intval($tieuChi->diemtoida), $totalMark);
        $bangDiemRenLuyen->save();

        return $totalMark;
    }

    public function calculatorMarkForTieuChiTongHopHoiDongTruong_Sub($idHocKyNamHoc, $idSinhVien, $idTieuChi)
    {
        $DanhSach_TieuChi = TieuChi::where('idtieuchicha', '=', $idTieuChi)->get();

        $totalMark = 0;

        foreach ($DanhSach_TieuChi as $key => $TieuChi) {
            if($TieuChi->idloaidiem == 1)
            {
                $totalMark += self::calculatorMarkForTieuChiTongHopHoiDongTruong_Sub($idHocKyNamHoc, $idSinhVien, $TieuChi->id);
            }
            else
            {
                $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    -> where('sinhvien_id', '=', $idSinhVien)
                    -> where('tieuchi_id', '=', $TieuChi->id)
                    -> first();

                $totalMark += intval($bangDiemRenLuyen->hoidongtruong_diem);
            }
        }

        $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            -> where('sinhvien_id', '=', $idSinhVien)
            -> where('tieuchi_id', '=', $idTieuChi)
            -> first();
        
        $tieuChi = TieuChi::find($idTieuChi);

        $bangDiemRenLuyen->hoidongtruong_diem = min(intval($tieuChi->diemtoida), $totalMark);
        $bangDiemRenLuyen->save();

        return $totalMark;
    }

    public static function CountLevel($DS_TieuChi_Level_0, $Level)
    {
    	$MaxLevel = $Level;

    	foreach ($DS_TieuChi_Level_0 as $key => $TieuChi) {
    		$DS_TieuChi_Level_Sub = TieuChi::where('idtieuchicha', '=', $TieuChi->id)->get();
    		if(count($DS_TieuChi_Level_Sub) > 0)
    		{
    			// $MaxLevel++;
    			$MaxLevel_Tmp = self::CountLevel($DS_TieuChi_Level_Sub, $Level+1);
    			
    			$MaxLevel = max($MaxLevel, $MaxLevel_Tmp);
    		}
    	}

    	return $MaxLevel;
    }

    public static function CountMaxColumn($idTieuChi)
    {
    	$MaxColumn = 1;
    	$DS_TieuChi_Level_Sub = TieuChi::where('idtieuchicha', '=', $idTieuChi)->get();
    	$MaxColumn = max($MaxColumn, count($DS_TieuChi_Level_Sub))-1;

    	foreach ($DS_TieuChi_Level_Sub as $key => $TieuChi) {
    		$MaxColumn += self::CountMaxColumn($TieuChi->id);
    	}

    	return $MaxColumn;
    }

    public static function getDiemSV($idSinhVien, $idTieuChi)
    {
        $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        $BangDiemSinhVienTheoTieuChi = self::getBangDiemDanhGia($idSinhVien, $idTieuChi, $idHocKyNamHocHienHanh);//->first();
        // dd($BangDiemSinhVienTheoTieuChi->toArray());

        // if($BangDiemSinhVienTheoTeuChi)
            return $BangDiemSinhVienTheoTieuChi;
        // else
        //     return 0;
    }

    public static function getDiemSVTuDanhGia($idSinhVien, $idTieuChi)
    {
        $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();

        $BangDiemSinhVienTheoTeuChi = self::getBangDiemDanhGia($idSinhVien, $idTieuChi, $idHocKyNamHocHienHanh);

        if($BangDiemSinhVienTheoTeuChi)
            return $BangDiemSinhVienTheoTeuChi->sinhvien_diem;
        else
            return 0;
    }

    public static function getDiemBCSDanhGia($idSinhVien, $idTieuChi)
    {
        $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();

        $BangDiemSinhVienTheoTeuChi = self::getBangDiemDanhGia($idSinhVien, $idTieuChi, $idHocKyNamHocHienHanh);

        if($BangDiemSinhVienTheoTeuChi)
            return $BangDiemSinhVienTheoTeuChi->bancansu_diem;
        else
            return "NULL";
    }

    public static function getBangDiemDanhGia($idSinhVien, $idTieuChi, $idHocKyNamHoc)
    {
        $BangDiemSinhVienTheoTeuChi = BangDiemRenLuyen::where('sinhvien_id', '=', $idSinhVien)
            -> where('tieuchi_id', '=', $idTieuChi)
            -> where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            -> first();
        return $BangDiemSinhVienTheoTeuChi;
        // return $BangDiemSinhVienTheoTeuChi ? $BangDiemSinhVienTheoTeuChi[0] : $BangDiemSinhVienTheoTeuChi;
    }

    public static function GetTongDiem($idSinhVien='')
    {
        // $tongDiem_SinhVienDanhGia = 0;
        // $tongDiem_BanCanSuDanhGia = 0;
        // $tongDiem_CoVanHocTapDanhGia = 0;
        // $tongDiem_CoVanHocTapDanhGia = 0;
        // $tongDiem_HoiDongKhoaDanhGia = 0;
        // $tongDiem_HoiDongTruongDanhGia = 0;

        $idHocKyNamHocHienHanh =  HocKyNamHocController::getIdHocKyNamHocHienHanh();
        return self::GetTongDiemTheoHocKy($idSinhVien, $idHocKyNamHocHienHanh);
        // $DS_TieuChi_Level_0 = TieuChi::where('idhocky_namhoc', '=', $idHocKyNamHocHienHanh)
        //     -> where('idtieuchicha', '=', 0)
        //     -> select('id', 'diemtoida')
        //     -> get();

        // foreach ($DS_TieuChi_Level_0 as $key => $TieuChi) {
        //     $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
        //         -> where('sinhvien_id', '=', $idSinhVien)
        //         -> where('tieuchi_id', '=', $TieuChi->id)
        //         -> first();

        //     $tongDiem_SinhVienDanhGia += min(intval($TieuChi->diemtoida), intval($bangDiemRenLuyen ? $bangDiemRenLuyen->sinhvien_diem : 0));
        //     $tongDiem_BanCanSuDanhGia += min(intval($TieuChi->diemtoida), intval($bangDiemRenLuyen ? $bangDiemRenLuyen->bancansu_diem : 0));
        //     $tongDiem_CoVanHocTapDanhGia += min(intval($TieuChi->diemtoida), intval($bangDiemRenLuyen ? $bangDiemRenLuyen->covanhoctap_diem : 0));
        //     $tongDiem_HoiDongKhoaDanhGia += min(intval($TieuChi->diemtoida), intval($bangDiemRenLuyen ? $bangDiemRenLuyen->hoidongkhoa_diem : 0));
        //     $tongDiem_HoiDongTruongDanhGia += min(intval($TieuChi->diemtoida), intval($bangDiemRenLuyen ? $bangDiemRenLuyen->hoidongtruong_diem : 0));
        // }

        // return array(
        //     'tongDiem_SinhVienDanhGia'=>$tongDiem_SinhVienDanhGia,
        //     'tongDiem_BanCanSuDanhGia'=>$tongDiem_BanCanSuDanhGia,
        //     'tongDiem_CoVanHocTapDanhGia'=>$tongDiem_CoVanHocTapDanhGia,
        //     'tongDiem_HoiDongKhoaDanhGia'=>$tongDiem_HoiDongKhoaDanhGia,
        //     'tongDiem_HoiDongKhoaDanhGia'=>$tongDiem_HoiDongKhoaDanhGia,
        //     'tongDiem_HoiDongTruongDanhGia'=>$tongDiem_HoiDongTruongDanhGia
        // );
    }

    public static function GetTongDiemTheoHocKyHienHanh($idSinhVien='')
    {
        return self::GetTongDiemTheoHocKy($idSinhVien, $idHocKyNamHocHienHanh);
    }

    public static function GetTongDiemTheoHocKy($idSinhVien='', $idHocKyNamHoc='')
    {
        $idHocKyNamHocBoTieuChi = "";
        try {
            $idHocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $idHocKyNamHoc)->first()->botieuchi_id;
            BangDiemRenLuyenController::KiemTraVaTaoBangDiem($idSinhVien, $idHocKyNamHoc);
        } catch (\Throwable $th) {
            //throw $th;
        }

        $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $idHocKyNamHocBoTieuChi)
            -> where('idtieuchicha', '=', 0)
            -> select('id')
            -> get();

        // $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
        //     -> where('sinhvien_id', '=', $idSinhVien)
        //     -> whereIn('tieuchi_id', $dsTieuChi_Level_0)
        //     -> get();
            // -> select('sinhvien_id', DB::raw('sum(diem) as tongdiem'))
            // -> groupBy('sinhvien_id')
            // -> first();
        // print_r($bangDiemRenLuyen->toArray());
        $diemTong = 0;
        // foreach ($bangDiemRenLuyen as $key => $bangDiem) {
        //     $diemTong += min($bangDiem->maxdiem, $bangDiem->diem);
        //     echo "<br> Min " . $bangDiem->maxdiem . " - " . $bangDiem->diem . " => ". min($bangDiem->maxdiem, $bangDiem->diem);
        // }
        
        foreach ($dsTieuChi_Level_0 as $key => $tieuChi_Level_0) {
            $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            -> where('sinhvien_id', '=', $idSinhVien)
            -> where('tieuchi_id', $tieuChi_Level_0->id)
            -> first();

            if($bangDiemRenLuyen)
                $diemTong += min($bangDiemRenLuyen->maxdiem, $bangDiemRenLuyen->diem);
        }
        // dd($bangDiemRenLuyen->toArray());
        return $diemTong;
        
        // return $bangDiemRenLuyen?$bangDiemRenLuyen->tongdiem:0;
    }

    public static function GetTongDiemTheoHocKyDanhSachTieuChiLevel0($idSinhVien='', $idHocKyNamHoc='', $dsTieuChiLevel0)
    {
        $diemTong = 0;

        // TestController::Log("Before Tinh tong DRL (" . memory_get_usage() . ") ");

        // $dsBangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
        //     -> where('sinhvien_id', '=', $idSinhVien)
        //     -> whereIn('tieuchi_id2', $dsTieuChiLevel0)
        //     -> select('diem')
        //     -> get();

        // $strsql = "select diem from view_bangdiemrenluyen where `hocky_namhoc_id` = 6 and `sinhvien_id` = " . $idSinhVien;
        // $viewBangDiemRL = DB::select($strsql);

        // $viewBangDiemRL = DB::select("select 'diem' from view_bangdiemrenluyen where `hocky_namhoc_id` = 6 and `sinhvien_id` = 3724");

        // foreach ($viewBangDiemRL as $key => $bangDiemRenLuyen) {
        //     $diemTong += floatval($bangDiemRenLuyen->diem);
        // }


        foreach ($dsTieuChiLevel0 as $key => $tieuChi_Level_0) {
            // $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            // -> where('sinhvien_id', '=', $idSinhVien)
            // -> where('tieuchi_id', '=', $tieuChi_Level_0->id)
            // -> select('maxdiem', 'diem')
            // -> first();

            // $bangDiemRenLuyen = DB::table('bangdiemrenluyen')->where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            // -> where('sinhvien_id', '=', $idSinhVien)
            // -> where('tieuchi_id', '=', $tieuChi_Level_0->id)
            // -> select('maxdiem', 'diem')
            // -> first();
            
            $bangDiemRenLuyen = DB::select("select `maxdiem`, `diem` from bangdiemrenluyen where `hocky_namhoc_id` = ? and `sinhvien_id` = ? and `tieuchi_id` = ?", [$idHocKyNamHoc, $idSinhVien, $tieuChi_Level_0->id]);
            // dd($bangDiemRenLuyen[0]->maxdiem);
            if($bangDiemRenLuyen)
                $diemTong += min($bangDiemRenLuyen[0]->maxdiem, $bangDiemRenLuyen[0]->diem);
            else
                $diemTong += $tieuChi_Level_0->diemmacdinh;
        }

        // TestController::Log("After Tinh tong DRL (" . memory_get_usage() . ") ");
        return $diemTong;
    }

    public static function GetTongDiemTheoHocKyDanhSachTieuChiLevel01($idkhoa='', $idHocKyNamHoc='', $dsTieuChiLevel0)
    {
        $diemTong = 0;
        foreach ($dsTieuChiLevel0 as $key => $tieuChi_Level_0) {
            $bangDiemRenLuyen = DB::select("select `maxdiem`, `diem` from bangdiemrenluyen where `hocky_namhoc_id` = ? and `sinhvien_id` = ? and `tieuchi_id` = ?", [$idHocKyNamHoc, $idSinhVien, $tieuChi_Level_0->id]);
            // dd($bangDiemRenLuyen[0]->maxdiem);
            if($bangDiemRenLuyen)
                $diemTong += min($bangDiemRenLuyen[0]->maxdiem, $bangDiemRenLuyen[0]->diem);
            else
                $diemTong += $tieuChi_Level_0->diemmacdinh;
        }

        // TestController::Log("After Tinh tong DRL (" . memory_get_usage() . ") ");
        return $diemTong;
    }




    public static function GetTongDiem_SinhVien($idSinhVien)
    {
        $tongDiem_SinhVienDanhGia = 0;

        $idHocKyNamHocHienHanh =  HocKyNamHocController::getIdHocKyNamHocHienHanh();
        $DS_TieuChi_Level_0 = TieuChi::where('idhocky_namhoc', '=', $idHocKyNamHocHienHanh)
            -> where('idtieuchicha', '=', 0)
            -> select('id', 'diemtoida')
            -> get();

        foreach ($DS_TieuChi_Level_0 as $key => $TieuChi) {
            $sinhVien_Diem = 0;
            $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
                -> where('sinhvien_id', '=', $idSinhVien)
                -> where('tieuchi_id', '=', $TieuChi->id)
                -> first();
            if($bangDiemRenLuyen)
                $sinhVien_Diem = $bangDiemRenLuyen->sinhvien_diem;

            $tongDiem_SinhVienDanhGia += min(intval($TieuChi->diemtoida), intval($sinhVien_Diem));
        }

        return $tongDiem_SinhVienDanhGia;
    }

    public static function GetTongDiem_BanCanSu($idSinhVien)
    {
        $tongDiem_BanCanSuDanhGia = 0;

        $idHocKyNamHocHienHanh =  HocKyNamHocController::getIdHocKyNamHocHienHanh();
        $DS_TieuChi_Level_0 = TieuChi::where('idhocky_namhoc', '=', $idHocKyNamHocHienHanh)
            -> where('idtieuchicha', '=', 0)
            -> select('id', 'diemtoida')
            -> get();

        foreach ($DS_TieuChi_Level_0 as $key => $TieuChi) {
            $banCanSu_Diem = 0;
            $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
                -> where('sinhvien_id', '=', $idSinhVien)
                -> where('tieuchi_id', '=', $TieuChi->id)
                -> first();

            if($bangDiemRenLuyen)
                $banCanSu_Diem = $bangDiemRenLuyen->bancansu_diem;

            $tongDiem_BanCanSuDanhGia += min(intval($TieuChi->diemtoida), intval($banCanSu_Diem));
        }

        return $tongDiem_BanCanSuDanhGia;
    }

    public static function GetTongDiem_CoVanHocTap($idSinhVien)
    {
        $tongDiem_CoVanHocTapDanhGia = 0;

        $idHocKyNamHocHienHanh =  HocKyNamHocController::getIdHocKyNamHocHienHanh();

        $DS_TieuChi_Level_0 = TieuChi::where('idhocky_namhoc', '=', $idHocKyNamHocHienHanh)
            -> where('idtieuchicha', '=', 0)
            -> select('id', 'diemtoida')
            -> get();

        foreach ($DS_TieuChi_Level_0 as $key => $TieuChi) {
            $coVanHocTap_Diem = 0;
            $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
                -> where('sinhvien_id', '=', $idSinhVien)
                -> where('tieuchi_id', '=', $TieuChi->id)
                -> first();

            if($bangDiemRenLuyen)
                $coVanHocTap_Diem = $bangDiemRenLuyen->covanhoctap_diem;

            $tongDiem_CoVanHocTapDanhGia += min(intval($TieuChi->diemtoida), intval($coVanHocTap_Diem));
        }

        return $tongDiem_CoVanHocTapDanhGia;
    }

    public static function GetTongDiem_HoiDongTruong($idSinhVien)
    {
        $tongDiem_HoiDongTruongDanhGia = 0;

        $idHocKyNamHocHienHanh =  HocKyNamHocController::getIdHocKyNamHocHienHanh();
        $DS_TieuChi_Level_0 = TieuChi::where('idhocky_namhoc', '=', $idHocKyNamHocHienHanh)
            -> where('idtieuchicha', '=', 0)
            -> select('id', 'diemtoida')
            -> get();

        foreach ($DS_TieuChi_Level_0 as $key => $TieuChi) {
            $hoiDongTruong_Diem = 0;
            $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
                -> where('sinhvien_id', '=', $idSinhVien)
                -> where('tieuchi_id', '=', $TieuChi->id)
                -> first();

            if($bangDiemRenLuyen)
                $hoiDongTruong_Diem = $bangDiemRenLuyen->hoidongtruong_diem;

            $tongDiem_HoiDongTruongDanhGia += min(intval($TieuChi->diemtoida), intval($hoiDongTruong_Diem));
        }

        return $tongDiem_HoiDongTruongDanhGia;
    }

    public function exportBangDiem_BanCanSu()
    {
        if(Auth::check())
        {
            if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_BANCANSU')))
            {
                $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
                self::exportBangDiemTheoLopHocKyNamHoc(SinhVien::find(Auth::user()->cbgvsv_id)->lop->id, $idHocKyNamHocHienHanh);
                // $tenLop = SinhVien::find(Auth::user()->cbgvsv_id)->lop->tenlop;

                // $sheetName = $tenLop;
                // $fileName = "BangDiemRenLuyen_" . $tenLop;
                // $fileExtend = "xlsx";

                // $rowNum = 1;

                // // $arrayTitleSheet = ["STT", "MSSV", "HỌ", "TÊN", "GIỚI TÍNH", "NGÀY SINH", "EMAIL", "CMND", "ĐIỂM TRÚNG TUYỂN", "LỚP", "NGÀNH", "BẬC ĐÀO TẠO", "HỆ ĐÀO TẠO", "BỘ MÔN", "KHOA"];
                // // $arrayColumnWidth = array(  'A' => 5, 
                // //                             'B' => 5, 
                // //                             'C' => 5, 
                // //                             'D' => 5, 
                // //                             'E' => 5, 
                // //                             'F' => 5, 
                // //                             'G' => 5, 
                // //                             'H' => 5, 
                // //                             'I' => 5, 
                // //                             'J' => 5, 
                // //                             'K' => 5, 
                // //                             'L' => 5, 
                // //                             'M' => 5, 
                // //                             'N' => 5, 
                // //                             'O' => 5, 
                // //                         );
                

                // Excel::create($fileName, function($excel) use ($sheetName, $rowNum) {

                //     $excel->sheet($sheetName, function($sheet) use($rowNum){

                //         $DS_TieuChi_Level_0 = TieuChi::where('idtieuchicha', '=', 0)->get();

                //         $MaxLevel = self::CountLevel($DS_TieuChi_Level_0, 0);
                //         $colNum = 1;
                        
                //         // Set font with ->setStyle()
                //         $sheet->setStyle(array(
                //             'font' => array(
                //                 'name'      =>  'Times New Roman',
                //                 'size'      =>  12
                //             )
                //         ));

                        
                //         $sheet->setOrientation('landscape');

                //         // Set all margins
                //         $sheet->setPageMargin(0.25);

                //         // Freeze first row
                //         // $sheet->freezeFirstRow();

                        

                //         // Set width for a single column
                //         // $sheet->setWidth($arrayColumnWidth);
                //         for ($i=4; $i < 50; $i++) { 
                //             $sheet->setWidth(self::convertNumToColumnChar($i), 5);
                //         }

                //         // Set height for row
                //         $sheet->getRowDimension(65000)->setRowHeight(19);

                        

                //         $sheet->mergeCells('A'.$rowNum.":A".($rowNum+$MaxLevel-1));
                //         $sheet->cell('A'.$rowNum, function($cell) {
                //             $cell->setValue('MSSV');
                //         });

                //         $sheet->mergeCells('B'.$rowNum.":C".($rowNum+$MaxLevel-1));
                //         $sheet->cell('B'.$rowNum, function($cell) {
                //             $cell->setValue('HỌ VÀ TÊN');
                //         });

                //         $colNum = 4;

                //         foreach ($DS_TieuChi_Level_0 as $key => $TieuChi) {
                //             $maxColumn = self::CountMaxColumn($TieuChi->id);

                //             $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum+$maxColumn).$rowNum);

                //             $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) use($TieuChi) {
                //                 $cell->setFontWeight('bold');
                //                 $cell->setAlignment('center');

                //                 $cell->setValue(strip_tags(html_entity_decode($TieuChi->tentieuchi, ENT_COMPAT, 'UTF-8')));
                //             });

                //             $colNum += ($maxColumn+1);

                //             $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum). ($rowNum+$MaxLevel-1));

                //             $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) use($TieuChi) {
                //                 $cell->setFontWeight('bold');
                //                 $cell->setAlignment('center');

                //                 $cell->setValue("Tổng");
                //             });
                //             $colNum++;
                //         }

                //         $colNum = 4;
                //         $rowNum++;

                //         foreach ($DS_TieuChi_Level_0 as $key => $TieuChi) {
                //             $DS_TieuChi = TieuChi::where('idtieuchicha', '=', $TieuChi->id)->get();

                //             if($DS_TieuChi)
                //             {
                //                 foreach ($DS_TieuChi as $key => $TieuChi1) {
                                
                //                     $DS_TieuChi_Sub = TieuChi::where('idtieuchicha', '=', $TieuChi1->id)->get();

                //                     $maxColumn = self::CountMaxColumn($TieuChi1->id);

                //                     if(count($DS_TieuChi_Sub) > 0)
                //                     {

                //                         $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum+$maxColumn).$rowNum);

                //                         $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) use($TieuChi1) {
                //                             $cell->setAlignment('center');

                //                             $cell->setValue(strip_tags(html_entity_decode($TieuChi1->tentieuchi, ENT_COMPAT, 'UTF-8')));
                //                         });
                //                         $colNum += ($maxColumn+1);
                //                     }
                //                     else
                //                     {

                //                         $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum).($rowNum+$MaxLevel-2));

                //                          $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) use($TieuChi1) {
                //                             $cell->setAlignment('center');

                //                             $cell->setValue(strip_tags(html_entity_decode($TieuChi1->chimuctieuchi, ENT_COMPAT, 'UTF-8')));
                //                         });

                //                         $colNum++;
                //                     }
                                    
                //                 }
                //             }
                //             else
                //             {
                //                 $colNum++;
                //             }

                //             $colNum++;

                //         }

                //         $colNum = 4;
                //         $rowNum++;

                //         foreach ($DS_TieuChi_Level_0 as $key => $TieuChi) {

                //             $DS_TieuChi = TieuChi::where('idtieuchicha', '=', $TieuChi->id)->get();
                //             if($DS_TieuChi)
                //             {
                //                 foreach ($DS_TieuChi as $key => $TieuChi) {
                                
                //                     $DS_TieuChi_Sub = TieuChi::where('idtieuchicha', '=', $TieuChi->id)->get();

                //                     if(count($DS_TieuChi_Sub) > 0)
                //                     {
                //                         foreach ($DS_TieuChi_Sub as $key => $TieuChi) {
                                
                //                             $DS_TieuChi_Sub1 = TieuChi::where('idtieuchicha', '=', $TieuChi->id)->get();

                //                             $maxColumn = self::CountMaxColumn($TieuChi->id);

                //                             if(count($DS_TieuChi_Sub1) > 0)
                //                             {

                //                                 $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum+$maxColumn+1).$rowNum);

                //                                 $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) use($TieuChi) {
                //                                     $cell->setAlignment('center');

                //                                     $cell->setValue(strip_tags(html_entity_decode($TieuChi->tentieuchi, ENT_COMPAT, 'UTF-8')));
                //                                 });
                //                                 $colNum += ($maxColumn+1);
                //                             }
                //                             else
                //                             {

                //                                 $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum).($rowNum+$MaxLevel-3));

                //                                  $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) use($TieuChi) {
                //                                     $cell->setAlignment('center');

                //                                     $cell->setValue(strip_tags(html_entity_decode($TieuChi->tentieuchi, ENT_COMPAT, 'UTF-8')));
                //                                 });

                //                                 $colNum++;
                //                             }
                                            
                //                         }
                //                     }
                //                     else
                //                     {
                //                         $colNum++;
                //                     }
                                    
                //                 }
                //             }
                //             else
                //             {
                //                 $colNum++;
                //             }

                //             $colNum++;
                //         }

                //         // Set title for table
                //         // $sheet->row(++$rowNum, $arrayTitleSheet);

                //         // $STT = intval(0);
                //         // $rowNum++;

                //         $idLop = SinhVien::find(Auth::user()->cbgvsv_id)->lop_id;
                //         $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->get();

                //         $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();

                //         foreach ($DS_SinhVien as $key => $SinhVien) {
                //             $colNum = 4;
                //             $totalMark = 0;

                //             $rowRecordSinhVien = [
                //                 $SinhVien->mssv,
                //                 $SinhVien->hochulot,
                //                 $SinhVien->ten,
                //             ];

                //             foreach ($DS_TieuChi_Level_0 as $key => $TieuChi_Level_0) {

                //                 $DS_TieuChi_Level_1 = TieuChi::where('idtieuchicha', '=', $TieuChi_Level_0->id)->get();
                //                 if($DS_TieuChi_Level_1)
                //                 {
                //                     foreach ($DS_TieuChi_Level_1 as $key => $TieuChi_Level_1) {
                                    
                //                         $DS_TieuChi_Level_2 = TieuChi::where('idtieuchicha', '=', $TieuChi_Level_1->id)->get();

                //                         if(count($DS_TieuChi_Level_2) > 0)
                //                         {
                //                             foreach ($DS_TieuChi_Level_2 as $key => $TieuChi_Level_2) {
                                    
                //                                 $DS_TieuChi_Level_3 = TieuChi::where('idtieuchicha', '=', $TieuChi_Level_2->id)->get();

                //                                 if(count($DS_TieuChi_Level_3) > 0)
                //                                 {

                //                                    foreach ($DS_TieuChi_Level_3 as $key => $TieuChi_Level_3) {
                                    
                //                                         $DS_TieuChi_Level_4 = TieuChi::where('idtieuchicha', '=', $TieuChi_Level_3->id)->get();

                //                                         if(count($DS_TieuChi_Level_4) > 0)
                //                                         {
                //                                             array_push($rowRecordSinhVien, "HA");
                //                                         }
                //                                         else
                //                                         {
                                                        
                //                                             $diem = 0;
                //                                             $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
                //                                                 -> where('sinhvien_id', '=', $SinhVien->id)
                //                                                 -> where('tieuchi_id', '=', $TieuChi_Level_3->id)
                //                                                 -> first();
                //                                             if($bangDiemRenLuyen)
                //                                                 $diem = $bangDiemRenLuyen->bancansu_diem;
                //                                             array_push($rowRecordSinhVien, $diem);
                //                                         }
                                                        
                //                                     }
                //                                 }
                //                                 else
                //                                 {

                //                                     $diem = 0;
                //                                     $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
                //                                         -> where('sinhvien_id', '=', $SinhVien->id)
                //                                         -> where('tieuchi_id', '=', $TieuChi_Level_2->id)
                //                                         -> first();
                //                                     if($bangDiemRenLuyen)
                //                                         $diem = $bangDiemRenLuyen->bancansu_diem;
                //                                     array_push($rowRecordSinhVien, $diem);
                //                                 }
                                                
                //                             }
                //                         }
                //                         else
                //                         {

                //                             $diem = 0;
                //                             $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
                //                                 -> where('sinhvien_id', '=', $SinhVien->id)
                //                                 -> where('tieuchi_id', '=', $TieuChi_Level_1->id)
                //                                 -> first();
                //                             if($bangDiemRenLuyen)
                //                                 $diem = $bangDiemRenLuyen->bancansu_diem;
                //                             array_push($rowRecordSinhVien, $diem);
                //                         }
                                        
                //                     }
                //                 }
                //                 else
                //                 {

                //                     $diem = 0;
                //                     $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
                //                         -> where('sinhvien_id', '=', $SinhVien->id)
                //                         -> where('tieuchi_id', '=', $TieuChi_Level_0->id)
                //                         -> first();
                //                     if($bangDiemRenLuyen)
                //                         $diem = $bangDiemRenLuyen->bancansu_diem;
                //                     array_push($rowRecordSinhVien, $diem);
                //                 }


                //                 $diem = 0;
                //                 $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
                //                     -> where('sinhvien_id', '=', $SinhVien->id)
                //                     -> where('tieuchi_id', '=', $TieuChi_Level_0->id)
                //                     -> first();
                //                 if($bangDiemRenLuyen)
                //                     $diem = $bangDiemRenLuyen->bancansu_diem;
                                
                //                 $totalMark += intval($diem);

                //                 array_push($rowRecordSinhVien, $diem);
                //             }
                            
                //             array_push($rowRecordSinhVien, $totalMark);
                            
                //             // Set record data for table
                //             $sheet->row(++$rowNum, $rowRecordSinhVien);
                //         }
                        
                //     });

                // })->download($fileExtend);
            }
            else
            {
                return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
            }

        }
        else
        {
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
        }
    }

    public function exportBangDiem_BanCanSu_TheoHocKyNamHoc($idHocKyNamHoc)
    {
        if(Auth::check())
        {
            if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_BANCANSU')))
            {
                self::exportBangDiemTheoLopHocKyNamHoc(SinhVien::find(Auth::user()->cbgvsv_id)->lop->id, $idHocKyNamHoc);
            }
            else
            {
                return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
            }

        }
        else
        {
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
        }
    }

    public static function exportBangDiemTheoLopHocKyNamHoc($idLop = '', $idHocKyNamHoc = '')
    {
    
        $lop = Lop::find($idLop);

        $sheetName = $lop? $lop->tenlop: "";
        $fileName = "BangDiemRenLuyen_" . $lop? $lop->tenlop: "";
        $fileExtend = "xlsx";

        $rowNum = 10;

        Excel::create($fileName, function($excel) use ($sheetName, $rowNum, $idHocKyNamHoc, $lop) {

            $excel->sheet($sheetName, function($sheet) use($rowNum, $idHocKyNamHoc, $lop){
                $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);

                $DS_TieuChi_Level_0 = TieuChi::where('idtieuchicha', '=', 0)
                    -> where('idhocky_namhoc', '=', $idHocKyNamHoc)
                    -> get();

                $MaxLevel = self::CountLevel($DS_TieuChi_Level_0, 0);
                // $idLop = SinhVien::find(Auth::user()->cbgvsv_id)->lop_id;
                $DS_SinhVien = SinhVien::where('lop_id', '=', $lop->id)->get();

                $colNum = 1;
                
                // Set font with ->setStyle()
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Times New Roman',
                        'size'      =>  8
                    )
                ));

                
                $sheet->setOrientation('landscape');

                // Set all margins
                $sheet->setPageMargin(0.25);

                // Freeze first row
                // $sheet->freezeFirstRow();

                

                // Set width for a single column
                // $sheet->setWidth($arrayColumnWidth);
                $sheet->setWidth("A", 11);
                $sheet->setWidth("B", 21);
                $sheet->setWidth("C", 7);

                for ($i=4; $i < 50; $i++) { 
                    $sheet->setWidth(self::convertNumToColumnChar($i), 3);
                }

                // Set height for row
                $sheet->getRowDimension(65000)->setRowHeight(19);

                // Set tiêu đề cơ quan
                $sheet->mergeCells("A1:D1");
                $sheet->cell('A1', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValue('UBND TỈNH AN GIANG');
                });

                $sheet->mergeCells("A2:D2");
                $sheet->cell('A2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValue('TRƯỜNG ĐẠI HỌC AN GIANG');
                });

                // Set tiêu đề quốc hiệu
                $sheet->mergeCells("E1:AY1");
                $sheet->cell('E1', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValue('CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM');
                });

                $sheet->mergeCells("E2:AY2");
                $sheet->cell('E2', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValue('Độc lập - Tự do - Hạnh phúc');
                });

                // Set tiêu đề
                $sheet->mergeCells("A4:AY4");
                $sheet->cell('A4', function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValue('BẢNG TỔNG HỢP KẾT QUẢ RÈN LUYỆN SINH VIÊN');
                });

                $sheet->mergeCells("A5:AY5");
                $sheet->cell('A5', function($cell) use($hocKyNamHoc) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValue("Năm học " . $hocKyNamHoc->namhoc->tennamhoc);
                });

                $sheet->cell('D7', function($cell) use($hocKyNamHoc) {
                    $cell->setFontWeight('bold');
                    $cell->setValue($hocKyNamHoc->hocky->tenhocky);
                });
                
                $sheet->cell('D8', function($cell) use($lop)  {
                    $cell->setFontWeight('bold');
                    $cell->setValue('Lớp: '.$lop->tenlop);
                });

                $sheet->cell('Y7', function($cell) use($DS_SinhVien){
                    $cell->setFontWeight('bold');
                    $cell->setValue('Sỉ số: ' . count($DS_SinhVien));
                });

                $sheet->cell('Y8', function($cell) use($lop) {
                    $cell->setFontWeight('bold');
                    $cell->setValue('Khoa: '.$lop->nganh->bomon->khoa->tenkhoa);
                });


                $sheet->mergeCells('A'.$rowNum.":A".($rowNum+$MaxLevel-1));
                $sheet->cell('A'.$rowNum, function($cell) {
                    $cell->setValue('MSSV');
                });

                $sheet->mergeCells('B'.$rowNum.":C".($rowNum+$MaxLevel-1));
                $sheet->cell('B'.$rowNum, function($cell) {
                    $cell->setValue('HỌ VÀ TÊN');
                });

                $colNum = 4;

                foreach ($DS_TieuChi_Level_0 as $key => $TieuChi) {
                    $maxColumn = self::CountMaxColumn($TieuChi->id);

                    $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum+$maxColumn).$rowNum);

                    $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) use($TieuChi) {
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');

                        $cell->setValue(strip_tags(html_entity_decode($TieuChi->tentieuchi, ENT_COMPAT, 'UTF-8')));
                    });

                    $colNum += ($maxColumn+1);

                    $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum). ($rowNum+$MaxLevel-1));

                    $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) use($TieuChi) {
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');

                        $cell->setValue("Tổng");
                    });

                    $colNum++;
                }

                $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum). ($rowNum + 2));

                $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) {
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValue("Tổng cộng");
                });


                $colNum = 4;
                $rowNum++;

                foreach ($DS_TieuChi_Level_0 as $key => $TieuChi) {
                    $DS_TieuChi = TieuChi::where('idtieuchicha', '=', $TieuChi->id)->get();

                    if($DS_TieuChi)
                    {
                        foreach ($DS_TieuChi as $key => $TieuChi1) {
                        
                            $DS_TieuChi_Sub = TieuChi::where('idtieuchicha', '=', $TieuChi1->id)->get();

                            $maxColumn = self::CountMaxColumn($TieuChi1->id);

                            if(count($DS_TieuChi_Sub) > 0)
                            {

                                $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum+$maxColumn).$rowNum);

                                $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) use($TieuChi1) {
                                    $cell->setAlignment('center');

                                    $cell->setValue(strip_tags(html_entity_decode($TieuChi1->tentieuchi, ENT_COMPAT, 'UTF-8')));
                                });
                                $colNum += ($maxColumn+1);
                            }
                            else
                            {

                                $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum).($rowNum+$MaxLevel-2));

                                $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) use($TieuChi1) {
                                    $cell->setAlignment('center');

                                    $cell->setValue(strip_tags(html_entity_decode($TieuChi1->chimuctieuchi, ENT_COMPAT, 'UTF-8')));
                                });

                                $colNum++;
                            }
                            
                        }
                    }
                    else
                    {
                        $colNum++;
                    }

                    $colNum++;

                }

                $colNum = 4;
                $rowNum++;

                foreach ($DS_TieuChi_Level_0 as $key => $TieuChi) {

                    $DS_TieuChi = TieuChi::where('idtieuchicha', '=', $TieuChi->id)->get();
                    if($DS_TieuChi)
                    {
                        foreach ($DS_TieuChi as $key => $TieuChi) {
                        
                            $DS_TieuChi_Sub = TieuChi::where('idtieuchicha', '=', $TieuChi->id)->get();

                            if(count($DS_TieuChi_Sub) > 0)
                            {
                                foreach ($DS_TieuChi_Sub as $key => $TieuChi) {
                        
                                    $DS_TieuChi_Sub1 = TieuChi::where('idtieuchicha', '=', $TieuChi->id)->get();

                                    $maxColumn = self::CountMaxColumn($TieuChi->id);

                                    if(count($DS_TieuChi_Sub1) > 0)
                                    {

                                        $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum+$maxColumn+1).$rowNum);

                                        $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) use($TieuChi) {
                                            $cell->setAlignment('center');

                                            $cell->setValue(strip_tags(html_entity_decode($TieuChi->tentieuchi, ENT_COMPAT, 'UTF-8')));
                                        });
                                        $colNum += ($maxColumn+1);
                                    }
                                    else
                                    {

                                        $sheet->mergeCells(self::convertNumToColumnChar($colNum).$rowNum.":".self::convertNumToColumnChar($colNum).($rowNum+$MaxLevel-3));

                                        $sheet->cell(self::convertNumToColumnChar($colNum).$rowNum, function($cell) use($TieuChi) {
                                            $cell->setAlignment('center');

                                            $cell->setValue(strip_tags(html_entity_decode($TieuChi->tentieuchi, ENT_COMPAT, 'UTF-8')));
                                        });

                                        $colNum++;
                                    }
                                    
                                }
                            }
                            else
                            {
                                $colNum++;
                            }
                            
                        }
                    }
                    else
                    {
                        $colNum++;
                    }

                    $colNum++;
                }

                // Set title for table
                // $sheet->row(++$rowNum, $arrayTitleSheet);

                // $STT = intval(0);
                // $rowNum++;

                

                // $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();

                foreach ($DS_SinhVien as $key => $SinhVien) {
                    $colNum = 4;
                    $totalMark = 0;

                    $rowRecordSinhVien = [
                        $SinhVien->mssv,
                        $SinhVien->hochulot,
                        $SinhVien->ten,
                    ];

                    foreach ($DS_TieuChi_Level_0 as $key => $TieuChi_Level_0) {

                        $DS_TieuChi_Level_1 = TieuChi::where('idtieuchicha', '=', $TieuChi_Level_0->id)->get();
                        if($DS_TieuChi_Level_1)
                        {
                            foreach ($DS_TieuChi_Level_1 as $key => $TieuChi_Level_1) {
                            
                                $DS_TieuChi_Level_2 = TieuChi::where('idtieuchicha', '=', $TieuChi_Level_1->id)->get();

                                if(count($DS_TieuChi_Level_2) > 0)
                                {
                                    foreach ($DS_TieuChi_Level_2 as $key => $TieuChi_Level_2) {
                            
                                        $DS_TieuChi_Level_3 = TieuChi::where('idtieuchicha', '=', $TieuChi_Level_2->id)->get();

                                        if(count($DS_TieuChi_Level_3) > 0)
                                        {

                                            foreach ($DS_TieuChi_Level_3 as $key => $TieuChi_Level_3) {
                            
                                                $DS_TieuChi_Level_4 = TieuChi::where('idtieuchicha', '=', $TieuChi_Level_3->id)->get();

                                                if(count($DS_TieuChi_Level_4) > 0)
                                                {
                                                    array_push($rowRecordSinhVien, "HA");
                                                }
                                                else
                                                {
                                                
                                                    $diem = 0;
                                                    $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                                                        -> where('sinhvien_id', '=', $SinhVien->id)
                                                        -> where('tieuchi_id', '=', $TieuChi_Level_3->id)
                                                        -> first();
                                                    if($bangDiemRenLuyen)
                                                        $diem = $bangDiemRenLuyen->bancansu_diem;
                                                    array_push($rowRecordSinhVien, $diem);
                                                }
                                                
                                            }
                                        }
                                        else
                                        {

                                            $diem = 0;
                                            $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                                                -> where('sinhvien_id', '=', $SinhVien->id)
                                                -> where('tieuchi_id', '=', $TieuChi_Level_2->id)
                                                -> first();
                                            if($bangDiemRenLuyen)
                                                $diem = $bangDiemRenLuyen->bancansu_diem;
                                            array_push($rowRecordSinhVien, $diem);
                                        }
                                        
                                    }
                                }
                                else
                                {

                                    $diem = 0;
                                    $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                                        -> where('sinhvien_id', '=', $SinhVien->id)
                                        -> where('tieuchi_id', '=', $TieuChi_Level_1->id)
                                        -> first();
                                    if($bangDiemRenLuyen)
                                        $diem = $bangDiemRenLuyen->bancansu_diem;
                                    array_push($rowRecordSinhVien, $diem);
                                }
                                
                            }
                        }
                        else
                        {

                            $diem = 0;
                            $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                                -> where('sinhvien_id', '=', $SinhVien->id)
                                -> where('tieuchi_id', '=', $TieuChi_Level_0->id)
                                -> first();
                            if($bangDiemRenLuyen)
                                $diem = $bangDiemRenLuyen->bancansu_diem;
                            array_push($rowRecordSinhVien, $diem);
                        }


                        $diem = 0;
                        $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                            -> where('sinhvien_id', '=', $SinhVien->id)
                            -> where('tieuchi_id', '=', $TieuChi_Level_0->id)
                            -> first();
                        if($bangDiemRenLuyen)
                            $diem = $bangDiemRenLuyen->bancansu_diem;
                        
                        $totalMark += intval($diem);

                        array_push($rowRecordSinhVien, $diem);
                    }
                    
                    array_push($rowRecordSinhVien, $totalMark);
                    
                    // Set record data for table
                    $sheet->row(++$rowNum, $rowRecordSinhVien);
                }
                
            });

        })->download($fileExtend);
    }

    public static function convertNumToColumnChar($num)
    {
        $tmp = intval($num);
        $str = "";
        while ($tmp > 0) {
            // if($tmp === 26)
            // {
            //     $str = chr(($numChar - 1) + 65) . $str;
            //     break;
            // }
            // else
            // {
                $numChar = $tmp % 26;
                if($numChar === 0)
                    $numChar = 26;
                $str = chr(($numChar - 1) + 65) . $str;

                $tmp = intval(($tmp-$numChar)/26);
            // }
        }

        return $str;
    }
}