<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HocKyNamHoc;
use App\BangDiemRenLuyen;
use App\TieuChi;
use App\HocKyNamHocBoTieuChi;
use App\Tinh;
use App\Khoa;
use App\KhoaHoc;
use DB;

class ServiceSearchFilterController extends Controller
{
    public function adminindex(Request $request)
    {
        $dsHocKyNamHoc = HocKyNamHoc::orderBy('id', 'desc')->take(20)->get();
        return view('admin.search_filter', ['dsHocKyNamHoc'=>$dsHocKyNamHoc]);
    }

    public function adminstaticalregion()
    {
        $dsTinh = Tinh::orderBy('tentinh', 'asc')->get();
        $dsKhoaHoc = KhoaHoc::orderBy('id', 'desc')->limit(15)->get();
        $dsKhoa = Khoa::where('loaikhoaphong_id', '=', 1)->orderBy('tenkhoa', 'asc')->get();
        return view('admin.statical_region', ['dsTinh'=>$dsTinh, 'dsKhoaHoc'=>$dsKhoaHoc, 'dsKhoa'=>$dsKhoa]);
    }

    public function truongdonvistaticalregion()
    {
        $dsTinh = Tinh::orderBy('tentinh', 'asc')->get();
        $dsKhoaHoc = KhoaHoc::orderBy('id', 'desc')->limit(15)->get();
        $dsKhoa = Khoa::where('loaikhoaphong_id', '=', 1)->orderBy('tenkhoa', 'asc')->get();
        return view('truongdonvi.statical_region', ['dsTinh'=>$dsTinh, 'dsKhoaHoc'=>$dsKhoaHoc, 'dsKhoa'=>$dsKhoa]);
    }

    public function subadminindex(Request $request)
    {
        $dsHocKyNamHoc = HocKyNamHoc::orderBy('id', 'desc')->take(20)->get();
        return view('subadmin.search_filter', ['dsHocKyNamHoc'=>$dsHocKyNamHoc]);
    }
    
    public function truongdonviindex(Request $request)
    {
        $dsHocKyNamHoc = HocKyNamHoc::orderBy('id', 'desc')->take(20)->get();
        return view('truongdonvi.search_filter', ['dsHocKyNamHoc'=>$dsHocKyNamHoc]);
    }
    
    public function adminindexpost(Request $request)
    {
        $query = BangDiemRenLuyen::query();
        // Query tiêu chí level 0
        if(count($request->HocKyNamHocID) > 0)
            $dsTieuChi_Level_0 = HocKyNamHocBoTieuChi::whereIn('hockynamhoc_id', $request->HocKyNamHocID)
                ->join('tieuchi', 'tieuchi.botieuchi_id', '=', 'hockynamhocbotieuchi.botieuchi_id')
                ->where('tieuchi.idtieuchicha', '=', 0)
                ->select('tieuchi.id')
                ->groupBy('tieuchi.id')
                ->get();
        else
            $dsTieuChi_Level_0 = TieuChi::where('tieuchi.idtieuchicha', '=', 0)->select('id')->get();

        // Query học kỳ - năm học
        if(count($request->HocKyNamHocID) > 0)
        $query->join('sinhvien', 'sinhvien.id', 'bangdiemrenluyen.sinhvien_id')
            ->join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            ->join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            ->join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            ->join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            ->whereIn('bangdiemrenluyen.hocky_namhoc_id', $request->HocKyNamHocID)
            ->whereIn('tieuchi_id', $dsTieuChi_Level_0)
            ->select('bangdiemrenluyen.sinhvien_id', 'bangdiemrenluyen.hocky_namhoc_id', 'sinhvien.mssv', 'sinhvien.hochulot', 'sinhvien.ten', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa', DB::raw('sum(if(bangdiemrenluyen.diem >= bangdiemrenluyen.maxdiem, bangdiemrenluyen.maxdiem, bangdiemrenluyen.diem)) as tongdiem'))
            ->groupBy('bangdiemrenluyen.sinhvien_id', 'bangdiemrenluyen.hocky_namhoc_id', 'sinhvien.mssv', 'sinhvien.hochulot', 'sinhvien.ten', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa')
            ->orderBy('khoa.tenkhoa', 'asc')
            ->orderBy('lop.tenlop', 'asc')
            ->orderBy('sinhvien.mssv', 'asc');
        else
            $query->join('sinhvien', 'sinhvien.id', 'bangdiemrenluyen.sinhvien_id')
            ->join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            ->join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            ->join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            ->join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            ->whereIn('tieuchi_id', $dsTieuChi_Level_0)
            ->select('bangdiemrenluyen.sinhvien_id', 'bangdiemrenluyen.hocky_namhoc_id', 'sinhvien.mssv', 'sinhvien.hochulot', 'sinhvien.ten', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa', DB::raw('sum(if(bangdiemrenluyen.diem >= bangdiemrenluyen.maxdiem, bangdiemrenluyen.maxdiem, bangdiemrenluyen.diem)) as tongdiem'))
            ->groupBy('bangdiemrenluyen.sinhvien_id', 'bangdiemrenluyen.hocky_namhoc_id', 'sinhvien.mssv', 'sinhvien.hochulot', 'sinhvien.ten', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa')
            ->orderBy('khoa.tenkhoa', 'asc')
            ->orderBy('lop.tenlop', 'asc')
            ->orderBy('sinhvien.mssv', 'asc');

        // Query điều kiện điểm học tập
        if($request->HocTap['hoctapdieukien1'])
            $query->join('bangdiemhoctap', 'bangdiemhoctap.sinhvien_id', '=','bangdiemrenluyen.sinhvien_id')->where('bangdiemhoctap.hockynamhoc_id', '=', 'bangdiemrenluyen.hocky_namhoc_id')
                ->where('bangdiemhoctap.diem', $request->HocTap['HocTapdieukien1'], $request->HocTap['hoctapdieukien1value']);

        if($request->HocTap['hoctapdieukien1'] && $request->HocTap['hoctapdieukien2'])
            $query->where('bangdiemhoctap.diem', $request->HocTap['hoctapdieukien2'], $request->HocTap['hoctapdieukien2value']);
        
        if(!$request->HocTap['hoctapdieukien1'] && $request->HocTap['hoctapdieukien2'])
            $query->join('bangdiemhoctap', 'bangdiemhoctap.sinhvien_id', '=','bangdiemrenluyen.sinhvien_id')->where('bangdiemhoctap.hockynamhoc_id', '=', 'bangdiemrenluyen.hocky_namhoc_id')
                ->where('bangdiemhoctap.diem', $request->HocTap['hoctapdieukien2'], $request->HocTap['hoctapdieukien2value']);

        // Query điều kiện điểm rèn luyện
        if($request->RenLuyen['renluyendieukien1'])
            $query->having('tongdiem', $request->RenLuyen['renluyendieukien1'], $request->RenLuyen['renluyendieukien1value']);

        if($request->RenLuyen['renluyendieukien1'] && $request->RenLuyen['renluyendieukien2'])
            $query->having('tongdiem', $request->RenLuyen['renluyendieukien2'], $request->RenLuyen['renluyendieukien2value']);
        
        if(!$request->RenLuyen['renluyendieukien1'] && $request->RenLuyen['renluyendieukien2'])
            $query->having('tongdiem', $request->RenLuyen['renluyendieukien2'], $request->RenLuyen['renluyendieukien2value']);

        $result = $query->get();
        foreach ($result as $key => $value) {
            $diemHocTap = BangDiemHocTapController::GetDiemHocTap($value->hocky_namhoc_id, $value->sinhvien_id);
            $value->diemhoctap = $diemHocTap;
        }
        return $result;
    }
}
