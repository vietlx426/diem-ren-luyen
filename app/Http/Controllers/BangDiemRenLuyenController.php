<?php

namespace App\Http\Controllers;

use App\BangDiemRenLuyen;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\SinhVien;
use App\HocKyNamHoc;
use App\ThoiGianDanhGiaDRL;
use App\TieuChi;
use App\BoTieuChi;
use App\HocKyNamHocBoTieuChi;
use App\Lop;
use App\Khoa;
use App\CoVanHocTap;
use App\Http\Controllers\HocKyNamHocController;
use PDF;
use Excel;
use Carbon\Carbon;

class BangDiemRenLuyenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function sinhvien_index()
    {
        if(Auth::check())
        {
            if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_SINHVIEN')))
            {

                $idSinhVien=Auth::user()->cbgvsv_id;
                $dsHocKyNamHoc = HocKyNamHocController::DanhSachHocKyNamHocCuaSinhVien($idSinhVien);

                return view('sinhvien.bangdiemrenluyen_all', ['dsHocKyNamHoc'=>$dsHocKyNamHoc, 'idSinhVien'=>$idSinhVien]);
            }
            else
            {
                return redirect()->back()->with('warning', "Người dùng hiện tại không có quyền sử dụng chức năng này!");
            }
        }
        return redirect()->route('home');
    }
    
    public function sinhvien_hockynamhoc($idHocKyNamHoc)
    {
        if(Auth::check())
        {
            if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_SINHVIEN')))
            {
                $totalMarks = 0;
                $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
                $idSinhVien=Auth::user()->cbgvsv_id;
                $hocKyNamHocBoTieuChi =  HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $idHocKyNamHoc)->first();

                if($hocKyNamHocBoTieuChi)
                {
                    $idBoTieuChi = $hocKyNamHocBoTieuChi->botieuchi_id;
                    $boTieuChi = BoTieuChi::find($idBoTieuChi);
                    self::KiemTraVaTaoBangDiem($idSinhVien, $idHocKyNamHoc);
                    $dsTieuChi_Level_0 = self::getDiemRenLuyen_TieuChiLevel0($idBoTieuChi, $idSinhVien, $idHocKyNamHoc);

                    $totalMaxMarks = $dsTieuChi_Level_0->sum('diemtoida');
                    // $totalMarks = $dsTieuChi_Level_0->sum('diem');

                    foreach ($dsTieuChi_Level_0 as $key => $tieuChi_Level_0) {
                        $totalMarks += min($tieuChi_Level_0->diem, $tieuChi_Level_0->diemtoida);
                    }

                    return view('sinhvien.bangdiemrenluyen_detail', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks, 'totalMaxMarks' => $totalMaxMarks, 'hocKyNamHoc'=>$hocKyNamHoc, 'idHocKyNamHoc'=>$idHocKyNamHoc, 'idSinhVien'=>$idSinhVien]);
                }
                else
                    return redirect()->back()->with('warning', "Chưa có kết quả cho " . $hocKyNamHoc->tenhockynamhoc);
            }
            else
            {
                return redirect()->back()->with('warning', "Người dùng hiện tại không có quyền sử dụng chức năng này!");
            }
        }
        return redirect()->route('home');
    }

    public function admin_bangdiemrenluyen_chitiet_theo_sinhvien_hockynamhoc($idHocKyNamHoc, $idSinhVien)
    {
        if(Auth::check())
        {
            if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_QUANTRIHETHONG')) || ServiceUserController::isGroupOfUserCurrent(env('GROUP_CHUYENVIENHETHONG')))
            {
                $totalMarks = 0;
                $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
                $hocKyNamHocBoTieuChi =  HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $idHocKyNamHoc)->first();

                if($hocKyNamHocBoTieuChi)
                {
                    $sinhVien = SinhVien::find($idSinhVien);
                    $idBoTieuChi = $hocKyNamHocBoTieuChi->botieuchi_id;
                    $boTieuChi = BoTieuChi::find($idBoTieuChi);
                    self::KiemTraVaTaoBangDiem($idSinhVien, $idHocKyNamHoc);
                    $dsTieuChi_Level_0 = self::getDiemRenLuyen_TieuChiLevel0($idBoTieuChi, $idSinhVien, $idHocKyNamHoc);
                    $totalMaxMarks = $dsTieuChi_Level_0->sum('diemtoida');
                    foreach ($dsTieuChi_Level_0 as $key => $tieuChi_Level_0) {
                        $totalMarks += min($tieuChi_Level_0->diem, $tieuChi_Level_0->diemtoida);
                    }
                    return view('admin.bangdiemrenluyen_detail', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks, 'totalMaxMarks' => $totalMaxMarks, 'hocKyNamHoc'=>$hocKyNamHoc, 'idHocKyNamHoc'=>$idHocKyNamHoc, 'idSinhVien'=>$idSinhVien, 'sinhVien'=>$sinhVien]);
                }
                else
                    return redirect()->back()->with('warning', "Chưa có kết quả cho " . $hocKyNamHoc->tenhockynamhoc);
            }
            else
            {
                return redirect()->back()->with('warning', "Người dùng hiện tại không có quyền sử dụng chức năng này!");
            }
        }
        return redirect()->route('home');
    }

    // Get danh sách tiêu chí 0 và tổng điểm và tạo bảng điểm nếu chưa có
    public function getDiemRenLuyen_TieuChiLevel0($idBoTieuChi, $idSinhVien, $idHocKyNamHoc)
    {
        $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $idBoTieuChi)->where('idtieuchicha', '=', 0)->get();
                
        foreach ($dsTieuChi_Level_0 as $key => $tieuChi_Level_0) {
            $tieuChi_Level_0_BangDiem = BangDiemRenLuyen::where('tieuchi_id', '=', $tieuChi_Level_0->id)
                ->where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                ->where('sinhvien_id', '=', $idSinhVien)
                ->first();
            
            // if(!$tieuChi_Level_0_BangDiem)
            //     $tieuChi_Level_0_BangDiem = BangDiemRenLuyen::create(array('hocky_namhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$idSinhVien, 'tieuchi_id'=>$tieuChi_Level_0->id, 'maxdiem'=>$tieuChi_Level_0->diemtoida, 'diem'=>$tieuChi_Level_0->diemmacdinh));
            if($tieuChi_Level_0_BangDiem)
                $tieuChi_Level_0->diem = $tieuChi_Level_0_BangDiem->diem;
            else
                $tieuChi_Level_0->diem = 0;
        }

        return $dsTieuChi_Level_0;
    }

    // Get tổng điểm và tạo bảng điểm nếu chưa có
    public function getDiemRenLuyen($idBoTieuChi, $idSinhVien, $idHocKyNamHoc)
    {
        $dsTieuChi_Level_0 = self::getDiemRenLuyen_TieuChiLevel0($idBoTieuChi, $idSinhVien, $idHocKyNamHoc);
        $totalMarks = 0;

        foreach ($dsTieuChi_Level_0 as $key => $tieuChi_Level_0) {
            $totalMarks += min($tieuChi_Level_0->diem, $tieuChi_Level_0->diemtoida);
        }

        return $totalMarks;
        // return $dsTieuChi_Level_0->sum('diem');
    }

    public static function KiemTraVaTaoBangDiem($idSinhVien, $idHocKyNamHoc)
    {
        $idBoTieuChi="";
        try {
            $idBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $idHocKyNamHoc)->first()->botieuchi_id;
        } catch (\Throwable $th) {
            //throw $th;
        }
        // $boTieuChi = BoTieuChi::find($idBoTieuChi);
        $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $idBoTieuChi)->where('idtieuchicha', '=', 0)->get();
        foreach ($dsTieuChi_Level_0 as $key => $tieuChi_Level_0) {
            $tieuChi_Level_0_BangDiem = BangDiemRenLuyen::where('tieuchi_id', '=', $tieuChi_Level_0->id)
                ->where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                ->where('sinhvien_id', '=', $idSinhVien)
                ->first();
            
            if(!$tieuChi_Level_0_BangDiem)
                $tieuChi_Level_0_BangDiem = BangDiemRenLuyen::create(array('hocky_namhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$idSinhVien, 'tieuchi_id'=>$tieuChi_Level_0->id, 'maxdiem'=>$tieuChi_Level_0->diemtoida, 'diem'=>$tieuChi_Level_0->diemmacdinh));
            
            if($tieuChi_Level_0->idloaidiem == 1)
                self::KiemTraVaTaoBangDiemTieuChiCon($idSinhVien, $idHocKyNamHoc, $idBoTieuChi, $tieuChi_Level_0->id);

        }
        return;
    }

    public static function KiemTraVaTaoBangDiemTieuChiCon($idSinhVien, $idHocKyNamHoc, $idBoTieuChi, $idTieuChiCha)
    {
        // $boTieuChi = BoTieuChi::find($idBoTieuChi);
        $dsTieuChiCon = TieuChi::where('botieuchi_id', '=', $idBoTieuChi)->where('idtieuchicha', '=', $idTieuChiCha)->get();
        foreach ($dsTieuChiCon as $key => $tieuChiCon) {
            $tieuChiCon_BangDiem = BangDiemRenLuyen::where('tieuchi_id', '=', $tieuChiCon->id)
                ->where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                ->where('sinhvien_id', '=', $idSinhVien)
                ->first();
            
            if(!$tieuChiCon_BangDiem)
            {
                $tieuChiCon_BangDiem = BangDiemRenLuyen::create(array('hocky_namhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$idSinhVien, 'tieuchi_id'=>$tieuChiCon->id, 'maxdiem'=>$tieuChiCon->diemtoida, 'diem'=>$tieuChiCon->diemmacdinh));
                ServiceTieuChiMinhChungController::UpdateDiemTieuChiCha($tieuChiCon, $idHocKyNamHoc, $idSinhVien);
            }

            if($tieuChiCon->idloaidiem == 1)
                self::KiemTraVaTaoBangDiemTieuChiCon($idSinhVien, $idHocKyNamHoc, $idBoTieuChi, $tieuChiCon->id);
        }
        return;
    }



    public function sinhvien_hockynamhoc_export($idHocKyNamHoc)
    {
        if(Auth::check())
        {
            if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_SINHVIEN')))
            {
                $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
                $idSinhVien=Auth::user()->cbgvsv_id;
                $sinhVien = SinhVien::find($idSinhVien);
                $idBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $idHocKyNamHoc)->first()->botieuchi_id;
                $boTieuChi = BoTieuChi::find($idBoTieuChi);

                $dsTieuChi_Level_0 = self::getDiemRenLuyen_TieuChiLevel0($idBoTieuChi, $idSinhVien, $idHocKyNamHoc);
                $totalMaxMarks = $dsTieuChi_Level_0->sum('diemtoida');
                $totalMarks = 0;
                foreach ($dsTieuChi_Level_0 as $key => $tieuChi_Level_0) {
                    $totalMarks += min($tieuChi_Level_0->diem, $tieuChi_Level_0->diemtoida);
                }

                $pdf = PDF::loadView('sinhvien.bangdiemrenluyen_export', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks, 'totalMaxMarks' => $totalMaxMarks, 'hocKyNamHoc'=>$hocKyNamHoc, 'idHocKyNamHoc'=>$idHocKyNamHoc, 'sinhVien'=>$sinhVien, 'idSinhVien'=>$idSinhVien], [], [
                    'mode'              => 'utf-8',
                    'format'           => 'A4',
                    'author'           => 'Hoang Anh',
                    'display_mode'     => 'fullpage',
                    'margin_left'       => '10.0',
                    'margin_right'      => '10.0',
                    'margin_top'        => '10.0',
                    'margin_bottom'     => '5.0'
                ]);
                
                return $pdf->download('DiemRenLuyen_' . $hocKyNamHoc->tenhockynamhoc . '.pdf');
            }
            else
            {
                return redirect()->back()->with('warning', "Người dùng hiện tại không có quyền sử dụng chức năng này!");
            }
        }
        return redirect()->route('home');
    }

    public function admin_bangdiemrenluyen_sinhvien_hockynamhoc_export($idHocKyNamHoc, $idSinhVien)
    {
        if(Auth::check())
        {
            if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_QUANTRIHETHONG')) || ServiceUserController::isGroupOfUserCurrent(env('GROUP_CHUYENVIENHETHONG')))
            {
                $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
                $sinhVien = SinhVien::find($idSinhVien);
                $idBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $idHocKyNamHoc)->first()->botieuchi_id;
                $boTieuChi = BoTieuChi::find($idBoTieuChi);

                $dsTieuChi_Level_0 = self::getDiemRenLuyen_TieuChiLevel0($idBoTieuChi, $idSinhVien, $idHocKyNamHoc);
                $totalMaxMarks = $dsTieuChi_Level_0->sum('diemtoida');
                $totalMarks = 0;
                foreach ($dsTieuChi_Level_0 as $key => $tieuChi_Level_0) {
                    $totalMarks += min($tieuChi_Level_0->diem, $tieuChi_Level_0->diemtoida);
                }

                $pdf = PDF::loadView('export.bangdiemrenluyen_canhan_export', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks, 'totalMaxMarks' => $totalMaxMarks, 'hocKyNamHoc'=>$hocKyNamHoc, 'idHocKyNamHoc'=>$idHocKyNamHoc, 'sinhVien'=>$sinhVien, 'idSinhVien'=>$idSinhVien], [], [
                    'mode'              => 'utf-8',
                    'format'           => 'A4',
                    'author'           => 'Hoang Anh',
                    'display_mode'     => 'fullpage',
                    'margin_left'       => '10.0',
                    'margin_right'      => '10.0',
                    'margin_top'        => '10.0',
                    'margin_bottom'     => '5.0'
                ]);
                
                return $pdf->download('DiemRenLuyen_'. $sinhVien->mssv . '_' . $sinhVien->hochulot . ' ' . $sinhVien->ten. '_' . $hocKyNamHoc->tenhockynamhoc . '.pdf');
            }
            else
            {
                return redirect()->back()->with('warning', "Người dùng hiện tại không có quyền sử dụng chức năng này!");
            }
        }
        return redirect()->route('home');
    }

    public function bancansu_lop_hockynamhoc_export($idHocKyNamHoc, $idLop)
    {
        if(Auth::check())
        {
            if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_SINHVIEN')))
                return self::Export_BangDiemRenLuyen_PDF_Theo_HocKyNamHoc_Lop($idHocKyNamHoc, $idLop);
            else
                return redirect()->back()->with('warning', "Người dùng hiện tại không có quyền sử dụng chức năng này!");
        }
        return redirect()->route('home');
    }

    public function covanhoctap_bangdiemrenluyen_lop_hockynamhoc_export($idHocKyNamHoc, $idLop)
    {
        if(Auth::check())
            return self::Export_BangDiemRenLuyen_PDF_Theo_HocKyNamHoc_Lop($idHocKyNamHoc, $idLop);
        return redirect()->route('home');
    }

    public function giaovukhoa_bangdiemrenluyen_lop_hockynamhoc_export($idHocKyNamHoc, $idLop)
    {
        if(Auth::check())
            return self::Export_BangDiemRenLuyen_PDF_Theo_HocKyNamHoc_Lop($idHocKyNamHoc, $idLop);
        return redirect()->route('home');
    }

    public function subadmin_bangdiemrenluyen_hockynamhoc_lop_export($idHocKyNamHoc, $idLop)
    {
        if(Auth::check())
            return self::Export_BangDiemRenLuyen_PDF_Theo_HocKyNamHoc_Lop($idHocKyNamHoc, $idLop);
        return redirect()->route('home');
    }

    public static function Export_BangDiemRenLuyen_PDF_Theo_HocKyNamHoc_Lop($idHocKyNamHoc, $idLop)
    {
        $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
            
        $lop = Lop::find($idLop);
        
        $dsSinhVien_Diem_XepLoai = self::BangDiemRenLuyen_Theo_HocKyNamHoc_Lop($idHocKyNamHoc, $idLop);

        $pdf = PDF::loadView('export.bangdiemrenluyen_hocky_lop_export', ['dsSinhVien_Diem_XepLoai'=>$dsSinhVien_Diem_XepLoai, 'lop'=>$lop, 'hocKyNamHoc'=>$hocKyNamHoc], [], [
            'mode'              => 'utf-8',
            'format'           => 'A4',
            'author'           => 'Hoang Anh',
            'display_mode'     => 'fullpage',
            'margin_left'       => '15.0',
            'margin_right'      => '15.0',
            'margin_top'        => '15.0',
            'margin_bottom'     => '10.0'
        ]);
        
        return $pdf->download('DiemRenLuyen_' . $lop->tenlop . "_" . $hocKyNamHoc->tenhockynamhoc . '.pdf');
    }

    public function bancansu_index()
    {
        if(Auth::check())
        {
            if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_BANCANSU')))
            {
                $idSinhVien=Auth::user()->cbgvsv_id;
                $sinhVien = SinhVien::find($idSinhVien);
                $lop = Lop::find($sinhVien->lop_id);
                $dsSinhVien = SinhVien::where('lop_id', '=', $sinhVien->lop_id)->orderBy('mssv', 'asc')->get();
                $dsHocKyNamHoc = HocKyNamhocController::DanhSachHocKyNamHocCuaSinhVien($idSinhVien);
                return view('bancansu.bangdiemrenluyen_index', ['lop'=>$lop, 'dsSinhVien'=>$dsSinhVien, 'dsHocKyNamHoc'=>$dsHocKyNamHoc]);
            }
            else
            {
                return redirect()->back()->with('warning', "Người dùng hiện tại không có quyền sử dụng chức năng này!");
            }
        }
        return redirect()->route('home');
    }

    public function covanhoctap_index()
    {
        if(Auth::check())
        {
            $idCBGV = Auth::user()->cbgvsv_id;
            $coVanHocTap = CoVanHocTap::where('canbogiangvien_id', '=', $idCBGV)
                -> where('trangthai_id', '=', 1)
                -> leftjoin('lop', 'lop.id', '=', 'covanhoctap.lop_id')
                -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
                -> where('khoahoc.namketthuc', '>=', date('Y'))
                -> select('covanhoctap.*')
                -> first();
            $lop = Lop::find($coVanHocTap->lop_id);
            $dsSinhVien = SinhVien::where('lop_id', '=', $lop->id)->orderBy('mssv', 'asc')->get();
            $dsHocKyNamHoc = HocKyNamhocController::DanhSachHocKyNamHocCuaLop($lop->id);

            return view('covanhoctap.bangdiemrenluyen_index', ['lop'=>$lop, 'dsSinhVien'=>$dsSinhVien, 'dsHocKyNamHoc'=>$dsHocKyNamHoc]);
        }
        return redirect()->route('home');
    }

    public function giaovukhoa_hockynamhoc_lop($idLop)
    {
        if(Auth::check())
        {
            $lop = Lop::find($idLop);
            $dsSinhVien = SinhVien::where('lop_id', '=', $lop->id)->orderBy('mssv', 'asc')->get();
            $dsHocKyNamHoc = HocKyNamhocController::DanhSachHocKyNamHocCuaLop($lop->id);

            return view('giaovukhoa.bangdiemrenluyen_ketqua', ['lop'=>$lop, 'dsSinhVien'=>$dsSinhVien, 'dsHocKyNamHoc'=>$dsHocKyNamHoc]);
        }
        return redirect()->route('home');
    }

    public function bancansu_bangdiem_hockynamhoc($idHocKyNamHoc)
    {
        if(Auth::check())
            if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_BANCANSU')))
            {
                $idLop = SinhVien::find(Auth::user()->cbgvsv_id)->lop_id;
                $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
                $dsSinhVien_Diem_XepLoai = self::BangDiemRenLuyen_Theo_HocKyNamHoc_Lop($idHocKyNamHoc, $idLop);
                return view('bancansu.bangdiemrenluyen_hockynamhoc', ['dsSinhVien_Diem_XepLoai'=>$dsSinhVien_Diem_XepLoai, 'hocKyNamHoc'=>$hocKyNamHoc, 'idHocKyNamHoc'=>$idHocKyNamHoc, 'idLop'=>$idLop]);
            }
            else
                return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
        else
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
    }

    public function covanhoctap_bangdiem_hockynamhoc($idHocKyNamHoc)
    {
        if(Auth::check())
        {
            $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
            $idCBGV = Auth::user()->cbgvsv_id;
            $coVanHocTap = CoVanHocTap::where('canbogiangvien_id', '=', $idCBGV)
                -> where('trangthai_id', '=', 1)
                -> join('lop', 'lop.id', '=', 'covanhoctap.lop_id')
                -> join('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
                -> where('khoahoc.namketthuc', '>=', date('Y'))
                -> select('covanhoctap.*')
                -> first();

            $hocKyNamHocBoTieuChi =  HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $idHocKyNamHoc)->first();
            if($hocKyNamHocBoTieuChi)
            {
                $idLop = $coVanHocTap?$coVanHocTap->lop_id:'';
                $dsSinhVien_Diem_XepLoai = self::BangDiemRenLuyen_Theo_HocKyNamHoc_Lop($idHocKyNamHoc, $idLop);
                return view('covanhoctap.bangdiemrenluyen_hockynamhoc', ['dsSinhVien_Diem_XepLoai'=>$dsSinhVien_Diem_XepLoai, 'idHocKyNamHoc'=>$idHocKyNamHoc, 'hocKyNamHoc'=>$hocKyNamHoc, 'idLop'=>$idLop]);
            }
            else
                return redirect()->back()->with('warning', "Chưa có kết quả cho " . $hocKyNamHoc->tenhockynamhoc);
        }
        else
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
    }

            
    public function giaovukhoa_bangdiem_hockynamhoc($idHocKyNamHoc, $idLop)
    {
        if(Auth::check())
        {
            $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
            $lop = Lop::find($idLop);
            $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $idHocKyNamHoc)->first();
            
            if($hocKyNamHocBoTieuChi)
            {
                $dsSinhVien_Diem_XepLoai = self::BangDiemRenLuyen_Theo_HocKyNamHoc_Lop($idHocKyNamHoc, $idLop);
                return view('giaovukhoa.bangdiemrenluyen_hockynamhoc_lop_ketqua', ['dsSinhVien_Diem_XepLoai'=>$dsSinhVien_Diem_XepLoai, 'idHocKyNamHoc'=>$idHocKyNamHoc, 'hocKyNamHoc'=>$hocKyNamHoc, 'lop'=>$lop]);
            }
            else
                return redirect()->back()->with('warning', "Chưa có kết quả cho " . $hocKyNamHoc->tenhockynamhoc);
        }
            
        else
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
    }

    public function subadmin_bangdiem_hockynamhoc_lop($idHocKyNamHoc, $idLop)
    {
        if(Auth::check())
        {
            $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
            $lop = Lop::find($idLop);
            $dsSinhVien_Diem_XepLoai = self::BangDiemRenLuyen_Theo_HocKyNamHoc_Lop($idHocKyNamHoc, $idLop);
            return view('subadmin.bangdiemrenluyen_hockynamhoc_lop_ketqua', ['dsSinhVien_Diem_XepLoai'=>$dsSinhVien_Diem_XepLoai, 'hocKyNamHoc'=>$hocKyNamHoc, 'lop'=>$lop]);
        }
            
        else
            return redirect()->route('home')->with('warning', "Người dùng không có quyền truy cấp chức năng này.");
    }


    public static function DanhSach_TieuChi_BangDiem($idHocKyNamHoc='')
    {
        if(Auth::check() && ServiceUserController::isGroupOfUserCurrent(env('GROUP_SINHVIEN')))
            $idSinhVien=Auth::user()->cbgvsv_id;
        $dsTieuChi = TieuChiController::getArrayIDTieuChi($idHocKyNamHoc);
        $dsTieuChi_Level_0 = TieuChiController::getArrayIDTieuChi_Level_0($idHocKyNamHoc);
        $ds_TieuChi_BangDiem = array();
        
        // Lấy danh sách tiêu chí và điểm theo từng tiêu chí
        foreach ($dsTieuChi as $key => $idTieuChi) {
            $tieuChi = TieuChi::where('id', '=', $idTieuChi)->first();

            $bangDiem = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                -> where('sinhvien_id', '=', $idSinhVien)
                -> where('tieuchi_id', '=', $idTieuChi)
                -> select('sinhvien_diem', 'bancansu_diem', 'covanhoctap_diem', 'hoidongkhoa_diem', 'hoidongtruong_diem')
                -> first();

            $tieuChi_BangDiem = json_decode(json_encode($tieuChi));
            
            if($bangDiem)
            {
                $tieuChi_BangDiem->sinhvien_diem = $bangDiem->sinhvien_diem;
                $tieuChi_BangDiem->bancansu_diem = $bangDiem->bancansu_diem;
                $tieuChi_BangDiem->covanhoctap_diem = $bangDiem->covanhoctap_diem;
                $tieuChi_BangDiem->hoidongkhoa_diem = $bangDiem->hoidongkhoa_diem;
                $tieuChi_BangDiem->hoidongtruong_diem = $bangDiem->hoidongtruong_diem;
            }
            else
            {
                $tieuChi_BangDiem->sinhvien_diem = 0;
                $tieuChi_BangDiem->bancansu_diem = 0;
                $tieuChi_BangDiem->covanhoctap_diem = 0;
                $tieuChi_BangDiem->hoidongkhoa_diem = 0;
                $tieuChi_BangDiem->hoidongtruong_diem = 0;
            }

            array_push($ds_TieuChi_BangDiem, $tieuChi_BangDiem);
        }

        // Tính điểm tổng cộng
        // Lấy tiêu chí và điểm theo từng tiêu chí
        $sinhvien_diem_tong = 0;
        $bancansu_diem_tong = 0;
        $covanhoctap_diem_tong = 0;
        $hoidongkhoa_diem_tong = 0;
        $hoidongtruong_diem_tong = 0;
        foreach ($dsTieuChi_Level_0->toArray() as $key => $TieuChi) {
            $TieuChi = (object) $TieuChi;
            $bangDiem = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                -> where('sinhvien_id', '=', $idSinhVien)
                -> where('tieuchi_id', '=', $TieuChi->id)
                -> select('sinhvien_diem', 'bancansu_diem', 'covanhoctap_diem', 'hoidongkhoa_diem', 'hoidongtruong_diem')
                -> first();

            if($bangDiem)
            {
                $sinhvien_diem_tong += intval($bangDiem->sinhvien_diem);
                $bancansu_diem_tong += intval($bangDiem->bancansu_diem);
                $covanhoctap_diem_tong += intval($bangDiem->covanhoctap_diem);
                $hoidongkhoa_diem_tong += intval($bangDiem->hoidongkhoa_diem);
                $hoidongtruong_diem_tong += intval($bangDiem->hoidongtruong_diem);
            }
        }

        $arrayTieuChi_BangDiem = array(
            'dstieuchibangdiem' => $ds_TieuChi_BangDiem,
            'sinhvien_diem_tong' => $sinhvien_diem_tong,
            'bancansu_diem_tong' => $bancansu_diem_tong,
            'covanhoctap_diem_tong' => $covanhoctap_diem_tong,
            'hoidongkhoa_diem_tong' => $hoidongkhoa_diem_tong,
            'hoidongtruong_diem_tong' => $hoidongtruong_diem_tong
        );

        // dd($arrayTieuChi_BangDiem);
        return (object) $arrayTieuChi_BangDiem;
    }

    

    public function sinhvien_chamdiem()
    {
        if(Auth::check())
        {
            if(ServiceUserController::isGroupOfUserCurrent(env('GROUP_SINHVIEN')))
            {

                $idsv=Auth::user()->cbgvsv_id;
                $lopid = SinhVien::find($idsv)->lop_id;
                $HocKy_HienTai = HocKyNamHoc::where('idtrangthaihocky','=','2')->first();

                $TGDG = ThoiGianDanhGiaDRL::where('lop_id', '=', $lopid) 
                    -> where('thoigianbatdau', '<=', now())
                    -> where('thoigianketthuc', '>=', now())
                    -> where('hockynamhoc_id', '=', $HocKy_HienTai->id)
                    -> get();

                $DS_BangDiemRenLuyen= BangDiemRenLuyen::where('id','-1')->get();
                $TongDiem =BangDiemRenLuyen::select(DB::raw('SUM(bangdiemrenluyen.sinhvien_diem)as T'))
                ->join('tieuchi','tieuchi_id','=','tieuchi.id')
                ->where('tieuchi.idhocky_namhoc', '=', $HocKy_HienTai->id)
                ->where('tieuchi.idtieuchicha','=',0)
                ->where('sinhvien_id','=',$idsv)->get();

                self::SortbyTieuChi($DS_BangDiemRenLuyen,"0",$HocKy_HienTai->id,$idsv);

                return view('sinhvien.bangdiemrenluyen', ['DS_BangDiem' => $DS_BangDiemRenLuyen,'HocKy'=>$HocKy_HienTai,'TongDiem'=>$TongDiem,'TGDG'=>$TGDG]);

            }
            else
            {
                return redirect()->back()->with('warning', "Người dùng hiện tại không có quyền sử dụng chức năng này!");
            }
        }
        return redirect()->route('home');
    }

     public function sinhvien_store(Request $request)
     {
        // return array('status' => true, 'message' => "sinhvien_store");
        $Array=$request->Array;
        $HocKy_HienTai = HocKyNamHoc::where('idtrangthaihocky','=','2')->first();
        $DSTieuChi = TieuChi::where('idhocky_namhoc','=',$HocKy_HienTai->id)->get();
        $idsv =Auth::user()->cbgvsv_id;
        $flag;
        $test="";
        try{
            foreach ($DSTieuChi as $TC) {
                $flag=false;
                foreach ($Array as  $value) {
                    $t = explode("-",$value);
                    if(isset($t[1])){
                        $id =$t[0];
                        $diem = $t[1];
                        if($diem>$TC->diemtoida)
                            $diem=$TC->diemtoida;
                        if($id == $TC->id){
                            $flag=true;
                            if(BangDiemRenLuyenController::isExistDiemRenLuyen($TC->id,$idsv,$HocKy_HienTai->id)){
                                $BangDiemRenLuyenold = BangDiemRenLuyen::where('tieuchi_id',$TC->id)->where('sinhvien_id',$idsv)->where('hocky_namhoc_id',$HocKy_HienTai->id)->first();
                                $BangDiemRenLuyenold->sinhvien_diem = $diem;
                                $BangDiemRenLuyenold->save();    
                            }
                            else{
                            $BangDiemRenLuyen = new BangDiemRenLuyen();
                            $BangDiemRenLuyen->tieuchi_id=$TC->id;
                            $BangDiemRenLuyen->sinhvien_diem=$diem;
                            $BangDiemRenLuyen->sinhvien_id=$idsv;
                            $BangDiemRenLuyen->hocky_namhoc_id = $HocKy_HienTai->id;
                            $BangDiemRenLuyen->bancansu_diem=0;
                            $BangDiemRenLuyen->covanhoctap_diem=0;
                            $BangDiemRenLuyen->hoidongkhoa_diem=0;
                            $BangDiemRenLuyen->hoidongtruong_diem=0;
                            $BangDiemRenLuyen->save();   
                            }
                        }
                    }
                }
                if($flag==false){
                    if(BangDiemRenLuyenController::isExistDiemRenLuyen($TC->id,$idsv,$HocKy_HienTai->id)){
                            $BangDiemRenLuyenold = BangDiemRenLuyen::where('tieuchi_id',$TC->id)->where('sinhvien_id',$idsv)->where('hocky_namhoc_id',$HocKy_HienTai->id)->first();
                            $BangDiemRenLuyenold->sinhvien_diem = 0;
                            $BangDiemRenLuyenold->save();                 
                        }
                    else{
                        $BangDiemRenLuyen = new BangDiemRenLuyen();
                        $BangDiemRenLuyen->tieuchi_id=$TC->id;
                        $BangDiemRenLuyen->sinhvien_diem=0;
                        $BangDiemRenLuyen->sinhvien_id=$idsv;
                        $BangDiemRenLuyen->hocky_namhoc_id = $HocKy_HienTai->id;
                        $BangDiemRenLuyen->bancansu_diem=0;
                        $BangDiemRenLuyen->covanhoctap_diem=0;
                        $BangDiemRenLuyen->hoidongkhoa_diem=0;
                        $BangDiemRenLuyen->hoidongtruong_diem=0;
                        $BangDiemRenLuyen->save();  
                    }
                }            
            }

            $DSC = DB::SELECT(DB::raw("SELECT * FROM `bangdiemrenluyen` WHERE tieuchi_id NOT IN(Select id FROM tieuchi WHERE idtieuchicha=0) AND (SELECT count(*) from tieuchi where idtieuchicha = bangdiemrenluyen.tieuchi_id AND idhocky_namhoc=".$HocKy_HienTai->id.")>0 AND sinhvien_id=".$idsv." AND hocky_namhoc_id=".$HocKy_HienTai->id));
    
            foreach($DSC as $dsc){
                $TongDiem = DB::SELECT(DB::raw("SELECT SUM(bangdiemrenluyen.sinhvien_diem) as TD FROM tieuchi,bangdiemrenluyen  WHERE idtieuchicha=".$dsc->tieuchi_id." AND tieuchi_id=tieuchi.id AND sinhvien_id=".$idsv." AND hocky_namhoc_id=".$HocKy_HienTai->id." AND idhocky_namhoc=".$HocKy_HienTai->id));
                $test =$test." ".$TongDiem[0]->TD;
                $TC = BangDiemRenLuyen::find($dsc->id);
                $TC->sinhvien_diem = $TongDiem[0]->TD;
                $TC->save();
            }

            $DSTCC =DB::SELECT(DB::raw("SELECT * FROM bangdiemrenluyen WHERE tieuchi_id IN (SELECT id from tieuchi WHERE idtieuchicha=0 AND idhocky_namhoc=".$HocKy_HienTai->id.") AND sinhvien_id=".$idsv." AND hocky_namhoc_id=".$HocKy_HienTai->id));

            foreach ($DSTCC as $value) {
                $TongDiem = DB::SELECT(DB::raw("SELECT SUM(bangdiemrenluyen.sinhvien_diem) as TD FROM tieuchi,bangdiemrenluyen  WHERE idtieuchicha=".$value->tieuchi_id." AND tieuchi_id=tieuchi.id AND sinhvien_id=".$idsv." AND hocky_namhoc_id=".$HocKy_HienTai->id." AND idhocky_namhoc=".$HocKy_HienTai->id));
                $TC = BangDiemRenLuyen::find($value->id);
                $TC->sinhvien_diem = $TongDiem[0]->TD;
                $TC->save();
            }

            $result =array('status'=>true,'message'=>"Lưu thành công!");
            return $result;
         }
        catch (Exception $e) {
            $result = array('status' => false, 'message' => $e);
            return $result;
        }
    }

    public function SortbyTieuChi(&$DS,$muccha,$hocky,$idsv){
        $DS_BangDiemRenLuyen= DB::select(DB::raw("SELECT  tieuchi.*,BDRL.sinhvien_diem,BDRL.sinhvien_id FROM `tieuchi` left join (Select * from bangdiemrenluyen WHERE bangdiemrenluyen.sinhvien_id=".$idsv." AND bangdiemrenluyen.hocky_namhoc_id=".$hocky.") as BDRL on tieuchi.id = BDRL.tieuchi_id WHERE tieuchi.idhocky_namhoc=".$hocky." AND tieuchi.idtieuchicha =".$muccha." order by stt"));
        foreach ($DS_BangDiemRenLuyen as $value) {
            $DS->push($value);

            BangDiemRenLuyenController::SortbyTieuChi($DS,$value->id,$hocky,$idsv);
        }
    }

    public function DSSV($id_lop)
    {
        $DS_SV = BangDiemRenLuyen::join(
        DB::raw("(SELECT bangdiemrenluyen.sinhvien_id,SUM(bangdiemrenluyen.sinhvien_diem)as SV , SUM(bangdiemrenluyen.bancansu_diem) as BCS ,SUM(bangdiemrenluyen.covanhoctap_diem)as CVHT,SUM(bangdiemrenluyen.hoidongkhoa_diem)as HDK,SUM(bangdiemrenluyen.hoidongtruong_diem)as HDT FROM bangdiemrenluyen GROUP by bangdiemrenluyen.sinhvien_id ) as TD"), function($join){
        $join->on('TD.sinhvien_id','=','bangdiemrenluyen.sinhvien_id');
        })
        ->join('sinhvien','sinhvien.id','=','bangdiemrenluyen.sinhvien_id')
        ->join('lop','lop.id','=','sinhvien.lop_id')
        ->where('lop.id',$id_lop)
        ->select('sinhvien.id','lop.tenlop','sinhvien.mssv','sinhvien.hochulot','sinhvien.ten','TD.SV','TD.BCS','TD.CVHT','TD.HDK','TD.HDT')->distinct()->get();
        return view('subadmin.bangdiemrenluyen_dssv',['DS_SinhVien'=>$DS_SV]);
    }

    public function indexDSDRL(){
        $Array;
        $ArrayTieuChiBu;
        $STT=0;
        $TCC=0;
        $DanhSach_TieuChi = TieuChi::where('id','=','-1')->get();
        $HocKy_HienTai = HocKyNamHoc::where('idtrangthaihocky','=','2')->first();
        TieuChiController::SortTieuChiChoBD($DanhSach_TieuChi,"0",$HocKy_HienTai->id);
        foreach ($DanhSach_TieuChi as  $value) {
            if($value->idtieuchicha==0){
                $ArrayTieuChiBu[$STT]=$value->id;
                $STT++;
            }
            $SLColchild=0;
            foreach ($DanhSach_TieuChi as  $valuechild) {
                $TC = TieuChi::where('id','=',$valuechild->idtieuchicha)->first();
                if(count($TC)>0)
                    if($value->id==$TC->idtieuchicha){
                        $SLColchild++;
                        $tempTCC=$TC->id;
                        if($tempTCC!=$TCC){
                            $SLColchild-=1;
                            $TCC=$tempTCC;
                        }
                    }
                if($value->id == $valuechild->idtieuchicha)
                    $SLColchild++;
            }
            $Array[$value->id]=$SLColchild;
        }

        $DSSV=SinhVien::where('lop_id','=','1')->get();
        //return dd($DSSV);
        return view('subadmin.bangdiemrenluyendanhchokhoa',['DanhSach_TieuChi' => $DanhSach_TieuChi,'SLColchild'=>$Array,'DSTieuChiBu'=>$ArrayTieuChiBu,'DSLop'=>$DSSV]);
    }

    public function indexDSL(){
        $DS_Lop =Lop::join('nganh','nganh.id','=','lop.nganh_id')
            ->join('bomon','bomon.id','=','nganh.idbomon')
            ->join('khoa','khoa.id','=','bomon.idkhoa')
            ->join('bacdaotao','bacdaotao.id','=','nganh.idbacdaotao')
            ->join('hedaotao','hedaotao.id','=','nganh.idhedaotao')
            ->join('khoahoc','khoahoc.id','=','lop.khoahoc_id')
            ->select('lop.id','lop.malop','lop.tenlop','nganh.tennganh','bacdaotao.tenbac','hedaotao.tenhe','khoahoc.nambatdau','khoahoc.namketthuc')
            ->where('khoa.id','=','1')->get();
        $DS_Khoa=Khoa::all();
        return view('subadmin/bangdiemrenluyen_dslop',['DS_Khoa'=>$DS_Khoa,'DS_Lop'=>$DS_Lop]);
    }

    public function DSL($id_khoa)
    {
        $DS_Lop =Lop::join('nganh','nganh.id','=','lop.nganh_id')
            ->join('bomon','bomon.id','=','nganh.idbomon')
            ->join('khoa','khoa.id','=','bomon.idkhoa')
            ->join('bacdaotao','bacdaotao.id','=','nganh.idbacdaotao')
            ->join('hedaotao','hedaotao.id','=','nganh.idhedaotao')
            ->join('khoahoc','khoahoc.id','=','lop.khoahoc_id')
            ->select('lop.id','lop.malop','lop.tenlop','nganh.tennganh','bacdaotao.tenbac','hedaotao.tenhe','khoahoc.nambatdau','khoahoc.namketthuc')
            ->where('khoa.id','=',$id_khoa)->get();
        return $DS_Lop->toArray();
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * @param  \App\BangDiemRenLuyen  $bangDiemRenLuyen
     * @return \Illuminate\Http\Response
     */
    public function show(BangDiemRenLuyen $bangDiemRenLuyen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BangDiemRenLuyen  $bangDiemRenLuyen
     * @return \Illuminate\Http\Response
     */
    public function edit(BangDiemRenLuyen $bangDiemRenLuyen)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BangDiemRenLuyen  $bangDiemRenLuyen
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, BangDiemRenLuyen $bangDiemRenLuyen)
    {
        $Id = $request->id;
        $TieuChiId = $request->tieuchi_id;
        $result = BangDiemRenLuyenController::isNotExistIdTieuChiUpdate($Id,$TieuChiId);
        if($result['status'])
        {
            try {
                $objold = BangDiemRenLuyen::find($Id)->toArray();
                $BangDiemRenLuyen = BangDiemRenLuyen::find($Id);
                $BangDiemRenLuyen->tieuchi_id = $TieuChiId;
                $BangDiemRenLuyen->sinhvien_diem=(int)trim($request->sinhvien_diem);
                $BangDiemRenLuyen->bancansu_diem=(int)trim($request->bancansu_diem);
                $BangDiemRenLuyen->covanhoctap_diem=(int)trim($request->covanhoctap_diem);
                $BangDiemRenLuyen->hoidongkhoa_diem=(int)trim($request->hoidongkhoa_diem);
                $BangDiemRenLuyen->hoidongtruong_diem=(int)trim($request->hoidongtruong_diem);
                $BangDiemRenLuyen->save();
                // Write log
                try {
                    $objnew = BangDiemRenLuyen::find($BangDiemRenLuyen->id)->toArray();
                    LogController::storeobjectlog($objold, $objnew, LogLoaiHoatDong::UpdateRecord, '');
                    
                } catch (Exception $e) {
                    
                }
                // End Write log

                $result = array('status' => true, 'message' => "Cập nhật thành công!");
                return $result;
            } catch (Exception $e) {
                $result = array('status' => false, 'message' => $e);
                return $result;
            }
        }
        else
        {
            return $result;
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BangDiemRenLuyen  $bangDiemRenLuyen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(is_numeric($id))
        {
            if(BangDiemRenLuyenController::isExistId($id))
                try {

                    $objold = BangDiemRenLuyen::find($id)->toArray();
                    BangDiemRenLuyen::destroy($id);

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

    public function ExportBangDiemRenLuyenShow()
    {
        $dsHocKyNamHoc = HocKyNamHoc::orderBy('id', 'desc')->take(5)->get();
        $dsKhoa = Khoa::where('loaikhoaphong_id', '=', 1)->orderBy('tenkhoa', 'asc')->get();
        return view('admin.bangdiemrenluyen_export_all', ['dsHocKyNamHoc'=>$dsHocKyNamHoc, 'dsKhoa'=>$dsKhoa]);

    }

    public function ExportBangDiemRenLuyen(Request $request)
    {
        $boolRessult = true;
        $messages = "";

        $idHocKyNamHoc = $request->hockynamhoc;
        $idKhoa = $request->khoa;

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
            return self::createFile($idHocKyNamHoc, $idKhoa);
        else
            return redirect()->back()->withInput()->with('warning', $messages);
    }

    public static function createFile($idHocKyNamHoc, $idKhoa)
    {
        $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
        $sheetName = "BangDiem";
        $fileName = "BangDiemRenLuyen_".$hocKyNamHoc->tenhockynamhoc;
        $fileExtend ="xls";
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


        Excel::create($fileName, function($excel) use ($sheetName, $hocKyNamHoc, $idKhoa, $arrayTitleSheet, $arrayColumnWidth, $rowNum) {

            $excel->sheet($sheetName, function($sheet) use($hocKyNamHoc, $idKhoa, $arrayTitleSheet, $arrayColumnWidth, $rowNum){
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

                // Set multiple column formats
                $sheet->setColumnFormat(array(
                    'F' => 'dd/mm/yyyy',
                    'J' => '0.00',
                    'K' => '0.00',
                ));

                $STT = intval(0);
                $dsSinhVien = self::BangDiemRenLuyen_Theo_HocKyNamHoc_Khoa($hocKyNamHoc, $idKhoa);

                foreach ($dsSinhVien as $key => $sinhVien) {
                    $diemRenLuyen = number_format(floatval($sinhVien->diemrenluyen), 2, '.', ',');
                    $ngaySinh = "";
                    try {
                        $ngaySinh = Carbon::createFromFormat("Y-m-d", $sinhVien->ngaysinh)->format("d/m/Y");
                    } catch (\Throwable $th) {}

                    $rowRecord = [
                        ++$STT,
                        $sinhVien->mssv,
                        $sinhVien->hochulot,
                        $sinhVien->ten,
                        $sinhVien->tengioitinh,
                        $ngaySinh,
                        $sinhVien->email_agu,
                        $sinhVien->tenlop,
                        $sinhVien->tenkhoa,
                        number_format(floatval($sinhVien->diemhoctap), 2, '.', ','),
                        number_format(floatval($sinhVien->diemrenluyen), 2, '.', ','),
                        $sinhVien->tenxeploai
                    ];
                    // Set record data for table
                    $sheet->row(++$rowNum, $rowRecord);
                }
            });

        })->export($fileExtend);
    }

    public static function BangDiemRenLuyen_Theo_HocKyNamHoc_Khoa($hocKyNamHoc, $idKhoa)
    {   
        $idHocKyNamHoc = $hocKyNamHoc->id;
        $namBatDau = intval(trim(explode("-",$hocKyNamHoc->namhoc->tennamhoc)[0]));
        $namKetThuc = intval(trim(explode("-",$hocKyNamHoc->namhoc->tennamhoc)[1]));
        $tongDiemMacDinh = TieuChiController::TongDiemMacDinhTheoHocKyNamHoc($idHocKyNamHoc);

        $dsSinhVien = DB::select("select t3.* , xeploaidiemrenluyen.tenxeploai from
            (select t2.id,COALESCE( sum(diemtieuchi),0)-COALESCE(sum(diemmacdinh),0) + ? as diemrenluyen, diemhoctap, mssv,hochulot, ten, tengioitinh, ngaysinh, email_agu, tenlop, tenkhoa from 
            (select sinhvien_id, tieuchi_id, maxdiem, max(diem) diem, diemmacdinh, least(maxdiem,diem) as diemtieuchi from bangdiemrenluyen join tieuchi on bangdiemrenluyen.tieuchi_id=tieuchi.id where hocky_namhoc_id=? and tieuchi.idtieuchicha=0 group by sinhvien_id,tieuchi_id ) t1 
            right join 
            (select `sinhvien`.`id`, `sinhvien`.`mssv`, `sinhvien`.`hochulot`, `sinhvien`.`ten`, `gioitinh`.`tengioitinh`, `sinhvien`.`ngaysinh`, `sinhvien`.`email_agu`, `lop`.`tenlop`, `khoa`.`tenkhoa`, bdht.diem as diemhoctap from `sinhvien` inner join `lop` on `lop`.`id` = `sinhvien`.`lop_id` left join `khoahoc` on `khoahoc`.`id` = `lop`.`khoahoc_id` left join `nganh` on `nganh`.`id` = `lop`.`nganh_id` left join `bomon` on `bomon`.`id` = `nganh`.`idbomon` left join `khoa` on `khoa`.`id` = `bomon`.`idkhoa` left join `gioitinh` on `gioitinh`.`id` = `sinhvien`.`gioitinh` left join (select sinhvien_id, diem from bangdiemhoctap where hockynamhoc_id= ? ) as bdht on sinhvien.id=bdht.sinhvien_id  where `bomon`.`idkhoa` = ? and `khoahoc`.`nambatdau` <= ? and `khoahoc`.`namketthuc` >= ?  ) t2 on t1.sinhvien_id=t2.id 

            GROUP BY t2.id order by `tenlop` asc, `mssv` asc) t3
            
            join
            xeploaidiemrenluyen on t3.diemrenluyen >= xeploaidiemrenluyen.mindiem AND t3.diemrenluyen < xeploaidiemrenluyen.maxdiem
            ", [$tongDiemMacDinh, $idHocKyNamHoc, $idHocKyNamHoc, $idKhoa, $namBatDau, $namKetThuc]);

        return $dsSinhVien;
    }

    public static function BangDiemRenLuyen_Theo_HocKyNamHoc_Lop($idHocKyNamHoc, $idLop)
    {   
        $tongDiemMacDinh = TieuChiController::TongDiemMacDinhTheoHocKyNamHoc($idHocKyNamHoc);

        // $dsSinhVien = DB::select("select tbl_sinhvien_drl.*, xeploaidiemrenluyen.tenxeploai from
        // (select tbl_sinhvien_diemhoctap_tieuchi_0.id, tbl_sinhvien_diemhoctap_tieuchi_0.mssv, tbl_sinhvien_diemhoctap_tieuchi_0.hochulot, tbl_sinhvien_diemhoctap_tieuchi_0.ten, tbl_sinhvien_diemhoctap_tieuchi_0.diemhoctap, sum(tbl_sinhvien_diemhoctap_tieuchi_0.diemrenluyen) as diemrenluyen
        // from
        //     (select tbl_sinhvien_diemhoctap_tieuchi_0.*, ifnull(max(diem), diemmacdinh) as diemrenluyen from
        //         (select tbl_sinhvien_diemhoctap.id, tbl_sinhvien_diemhoctap.mssv, tbl_sinhvien_diemhoctap.hochulot, tbl_sinhvien_diemhoctap.ten, tbl_sinhvien_diemhoctap.diemhoctap, tbl_tieuchi_0.id as tieuchi_id, tbl_tieuchi_0.diemtoida, tbl_tieuchi_0.diemmacdinh from
        //             (select tieuchi.id, tieuchi.diemtoida, tieuchi.diemmacdinh from tieuchi join (select * from hockynamhocbotieuchi where hockynamhoc_id = ?) as tbl_hknhbotieuchi on tieuchi.botieuchi_id = tbl_hknhbotieuchi.botieuchi_id and tieuchi.idtieuchicha = 0) as tbl_tieuchi_0
        //             left join
        //             (select tbl_sinhvien.id, tbl_sinhvien.mssv, tbl_sinhvien.hochulot, tbl_sinhvien.ten, tbl_diemhoctap.diem as diemhoctap from (select * from sinhvien where lop_id = 84) as tbl_sinhvien left join (select * from bangdiemhoctap where hockynamhoc_id = ?) as tbl_diemhoctap on tbl_sinhvien.id = tbl_diemhoctap.sinhvien_id) as tbl_sinhvien_diemhoctap
        //             on 1 = 1) as tbl_sinhvien_diemhoctap_tieuchi_0
        //         left join
        //          (select sinhvien_id, tieuchi_id, diem from bangdiemrenluyen where hocky_namhoc_id = ?) as tbl_diemrenluyen
        //          on tbl_sinhvien_diemhoctap_tieuchi_0.id = tbl_diemrenluyen.sinhvien_id and tbl_sinhvien_diemhoctap_tieuchi_0.tieuchi_id = tbl_diemrenluyen.tieuchi_id
        //          group by tbl_sinhvien_diemhoctap_tieuchi_0.id, tbl_sinhvien_diemhoctap_tieuchi_0.tieuchi_id) as tbl_sinhvien_diemhoctap_tieuchi_0
        //          group by tbl_sinhvien_diemhoctap_tieuchi_0.id, tbl_sinhvien_diemhoctap_tieuchi_0.mssv, tbl_sinhvien_diemhoctap_tieuchi_0.hochulot, tbl_sinhvien_diemhoctap_tieuchi_0.ten, tbl_sinhvien_diemhoctap_tieuchi_0.diemhoctap)as tbl_sinhvien_drl
        //          join xeploaidiemrenluyen on tbl_sinhvien_drl.diemrenluyen >= xeploaidiemrenluyen.mindiem and tbl_sinhvien_drl.diemrenluyen < xeploaidiemrenluyen.maxdiem
        //      ", [$idHocKyNamHoc, $idLop, $idHocKyNamHoc, $idHocKyNamHoc]);
        

        // $dsSinhVien = DB::select("select t3.* , xeploaidiemrenluyen.tenxeploai from
        //     (select t2.id, (COALESCE( sum(diemtieuchi),0)-COALESCE(sum(diemmacdinh),0) + ?) as diemrenluyen, diemhoctap, mssv,hochulot, ten, tengioitinh, ngaysinh, email_agu, tenlop, tenkhoa from 
        //     (select sinhvien_id, tieuchi_id, maxdiem, max(diem) diem, diemmacdinh, least(maxdiem,diem) as diemtieuchi from bangdiemrenluyen join tieuchi on bangdiemrenluyen.tieuchi_id=tieuchi.id where hocky_namhoc_id=? and tieuchi.idtieuchicha=0 group by sinhvien_id,tieuchi_id ) t1 
        //     right join 
        //     (select `sinhvien`.`id`, `sinhvien`.`mssv`, `sinhvien`.`hochulot`, `sinhvien`.`ten`, `gioitinh`.`tengioitinh`, `sinhvien`.`ngaysinh`, `sinhvien`.`email_agu`, `lop`.`tenlop`, `khoa`.`tenkhoa`, bdht.diem as diemhoctap from `sinhvien` inner join `lop` on `lop`.`id` = `sinhvien`.`lop_id` left join `khoahoc` on `khoahoc`.`id` = `lop`.`khoahoc_id` left join `nganh` on `nganh`.`id` = `lop`.`nganh_id` left join `bomon` on `bomon`.`id` = `nganh`.`idbomon` left join `khoa` on `khoa`.`id` = `bomon`.`idkhoa` left join `gioitinh` on `gioitinh`.`id` = `sinhvien`.`gioitinh` left join (select sinhvien_id, diem from bangdiemhoctap where hockynamhoc_id= ? ) as bdht on sinhvien.id=bdht.sinhvien_id  where `sinhvien`.`lop_id` = ?) t2 on t1.sinhvien_id=t2.id 

        //     GROUP BY t2.id order by `tenlop` asc, `mssv` asc) t3
            
        //     join
        //     xeploaidiemrenluyen on t3.diemrenluyen >= xeploaidiemrenluyen.mindiem AND t3.diemrenluyen < xeploaidiemrenluyen.maxdiem
        //     ", [$tongDiemMacDinh, $idHocKyNamHoc, $idHocKyNamHoc, $idLop]);


        $dsSinhVien = DB::select("select t3.* , xeploaidiemrenluyen.tenxeploai from
            (select t2.id, (IFNULL(sum(diemtieuchi),0)- IFNULL(sum(diemmacdinh),0) + ?) as diemrenluyen, diemhoctap, mssv,hochulot, ten from 
            (select sinhvien_id, tieuchi_id, maxdiem, max(diem) diem, diemmacdinh, case when maxdiem > diem then diem else maxdiem end as diemtieuchi from bangdiemrenluyen join tieuchi on bangdiemrenluyen.tieuchi_id=tieuchi.id where hocky_namhoc_id=? and tieuchi.idtieuchicha=0 group by sinhvien_id,tieuchi_id ) t1 
            right join 
            (select `sinhvien`.`id`, `sinhvien`.`mssv`, `sinhvien`.`hochulot`, `sinhvien`.`ten`, bdht.diem as diemhoctap from `sinhvien` left join (select sinhvien_id, diem from bangdiemhoctap where hockynamhoc_id= ? ) as bdht on sinhvien.id=bdht.sinhvien_id  where `sinhvien`.`lop_id` = ?) t2 on t1.sinhvien_id=t2.id 

            GROUP BY t2.id order by `mssv` asc) t3
            
            join
            xeploaidiemrenluyen on t3.diemrenluyen >= xeploaidiemrenluyen.mindiem AND t3.diemrenluyen < xeploaidiemrenluyen.maxdiem
            ", [$tongDiemMacDinh, $idHocKyNamHoc, $idHocKyNamHoc, $idLop]);

        // $dsSinhVien = SinhVien::where('lop_id', '=', $idLop)->get();
        // foreach ($dsSinhVien as $key => $sinhVien) {
        //     $sinhVien['diemrenluyen'] = ServiceDanhGiaDiemRenLuyenController::GetTongDiemTheoHocKy($sinhVien->id, $idHocKyNamHoc);
        //     $sinhVien['tenxeploai'] = "asds";//XepLoaiDiemRenLuyenController::getXepLoai($sinhVien->id, $idHocKyNamHoc)->tenxeploai;
        // }

        return $dsSinhVien;
    }


    public static function isNotExistIdTieuChi($idTieuChi){
        $request_idtieuchi = BangDiemRenLuyenController::isExistIdTieuChi($idTieuChi);
        $status = true;
        $message = "";
        if($request_idtieuchi)
        {
            $status = false;
            $message .= "<br> - Tiêu Chí này đã tồn tại!";
        }
        $result = array('status' => $status, 'message' => $message);
        return $result;
    }

    public static function isNotExistIdTieuChiUpdate($id,$tieuchiId){
        $request_idtieuchi =BangDiemRenLuyenController::isExistIdTieuChiUpdate($id,$tieuchiId);
        $status=true;
        $message="";
        if($request_idtieuchi){
            $status=false;
            $message.="<br> - Tiêu Chí này đã tồn tại!";
        }
        $result=array('status'=>$status,'message'=>$message);
        return $result;
    }
    public static function isExistId($id){
        $DS_BangDiemRenLuyen = BangDiemRenLuyen::find($id);
        if(count($DS_BangDiemRenLuyen)>0)
            return true;
        return false;
    }

    public static function isExistIdTieuChi($tieuchiId){
        $DS_BangDiemRenLuyen = BangDiemRenLuyen::where('tieuchi_id','=',$tieuchiId)->select('tieuchi_id')->get();
        if(count($DS_BangDiemRenLuyen)>0)
            return true;
        return false; 
    }

    public static function isExistDiemRenLuyen($idtieuchi,$idsv,$idhocky){
        $DS = BangDiemRenLuyen::where('tieuchi_id',$idtieuchi)->where('sinhvien_id',$idsv)->where('hocky_namhoc_id',$idhocky)->first();
        if(count($DS)>0)
            return true;
        return false;
    }
    
    public static function isExistIdTieuChiUpdate($id,$tieuchiId){
        $DS_BangDiemRenLuyen=BangDiemRenLuyen::where('tieuchi_id','=',$tieuchiId)
            ->where('id','<>','$id')
            ->select('tieuchi_id')
            ->get();
        if(count($DS_BangDiemRenLuyen)>0)
            return true;
        return false;
    }

}
