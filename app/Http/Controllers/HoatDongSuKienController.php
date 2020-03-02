<?php

namespace App\Http\Controllers;

use App\HoatDongSuKien;
use Illuminate\Http\Request;
use App\Http\Requests\HoatDongSuKienRequest;
use App\Http\Requests\ServiceImportSinhVienRequest;
use App\LoaiHoatDongSuKien;
use App\HocKyNamHoc;
use App\TieuChi;
use App\HoatDongSuKienTieuChi;
use App\HoatDongSuKienDanhChoLop;
use App\Lop;
use Excel;
use DB;
use Carbon\Carbon;
use DateTime;
use Auth;
use App\SinhVien;
use App\NamHoc;
use App\CoVanHocTap;
use App\DangKyHoatDongSuKien;
use App\GiaoVuKhoa;

class HoatDongSuKienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DS_HoatDongSuKien= HoatDongSuKien::leftjoin('loaihoatdongsukien','loaihoatdongsukien.id','=','hoatdongsukien.loaihoatdongsukien_id')
            -> select('loaihoatdongsukien.tenloaihoatdongsukien','hoatdongsukien.*')
            -> orderBy('hoatdongsukien.thoigianbatdau', 'desc')
            -> get();
        $DS_LoaiHoatDongSuKien = LoaiHoatDongSuKien::all();
        return view('subadmin.hoatdongsukien',['DS_HoatDongSuKien'=> $DS_HoatDongSuKien,'DS_LoaiHoatDongSuKien' => $DS_LoaiHoatDongSuKien ]);
    }

    public function admin_index()
    {
        $DS_HoatDongSuKien= HoatDongSuKien::leftjoin('loaihoatdongsukien','loaihoatdongsukien.id','=','hoatdongsukien.loaihoatdongsukien_id')
            -> select('loaihoatdongsukien.tenloaihoatdongsukien','hoatdongsukien.*')
            -> orderBy('hoatdongsukien.thoigianbatdau', 'desc')
            -> get();
        $DS_LoaiHoatDongSuKien = LoaiHoatDongSuKien::all();
        return view('admin.hoatdongsukienlist',['DS_HoatDongSuKien'=> $DS_HoatDongSuKien,'DS_LoaiHoatDongSuKien' => $DS_LoaiHoatDongSuKien ]);
    }

    public function sinhvien_index()
    {
        if(Auth::check() && Auth::user()->idloaiuser == 3)
        {
            try {
                $idSinhVien = Auth::user()->cbgvsv_id;
                $dsHocKyNamHoc = HocKyNamHocController::DanhSachHocKyNamHocCuaSinhVien($idSinhVien);
                $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();

                $isIncludeHocKyNamHoc = "false";

                foreach ($dsHocKyNamHoc as $key => $value) {
                    if($hocKyNamHocHienHanh->id == $value->id)
                    {
                        $isIncludeHocKyNamHoc = $key;
                        break;
                    }
                }

                if(strcmp($isIncludeHocKyNamHoc, "false") == 0)
                    $hocKyNamHocHienHanh = "";
                else
                    unset($dsHocKyNamHoc[$isIncludeHocKyNamHoc]);
                if($hocKyNamHocHienHanh)
                    $dsHoatDongSuKienHienHanh = HoatDongSuKien::where('hocky_namhoc_id', '=', $hocKyNamHocHienHanh->id)
                    -> leftjoin('hoatdongsukientieuchi', 'hoatdongsukientieuchi.hoatdongsukien_id', '=', 'hoatdongsukien.id')
                    -> leftjoin('tieuchi', 'tieuchi.id', '=', 'hoatdongsukientieuchi.tieuchi_id')
                    -> select('hoatdongsukien.*', 'tieuchi.chimuctieuchi', 'hoatdongsukientieuchi.diemcong', DB::raw('if(hoatdongsukien.thoigianketthucdangky >= NOW(), 1, 0) as handangky') )
                    -> orderBy('thoigianbatdau', 'asc')
                    -> get();
                
                foreach ($dsHoatDongSuKienHienHanh as $key => $value) {
                    $dangKyHoatDongSuKien = DangKyHoatDongSuKienController::getDangKyHoatDongSuKien($value->id);
                    if($dangKyHoatDongSuKien)
                    {
                        $value->dangky = $dangKyHoatDongSuKien->dangky;
                        $value->thamdu = $dangKyHoatDongSuKien->thamdu;
                    }
                    else
                    {
                        $value->dangky = 0;
                        $value->thamdu = 0;
                    }
                }
                return view('sinhvien.hoatdongsukien', ['hocKyNamHocHienHanh'=>$hocKyNamHocHienHanh, 'dsHocKyNamHoc'=>$dsHocKyNamHoc, 'dsHoatDongSuKienHienHanh'=>$dsHoatDongSuKienHienHanh]);
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->back()->with('danger', $th->getMessage());
            }
            
        }
        
    }

    public function covanhoctap_index()
    {
        if(Auth::check())
        {
            $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
            $dsHoatDongSuKienHienHanh = HoatDongSuKien::where('hocky_namhoc_id', '=', $hocKyNamHocHienHanh->id)
                -> leftjoin('hoatdongsukientieuchi', 'hoatdongsukientieuchi.hoatdongsukien_id', '=', 'hoatdongsukien.id')
                -> leftjoin('tieuchi', 'tieuchi.id', '=', 'hoatdongsukientieuchi.tieuchi_id')
                -> select('hoatdongsukien.*', 'tieuchi.chimuctieuchi', 'hoatdongsukientieuchi.diemcong', DB::raw('if(hoatdongsukien.thoigianketthucdangky >= NOW(), 1, 0) as handangky') )
                -> orderBy('thoigianbatdau', 'asc')
                -> get();

            return view('covanhoctap.hoatdongsukienlist', ['hocKyNamHocHienHanh'=>$hocKyNamHocHienHanh, 'dsHoatDongSuKienHienHanh'=>$dsHoatDongSuKienHienHanh]);
        }
        
    }

    public function giaovukhoa_index()
    {
        if(Auth::check())
        {
            $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
            $dsHoatDongSuKienHienHanh = HoatDongSuKien::where('hocky_namhoc_id', '=', $hocKyNamHocHienHanh->id)
                -> leftjoin('hoatdongsukientieuchi', 'hoatdongsukientieuchi.hoatdongsukien_id', '=', 'hoatdongsukien.id')
                -> leftjoin('tieuchi', 'tieuchi.id', '=', 'hoatdongsukientieuchi.tieuchi_id')
                -> select('hoatdongsukien.*', 'tieuchi.chimuctieuchi', 'hoatdongsukientieuchi.diemcong', DB::raw('if(hoatdongsukien.thoigianketthucdangky >= NOW(), 1, 0) as handangky') )
                -> orderBy('thoigianbatdau', 'asc')
                -> get();

            return view('giaovukhoa.hoatdongsukienlist', ['hocKyNamHocHienHanh'=>$hocKyNamHocHienHanh, 'dsHoatDongSuKienHienHanh'=>$dsHoatDongSuKienHienHanh]);
        }
        
    }

    public function sinhvien_show($idHoatDongSuKien = '')
    {
        $hoatDongSuKien = HoatDongSuKien::where('hoatdongsukien.id', '=', $idHoatDongSuKien)
            -> leftjoin('hoatdongsukientieuchi', 'hoatdongsukientieuchi.hoatdongsukien_id', '=', 'hoatdongsukien.id')
            -> leftjoin('tieuchi', 'tieuchi.id', '=', 'hoatdongsukientieuchi.tieuchi_id')
            -> leftjoin('dangkyhoatdongsukien', 'dangkyhoatdongsukien.hoatdongsukien_id', '=', 'hoatdongsukien.id')
            -> leftjoin('loaihoatdongsukien', 'loaihoatdongsukien.id', '=', 'hoatdongsukien.loaihoatdongsukien_id')
            -> select('hoatdongsukien.*', 'loaihoatdongsukien.tenloaihoatdongsukien', 'tieuchi.tentieuchi', 'tieuchi.chimuctieuchi', 'hoatdongsukientieuchi.diemcong', 'hoatdongsukientieuchi.diemtru', DB::raw('if(hoatdongsukien.thoigianketthucdangky >= NOW(), 1, 0) as handangky'))
            -> first();

            if($hoatDongSuKien->thoigianketthucdangky)
        {
            if(date('Y-m-d', strtotime($hoatDongSuKien->thoigianketthucdangky)) >= date('Y-m-d'))
                $hoatDongSuKien->handangky = 1;
        }
        else
            if($hoatDongSuKien->thoigianbatdau >= now())
                $hoatDongSuKien->handangky = 1;

        if($hoatDongSuKien)
        {
            $dangKyHoatDongSuKien = DangKyHoatDongSuKienController::getDangKyHoatDongSuKien($hoatDongSuKien->id);
            if($dangKyHoatDongSuKien)
            {
                $hoatDongSuKien->dangky = $dangKyHoatDongSuKien->dangky;
                $hoatDongSuKien->thamdu = $dangKyHoatDongSuKien->dangky;
            }
            else
            {
                $hoatDongSuKien->dangky = 0;
                $hoatDongSuKien->thamdu = 0;
            }
        }

        return view('sinhvien.hoatdongsukien_detail_register', ['hoatDongSuKien'=>$hoatDongSuKien]);
    }

    public function covanhoctap_show($idHoatDongSuKien='')
    {
        $hoatDongSuKien = HoatDongSuKien::where('hoatdongsukien.id', '=', $idHoatDongSuKien)
            -> leftjoin('hoatdongsukientieuchi', 'hoatdongsukientieuchi.hoatdongsukien_id', '=', 'hoatdongsukien.id')
            -> leftjoin('tieuchi', 'tieuchi.id', '=', 'hoatdongsukientieuchi.tieuchi_id')
            -> leftjoin('dangkyhoatdongsukien', 'dangkyhoatdongsukien.hoatdongsukien_id', '=', 'hoatdongsukien.id')
            -> leftjoin('loaihoatdongsukien', 'loaihoatdongsukien.id', '=', 'hoatdongsukien.loaihoatdongsukien_id')
            -> select('hoatdongsukien.*', 'loaihoatdongsukien.tenloaihoatdongsukien', 'tieuchi.tentieuchi', 'tieuchi.chimuctieuchi', 'hoatdongsukientieuchi.diemcong', 'hoatdongsukientieuchi.diemtru', DB::raw('if(hoatdongsukien.thoigianketthucdangky >= NOW(), 1, 0) as handangky'))
            -> first();

        $idCBGVSV = Auth::user()->cbgvsv_id;
        $coVanHocTap = CoVanHocTap::where('canbogiangvien_id', '=', $idCBGVSV)
            -> where('trangthai_id', '=', 1)
            -> first();

        $idLop = "";
        if($coVanHocTap)
            $idLop = $coVanHocTap->lop_id;

        $dsSinhVienDangKyThamDu = DangKyHoatDongSuKien::where('hoatdongsukien_id', '=', $idHoatDongSuKien)
            -> join('sinhvien', 'sinhvien.id', '=', 'dangkyhoatdongsukien.sinhvien_id')
            -> where('sinhvien.lop_id', '=', $idLop)
            -> select('sinhvien.*', 'dangkyhoatdongsukien.dangky', 'dangkyhoatdongsukien.thamdu')
            -> get();

        return view('covanhoctap.hoatdongsukienshow', ['hoatDongSuKien'=>$hoatDongSuKien, 'dsSinhVienDangKyThamDu'=>$dsSinhVienDangKyThamDu]);

    }

    public function giaovukhoa_show($idHoatDongSuKien='')
    {
        $hoatDongSuKien = HoatDongSuKien::where('hoatdongsukien.id', '=', $idHoatDongSuKien)
            -> leftjoin('hoatdongsukientieuchi', 'hoatdongsukientieuchi.hoatdongsukien_id', '=', 'hoatdongsukien.id')
            -> leftjoin('tieuchi', 'tieuchi.id', '=', 'hoatdongsukientieuchi.tieuchi_id')
            -> leftjoin('dangkyhoatdongsukien', 'dangkyhoatdongsukien.hoatdongsukien_id', '=', 'hoatdongsukien.id')
            -> leftjoin('loaihoatdongsukien', 'loaihoatdongsukien.id', '=', 'hoatdongsukien.loaihoatdongsukien_id')
            -> select('hoatdongsukien.*', 'loaihoatdongsukien.tenloaihoatdongsukien', 'tieuchi.tentieuchi', 'tieuchi.chimuctieuchi', 'hoatdongsukientieuchi.diemcong', 'hoatdongsukientieuchi.diemtru', DB::raw('if(hoatdongsukien.thoigianketthucdangky >= NOW(), 1, 0) as handangky'))
            -> first();

        $idCBGVSV = Auth::user()->cbgvsv_id;
        $listLop = GiaoVuKhoa::where('cbgv_id', '=', $idCBGVSV)
            -> where('trangthai_id', '=', 1)
            -> join('bomon', 'bomon.idkhoa', '=', 'giaovukhoa.khoa_id')
            -> join('nganh', 'nganh.idbomon', '=', 'bomon.id')
            -> join('lop', 'lop.nganh_id', '=', 'nganh.id')
            -> select('lop.id')
            -> get();

        $dsSinhVienDangKyThamDu = DangKyHoatDongSuKien::where('hoatdongsukien_id', '=', $idHoatDongSuKien)
            -> join('sinhvien', 'sinhvien.id', '=', 'dangkyhoatdongsukien.sinhvien_id')
            -> whereIn('sinhvien.lop_id', $listLop)
            -> select('sinhvien.*', 'dangkyhoatdongsukien.dangky', 'dangkyhoatdongsukien.thamdu')
            -> get();

        return view('giaovukhoa.hoatdongsukienshow', ['hoatDongSuKien'=>$hoatDongSuKien, 'dsSinhVienDangKyThamDu'=>$dsSinhVienDangKyThamDu]);

    }

    public static function HoatDongSuKienTheoHocKy($idHocKy)
    {
        if(Auth::check())
        {
            $idSinhVien = Auth::user()->cbgvsv_id;
            $dsHoatDongSuKien = HoatDongSuKien::where('hocky_namhoc_id', '=', $idHocKy)
                -> leftjoin('hoatdongsukientieuchi', 'hoatdongsukientieuchi.hoatdongsukien_id', '=', 'hoatdongsukien.id')
                -> leftjoin('tieuchi', 'tieuchi.id', '=', 'hoatdongsukientieuchi.tieuchi_id')
                -> leftjoin('dangkyhoatdongsukien', 'dangkyhoatdongsukien.hoatdongsukien_id', '=', 'hoatdongsukien.id')
                -> where('dangkyhoatdongsukien.sinhvien_id', '=', $idSinhVien)
                -> select('hoatdongsukien.*', 'tieuchi.chimuctieuchi', 'hoatdongsukientieuchi.diemcong', 'dangkyhoatdongsukien.thamdu' )
                -> orderBy('thoigianbatdau', 'asc')
                -> get();

            return $dsHoatDongSuKien;
        }

        return NULL;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        $DS_Lop = Lop::all();
        $DS_LoaiHoatDongSuKien = LoaiHoatDongSuKien::orderBy('tenloaihoatdongsukien', 'asc')->get();
        $DS_TieuChi = TieuChi::join('hockynamhocbotieuchi', 'hockynamhocbotieuchi.botieuchi_id', '=', 'tieuchi.botieuchi_id')
            -> where('hockynamhocbotieuchi.hockynamhoc_id', '=', $idHocKyNamHocHienHanh)
            -> where('tieuchi.idtieuchicha', '=', 0)
            -> select('tieuchi.*')
            -> get();
        $arrayHierachyTieuChi = array();
        $levelHierachy = 0;

        foreach ($DS_TieuChi as $key => $TieuChi) {
            self::GetHieracchyTieuChi($arrayHierachyTieuChi, $TieuChi, $levelHierachy, "");
        }

        $DS_HocKyNamHoc = HocKyNamHoc::wherein('idtrangthaihocky', [2, 3])->get();
        return view('subadmin.hoatdongsukien_add', ['DS_LoaiHoatDongSuKien' => $DS_LoaiHoatDongSuKien,'DS_Lop' => $DS_Lop, 'DS_HocKyNamHoc' => $DS_HocKyNamHoc, 'DS_TieuChi' => $arrayHierachyTieuChi]);
    }

    public function admin_create()
    {
        $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        $DS_Lop = Lop::all();
        $DS_LoaiHoatDongSuKien = LoaiHoatDongSuKien::orderBy('tenloaihoatdongsukien', 'asc')->get();
        $DS_TieuChi = TieuChi::join('hockynamhocbotieuchi', 'hockynamhocbotieuchi.botieuchi_id', '=', 'tieuchi.botieuchi_id')
            -> where('hockynamhocbotieuchi.hockynamhoc_id', '=', $idHocKyNamHocHienHanh)
            -> where('tieuchi.idtieuchicha', '=', 0)
            -> select('tieuchi.*')
            -> get();
        $arrayHierachyTieuChi = array();
        $levelHierachy = 0;

        foreach ($DS_TieuChi as $key => $TieuChi) {
            self::GetHieracchyTieuChi($arrayHierachyTieuChi, $TieuChi, $levelHierachy, "");
        }

        $DS_HocKyNamHoc = HocKyNamHoc::wherein('idtrangthaihocky', [2, 3])->get();
        return view('admin.hoatdongsukiencreate', ['DS_LoaiHoatDongSuKien' => $DS_LoaiHoatDongSuKien,'DS_Lop' => $DS_Lop, 'DS_HocKyNamHoc' => $DS_HocKyNamHoc, 'DS_TieuChi' => $arrayHierachyTieuChi]);
    }


    public function edit($id)
    {
        $hoatdongsukien = HoatDongSuKien::find($id);
  
        $HDSKTC = HoatDongSuKienTieuChi::where('hoatdongsukien_id','=',$id)->first();
        $HDSKDCL = HoatDongSuKienDanhChoLop::where('hoatdongsukien_id','=',$id)->get();
        $DS_Lop = Lop::all();
        $DS_LoaiHoatDongSuKien = LoaiHoatDongSuKien::orderBy('tenloaihoatdongsukien', 'asc')->get();

        $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        $DS_TieuChi = TieuChi::join('hockynamhocbotieuchi', 'hockynamhocbotieuchi.botieuchi_id', '=', 'tieuchi.botieuchi_id')
            -> where('hockynamhocbotieuchi.hockynamhoc_id', '=', $idHocKyNamHocHienHanh)
            -> where('tieuchi.idtieuchicha', '=', 0)
            -> select('tieuchi.*')
            -> get();

        $arrayHierachyTieuChi = array();

        $levelHierachy = 0;

        foreach ($DS_TieuChi as $key => $TieuChi) {
            self::GetHieracchyTieuChi($arrayHierachyTieuChi, $TieuChi, $levelHierachy, "");
        }

        $DS_HocKyNamHoc = HocKyNamHoc::wherein('idtrangthaihocky', [2, 3])->get();
       return view('subadmin.hoatdongsukien_edit', ['hoatdongsukien' => $hoatdongsukien,'HDSKTC' => $HDSKTC,'HDSKDCL' => $HDSKDCL,'DS_LoaiHoatDongSuKien' => $DS_LoaiHoatDongSuKien,'DS_Lop' => $DS_Lop, 'DS_HocKyNamHoc' => $DS_HocKyNamHoc, 'DS_TieuChi' => $arrayHierachyTieuChi]);

    }

    public function admin_edit($id)
    {
        $hoatdongsukien = HoatDongSuKien::find($id);
  
        $HDSKTC = HoatDongSuKienTieuChi::where('hoatdongsukien_id','=',$id)->first();
        $HDSKDCL = HoatDongSuKienDanhChoLop::where('hoatdongsukien_id','=',$id)->get();
        $DS_Lop = Lop::all();
        $DS_LoaiHoatDongSuKien = LoaiHoatDongSuKien::orderBy('tenloaihoatdongsukien', 'asc')->get();
        $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        $DS_TieuChi = TieuChi::join('hockynamhocbotieuchi', 'hockynamhocbotieuchi.botieuchi_id', '=', 'tieuchi.botieuchi_id')
            -> where('hockynamhocbotieuchi.hockynamhoc_id', '=', $idHocKyNamHocHienHanh)
            -> where('tieuchi.idtieuchicha', '=', 0)
            -> select('tieuchi.*')
            -> get();
        $arrayHierachyTieuChi = array();
        $levelHierachy = 0;
        foreach ($DS_TieuChi as $key => $TieuChi) {
            self::GetHieracchyTieuChi($arrayHierachyTieuChi, $TieuChi, $levelHierachy, "");
        }
        $DS_HocKyNamHoc = HocKyNamHoc::wherein('idtrangthaihocky', [2, 3])->get();
        return view('admin.hoatdongsukienedit', ['hoatdongsukien' => $hoatdongsukien,'HDSKTC' => $HDSKTC,'HDSKDCL' => $HDSKDCL,'DS_LoaiHoatDongSuKien' => $DS_LoaiHoatDongSuKien,'DS_Lop' => $DS_Lop, 'DS_HocKyNamHoc' => $DS_HocKyNamHoc, 'DS_TieuChi' => $arrayHierachyTieuChi]);
    }

    public function GetHieracchyTieuChi(&$arrayHierachyTieuChi, $TieuChi, $levelHierachy, $chiMucTieuChiCha)
    {
        if(empty($chiMucTieuChiCha))
        {
            $chiMucTieuChiCha = $TieuChi->chimuctieuchi;
        }
        else
        {
            $chiMucTieuChiCha = $TieuChi->chimuctieuchi;
            // $chiMucTieuChiCha = $chiMucTieuChiCha . " " .  $TieuChi->chimuctieuchi;
        }

        $arrayHierachyTieuChi_Temp = array('id' => $TieuChi->id, 'tentieuchi' => self::ChuanHoaTenTieuChi( $chiMucTieuChiCha . " " . $TieuChi->tentieuchi), 'levelhierachy' => $levelHierachy, 'idloaidiem' => $TieuChi->idloaidiem);
        
        array_push($arrayHierachyTieuChi, $arrayHierachyTieuChi_Temp);

        $DS_TieuChi = TieuChi::where('idtieuchicha', '=', $TieuChi->id)->get();

        $levelHierachy++;

        foreach ($DS_TieuChi as $key => $TieuChi1) {
            self::GetHieracchyTieuChi($arrayHierachyTieuChi, $TieuChi1, $levelHierachy, $chiMucTieuChiCha);
        }
    }

    public function ChuanHoaTenTieuChi($tenTieuChi)
    {
        $MAX_LEN = 200;
        $tenTieuChi_ChuanHoa = $tenTieuChi;
        if(strlen($tenTieuChi) > $MAX_LEN)
        {
            $tenTieuChi_ChuanHoa = trim(substr($tenTieuChi, 0, $MAX_LEN)) . "...";
        }

        return $tenTieuChi_ChuanHoa;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HoatDongSuKienRequest $request)
    {   
        $TenHoatDongSuKien = trim($request->tenhoatdongsukien);
        $result = HoatDongSuKienController::isNotExistTenHoatDongSuKien($TenHoatDongSuKien);
        if($result['status'])
        {
            try {
                $HDSK = new HoatDongSuKien();
                $HDSK->tenhoatdongsukien = $TenHoatDongSuKien;
                $HDSK->hocky_namhoc_id = $request->hockynamhoc; 
                $HDSK->loaihoatdongsukien_id = $request->loaihoatdongsukien;
                $HDSK->thoigianbatdaudangky = $request->thoigianBDDK;
                $HDSK->thoigianketthucdangky = $request->thoigianKTDK;
                $HDSK->thoigianbatdau = DateTime::createFromFormat('d/m/Y h:i A',trim($request->thoigianbatdau));
                $HDSK->thoigianketthuc = DateTime::createFromFormat('d/m/Y h:i A',trim($request->thoigianketthuc));
                $HDSK->diadiem = $request->diadiem;
                $HDSK->ghichu = $request->ghichu;
                $HDSK->xeploaihoatdongsukien = intval($request->selected_rating);
                $HDSK->save();

                if($request->tieuchi)
                {
                    $HDSKTC = new HoatDongSuKienTieuChi();
                    $HDSKTC->hoatdongsukien_id= $HDSK->id;
                    $HDSKTC->tieuchi_id= $request->tieuchi;
                    $HDSKTC->diemcong = $request->diemcong;
                    $HDSKTC->diemtru = $request->diemtru;
                    $HDSKTC->save();
                }

                $json_lop = json_encode($request->lop,JSON_FORCE_OBJECT);
                $lops=$request->lop;
                
                if(request('lop')){
                    foreach ($lops as $lop) {
                        $HDSKCL = new HoatDongSuKienDanhChoLop();
                        $HDSKCL->hoatdongsukien_id= $HDSK->id;
                        $HDSKCL->lop_id= $lop;
                        $HDSKCL->save();
                    }
                }
                
                // Write log
                try {
                    $objnew = HoatDongSuKien::find($HDSK->id)->toArray();
                    LogController::storeobjectlog('', $objnew, LogLoaiHoatDong::NewInsertRecord, '');
                    
                } catch (Exception $e) {
                    
                }
                // End Write log

                return redirect()->route('hoatdongsukien')->with('success', "Lưu thành công!");
            } catch (Exception $e) {
                return redirect()->route('hoatdongsukien')->with('danger', "Lưu chưa được, vui lòng thử lại!");
            }
        }
        else
        {
            return redirect()->back()->withInput()->with('warning', "Tên hoạt động sự kiện đã tồn tại!");
        }
    }

    public function admin_store(HoatDongSuKienRequest $request)
    {   
        $TenHoatDongSuKien = trim($request->tenhoatdongsukien);
        $result = HoatDongSuKienController::isNotExistTenHoatDongSuKien($TenHoatDongSuKien);
        if($result['status'])
        {
            try {
                $HDSK = new HoatDongSuKien();
                $HDSK->tenhoatdongsukien = $TenHoatDongSuKien;
                $HDSK->hocky_namhoc_id = $request->hockynamhoc; 
                $HDSK->loaihoatdongsukien_id = $request->loaihoatdongsukien;
                $HDSK->thoigianbatdaudangky = $request->thoigianBDDK;
                $HDSK->thoigianketthucdangky = $request->thoigianKTDK;
                $HDSK->thoigianbatdau = DateTime::createFromFormat('d/m/Y h:i A',trim($request->thoigianbatdau));
                $HDSK->thoigianketthuc = DateTime::createFromFormat('d/m/Y h:i A',trim($request->thoigianketthuc));
                $HDSK->diadiem = $request->diadiem;
                $HDSK->ghichu = $request->ghichu;
                $HDSK->xeploaihoatdongsukien = intval($request->selected_rating);
                $HDSK->save();

                if($request->tieuchi)
                {
                    $HDSKTC = new HoatDongSuKienTieuChi();
                    $HDSKTC->hoatdongsukien_id= $HDSK->id;
                    $HDSKTC->tieuchi_id= $request->tieuchi;
                    $HDSKTC->diemcong = $request->diemcong;
                    $HDSKTC->diemtru = $request->diemtru;
                    $HDSKTC->save();
                }

                $json_lop = json_encode($request->lop,JSON_FORCE_OBJECT);
                $lops=$request->lop;
                
                if(request('lop')){
                    foreach ($lops as $lop) {
                        $HDSKCL = new HoatDongSuKienDanhChoLop();
                        $HDSKCL->hoatdongsukien_id= $HDSK->id;
                        $HDSKCL->lop_id= $lop;
                        $HDSKCL->save();
                    }
                }
                
                // Write log
                try {
                    $objnew = HoatDongSuKien::find($HDSK->id)->toArray();
                    LogController::storeobjectlog('', $objnew, LogLoaiHoatDong::NewInsertRecord, '');
                    
                } catch (Exception $e) {
                    
                }
                // End Write log

                return redirect()->route('admin_hoatdongsukien')->with('success', "Lưu thành công!");
            } catch (Exception $e) {
                return redirect()->route('admin_hoatdongsukien')->with('danger', "Lưu chưa được, vui lòng thử lại!");
            }
        }
        else
        {
            return redirect()->back()->withInput()->with('warning', "Tên hoạt động sự kiện đã tồn tại!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BoMon  $boMon
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BoMon  $boMon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $TenHoatDongSuKien = trim($request->tenhoatdongsukien);
        $result = HoatDongSuKienController::isNotExistTenHoatDongSuKienUpdate($id, $TenHoatDongSuKien);         
        if($result['status'])
        {
            try {
                $objold = HoatDongSuKien::find($id)->toArray();
                $HDSK = HoatDongSuKien::find($id);
                $HDSK->tenhoatdongsukien = $TenHoatDongSuKien;
                $HDSK->hocky_namhoc_id = $request->hockynamhoc; 
                $HDSK->loaihoatdongsukien_id = $request->loaihoatdongsukien;

                if($request->thoigianBDDK)
                {
                    $HDSK->thoigianbatdaudangky = DateTime::createFromFormat('d/m/Y',trim($request->thoigianBDDK));
                }
                else
                {
                    $HDSK->thoigianbatdaudangky = null;
                }

                if($request->thoigianKTDK)
                {
                    $HDSK->thoigianketthucdangky = DateTime::createFromFormat('d/m/Y',trim($request->thoigianKTDK));
                }
                else
                {
                    $HDSK->thoigianketthucdangky = null;
                }

                if($request->thoigianbatdau)
                {
                    $HDSK->thoigianbatdau = DateTime::createFromFormat('d/m/Y h:i A',trim($request->thoigianbatdau));
                }
                else
                {
                    $HDSK->thoigianbatdau = null;
                }

                if($request->thoigianketthuc)
                {
                    $HDSK->thoigianketthuc = DateTime::createFromFormat('d/m/Y h:i A',trim($request->thoigianketthuc));
                }
                else
                {
                    $HDSK->thoigianketthuc = 'Null';
                }

                $HDSK->diadiem = $request->diadiem;
                $HDSK->ghichu = $request->ghichu;
                $HDSK->xeploaihoatdongsukien = intval($request->selected_rating);

                $HDSK->save();

                if($request->tieuchi)
                {

                    $HDSKTC = HoatDongSuKienTieuChi::firstOrnew(['hoatdongsukien_id'=>$HDSK->id]);
                    
                    $HDSKTC->tieuchi_id= $request->tieuchi;
                    $HDSKTC->diemcong = $request->diemcong;
                    $HDSKTC->diemtru = $request->diemtru;
                    $HDSKTC->save();
                }

                $lops=$request->lop;
                if(request('lop')){
                    foreach ($lops as $lop) {
                        $HDSKCL = HoatDongSuKienDanhChoLop::firstOrnew(['hoatdongsukien_id'=>$HDSK->id]);
                        
                        $HDSKCL->lop_id= $lop;
                        $HDSKCL->save();
                    }
                }
                
                // Write log
                try {
                    $objnew = HoatDongSuKien::find($HDSK->id)->toArray();
                    LogController::storeobjectlog($objold, $objnew, LogLoaiHoatDong::UpdateRecord, '');
                    
                } catch (Exception $e) {
                    
                }
                // End Write log

                return redirect()->route('hoatdongsukien')->with('success', "Lưu thành công!");


                // $result = array('status' => true, 'message' => "Thêm thành công!");
                // return $result;
            } catch (Exception $e) {
                return redirect()->route('hoatdongsukien')->with('danger', "Lưu chưa được, vui lòng thử lại!");
                // $result = array('status' => false, 'message' => $e);
                // return $result;
            }
        }
        else
        {
            // return $result;
            return redirect()->back()->withInput()->with('warning', "Tên hoạt động sự kiện đã tồn tại!");
        }
    }

    public function admin_update(Request $request)
    {
        $idHoatDongSuKien = $request->idhoatdongsukien;
        $TenHoatDongSuKien = trim($request->tenhoatdongsukien);
        $result = HoatDongSuKienController::isNotExistTenHoatDongSuKienUpdate($idHoatDongSuKien, $TenHoatDongSuKien);         
        if($result['status'])
        {
            try {
                $objold = HoatDongSuKien::find($idHoatDongSuKien)->toArray();
                $HDSK = HoatDongSuKien::find($idHoatDongSuKien);
                $HDSK->tenhoatdongsukien = $TenHoatDongSuKien;
                $HDSK->hocky_namhoc_id = $request->hockynamhoc; 
                $HDSK->loaihoatdongsukien_id = $request->loaihoatdongsukien;

                if($request->thoigianBDDK)
                {
                    $HDSK->thoigianbatdaudangky = DateTime::createFromFormat('d/m/Y',trim($request->thoigianBDDK));
                }
                else
                {
                    $HDSK->thoigianbatdaudangky = null;
                }

                if($request->thoigianKTDK)
                {
                    $HDSK->thoigianketthucdangky = DateTime::createFromFormat('d/m/Y',trim($request->thoigianKTDK));
                }
                else
                {
                    $HDSK->thoigianketthucdangky = null;
                }

                if($request->thoigianbatdau)
                {
                    $HDSK->thoigianbatdau = DateTime::createFromFormat('d/m/Y h:i A',trim($request->thoigianbatdau));
                }
                else
                {
                    $HDSK->thoigianbatdau = null;
                }

                if($request->thoigianketthuc)
                {
                    $HDSK->thoigianketthuc = DateTime::createFromFormat('d/m/Y h:i A',trim($request->thoigianketthuc));
                }
                else
                {
                    $HDSK->thoigianketthuc = 'Null';
                }
                $HDSK->diadiem = $request->diadiem;
                $HDSK->ghichu = $request->ghichu;
                $HDSK->xeploaihoatdongsukien = intval($request->selected_rating);
                $HDSK->save();

                if($request->tieuchi)
                {
                    $HDSKTC = HoatDongSuKienTieuChi::firstOrnew(['hoatdongsukien_id'=>$HDSK->id]);
                    $HDSKTC->tieuchi_id= $request->tieuchi;
                    $HDSKTC->diemcong = $request->diemcong;
                    $HDSKTC->diemtru = $request->diemtru;
                    $HDSKTC->save();
                }
                $lops=$request->lop;
                if(request('lop')){
                    foreach ($lops as $lop) {
                        $HDSKCL = HoatDongSuKienDanhChoLop::firstOrnew(['hoatdongsukien_id'=>$HDSK->id]);
                        $HDSKCL->lop_id= $lop;
                        $HDSKCL->save();
                    }
                }
                // Write log
                try {
                    $objnew = HoatDongSuKien::find($HDSK->id)->toArray();
                    LogController::storeobjectlog($objold, $objnew, LogLoaiHoatDong::UpdateRecord, '');
                    
                } catch (Exception $e) {
                    
                }
                // End Write log

                return redirect()->route('admin_hoatdongsukien')->with('success', "Lưu thành công!");
            } catch (Exception $e) {
                return redirect()->route('admin_hoatdongsukien')->with('danger', "Lưu chưa được, vui lòng thử lại!");
            }
        }
        else
        {
            return redirect()->back()->withInput()->with('warning', "Tên hoạt động sự kiện đã tồn tại!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BoMon  $boMon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // Kiểm tra có đang là khóa ngoại của tbl khác ko?
        // code

        if(is_numeric($id))
        {
            if(HoatDongSuKienController::isExistId($id))
                try {

                    $objold = HoatDongSuKien::find($id)->toArray();
                    HoatDongSuKienTieuChi::where('hoatdongsukien_id','=',$id)->delete();
                    HoatDongSuKienDanhChoLop::where('hoatdongsukien_id','=',$id)->delete();
                    
                    HoatDongSuKien::destroy($id);

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


    //Import
    // public function Admin_ImportHDSK($idhoatdongsukien)
    // {
    //     $hoatDongSuKien = HoatDongSuKien::find($idhoatdongsukien);
    //     return view('admin.hoatdongsukien_import');
    // }

    public function ImportHDSK()
    {
        return view('subadmin.hoatdongsukien_import');
    }

    public function storeImportHDSK(ServiceImportSinhVienRequest $request)
    {
        
        

        if($request->hasFile('input_file')){
            $path = $request->file('input_file')->getRealPath();

            $reader = Excel::load($request->file('input_file')->getRealPath());

            $numRow = $reader->get()->count();
            $numColumn = 10;

            // Lấy số dòng
            $reader->takeRows($numRow);

            // Lấy & giới hạn số cột
            $reader->takeColumns($numColumn);

            $countRowExcel = 1;
            $arrayMessage = array('result' => true, 'message' => "" );

            foreach ($reader->toArray() as $key => $HDSK) {
                $countRowExcel++;

                $resultMessage = self::validateHDSKImport($HDSK);

                if($resultMessage['result'] == false)
                {
                    $arrayMessage['result'] = false;
                    $arrayMessage['message'] .= "&#13; Dòng " . $countRowExcel . ": " . $resultMessage['message'];
                }
            }

            if($arrayMessage['result'])
            {
                foreach ($reader->toArray() as $key => $HDSK) {

                    // Lưu sinh viên
                    $hdsk = self::storeHDSK($HDSK);

                    // // Tạo user/pass
                    // if($sinhVien || count($sinhVien) > 0)
                    // {
                    //     $user = self::storeUser($SinhVien, $sinhVien->id);
                    // }

                    // // Add user to group sinh viên
                    // if($user || count($user) > 0)
                    // {
                    //     self::storeUserGroup($user->id, $group_id_SinhVien);
                    // }
                }
            }
            else
            {
                return redirect()->route('hoatdongsukien')->withInput()->with(['message'=>$arrayMessage['message']]);
            }
        }
        else
            return redirect()->back()->with(['danger'=>"Không tìm thấy file để import.<br>Vui lòng refresh (hoặc nhấn F5) và chọn/nhập lại thông tin"]);
    }
    public function validateHDSKImport($HDSK)
    {
        $arrayMessage = array('result' => true, 'message' => "" );

        
        if(empty(trim($HDSK['hocky_namhoc_id'])))
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Không có học  kỳ; ";
        }

        
        if(empty(trim($HDSK['loaihoatdongsukien'])))
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Không có loại hoạt động sự kiện; ";
        }

        
        if(empty(trim($HDSK['tenhoatdongsukien'])))
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Không có tên hoạt động sự kiện; ";
        }

       
        $HDSKExist = HoatDongSuKien::where('tenhoatdongsukien', '=', $HDSK['tenhoatdongsukien'])->get();
        if(count($HDSKExist) > 0)
        {
            $arrayMessage['result'] = false;
            $arrayMessage['message'] .= "Tên hoạt động sự kiện đã tồn tại; ";
        }

        // // 2. Kiểm tra email
        // $SinhVienExist = SinhVien::where('email_agu', '=', $SinhVien['email'])->get();
        // if(count($SinhVienExist) > 0)
        // {
        //     $arrayMessage['result'] = false;
        //     $arrayMessage['message'] .= "EMAIL đã tồn tại; ";
        // }

        // // 3. Kiểm tra số cmnd
        // $SinhVienExist = SinhVien::where('cmnd', '=', $SinhVien['cmnd'])->get();
        // if(count($SinhVienExist) > 0)
        // {
        //     $arrayMessage['result'] = false;
        //     $arrayMessage['message'] .= "CMND đã tồn tại;";
        // }

        return $arrayMessage;
    }

    public function storeHDSK($HDSK)
    {
        try {
            $hdsk = new HoatDongSuKien();

            $hdsk->hocky_namhoc_id = $HDSK['hocky_namhoc_id'];
            $hdsk->loaihoatdongsukien_id = $HDSK['loaihoatdongsukien'];
            $sinhVien->tenhoatdongsukien = $HDSK['tenhoatdongsukien'];

            try {
                $hdsk->thoigianbatdaudangky = Carbon::createFromFormat('d/M/Y', $HDSK['thoigianbatdaudangky'])->format('Y-m-d');
            } catch (Exception $e) {}
             try {
                $hdsk->thoigianketthucdangky = Carbon::createFromFormat('d/M/Y', $HDSK['thoigianketthucdangky'])->format('Y-m-d');
            } catch (Exception $e) {}
             try {
                $hdsk->thoigianbatdau = Carbon::createFromFormat('d/M/Y h:i:s', $HDSK['thoigianbatdau'])->format('Y-m-d h:i:s');
            } catch (Exception $e) {}
             try {
                $hdsk->thoigianketthuc = Carbon::createFromFormat('d/M/Y h:i:s', $HDSK['thoigianketthuc'])->format('Y-m-d h:i:s');
            } catch (Exception $e) {}

            $hdsk->diadiem = $HDSK['diadiem'];
            $hdsk->ghichu = $HDSK['ghichu'];
            $hdsk->xeloaihoatdongsukien = $HDSK['xeloaihoatdongsukien'];

            $hdsk->save();
            
            return $hdsk;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Check Exist Id bộ môn from storage.
     *
     * @param  $Id
     * @return True/False
     */
    public static function isExistId($Id)
    {
        $HoatDongSuKien = HoatDongSuKien::find($Id);
        if(count($HoatDongSuKien)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Mã bộ môn và Tên bộ môn from storage.
     *
     * @param  $MaBoMon, $TenBoMon
     * @return Array(statust, message)
     */
    public static function isNotExistTenHoatDongSuKien($TenHoatDongSuKien)
    {
       
        $request_tenhoatdongsukien = HoatDongSuKienController::isExistTenHoatDongSuKien($TenHoatDongSuKien);

        $status = true;
        $message = "";

        if($request_tenhoatdongsukien)
        {
            $status = false;
            $message .= "<br> - Tên hoạt động sự kiện đã tồn tại!";
        }

        $result = array('status' => $status, 'message' => $message);
        return $result;
    }

    /**
     * 
     *
     * @param  $MaBoMon, $TenBoMon
     * @return Array(statust, message)
     */
    public static function isNotExistTenHoatDongSuKienUpdate($Id,$TenHoatDongSuKien)
    {
       
        $request_tenhoatdongsukien = HoatDongSuKienController::isExistTenHoatDongSuKienUpdate($Id, $TenHoatDongSuKien);

        $status = true;
        $message = "";

        if($request_tenhoatdongsukien)
        {
            $status = false;
            $message .= "<br> - Tên hoạt động sự kiện đã tồn tại!";
        }

        $result = array('status' => $status, 'message' => $message);
        return $result;
    }

    /**
     * Check Exist Mã bộ môn from storage.
     *
     * @param  $MaBoMon
     * @return True, False
     */
    

    /**
     * Check Exist Mã bộ môn from storage to update.
     *
     * @param  $MaBoMon
     * @return True, False
     */
    

    /**
     * Check Exist Tên bộ môn from storage.
     *
     * @param  $TenBoMon
     * @return True, False
     */
    public static function isExistTenHoatDongSuKien($TenHoatDongSuKien)
    {
        $DanhSach_HoatDongSuKien = HoatDongSuKien::where('tenhoatdongsukien', '=', $TenHoatDongSuKien)->select('tenhoatdongsukien')->get();
        if(count($DanhSach_HoatDongSuKien)>0)
            return true;
        return false;
    }

    /**
     * Check Exist Tên bộ môn from storage to update.
     *
     * @param  $TenBoMon
     * @return True, False
     */
    public static function isExistTenHoatDongSuKienUpdate($Id, $TenHoatDongSuKien)
    {
        $DanhSach_HoatDongSuKien = HoatDongSuKien::where('tenhoatdongsukien', '=', $TenHoatDongSuKien)
            -> where('id','<>', $Id)
            ->select('tenhoatdongsukien')->get();
        if(count($DanhSach_HoatDongSuKien)>0)
            return true;
        return false;
    }

    /**
     * Get  STT to insert to storage.
     *
     * @param  null
     * @return $STT
     */
    function test()
    {
        $DS_HoatDongSuKien = DB::table('hoatdongsukien')->leftjoin('loaihoatdongsukien','loaihoatdongsukien.id','=','hoatdongsukien.loaihoatdongsukien_id')->select('loaihoatdongsukien.tenloaihoatdongsukien','hoatdongsukien.*')->get()->toArray();
        return Response()->json($DS_HoatDongSuKien);
    }
   function excel()
   {
    $DS_HoatDongSuKien = DB::table('hoatdongsukien')->leftjoin('loaihoatdongsukien','loaihoatdongsukien.id','=','hoatdongsukien.loaihoatdongsukien_id')->select('loaihoatdongsukien.tenloaihoatdongsukien','hoatdongsukien.*')->get()->toArray();
    $HDSK_array[] = array('Tên hoạt động sự kiện','Loại hoạt động sự kiện','Thời gian bắt đầu đăng ký', 'Thời gian kết thúc đăng ký','Giờ bắt đầu','Giờ kết thúc','Thời gian bắt đầu','Thời gian kết thúc','Địa điểm','Ghi chú');
    foreach ($DS_HoatDongSuKien as $hdsk) {
        $HDSK_array[]=array(
        '<b>Tên hoạt động sự kiện</b>' => $hdsk->tenhoatdongsukien,
        'Loại hoạt động sự kiện' => $hdsk->tenloaihoatdongsukien,
        'Thời gian bắt đầu đăng ký' => date('d/m/Y',strtotime($hdsk->thoigianbatdaudangky)),
        'Thời gian kết thúc đăng ký' => date('d/m/Y',strtotime($hdsk->thoigianketthucdangky)),
        'Giờ bắt đầu' => $hdsk->giobatdau,
        'Giờ kết thúc' => $hdsk->giokethuc,
        'Thời gian bắt đầu' => $hdsk->thoigianbatdau,
        'Thời gian kết thúc' => $hdsk->thoigianketthuc,
        'Địa điểm' => $hdsk->diadiem,
        'Ghi chú' => $hdsk->ghichu
        );
    }
    Excel::create('Hoạt động sự kiện',function($excel) use($HDSK_array){
        $excel->setTitle('Hoạt động sự kiện');
        $excel->sheet('Hoạt động sự kiện', function($sheet) use($HDSK_array){
            $sheet->fromArray($HDSK_array,'Hoạt động sự kiện','A2',false,false);
        });
    })->download('xlsx');
   }
}
