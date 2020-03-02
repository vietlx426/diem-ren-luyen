<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HocKyNamHocBoTieuChi;
use App\TieuChi;
use App\TieuChiMinhChung;
use App\Http\Requests\TieuChiMinhChungRequest;
use Auth;
use Excel;
use App\SinhVien;
use App\BangDiemRenLuyen;
use App\BangDiemHocTap;
use App\TieuChiModuleThoiGian;
use App\HocKyNamHoc;
use App\LyLich;

class ServiceTieuChiMinhChungController extends Controller
{
    public function adminindextieuchiminhchung()
    {
        $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
        $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $hocKyNamHocHienHanh->id)->first();
        if($hocKyNamHocBoTieuChi)
        {
            $boTieuChi = $hocKyNamHocBoTieuChi->botieuchi;
            $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $boTieuChi->id)->where('idtieuchicha', '=', 0)->select('tieuchi.*')->get();
            $totalMarks = $dsTieuChi_Level_0->sum('diemtoida');
            return view('admin.tieuchi_minhchung_index', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks, 'idHocKy'=>$hocKyNamHocHienHanh->id]);
        }
        return view('admin.tieuchi_minhchung_index');
    }

    public function truongdonviindextieuchiminhchung()
    {
        $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
        $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $hocKyNamHocHienHanh->id)->first();
        if($hocKyNamHocBoTieuChi)
        {
            $boTieuChi = $hocKyNamHocBoTieuChi->botieuchi;
            $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $boTieuChi->id)->where('idtieuchicha', '=', 0)->select('tieuchi.*')->get();
            $totalMarks = $dsTieuChi_Level_0->sum('diemtoida');
            return view('truongdonvi.tieuchi_minhchung_index', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks, 'idHocKy'=>$hocKyNamHocHienHanh->id]);
        }
        return view('truongdonvi.tieuchi_minhchung_index');
    }

    public function subadminindextieuchiminhchung()
    {
        $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
        $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $hocKyNamHocHienHanh->id)->first();
        $boTieuChi = $hocKyNamHocBoTieuChi->botieuchi;

        $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $boTieuChi->id)->where('idtieuchicha', '=', 0)->select('tieuchi.*')->get();
        $totalMarks = $dsTieuChi_Level_0->sum('diemtoida');

        return view('subadmin.tieuchi_minhchung_index', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks, 'idHocKy'=>$hocKyNamHocHienHanh->id]);
    }

    public function giaovukhoaindextieuchiminhchung()
    {
        $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
        $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $hocKyNamHocHienHanh->id)->first();
        if($hocKyNamHocBoTieuChi)
        {
            $boTieuChi = $hocKyNamHocBoTieuChi->botieuchi;
            $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $boTieuChi->id)->where('idtieuchicha', '=', 0)->select('tieuchi.*')->get();
            $totalMarks = $dsTieuChi_Level_0->sum('diemtoida');
            return view('giaovukhoa.tieuchi_minhchung_index', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks, 'idHocKy'=>$hocKyNamHocHienHanh->id]);
        }
        return view('giaovukhoa.tieuchi_minhchung_index');
    }

    public function covanhoctapindextieuchiminhchung()
    {
        $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
        $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $hocKyNamHocHienHanh->id)->first();
        if($hocKyNamHocBoTieuChi)
        {
            $boTieuChi = $hocKyNamHocBoTieuChi->botieuchi;
            $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $boTieuChi->id)->where('idtieuchicha', '=', 0)->select('tieuchi.*')->get();
            $totalMarks = $dsTieuChi_Level_0->sum('diemtoida');
            return view('covanhoctap.tieuchi_minhchung_index', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks, 'idHocKy'=>$hocKyNamHocHienHanh->id]);
        }
        return view('covanhoctap.tieuchi_minhchung_index');
    }

    public function bancansuindextieuchiminhchung()
    {
        $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
        $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $hocKyNamHocHienHanh->id)->first();
        if($hocKyNamHocBoTieuChi)
        {
            $boTieuChi = $hocKyNamHocBoTieuChi->botieuchi;
            $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $boTieuChi->id)->where('idtieuchicha', '=', 0)->select('tieuchi.*')->get();
            $totalMarks = $dsTieuChi_Level_0->sum('diemtoida');
            return view('bancansu.tieuchi_minhchung_index', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks, 'idHocKy'=>$hocKyNamHocHienHanh->id]);
        }
        return view('bancansu.tieuchi_minhchung_index');
    }

    public function sinhvienindextieuchiminhchung()
    {
        $hocKyNamHocHienHanh = HocKyNamHocController::getHocKyNamHocHienHanh();
        $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $hocKyNamHocHienHanh->id)->first();
        if($hocKyNamHocBoTieuChi)
        {
            $boTieuChi = $hocKyNamHocBoTieuChi->botieuchi;
            $dsTieuChi_Level_0 = TieuChi::where('botieuchi_id', '=', $boTieuChi->id)->where('idtieuchicha', '=', 0)->select('tieuchi.*')->get();
            $totalMarks = $dsTieuChi_Level_0->sum('diemtoida');
            return view('sinhvien.tieuchi_minhchung_index', ['boTieuChi'=>$boTieuChi, 'dsTieuChi_Level_0' => $dsTieuChi_Level_0, 'countTieuChi_Level_0' => count($dsTieuChi_Level_0), 'totalMarks' => $totalMarks, 'idHocKy'=>$hocKyNamHocHienHanh->id]);
        }
        return view('sinhvien.tieuchi_minhchung_index');
    }

    public function admintieuchiminhchung($idHocKyNamHoc, $idTieuChi)
    {
        $dsTieuChiMinhChung = TieuChiMinhChung::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->get();
        $tieuChi = TieuChi::find($idTieuChi);

        return view('admin.tieuchi_minhchunglist', ['dsTieuChiMinhChung'=>$dsTieuChiMinhChung, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc]);
    }

    public function truongdonvitieuchiminhchung($idHocKyNamHoc, $idTieuChi)
    {
        $dsTieuChiMinhChung = TieuChiMinhChung::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->get();
        $tieuChi = TieuChi::find($idTieuChi);

        return view('truongdonvi.tieuchi_minhchunglist', ['dsTieuChiMinhChung'=>$dsTieuChiMinhChung, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc]);
    }

    public function giaovukhoatieuchiminhchung($idHocKyNamHoc, $idTieuChi)
    {
        $dsTieuChiMinhChung = TieuChiMinhChung::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->get();
        $tieuChi = TieuChi::find($idTieuChi);

        return view('giaovukhoa.tieuchi_minhchunglist', ['dsTieuChiMinhChung'=>$dsTieuChiMinhChung, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc]);
    }

    public function covanhoctaptieuchiminhchung($idHocKyNamHoc, $idTieuChi)
    {
        $dsTieuChiMinhChung = TieuChiMinhChung::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->get();
        $tieuChi = TieuChi::find($idTieuChi);

        return view('covanhoctap.tieuchi_minhchunglist', ['dsTieuChiMinhChung'=>$dsTieuChiMinhChung, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc]);
    }

    public function bancansutieuchiminhchung($idHocKyNamHoc, $idTieuChi)
    {
        $dsTieuChiMinhChung = TieuChiMinhChung::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->get();
        $tieuChi = TieuChi::find($idTieuChi);

        return view('bancansu.tieuchi_minhchunglist', ['dsTieuChiMinhChung'=>$dsTieuChiMinhChung, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc]);
    }

    public function sinhvientieuchiminhchung($idHocKyNamHoc, $idTieuChi)
    {
        $dsTieuChiMinhChung = TieuChiMinhChung::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->get();
        $tieuChi = TieuChi::find($idTieuChi);

        return view('sinhvien.tieuchi_minhchunglist', ['dsTieuChiMinhChung'=>$dsTieuChiMinhChung, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc]);
    }
    
    public function admintieuchiminhchungmodule($idHocKyNamHoc, $idTieuChi, $idModule)
    {
        $tieuChiModuleThoiGian = TieuChiModuleThoiGian::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->where('module_id', '=', $idModule)->first();
        $tieuChi = TieuChi::find($idTieuChi);

        return view('admin.tieuchi_minhchung_module', ['tieuChiModuleThoiGian'=>$tieuChiModuleThoiGian, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc, 'idModule'=>$idModule]);
    }

    public function truongdonvitieuchiminhchungmodule($idHocKyNamHoc, $idTieuChi, $idModule)
    {
        $tieuChiModuleThoiGian = TieuChiModuleThoiGian::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->where('module_id', '=', $idModule)->first();
        $tieuChi = TieuChi::find($idTieuChi);

        return view('truongdonvi.tieuchi_minhchung_module', ['tieuChiModuleThoiGian'=>$tieuChiModuleThoiGian, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc, 'idModule'=>$idModule]);
    }

    public function giaovukhoatieuchiminhchungmodule($idHocKyNamHoc, $idTieuChi, $idModule)
    {
        $tieuChiModuleThoiGian = TieuChiModuleThoiGian::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->where('module_id', '=', $idModule)->first();
        $tieuChi = TieuChi::find($idTieuChi);

        return view('giaovukhoa.tieuchi_minhchung_module', ['tieuChiModuleThoiGian'=>$tieuChiModuleThoiGian, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc, 'idModule'=>$idModule]);
    }

    public function covanhoctaptieuchiminhchungmodule($idHocKyNamHoc, $idTieuChi, $idModule)
    {
        $tieuChiModuleThoiGian = TieuChiModuleThoiGian::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->where('module_id', '=', $idModule)->first();
        $tieuChi = TieuChi::find($idTieuChi);

        return view('covanhoctap.tieuchi_minhchung_module', ['tieuChiModuleThoiGian'=>$tieuChiModuleThoiGian, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc, 'idModule'=>$idModule]);
    }

    public function bancansutieuchiminhchungmodule($idHocKyNamHoc, $idTieuChi, $idModule)
    {
        $tieuChiModuleThoiGian = TieuChiModuleThoiGian::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->where('module_id', '=', $idModule)->first();
        $tieuChi = TieuChi::find($idTieuChi);
        return view('bancansu.tieuchi_minhchung_module', ['tieuChiModuleThoiGian'=>$tieuChiModuleThoiGian, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc, 'idModule'=>$idModule]);
    }

    public function sinhvientieuchiminhchungmodule($idHocKyNamHoc, $idTieuChi, $idModule)
    {
        $tieuChiModuleThoiGian = TieuChiModuleThoiGian::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->where('module_id', '=', $idModule)->first();
        $tieuChi = TieuChi::find($idTieuChi);
        return view('sinhvien.tieuchi_minhchung_module', ['tieuChiModuleThoiGian'=>$tieuChiModuleThoiGian, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc, 'idModule'=>$idModule]);
    }

    public function admintieuchiminhchungmodulekekhailylich($idHocKyNamHoc, $idTieuChi, $idModule)
    {
        if(Auth::check())
        {
            try {
                
                    if($idModule == 2)
                    {
                        $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
                        $namBatDauNamHoc = intval(substr(trim($hocKyNamHoc->namhoc->tennamhoc), 0, 4));
                        $tieuChi = TieuChi::find($idTieuChi);
                        $tieuChiModuleThoiGian = TieuChiModuleThoiGian::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->where('module_id', '=', $idModule)->first();
                        if($tieuChiModuleThoiGian)
                        {
                            $dsSinhVienLyLich = LyLich::where('lylich.created_at', '>=', $tieuChiModuleThoiGian->thoigianbatdau)
                                ->where('lylich.created_at', '<=', $tieuChiModuleThoiGian->thoigianketthuc)
                                ->leftjoin('sinhvien', 'sinhvien.id', '=', 'lylich.sinhvien_id')
                                ->leftjoin('lop', 'lop.id', '=', 'sinhvien.lop_id')
                                ->leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
                                ->where('khoahoc.namketthuc', '>=', $namBatDauNamHoc)
                                ->select('sinhvien.id')
                                ->groupBy('sinhvien.id')
                                ->get();
                            
                            foreach ($dsSinhVienLyLich as $key => $sinhVien) {
                                $bangDiemRenLuyen_TieuChiKeKhaiLyLich = BangDiemRenLuyen::firstOrCreate(['hocky_namhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$sinhVien->id, 'tieuchi_id'=>$tieuChi->id, 'maxdiem'=>$tieuChi->diemtoida]);
                                $bangDiemRenLuyen_TieuChiKeKhaiLyLich->diem = $tieuChi->diemtoida;
                                $bangDiemRenLuyen_TieuChiKeKhaiLyLich->save();
                                self::UpdateDiemTieuChiCha($tieuChi, $idHocKyNamHoc, $sinhVien->id);
                            }
                            return redirect()->route('admin_tieuchi_minhchung_module', ['idhockynamhoc'=>$idHocKyNamHoc, 'idtieuchi'=>$idTieuChi, 'idmodule'=>$idModule])->with('success', "Lưu thành công (đã có " . count($dsSinhVienLyLich) . " sinh viên được cộng điểm)");
                        }
                    }
                    else
                        return redirect()->back()->withInput()->with('danger', "Module này không phải module xét kê khai lý lịch");
                
            } catch (\Throwable $th) {
                return redirect()->route('admin_tieuchi_minhchung_module', ['idhockynamhoc'=>$idHocKyNamHoc, 'idtieuchi'=>$idTieuChi, 'idmodule'=>$idModule])->with('danger', "Lỗi trong quá trình tính điểm. <br>".$th.getMessage());
            }
        }
        else
            return redirect()->route('home');
    }

    public function subadmintieuchiminhchung($idHocKyNamHoc, $idTieuChi)
    {
        $dsTieuChiMinhChung = TieuChiMinhChung::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->get();
        $tieuChi = TieuChi::find($idTieuChi);

        return view('subadmin.tieuchi_minhchunglist', ['dsTieuChiMinhChung'=>$dsTieuChiMinhChung, 'tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc]);
    }

    public function admintieuchiminhchungimportcreate($idHocKyNamHoc, $idTieuChi)
    {
        $dsTieuChiMinhChung = TieuChiMinhChung::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('tieuchi_id', '=', $idTieuChi)->get();
        $tieuChi = TieuChi::find($idTieuChi);

        return view('admin.tieuchi_minhchungimport', ['tieuChi'=>$tieuChi, 'idHocKy'=>$idHocKyNamHoc]);
    }

    public function admintieuchiminhchungimportstore(TieuChiMinhChungRequest $request)
    {
        $idHocKyNamHoc = $request->idhockynamhoc;
        $idTieuChi = $request->idtieuchi;
        // $diem = $request->diem;

        /* 1. Execute cộng điểm */
        if($request->hasFile('input_file'))
        {
            $resultMessage = self::ExecuteImport($request->file('input_file'), $idHocKyNamHoc, $idTieuChi);
            if($resultMessage['result'])
            {
                /* 2. Lưu vào csdl */
                $tieuChiMinhChung = new TieuChiMinhChung();
                $tieuChiMinhChung->hockynamhoc_id = $idHocKyNamHoc;
                $tieuChiMinhChung->tieuchi_id = $idTieuChi;
                $tieuChiMinhChung->tenminhchung = $request->tenminhchung;
                // $tieuChiMinhChung->diem = $diem;
                $tieuChiMinhChung->save();

                /* 3. Upload file */
                // Lưu file excel cộng điểm để làm minh chứng
                $filename = $tieuChiMinhChung->id . '_Import_MinhChungTieuChi';
                $fullFileName = self::UploadFile($request->file('input_file'), $filename, $idHocKyNamHoc, $idTieuChi);
                $tieuChiMinhChung->fileupload = $fullFileName;
                $tieuChiMinhChung->save();

                // Lưu file minh chứng (bảng có chữ ký) (nếu có)
                if($request->hasFile('input_file_scan'))
                {
                    $filename = $tieuChiMinhChung->id .'_MinhChung_MinhChungTieuChi';
                    $fullFileName = self::UploadFile($request->file('input_file_scan'), $filename, $idHocKyNamHoc, $idTieuChi);
                    $tieuChiMinhChung->filescan = $fullFileName;
                    $tieuChiMinhChung->save();
                }
                return redirect()->route('admin_tieuchi_minhchung_importcreate', ['idhockynamhoc'=>$idHocKyNamHoc, 'idtieuchi'=>$idTieuChi])->with('success', "Import thành công.");
            }
            else
                return redirect()->back()->withInput()->with(['message'=>$resultMessage['message']]);
        }
        return redirect()->route('admin_tieuchi_minhchung_importcreate', ['idhockynamhoc'=>$idHocKyNamHoc, 'idtieuchi'=>$idTieuChi])->with('warning', "Import không thành công. Vui lòng thử lại.");
    }

    public function UploadFile($inpFile, $fileName, $idHocKyNamHoc, $idTieuChi)
    {
        if(!is_null($inpFile))
        {
            $ext = $inpFile->getClientOriginalExtension();
            $pathFile = storage_path().'/minhchungtieuchi/'.$idHocKyNamHoc."/".$idTieuChi."/";

            $inpFile->move($pathFile, $fileName.'.'.$ext);

            return $pathFile . $fileName.'.'.$ext;
        }
    }

    public function ExecuteImport($inpFile, $idHocKyNamHoc, $idTieuChi)
    {
        $reader = Excel::selectSheetsByIndex(0)->load($inpFile->getRealPath());
        $resultMessage = self::ValidateBanCanSuImport($reader);

        if($resultMessage['result'])
        {
            $tieuChi = TieuChi::find($idTieuChi);

            foreach ($resultMessage['data'] as $key => $data) {
                self::Execute($data['mssv'], $idHocKyNamHoc, $tieuChi, $data['diem']);
            }
        }
        // else
        return $resultMessage;
    }

    public function ValidateBanCanSuImport($reader)
    {
        $arrayMessage = array('result' => true, 'message' => "", 'data'=>array());
        $data = array();
        $MAX_ROW = 100000;
        $START_ROW = 10;
        // $DIEM_INDEX = "B7";

        $sheet = $reader->getSheet(0);
        $numRow = $reader->get()->count();
        $numRow = min($numRow, $MAX_ROW);
        
        // Kiểm tra điểm
        // $diem=$sheet->getCell('B7')->getValue();
        // if(empty($diem))
        // {
        //     $arrayMessage['result'] = false;
        //     $arrayMessage['message'] = "Chưa nhập điểm ở ô B7";
        // }
        for($row = $START_ROW; $row <= $numRow + 1; $row++)
        {
            $mssv=trim($sheet->getCell('B'.$row)->getValue());
            $diem=trim($sheet->getCell('F'.$row)->getValue());
            array_push($arrayMessage['data'], array('mssv'=>$mssv, 'diem'=>$diem));
            if(empty(trim($mssv)))
            {
                $arrayMessage['result'] = false;
                $arrayMessage['message'] .= "&#13; Dòng " . $row . ": Không có mssv";
            }
            else
            {
                $sinhVien = SinhVien::where('mssv', '=', trim($mssv))->first();
                if(!$sinhVien)
                {
                    $arrayMessage['result'] = false;
                    $arrayMessage['message'] .= "&#13; Dòng " . $row . ": Mã số sinh viên (" . trim($mssv) . ") không có trong hệ thống";
                }
            }
        }
        return $arrayMessage;
    }

    // public function Execute($mssv, $idHocKyNamHoc, $idTieuChi, $diem)
    public function Execute($mssv, $idHocKyNamHoc, $tieuChi, $diem)
    {
        $boolUpdateDiem = true;
        $idModuleDiemHocTap = 1;
        $idSinhVien = SinhVien::where('mssv', '=', $mssv)->first()->id;
        // $tieuChi = TieuChi::find($idTieuChi);
        $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            ->where('sinhvien_id', '=', $idSinhVien)
            ->where('tieuchi_id', '=', $tieuChi->id)
            ->first();

        if(!$bangDiemRenLuyen)
        {
            $bangDiemRenLuyen = BangDiemRenLuyen::create(array('hocky_namhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$idSinhVien, 'tieuchi_id'=>$tieuChi->id, 'maxdiem'=>$tieuChi->diemtoida, 'diemtoida'=>$tieuChi->diemtoida));
            $bangDiemRenLuyen->diem = $tieuChi->diemmacdinh;
        }
        
        if($bangDiemRenLuyen->diem > $bangDiemRenLuyen->maxdiem)
            $boolUpdateDiem = false;

        $newMark = self::CalculatorMark($diem, $tieuChi, $idHocKyNamHoc, $idSinhVien);

        if($tieuChi->module_id == $idModuleDiemHocTap)
        {
            $bangDiemHocTap = BangDiemHocTap::firstOrCreate(array('hockynamhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$idSinhVien));
            $bangDiemHocTap->diem = $diem;
            $bangDiemHocTap->save();
        }

        $bangDiemRenLuyen->diem += $newMark;

        $bangDiemRenLuyen->save();
        self::TinhDiemThuong($tieuChi, $idHocKyNamHoc, $idSinhVien);
        
        if($boolUpdateDiem)
            self::UpdateDiemTieuChiCha($tieuChi, $idHocKyNamHoc, $idSinhVien);

        return;
    }

    public function CalculatorMark($diem, $tieuChi, $idHocKyNamHoc, $idSinhVien)
    {
        $newMark = $diem;

        if($tieuChi->module_id)
        {
            switch ($tieuChi->module_id) {
                case '1':
                    $newMark = ServiceModuleController::KetQuaHocTapQuyDoi($diem);
                    break;
                
                case '3':
                    $newMark = ServiceModuleController::KetQuaSinhHoatCongDanQuyDoi($diem);
                    break;
                
                default:
                    break;
            }
        }
        return $newMark;
    }

    public function TinhDiemThuong($tieuChi, $idHocKyNamHoc, $idSinhVien)
    {
        if($tieuChi->module_id)
        {
            switch ($tieuChi->module_id) {
                case '4':
                    ServiceModuleController::DiemThuongTieuChiChinhTriXaHoi($idSinhVien, $idHocKyNamHoc);
                    break;
                    
                case '5':
                    ServiceModuleController::DiemThuongTieuChiTinhNguyen($idSinhVien, $idHocKyNamHoc);
                    break;
                
                default:
                    break;
            }
        }
        return "";
    }

    public static function UpdateDiemTieuChiCha($tieuChi, $idHocKyNamHoc, $idSinhVien)
    {
        $tongDiemTieuChiCha = 0;
        $tieuChiCha = TieuChi::find($tieuChi->idtieuchicha);
        $dsTieuChiCon = TieuChi::where('idtieuchicha', '=', $tieuChi->idtieuchicha)->get();
        
        foreach($dsTieuChiCon as $key => $tieuChiCon)
        {
            $bangDiemRenLuyenTieuChiCon = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            ->where('sinhvien_id', '=', $idSinhVien)
            ->where('tieuchi_id', '=', $tieuChiCon->id)
            ->first();
            
            if(!$bangDiemRenLuyenTieuChiCon)
                $bangDiemRenLuyenTieuChiCon = BangDiemRenLuyen::create(array('hocky_namhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$idSinhVien, 'tieuchi_id'=>$tieuChiCon->id, 'maxdiem'=>$tieuChiCon->diemtoida, 'diem'=>$tieuChiCon->diemmacdinh));

            $tongDiemTieuChiCha += min($bangDiemRenLuyenTieuChiCon->maxdiem,  $bangDiemRenLuyenTieuChiCon->diem);
        }

        // Điểm của tiêu chí cha
        $bangDiemRenLuyenTieuChiCha = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            ->where('sinhvien_id', '=', $idSinhVien)
            ->where('tieuchi_id', '=', $tieuChi->idtieuchicha)
            ->first();

        if(!$bangDiemRenLuyenTieuChiCha)
            $bangDiemRenLuyenTieuChiCha = BangDiemRenLuyen::create(array('hocky_namhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$idSinhVien, 'tieuchi_id'=>$tieuChi->idtieuchicha, 'maxdiem'=>$tieuChiCha->diemtoida));

        $bangDiemRenLuyenTieuChiCha->diem = $tongDiemTieuChiCha;
        $bangDiemRenLuyenTieuChiCha->save();

        if($tieuChiCha->idtieuchicha > 0)
            self::UpdateDiemTieuChiCha($tieuChiCha, $idHocKyNamHoc, $idSinhVien);
        return;
    }

    public function admintieuchiminhchungdownloadfileimport($idTieuChiMinhChung)
    {
        $tieuChiMinhChung = TieuChiMinhChung::find($idTieuChiMinhChung);
        if($tieuChiMinhChung)
        {   
            $filePath = $tieuChiMinhChung->fileupload;
            if(file_exists($filePath))
                return response()->download($filePath);
            else
                return redirect()->back()->with('danger', "File không tồn tại");
        }
        else
            return redirect()->back()->with('danger', "File không tồn tại");
    }

    public function subadmintieuchiminhchungdownloadfileimport($idTieuChiMinhChung)
    {
        return self::admintieuchiminhchungdownloadfileimport($idTieuChiMinhChung);
    }

    public function truongdonvitieuchiminhchungdownloadfileimport($idTieuChiMinhChung)
    {
        return self::admintieuchiminhchungdownloadfileimport($idTieuChiMinhChung);
    }

    public function giaovukhoatieuchiminhchungdownloadfileimport($idTieuChiMinhChung)
    {
        $tieuChiMinhChung = TieuChiMinhChung::find($idTieuChiMinhChung);
        if($tieuChiMinhChung)
        {   
            $filePath = $tieuChiMinhChung->fileupload;
            if(file_exists($filePath))
                return response()->download($filePath);
            else
                return redirect()->back()->with('danger', "File không tồn tại");
        }
        else
            return redirect()->back()->with('danger', "File không tồn tại");
    }

    public function covanhoctaptieuchiminhchungdownloadfileimport($idTieuChiMinhChung)
    {
        $tieuChiMinhChung = TieuChiMinhChung::find($idTieuChiMinhChung);
        if($tieuChiMinhChung)
        {   
            $filePath = $tieuChiMinhChung->fileupload;
            if(file_exists($filePath))
                return response()->download($filePath);
            else
                return redirect()->back()->with('danger', "File không tồn tại");
        }
        else
            return redirect()->back()->with('danger', "File không tồn tại");
    }

    public function bancansutieuchiminhchungdownloadfileimport($idTieuChiMinhChung)
    {
        $tieuChiMinhChung = TieuChiMinhChung::find($idTieuChiMinhChung);
        if($tieuChiMinhChung)
        {   
            $filePath = $tieuChiMinhChung->fileupload;
            if(file_exists($filePath))
                return response()->download($filePath);
            else
                return redirect()->back()->with('danger', "File không tồn tại");
        }
        else
            return redirect()->back()->with('danger', "File không tồn tại");
    }

    public function sinhvientieuchiminhchungdownloadfileimport($idTieuChiMinhChung)
    {
        $tieuChiMinhChung = TieuChiMinhChung::find($idTieuChiMinhChung);
        if($tieuChiMinhChung)
        {   
            $filePath = $tieuChiMinhChung->fileupload;
            if(file_exists($filePath))
                return response()->download($filePath);
            else
                return redirect()->back()->with('danger', "File không tồn tại");
        }
        else
            return redirect()->back()->with('danger', "File không tồn tại");
    }
    
    public function admintieuchiminhchungdownloadfileminhchung($idTieuChiMinhChung)
    {
        $tieuChiMinhChung = TieuChiMinhChung::find($idTieuChiMinhChung);
        if($tieuChiMinhChung)
        {   
            $filePath = $tieuChiMinhChung->filescan;
            if(file_exists($filePath))
                return response()->download($filePath);
            else
                return redirect()->back()->with('danger', "File không tồn tại");
        }
        else
            return redirect()->back()->with('danger', "File không tồn tại");
    }

    public function subadmintieuchiminhchungdownloadfileminhchung($idTieuChiMinhChung)
    {
        return self::admintieuchiminhchungdownloadfileminhchung($idTieuChiMinhChung);
    }

    public function truongdonvitieuchiminhchungdownloadfileminhchung($idTieuChiMinhChung)
    {
        return self::admintieuchiminhchungdownloadfileminhchung($idTieuChiMinhChung);
    }

    public function giaovukhoatieuchiminhchungdownloadfileminhchung($idTieuChiMinhChung)
    {
        $tieuChiMinhChung = TieuChiMinhChung::find($idTieuChiMinhChung);
        if($tieuChiMinhChung)
        {   
            $filePath = $tieuChiMinhChung->filescan;
            if(file_exists($filePath))
                return response()->download($filePath);
            else
                return redirect()->back()->with('danger', "File không tồn tại");
        }
        else
            return redirect()->back()->with('danger', "File không tồn tại");
    }

    public function covanhoctaptieuchiminhchungdownloadfileminhchung($idTieuChiMinhChung)
    {
        $tieuChiMinhChung = TieuChiMinhChung::find($idTieuChiMinhChung);
        if($tieuChiMinhChung)
        {   
            $filePath = $tieuChiMinhChung->filescan;
            if(file_exists($filePath))
                return response()->download($filePath);
            else
                return redirect()->back()->with('danger', "File không tồn tại");
        }
        else
            return redirect()->back()->with('danger', "File không tồn tại");
    }

    public function bancansutieuchiminhchungdownloadfileminhchung($idTieuChiMinhChung)
    {
        $tieuChiMinhChung = TieuChiMinhChung::find($idTieuChiMinhChung);
        if($tieuChiMinhChung)
        {   
            $filePath = $tieuChiMinhChung->filescan;
            if(file_exists($filePath))
                return response()->download($filePath);
            else
                return redirect()->back()->with('danger', "File không tồn tại");
        }
        else
            return redirect()->back()->with('danger', "File không tồn tại");
    }

    public function sinhvientieuchiminhchungdownloadfileminhchung($idTieuChiMinhChung)
    {
        $tieuChiMinhChung = TieuChiMinhChung::find($idTieuChiMinhChung);
        if($tieuChiMinhChung)
        {   
            $filePath = $tieuChiMinhChung->filescan;
            if(file_exists($filePath))
                return response()->download($filePath);
            else
                return redirect()->back()->with('danger', "File không tồn tại");
        }
        else
            return redirect()->back()->with('danger', "File không tồn tại");
    }

    public function admintieuchiminhchungdestroy($id = '')
    {
        try {
            $tieuChiMinhChung = TieuChiMinhChung::find($id);
            if($tieuChiMinhChung)
            {
                // 1. Rollback điểm
                self::RollbackMark($tieuChiMinhChung);
                
                // 2. Delete file
                self::DeleteFile($tieuChiMinhChung);

                // 3. Delete database
                TieuChiMinhChung::destroy($id);

                return redirect()->route('admin_tieuchi_minhchung', ['idhockynamhoc'=>$tieuChiMinhChung->hockynamhoc_id, 'idtieuchi'=>$tieuChiMinhChung->tieuchi_id])->with('success', 'Xóa thành công!');
            }
            else
                return redirect()->back()->withInput()->with('danger', 'Không tìm thấy dữ liệu để xóa!');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('danger', 'Xóa bị lỗi!<br>' . $th->getMessage());
        }
    }

    public function RollbackMark(TieuChiMinhChung $tieuChiMinhChung)
    {
        $idHocKyNamHoc = $tieuChiMinhChung->hockynamhoc_id;
        $idTieuChi = $tieuChiMinhChung->tieuchi_id;
        $filePath = $tieuChiMinhChung->fileupload;

        $reader = Excel::selectSheetsByIndex(0)->load($filePath);
        return self::ExecuteRollback($reader, $idTieuChi, $idHocKyNamHoc);
    }

    public function ExecuteRollback($reader, $idTieuChi, $idHocKyNamHoc)
    {
        try {
            $MAX_ROW = 100000;
            $START_ROW = 10;

            $sheet = $reader->getSheet(0);
            $numRow = $reader->get()->count();
            $numRow = min($numRow, $MAX_ROW);

            for($row = $START_ROW; $row <= $numRow + 1; $row++)
            {
                $mssv=trim($sheet->getCell('B'.$row)->getValue());
                $diem= trim($sheet->getCell('F'.$row)->getValue());

                $idModuleDiemHocTap = 1;

                $idSinhVien = SinhVien::where('mssv', '=', $mssv)->first()->id;
                $tieuChi = TieuChi::find($idTieuChi);

                $bangDiemRenLuyen = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                    ->where('sinhvien_id', '=', $idSinhVien)
                    ->where('tieuchi_id', '=', $idTieuChi)
                    ->first();

                $newMark = self::CalculatorMark($diem, $tieuChi, $idHocKyNamHoc, $idSinhVien);

                if($tieuChi->module_id == $idModuleDiemHocTap)
                {
                    $bangDiemHocTap = BangDiemHocTap::firstOrCreate(array('hockynamhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$idSinhVien));
                    $bangDiemHocTap->diem = null;
                    $bangDiemHocTap->save();
                }
                $bangDiemRenLuyen->diem -= $newMark;
                $bangDiemRenLuyen->save();

                self::TinhDiemThuong($tieuChi, $idHocKyNamHoc, $idSinhVien);
                
                self::UpdateDiemTieuChiCha($tieuChi, $idHocKyNamHoc, $idSinhVien);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return true;
    }

    public function DeleteFile(TieuChiMinhChung $tieuChiMinhChung)
    {
        try {
            if (file_exists($tieuChiMinhChung->fileupload)) {
                unlink($tieuChiMinhChung->fileupload);
            }
    
            if (file_exists($tieuChiMinhChung->filescan)) {
                unlink($tieuChiMinhChung->filescan);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return true;
    }
}
