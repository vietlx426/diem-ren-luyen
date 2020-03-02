<?php

namespace App\Http\Controllers;

use App\SinhVien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests\SinhVienProfileRequest;
use App\Http\Requests\SinhVienRequest;
use Validator;
use App\DanToc;
use App\TonGiao;
use App\Tinh;
use App\Huyen;
use App\Xa;
use App\MoiQuanHe;
use App\LyLich;
use App\AnhChiEm;
use App\Khoa;
use App\Nganh;
use App\KhoaHoc;
use App\Lop;
use App\GioiTinh;
use App\User;
use App\UserGroup;
use App\BanCanSu;
use App\DangKyHoatDongSuKien;
use PDF;
use DB;
use File;
use Excel;
use Carbon\Carbon;
use App\CoVanHocTap;
use App\TieuChiModuleThoiGian;
use App\BangDiemRenLuyen;
use App\TieuChi;


class SinhVienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DS_Khoa = Khoa::all();
        $DS_Nganh = Nganh::all();
        $DS_KhoaHoc = KhoaHoc::all();
        return view('subadmin.studentlist', ['DS_Khoa' => $DS_Khoa, 'DS_Nganh' => $DS_Nganh, 'DS_KhoaHoc' => $DS_KhoaHoc]);
    }

    public function covanhoctap_index()
    {
        $idCBGV = "";

        if(Auth::check())
        {
            $user = Auth::user();
            $idCBGV = $user->cbgvsv_id ? $user->cbgvsv_id : "";
        }

        $coVanHocTap = CoVanHocTap::where('canbogiangvien_id', '=', $idCBGV)
            -> where('trangthai_id', '=', 1)
            -> first();

        $idLop = $coVanHocTap ? $coVanHocTap->lop_id : "";

        $dsSinhVien = SinhVien::where('lop_id', '=', $idLop)->orderBy('mssv', 'asc')->get();

        return view('covanhoctap.studentlist', ['dsSinhVien' => $dsSinhVien]);

    }

    public function giaovukhoa_sinhvien($idLop)
    {
        $listSinhVien = SinhVien::where('lop_id', '=', $idLop)->get();
        return view('giaovukhoa.studentlist', ['listSinhVien'=>$listSinhVien]);
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
     * @param  \App\SinhVien  $sinhVien
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Student = SinhVien::find($id);
        $DS_GioiTinh = GioiTinh::all();
        $DS_Lop = Lop::all();

        return view('subadmin.studentedit', ['Student' => $Student, 'DS_GioiTinh' => $DS_GioiTinh, 'DS_Lop' => $DS_Lop]);
    }

    public function showKhoa($idKhoa)
    {
        $DS_SinhVien = SinhVien::join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            -> where('khoa.id', '=', $idKhoa)
            -> select('sinhvien.*', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa')
            -> get();
        return $DS_SinhVien->toArray();
    }

    public function showNganh($idNganh)
    {
        $DS_SinhVien = SinhVien::join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            -> where('nganh.id', '=', $idNganh)
            -> select('sinhvien.*', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa')
            -> get();
        return $DS_SinhVien->toArray();
    }

    public function showKhoaHoc($idKhoaHoc)
    {
        $DS_SinhVien = SinhVien::join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            -> where('lop.khoahoc_id', '=', $idKhoaHoc)
            -> select('sinhvien.*', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa')
            -> get();
        return $DS_SinhVien->toArray();
    }

    public function showLop($tenLop)
    {
        $DS_SinhVien = SinhVien::join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            -> where('lop.tenlop', '=', $tenLop)
            -> select('sinhvien.*', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa')
            -> get();
        return $DS_SinhVien->toArray();
    }

    public function showMSSV($MSSV)
    {
        $DS_SinhVien = SinhVien::join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            -> where('sinhvien.mssv', '=', $MSSV)
            -> select('sinhvien.*', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa')
            -> get();
        return $DS_SinhVien->toArray();
    }

    public function showEmail($Email)
    {
        $DS_SinhVien = SinhVien::join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            -> where('sinhvien.email_agu', '=', $Email)
            -> select('sinhvien.*', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa')
            -> get();
        return $DS_SinhVien->toArray();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SinhVien  $sinhVien
     * @return \Illuminate\Http\Response
     */
    public function edit(SinhVien $sinhVien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SinhVien  $sinhVien
     * @return \Illuminate\Http\Response
     */
    public function update(SinhVienRequest $request)
    {
        if(Auth::check() && (UserController::isGroupNoneId(env('GROUP_CHUYENVIENHETHONG')) || UserController::isGroupNoneId(env('GROUP_QUANTRIHETHONG'))))
        {
            $SinhVien = SinhVien::find($request->sinhvien_id);

            if($SinhVien)
            {
                // try {
                    $SinhVien->mssv = $request->mssv;
                    $SinhVien->hochulot = $request->hochulot;
                    $SinhVien->ten = $request->ten;
                    $SinhVien->gioitinh = $request->gioitinh;
                    // $SinhVien->ngaysinh = Carbon::createFromFormat('d/m/Y', $request->ngaysinh);
                    $SinhVien->ngaysinh = date('Y-m-d', strtotime($request->ngaysinh));
                    $SinhVien->email_agu = $request->email;
                    $SinhVien->cmnd = $request->cmnd;
                    $SinhVien->lop_id = $request->lop;
                    $SinhVien->diemtrungtuyen = $request->diemtrungtuyen;
                    $SinhVien->save();
                    return redirect()->back()->with(['success' => 'Lưu (cập nhật thành công)!']);
                // } catch (\Throwable $th) {
                //     //throw $th;
                //     return redirect()->back()->with(['danger' => 'Có lỗi trong quá trình lưu (cập nhật).<br>' . $th->getMessage() . '.<br>Vui lòng nhấn F5 (refresh) và thử lại.']);
                // }

                // try {
                //     1/0;
                //     $SinhVien->mssv = $request->mssv;
                //     $SinhVien->hochulot = $request->hochulot;
                //     $SinhVien->ten = $request->ten;
                //     $SinhVien->gioitinh = $request->gioitinh;
                //     $SinhVien->ngaysinh = Carbon::createFromFormat('d/m/Y', $request->ngaysinh);
                //     $SinhVien->email_agu = $request->email;
                //     $SinhVien->cmnd = $request->cmnd;
                //     $SinhVien->lop_id = $request->lop;
                //     $SinhVien->diemtrungtuyen = $request->diemtrungtuyen;
                //     $SinhVien->save();

                //     return redirect()->back()->with(['success' => 'Lưu (cập nhật thành công)!']);
                // } catch (Exception $e) {

                //     return redirect()->back()->with(['danger' => 'Có lỗi trong quá trình lưu (cập nhật).<br>' . $e->getMessage() . '.<br>Vui lòng nhấn F5 (refresh) và thử lại.']);
                    
                // }
                
            }
            else
            {
                return redirect()->back()->with(['danger' => 'Không tìm thấy thông tin tương ứng để cập nhật.<br>Vui lòng nhấn F5 (refresh) và thử lại.']);
            }
        }
        else
        {
            return redirect()->route('home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SinhVien  $sinhVien
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::check())
        {
            $sinhVien = SinhVien::find($id);
            if($sinhVien)
            {
                $user = Auth::user();
                if(UserGroupController::isGroup($user->id, env('GROUP_CHUYENVIENHETHONG')) || UserGroupController::isGroup($user->id, env('GROUP_QUANTRIHETHONG')))
                {
                    // 1. Xóa ban cán sự nếu có.
                    self::RemoveSinhVienBanCanSu($sinhVien->id);

                    // 2. Xóa đăng ký hoạt động sự kiện
                    self::RemoveSinhVienDangKyHoatDongSuKien($sinhVien->id);
                    
                    // 3. Xóa lý lịch
                    self::RemoveSinhVienLyLich($sinhVien->id);
                    
                    // 4. Xóa user
                    self::RemoveSinhVienUser($sinhVien->id);
                    
                    // 5. Xóa sinh viên
                    self::RemoveSinhVien($sinhVien->id);
                    return array('result'=>true, 'message'=>"Xóa thành công");
                }
                else
                    return array('result'=>false, 'message'=>"Bạn không có quyền xóa");
            }
            else
                return array('result'=>false, 'message'=>"Không tìm thấy");
        }
        return array('result'=>false, 'message'=>"Bạn không có quyền xóa");
    }

    public function RemoveSinhVienBanCanSu($idSinhVien)
    {
        BanCanSu::where('sinhvien_id', '=', $idSinhVien)->delete();
    }
    
    public function RemoveSinhVienDangKyHoatDongSuKien($idSinhVien)
    {
        DangKyHoatDongSuKien::where('sinhvien_id', '=', $idSinhVien)->delete();
    }

    public function RemoveSinhVienLyLich($idSinhVien)
    {
        $dsSinhVienLyLich = LyLich::where('sinhvien_id', '=', $idSinhVien)->get();
        foreach($dsSinhVienLyLich as $lyLich)
        {
            self::RemoveSinhVienLyLichAnhChiEm($lyLich->id);
        }
        LyLich::where('sinhvien_id', '=', $idSinhVien)->delete();
    }

    public function RemoveSinhVienLyLichAnhChiEm($idLyLich)
    {
        AnhChiEm::where('lylich_id', '=', $idLyLich)->delete();
    }

    public function RemoveSinhVienUser($idSinhVien)
    {
        $userSinhVien = User::where('cbgvsv_id', '=', $idSinhVien)->where('idloaiuser', '=', '3')->first();
        if($userSinhVien)
        {
            self::RemoveSinhVienUserGroup($userSinhVien->id);
            User::destroy($userSinhVien->id);
        }
    }

    public function RemoveSinhVienUserGroup($idUser)
    {
        UserGroup::where('idUser', '=', $idUser)->delete();
    }
    
    public function RemoveSinhVien($idSinhvien)
    {
        SinhVien::destroy($idSinhvien);
    }

    public function getProfile()
    {
        if(Auth::check())
        {
            if(UserController::isGroupNoneId(env('GROUP_SINHVIEN')))
            {
                $CBGVSV_ID = Auth::user()->cbgvsv_id;
                $LyLich = LyLich::where('sinhvien_id', '=', $CBGVSV_ID)->orderBy('id', 'desc')->first();
                $SV = SinhVien::find($CBGVSV_ID);
                if($LyLich)
                    $DanhSach_AnhChiEm = $LyLich->anhchiem;
                else
                    $DanhSach_AnhChiEm = AnhChiEm::where('id', '=', 0)->get();

                $DanhSach_DanToc = DanToc::all();
                $DanhSach_TonGiao = TonGiao::all();
                $DanhSach_Tinh = Tinh::all()->sortBy('tentinh');
                $DanhSach_MoiQuanHe = MoiQuanHe::all();

                return view('sinhvien.profile2', ['SV'=>$SV, 'LyLich'=>$LyLich, 'DanhSach_AnhChiEm'=>$DanhSach_AnhChiEm, 'DanhSach_DanToc'=>$DanhSach_DanToc, 'DanhSach_TonGiao'=>$DanhSach_TonGiao, 'DanhSach_Tinh'=>$DanhSach_Tinh, 'DanhSach_MoiQuanHe'=>$DanhSach_MoiQuanHe]);
            }
            else
            {
                return redirect()->route('home');
            }
        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function postProfile(SinhVienProfileRequest $request)
    {
        if(Auth::check())
        {
            /*
             * 
                B1. Kiểm tra xem thêm mới (thêm mới khi chưa có lý lịch hoặc quá 90 ngày kể từ ngày tạo ) hay cập nhật
             *
             */
            switch ($this::getAction()) {
                case '1':
                    if($this::insertLyLich($request))
                    {
                        return redirect()->route('sinhvien_profile')->with('success', "Lưu thành công!");
                    }
                    else
                    {
                        return back()->withInput()->with('error', "Lưu không thành công!<br>Vui lòng refesh lại và thử lại sau.");
                    }
                    break;
                
                case '2':
                    if($this::updateLyLich($request))
                    {
                        return redirect()->route('sinhvien_profile')->with('success', "Lưu thành công!");
                    }
                    else
                    {
                        return back()->withInput()->with('error', "Lưu không thành công!<br>Vui lòng refesh lại và thử lại sau.");
                    }

                    break;
                
                default:
                    return redirect()->route('home');
                    break;
            }
        }
        else
        {
            return redirect()->route('home');
        }
    }

    public static function insertLyLich($request)
    {
        try {
            $sinhvien_id = Auth::user()->cbgvsv_id;

            $LyLich_Old = LyLich::where('sinhvien_id', '=', $sinhvien_id)->orderBy('id', 'desc')->first();

            $LyLich = new LyLich();
            $LyLich->sinhvien_id = $sinhvien_id;
            $LyLich->dienthoai = $request->dienthoai;
            $LyLich->email = $request->email;
            $LyLich->noisinh = $request->noisinh;
            $LyLich->ngaycapcmnd = date('Y-m-d', strtotime($request->ngaycapcmnd));
            $LyLich->noicapcmnd = $request->noicapcmnd;
            $LyLich->xa_id = $request->xa;
            $LyLich->hokhauthuongtru = $request->hokhauthuongtru;
            $LyLich->tamtru_xa_id = $request->xa_tamtru;
            $LyLich->diachitamtru = $request->diachitamtru;
            $LyLich->dantoc_id = $request->dantoc;
            $LyLich->tongiao_id = $request->tongiao;

            if($request->ngayvaodoan)
                $LyLich->ngayvaodoantncshcm = date('Y-m-d', strtotime($request->ngayvaodoan));
            else
                $LyLich->ngayvaodoantncshcm = null;

            $LyLich->noivaodoantncshcm = $request->noivaodoan;
            
            if($request->ngayvaodang)
                $LyLich->ngayvaodangcsvn = date('Y-m-d', strtotime($request->ngayvaodang));
            else
                $LyLich->ngayvaodangcsvn = null;

            $LyLich->noivaodangcsvn = $request->noivaodang;
            $LyLich->hongheo = $request->dienngheocanngheo_ngheo;
            $LyLich->hocanngheo = $request->dienngheocanngheo_canngheo;
            $LyLich->mocoicha = $request->dienmocoi_cha;
            $LyLich->mocoime = $request->dienmocoi_me;
            $LyLich->conthuongbinh = $request->conthuongbinhlietsy_thuongbinh;
            $LyLich->conlietsy = $request->conthuongbinhlietsy_lietsy;
            $LyLich->tantat = $request->tantat;

            if(!$request->dienmocoi_cha)
            {
                $LyLich->hotencha = $request->hotencha;
                if($request->ngaysinhcha)
                {
                    $LyLich->ngaysinhcha = date('Y-m-d', strtotime($request->ngaysinhcha));
                }
                else
                {
                    $LyLich->ngaysinhcha = null;
                }
                $LyLich->dienthoaicha = $request->dienthoaicha;
                $LyLich->dantoc_idcha = $request->dantoccha;
                $LyLich->nghenghiepcha = $request->nghenghiepcha;
                $LyLich->noilamvieccha = $request->noilamvieccha;
                $LyLich->xa_idcha = $request->xa_thuongtru_cha;
                $LyLich->hokhauthuongtrucha = $request->hokhauthuongtrucha;
            }
            else
            {
                $LyLich->hotencha = null;
                $LyLich->ngaysinhcha = null;
                $LyLich->dienthoaicha = null;
                $LyLich->dantoc_idcha = null;
                $LyLich->nghenghiepcha = null;
                $LyLich->noilamvieccha = null;
                $LyLich->xa_idcha = null;
                $LyLich->hokhauthuongtrucha = null;
            }
            
            if(!$request->dienmocoi_me)
            {
                $LyLich->hotenme = $request->hotenme;

                if($request->ngaysinhme)
                {
                    $LyLich->ngaysinhme = date('Y-m-d', strtotime($request->ngaysinhme));
                }
                else
                {
                    $LyLich->ngaysinhme = null;
                }

                $LyLich->dienthoaime = $request->dienthoaime;
                $LyLich->dantoc_idme = $request->dantocme;
                $LyLich->nghenghiepme = $request->nghenghiepme;
                $LyLich->noilamviecme = $request->noilamviecme;
                $LyLich->xa_idme = $request->xa_thuongtru_me;
                $LyLich->hokhauthuongtrume = $request->hokhauthuongtrume;
            }
            else
            {
                $LyLich->hotenme = null;

                $LyLich->ngaysinhme = null;

                $LyLich->dienthoaime = null;
                $LyLich->dantoc_idme = null;
                $LyLich->nghenghiepme = null;
                $LyLich->noilamviecme = null;
                $LyLich->xa_idme = null;
                $LyLich->hokhauthuongtrume = null;
            }
            $LyLich->save();
            $AnhChiEm = new AnhChiEm();
            if($request->anhchiem_inp_hoten)
            {
                for($i = 0; $i < count($request->anhchiem_inp_hoten); $i++) {
                    $AnhChiEm = new AnhChiEm();
                    $AnhChiEm->lylich_id = $LyLich->id;
                    $AnhChiEm->moiquanhe_id = $request->anhchiem_sel_moiquanhe[$i];
                    $AnhChiEm->hoten = $request->anhchiem_inp_hoten[$i];
                    $AnhChiEm->namsinh = date('Y-m-d', strtotime($request->anhchiem_dat_namsinh[$i]));
                    $AnhChiEm->nghenghiep = $request->anhchiem_inp_nghenghiep[$i];
                    $AnhChiEm->noio = $request->anhchiem_inp_noio[$i];
                    $AnhChiEm->save();
                }
            }

            // Upload picture profile
            if($request->hasFile('picprofile'))
            {
                $filename = 'picprofile_'.$LyLich->id;
                $img = $request->file('picprofile');
                $ext = $img->getClientOriginalExtension();
                try {
                    SinhVienController::UploadPicture($img, $filename);
                    // SinhVienController::UploadPicture($request->file('picprofile'), $filename);
                    $LyLich->picture = env('PIC_PATH') . $filename.'.'.$ext;
                    $LyLich->save();    
                } catch (Exception $e) {
                    
                }
                
            }
            else
            {
                try {
                    if($LyLich_Old && $LyLich_Old->picture)
                    {
                        $oldfile = $LyLich_Old->picture;
                        $oldfile_ext = substr($oldfile, strrpos($oldfile, '.')+1);

                        $newfile = env('PIC_PATH') . 'picprofile_' . $LyLich->id .'.'.$oldfile_ext;

                        if(SinhVienController::CopyPicture($oldfile, $newfile))
                        {
                            $LyLich->picture = $newfile;
                            $LyLich->save();    
                        }
                    }
                } catch (Exception $e) {
                    
                }
            }

            // Tính điểm đang ký nội trú, ngoại trú
            $tieuChiModuleThoiGian = self::ModuleTinhDiemNoiTruNgoaiTru();
            if($tieuChiModuleThoiGian)
            {
                $dateNow = date('Y-m-d');
                if($dateNow >= $tieuChiModuleThoiGian->thoigianbatdau && $dateNow <= $tieuChiModuleThoiGian->thoigianketthuc)
                {
                    $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
                    $bangDiemModuleNoiTruNgoaiTru = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHocHienHanh)
                        ->where('sinhvien_id', '=', $sinhvien_id)
                        ->where('tieuchi_id', '=', $tieuChiModuleThoiGian->tieuchi_id)
                        ->first();
                    $tieuChi = TieuChi::find($tieuChiModuleThoiGian->tieuchi_id);
                    if(!$bangDiemModuleNoiTruNgoaiTru)
                    {
                        if($tieuChi)
                            $bangDiemModuleNoiTruNgoaiTru = BangDiemRenLuyen::create(array('hocky_namhoc_id'=>$idHocKyNamHocHienHanh, 'sinhvien_id'=>$sinhvien_id, 'tieuchi_id'=>$tieuChi->id, 'maxdiem'=>$tieuChi->diemtoida, 'diem'=>$tieuChi->diemmacdinh));
                    }

                    if($bangDiemModuleNoiTruNgoaiTru)
                        if($bangDiemModuleNoiTruNgoaiTru->diem < $bangDiemModuleNoiTruNgoaiTru->maxdiem)
                        {
                            $bangDiemModuleNoiTruNgoaiTru->diem += $bangDiemModuleNoiTruNgoaiTru->maxdiem;
                            $bangDiemModuleNoiTruNgoaiTru->save();
                            ServiceTieuChiMinhChungController::UpdateDiemTieuChiCha($tieuChi, $idHocKyNamHocHienHanh, $sinhvien_id);
                        }
                }
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function updateLyLich($request)
    {
        try {
            $sinhvien_id = Auth::user()->cbgvsv_id;

            $LyLich = LyLich::where('sinhvien_id', '=', $sinhvien_id)->orderBy('id', 'desc')->first();
            $LyLich->sinhvien_id = $sinhvien_id;
            $LyLich->dienthoai = $request->dienthoai;
            $LyLich->email = $request->email;
            $LyLich->noisinh = $request->noisinh;
            $LyLich->ngaycapcmnd = date('Y-m-d', strtotime($request->ngaycapcmnd));
            $LyLich->noicapcmnd = $request->noicapcmnd;
            $LyLich->xa_id = $request->xa;
            $LyLich->hokhauthuongtru = $request->hokhauthuongtru;
            $LyLich->tamtru_xa_id = $request->xa_tamtru;
            $LyLich->diachitamtru = $request->diachitamtru;
            $LyLich->dantoc_id = $request->dantoc;
            $LyLich->tongiao_id = $request->tongiao;

            if($request->ngayvaodoan)
                $LyLich->ngayvaodoantncshcm = date('Y-m-d', strtotime($request->ngayvaodoan));
            else
                $LyLich->ngayvaodoantncshcm = null;

            $LyLich->noivaodoantncshcm = $request->noivaodoan;

            if($request->ngayvaodang)
                $LyLich->ngayvaodangcsvn = date('Y-m-d', strtotime($request->ngayvaodang));
            else
                $LyLich->ngayvaodangcsvn = null;

            $LyLich->noivaodangcsvn = $request->noivaodang;
            $LyLich->hongheo = $request->dienngheocanngheo_ngheo;
            $LyLich->hocanngheo = $request->dienngheocanngheo_canngheo;
            $LyLich->mocoicha = $request->dienmocoi_cha;
            $LyLich->mocoime = $request->dienmocoi_me;
            $LyLich->conthuongbinh = $request->conthuongbinhlietsy_thuongbinh;
            $LyLich->conlietsy = $request->conthuongbinhlietsy_lietsy;
            $LyLich->tantat = $request->tantat;
            
            if(!$request->dienmocoi_cha)
            {
                $LyLich->hotencha = $request->hotencha;
                if($request->ngaysinhcha)
                {
                    $LyLich->ngaysinhcha = date('Y-m-d', strtotime($request->ngaysinhcha));
                }
                else
                {
                    $LyLich->ngaysinhcha = null;
                }
                $LyLich->dienthoaicha = $request->dienthoaicha;
                $LyLich->dantoc_idcha = $request->dantoccha;
                $LyLich->nghenghiepcha = $request->nghenghiepcha;
                $LyLich->noilamvieccha = $request->noilamvieccha;
                $LyLich->xa_idcha = $request->xa_thuongtru_cha;
                $LyLich->hokhauthuongtrucha = $request->hokhauthuongtrucha;
            }
            else
            {
                $LyLich->hotencha = null;
                $LyLich->ngaysinhcha = null;
                $LyLich->dienthoaicha = null;
                $LyLich->dantoc_idcha = null;
                $LyLich->nghenghiepcha = null;
                $LyLich->noilamvieccha = null;
                $LyLich->xa_idcha = null;
                $LyLich->hokhauthuongtrucha = null;
            }
            
            if(!$request->dienmocoi_me)
            {
                $LyLich->hotenme = $request->hotenme;

                if($request->ngaysinhme)
                {
                    $LyLich->ngaysinhme = date('Y-m-d', strtotime($request->ngaysinhme));
                }
                else
                {
                    $LyLich->ngaysinhme = null;
                }

                $LyLich->dienthoaime = $request->dienthoaime;
                $LyLich->dantoc_idme = $request->dantocme;
                $LyLich->nghenghiepme = $request->nghenghiepme;
                $LyLich->noilamviecme = $request->noilamviecme;
                $LyLich->xa_idme = $request->xa_thuongtru_me;
                $LyLich->hokhauthuongtrume = $request->hokhauthuongtrume;
            }
            else
            {
                $LyLich->hotenme = null;

                $LyLich->ngaysinhme = null;

                $LyLich->dienthoaime = null;
                $LyLich->dantoc_idme = null;
                $LyLich->nghenghiepme = null;
                $LyLich->noilamviecme = null;
                $LyLich->xa_idme = null;
                $LyLich->hokhauthuongtrume = null;
            }

            $LyLich->save();

            // Xóa danh sách anh chi em cũ
            SinhVienController::deleteSiblling($LyLich->id);

            // Thêm mới Anh, chị, em.
            if($request->anhchiem_inp_hoten)
            {
                $AnhChiEm = new AnhChiEm();
                for($i = 0; $i < count($request->anhchiem_inp_hoten); $i++) {
                    $AnhChiEm = new AnhChiEm();
                    
                    $AnhChiEm->lylich_id = $LyLich->id;
                    $AnhChiEm->moiquanhe_id = $request->anhchiem_sel_moiquanhe[$i];
                    $AnhChiEm->hoten = $request->anhchiem_inp_hoten[$i];
                    $AnhChiEm->namsinh = date('Y-m-d', strtotime($request->anhchiem_dat_namsinh[$i]));
                    $AnhChiEm->nghenghiep = $request->anhchiem_inp_nghenghiep[$i];
                    $AnhChiEm->noio = $request->anhchiem_inp_noio[$i];

                    $AnhChiEm->save();
                }
            }

            // Upload picture profile
            if($request->hasFile('picprofile'))
            {
                $filename = 'picprofile_'.$LyLich->id;
                $ext = $request->file('picprofile')->getClientOriginalExtension();
                try {
                    SinhVienController::UploadPicture($request->file('picprofile'), $filename);
                    $LyLich->picture = env('PIC_PATH') . $filename.'.'.$ext;
                    $LyLich->save();    
                } catch (Exception $e) {
                    
                }
                
            }

            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    public static function deleteSiblling($lylich_id)
    {
        if(Auth::check())
        {
            try {
                $DanhSach_AnhChiEm = AnhChiEm::where('lylich_id', '=', $lylich_id)->get();
                if($DanhSach_AnhChiEm)
                {
                    AnhChiEm::where('lylich_id', '=', $lylich_id)->delete();
                    return true;
                }
                else
                {
                    return true;
                }
            } catch (Exception $e) {
                return false;
            }
        }
        else
            return false;
    }

    /**
     * Get action.
     *
     * @param  null
     * @return value: 0: Không thực hiện gì cả, 1: Thêm mới, 2, Cập nhật.
     */
    public static function getAction()
    {
        if(Auth::check())
        {
            $sinhvien_id = Auth::user()->cbgvsv_id;

            if(self::DangKyNoiTruNgoaiTru($sinhvien_id))
                return '1';
            
            $minDate = date('Y-m-d', strtotime(now(). ' - 90 days')); // 90 ngày
            $LyLich = LyLich::where('sinhvien_id', '=', $sinhvien_id)->orderBy('id', 'desc')->first();
            $LyLichs = LyLich::where('sinhvien_id', '=', $sinhvien_id)->get();

            if(empty($LyLich) || count($LyLichs) <= 1)
            {
                return '1';
            }
            else
            {
                if(date("Y-m-d",strtotime($LyLich->created_at)) < $minDate)
                {
                    return '1';
                }
                else
                {
                    return '2';
                }
            }
        }
        return '0';
    }

    public static function daDangKyNoiTruNgoaiTru($idHocKyNamHoc, $idTieuChi, $idSinhVien)
    {
        $idModule = 2; // Module đăng ký nội trú, ngoại trú
        $tieuChiModuleThoiGian = TieuChiModuleThoiGian::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('module_id', '=', $idModule)->first();
        if($tieuChiModuleThoiGian)
        {
            $lyLichTrongThoiGianQuyDinh = LyLich::where('sinhvien_id', '=', $idSinhVien)->where('created_at', '>=', $tieuChiModuleThoiGian->thoigianbatdau)->where('created_at', '<=', $tieuChiModuleThoiGian->thoigianketthuc)->first();
            if($lyLichTrongThoiGianQuyDinh)
                return true;

            $bangDiemModuleNoiTruNgoaiTru = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
                ->where('sinhvien_id', '=', $idSinhVien)
                ->where('tieuchi_id', '=', $idTieuChi)
                ->first();
            if($bangDiemModuleNoiTruNgoaiTru)
                if($bangDiemModuleNoiTruNgoaiTru->diem >= $bangDiemModuleNoiTruNgoaiTru->maxdiem)
                    return true;
        }
        else
            return true;
        return false;
    }

    public static function DangKyNoiTruNgoaiTru($idSinhVien)
    {
        $tieuChiModuleThoiGian = self::ModuleTinhDiemNoiTruNgoaiTru();
        if($tieuChiModuleThoiGian)
        {
            $lyLichTrongThoiGianQuyDinh = LyLich::where('sinhvien_id', '=', $idSinhVien)->where('created_at', '>=', $tieuChiModuleThoiGian->thoigianbatdau)->where('created_at', '<=', $tieuChiModuleThoiGian->thoigianketthuc)->first();
                if(!$lyLichTrongThoiGianQuyDinh)
                    return true;
        }
        return false;
    }

    public static function ModuleTinhDiemNoiTruNgoaiTru()
    {
        $idModule = 2; // Module đăng ký nội trú, ngoại trú
        $idHocKyNamHocHienHanh = HocKyNamHocController::getIDHocKyNamHocHienHanh();
        $tieuChiModuleThoiGian = TieuChiModuleThoiGian::where('hockynamhoc_id', '=', $idHocKyNamHocHienHanh)->where('module_id', '=', $idModule)->first();
        return $tieuChiModuleThoiGian;
    }

    public static function CoModuleTinhDiemNoiTruNgoaiTru()
    {
        $tieuChiModuleThoiGian = self::ModuleTinhDiemNoiTruNgoaiTru();
        return $tieuChiModuleThoiGian ? true : false;
    }

    /*
    * ------ Upload picture to images/upload/profile -----*
    */
    public static function UploadPicture($img, $filename)
    {
        if(!is_null($img))
        {
            $ext = $img->getClientOriginalExtension();
            $img->move(env('PIC_PATH'), $filename.'.'.$ext);
        }
    }

    /*
    * ------ Upload picture to env('PIC_PATH_CARD') => storage/images/upload/cardpic/ -----*
    */
    public static function UploadCardPicture($img, $strPath, $fullfilename)
    {
        if(!is_null($img))
            $img->move($strPath, $fullfilename);
            // $img->move(env('PIC_PATH_CARD'), $fullfilename);
    }

    /*
    * ------ Copy picture to images/upload/profile -----*
    */
    public static function CopyPicture($oldfile, $newfile)
    {
        if (copy($oldfile, $newfile))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /*
    * ------ Delete path file -----*
    */
    public static function DeleteFile($file)
    {
        $path = $file;
        if(File::isFile($path)){
            File::delete($path);
        }
    }

    public function getStudentList()
    {
        if(Auth::check())
        {
            $DanhSach_SinhVien = SinhVien::all();
            return view('subadmin.sinhvien', ['DanhSach_SinhVien'=>$DanhSach_SinhVien]);
        }
        else
            return redirect()->route('home');
    }

    public function getStudentProfile($id)
    {
        if(Auth::check())
        {
            $LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'desc')->first();
            $SV = SinhVien::find($id);
            if ($LyLich)
                $DanhSach_AnhChiEm = $LyLich->anhchiem;
            else
                $DanhSach_AnhChiEm = AnhChiEm::where('id', '=', 0)->get();
            
            $DanhSach_DanToc = DanToc::all();
            $DanhSach_TonGiao = TonGiao::all();
            $DanhSach_Tinh = Tinh::all()->sortBy('tentinh');
            $DanhSach_Huyen;// = Huyen::all()->sortBy('tenhuyen');
            $DanhSach_Xa;// = Xa::all()->sortBy('tenxa');
            $DanhSach_MoiQuanHe = MoiQuanHe::all();
            return view('subadmin.profile_view', ['SV'=>$SV, 'LyLich'=>$LyLich, 'DanhSach_AnhChiEm'=>$DanhSach_AnhChiEm, 'DanhSach_DanToc'=>$DanhSach_DanToc, 'DanhSach_TonGiao'=>$DanhSach_TonGiao, 'DanhSach_Tinh'=>$DanhSach_Tinh, 'DanhSach_MoiQuanHe'=>$DanhSach_MoiQuanHe]);
        }
    }

    public function getStudentProfile_TruongDonVi($id)
    {
        if(Auth::check())
        {

            $LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'desc')->first();
            $SV = SinhVien::find($id);
            if ($LyLich)
                $DanhSach_AnhChiEm = $LyLich->anhchiem;
            else
                $DanhSach_AnhChiEm = AnhChiEm::where('id', '=', 0)->get();
            $DanhSach_DanToc = DanToc::all();
            $DanhSach_TonGiao = TonGiao::all();
            $DanhSach_Tinh = Tinh::all()->sortBy('tentinh');
            $DanhSach_Huyen;// = Huyen::all()->sortBy('tenhuyen');
            $DanhSach_Xa;// = Xa::all()->sortBy('tenxa');
            $DanhSach_MoiQuanHe = MoiQuanHe::all();
            return view('truongdonvi.profile_view', ['SV'=>$SV, 'LyLich'=>$LyLich, 'DanhSach_AnhChiEm'=>$DanhSach_AnhChiEm, 'DanhSach_DanToc'=>$DanhSach_DanToc, 'DanhSach_TonGiao'=>$DanhSach_TonGiao, 'DanhSach_Tinh'=>$DanhSach_Tinh, 'DanhSach_MoiQuanHe'=>$DanhSach_MoiQuanHe]);
        }
    }

    public function getStudentProfilePic($id)
    {
        if(Auth::check())
        {
            $DanhSach_LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'desc')->get();
            $LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'desc')->first();
            $SV = SinhVien::find($id);
            if ($LyLich)
                $DanhSach_AnhChiEm = $LyLich->anhchiem;
            else
                $DanhSach_AnhChiEm = AnhChiEm::where('id', '=', 0)->get();
            $DanhSach_DanToc = DanToc::all();
            $DanhSach_TonGiao = TonGiao::all();
            $DanhSach_Tinh = Tinh::all()->sortBy('tentinh');
            $DanhSach_Huyen;// = Huyen::all()->sortBy('tenhuyen');
            $DanhSach_Xa;// = Xa::all()->sortBy('tenxa');
            $DanhSach_MoiQuanHe = MoiQuanHe::all();
            return view('subadmin.profile', ['SV'=>$SV, 'DanhSach_LyLich'=>$DanhSach_LyLich, 'LyLich'=>$LyLich, 'DanhSach_AnhChiEm'=>$DanhSach_AnhChiEm, 'DanhSach_DanToc'=>$DanhSach_DanToc, 'DanhSach_TonGiao'=>$DanhSach_TonGiao, 'DanhSach_Tinh'=>$DanhSach_Tinh, 'DanhSach_MoiQuanHe'=>$DanhSach_MoiQuanHe]);
        }
    }

    public function AdminStudentProfilePic($id)
    {
        if(Auth::check())
        {
            $DanhSach_LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'desc')->get();
            $LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'desc')->first();
            $SV = SinhVien::find($id);
            if ($LyLich)
                $DanhSach_AnhChiEm = $LyLich->anhchiem;
            else
                $DanhSach_AnhChiEm = AnhChiEm::where('id', '=', 0)->get();
            $DanhSach_DanToc = DanToc::all();
            $DanhSach_TonGiao = TonGiao::all();
            $DanhSach_Tinh = Tinh::all()->sortBy('tentinh');
            $DanhSach_Huyen;// = Huyen::all()->sortBy('tenhuyen');
            $DanhSach_Xa;// = Xa::all()->sortBy('tenxa');
            $DanhSach_MoiQuanHe = MoiQuanHe::all();
            return view('admin.hinhthe_profile', ['SV'=>$SV, 'DanhSach_LyLich'=>$DanhSach_LyLich, 'LyLich'=>$LyLich, 'DanhSach_AnhChiEm'=>$DanhSach_AnhChiEm, 'DanhSach_DanToc'=>$DanhSach_DanToc, 'DanhSach_TonGiao'=>$DanhSach_TonGiao, 'DanhSach_Tinh'=>$DanhSach_Tinh, 'DanhSach_MoiQuanHe'=>$DanhSach_MoiQuanHe]);
        }
    }

    public function postPicforStudentCard(Request $request)
    {
        if(Auth::check() && UserController::isGroupNoneId(env('GROUP_CHUYENVIEN')) )
        {
            $request->validate([
                'picprofile' => 'image',
            ]);

            $SV = SinhVien::find($request->sinhvien_id);

            // Upload card picture
            if($request->hasFile('picprofile'))
            {
                $filename = $SV->mssv;

                $img = $request->file('picprofile');
                $ext = $img->getClientOriginalExtension();
                $fullfilename = $filename.'.'.$ext;
                try {
                    SinhVienController::DeleteFile($SV->hinhthe);
                    SinhVienController::UploadCardPicture($img, $fullfilename);
                    $SV->hinhthe = env('PIC_PATH_CARD') . $fullfilename;
                    $SV->save();    
                } catch (Exception $e) {
                    
                }
                return redirect()->route('studentprofilepic', ['id'=>$SV->id])->with('success', 'Cập nhật hình thành công!');
            }

            return redirect()->route('studentprofilepic', ['id'=>$SV->id]);

        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function AdminPostPicforStudentCard(Request $request)
    {
        if(Auth::check() && (UserController::isGroupNoneId(env('GROUP_CHUYENVIENHETHONG')) || UserController::isGroupNoneId(env('GROUP_QUANTRIHETHONG')) ))
        {
            $request->validate([
                'picprofile' => 'image',
            ]);

            $SV = SinhVien::find($request->sinhvien_id);

            // Upload card picture
            if($SV)
            {
                if($request->hasFile('picprofile'))
                {
                    $filename = $SV->mssv;
                    $img = $request->file('picprofile');
                    $ext = $img->getClientOriginalExtension();
                    if($ext)
                        $fullfilename = $filename.'.'.$ext;
                    else
                        $fullfilename = $filename.'.jpg';

                    try {
                        $strPath = env('PIC_PATH_CARD') . "lop_" . $SV->lop_id . "/";
                        SinhVienController::DeleteFile($SV->hinhthe);
                        SinhVienController::UploadCardPicture($img, $strPath, $fullfilename);
                        $SV->hinhthe = $strPath . $fullfilename;
                        // $SV->hinhthe = env('PIC_PATH_CARD') . $fullfilename;
                        $SV->save();    
                    } catch (Exception $e) {
                        
                    }
                    return redirect()->route('adminstudentprofilepic', ['id'=>$SV->id])->with('success', 'Cập nhật hình thành công!');
                }
                else
                    return redirect()->route('adminstudentprofilepic', ['id'=>$SV->id])->with('warning', 'Không có file hình!');
            }
            return redirect()->route('adminstudentprofilepic', ['id'=>$SV->id])->with('warning', 'Không tìm thấy thông tin!');
        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function AdminPostPicforStudentCardCopy(Request $request)
    {
        array('result'=>true, 'message'=>"Cập nhật hình thành công!");
        
        if(Auth::check() && (UserController::isGroupNoneId(env('GROUP_CHUYENVIENHETHONG')) || UserController::isGroupNoneId(env('GROUP_QUANTRIHETHONG'))))
        {
            $SV = SinhVien::find($request->idsinhvien);
            // Copy card picture
            if($SV)
            {
                if($request->picpath)
                {
                    $filename = $SV->mssv;
                    // $img = $request->file('picprofile');
                    // $ext = $img->getClientOriginalExtension();
                    // if($ext)
                    //     $fullfilename = $filename.'.'.$ext;
                    // else
                    //     $fullfilename = $filename.'.jpg';

                    $fileSource = $request->picpath;
                    $fileSource_ext = substr($fileSource, strrpos($fileSource, '.')+1);

                    if($fileSource_ext)
                        $fullfilename = $filename.'.'.$fileSource_ext;
                    else
                        $fullfilename = $filename.'.jpg';
                    // return $fullfilename;
                    
                    try {
                        $strPath = env('PIC_PATH_CARD') . "lop_" . $SV->lop_id . "/";
                        self::DeleteFile($SV->hinhthe);
                        self::CopyPicture($fileSource, $strPath.$fullfilename);
                        $SV->hinhthe = $strPath . $fullfilename;
                        $SV->save();    
                    } catch (Exception $e) {
                        return array('result'=>false, 'message'=>e.getMessage());
                    }
                    return array('result'=>true, 'message'=>"Cập nhật hình thành công!");
                }
                else
                    return array('result'=>false, 'message'=>"Không có file hình!");
            }
            return array('result'=>false, 'message'=>"Không tìm thấy thông tin!");
        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function getPrintProfile()
    {
        if(Auth::check())
        {
            $CBGVSV_ID = Auth::user()->cbgvsv_id;

            $LyLich = LyLich::where('sinhvien_id', '=', $CBGVSV_ID)->orderBy('id', 'desc')->first();
            $SV = SinhVien::find($CBGVSV_ID);
            $DanhSach_AnhChiEm = $LyLich->anhchiem;

            $pdf = PDF::loadView('sinhvien.print_profile', ['SV'=>$SV, 'LyLich'=>$LyLich, 'DanhSach_AnhChiEm'=>$DanhSach_AnhChiEm], [], [
                'mode'              => 'utf-8',
                'format'           => 'A4',
                'author'           => 'Hoang Anh',
                'display_mode'     => 'fullpage',
                'margin_left'       => '2.0',
                'margin_right'      => '2.0',
                'margin_top'        => '5.0',
                'margin_bottom'     => '3.0'
            ]);
            return $pdf->download('LyLich_' . $SV->mssv .'.pdf');
        }
        else
        {
            return redirect()->route('home');
        }

    }

    public function getUpdatedStudentProfile()
    {
        if(Auth::check() && UserController::isGroupNoneId(env('GROUP_TRUONGDONVI')))
        {
            // $DanhSach_SinhVien = SinhVien::all();
            $CD_DaCapNhat = DB::table('sinhvien')
                -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> where('nganh.idbacdaotao', '=', 1) // 1: Cao đẳng; 2: Đại học
                -> join('lylich', 'lylich.sinhvien_id', '=', 'sinhvien.id')
                -> select('sinhvien.id')
                -> groupBy('sinhvien.id')
                -> get();

            $CD = DB::table('sinhvien')
                -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> where('nganh.idbacdaotao', '=', 1) // 1: Cao đẳng; 2: Đại học
                -> select('sinhvien.id')
                -> groupBy('sinhvien.id')
                -> get();

            $DH_DaCapNhat = DB::table('sinhvien')
                -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> where('nganh.idbacdaotao', '=', 2) // 1: Cao đẳng; 2: Đại học
                -> join('lylich', 'lylich.sinhvien_id', '=', 'sinhvien.id')
                -> select('sinhvien.id')
                -> groupBy('sinhvien.id')
                -> get();

            $DH = DB::table('sinhvien')
                -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> where('nganh.idbacdaotao', '=', 2) // 1: Cao đẳng; 2: Đại học
                -> select('sinhvien.id')
                -> groupBy('sinhvien.id')
                -> get();

            $DanhSach_Khoa = Khoa::all();

            return view('subadmin.capnhatlylichdaunam', ['CD'=>count($CD), 'CD_DaCapNhat'=>count($CD_DaCapNhat), 'DH'=>count($DH), 'DH_DaCapNhat'=>count($DH_DaCapNhat), 'DanhSach_Khoa'=>$DanhSach_Khoa]);//, ['DanhSach_SinhVien'=>$DanhSach_SinhVien]);
        }
        else
            return redirect()->route('home');
    }

    public function getUpdatedStudentProfile_TruongDonVi()
    {
        if(Auth::check() && UserController::isGroupNoneId(env('GROUP_TRUONGDONVI')))
        {
            // $DanhSach_SinhVien = SinhVien::all();
            $CD_DaCapNhat = DB::table('sinhvien')
                -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> where('nganh.idbacdaotao', '=', 1) // 1: Cao đẳng; 2: Đại học
                -> join('lylich', 'lylich.sinhvien_id', '=', 'sinhvien.id')
                -> select('sinhvien.id')
                -> groupBy('sinhvien.id')
                -> get();

            $CD = DB::table('sinhvien')
                -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> where('nganh.idbacdaotao', '=', 1) // 1: Cao đẳng; 2: Đại học
                -> select('sinhvien.id')
                -> groupBy('sinhvien.id')
                -> get();

            $DH_DaCapNhat = DB::table('sinhvien')
                -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> where('nganh.idbacdaotao', '=', 2) // 1: Cao đẳng; 2: Đại học
                -> join('lylich', 'lylich.sinhvien_id', '=', 'sinhvien.id')
                -> select('sinhvien.id')
                -> groupBy('sinhvien.id')
                -> get();

            $DH = DB::table('sinhvien')
                -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> where('nganh.idbacdaotao', '=', 2) // 1: Cao đẳng; 2: Đại học
                -> select('sinhvien.id')
                -> groupBy('sinhvien.id')
                -> get();

            $DanhSach_Khoa = Khoa::all();

            return view('truongdonvi.capnhatlylichdaunam', ['CD'=>count($CD), 'CD_DaCapNhat'=>count($CD_DaCapNhat), 'DH'=>count($DH), 'DH_DaCapNhat'=>count($DH_DaCapNhat), 'DanhSach_Khoa'=>$DanhSach_Khoa]);//, ['DanhSach_SinhVien'=>$DanhSach_SinhVien]);
        }
        else
            return redirect()->route('home');
    }

    public function getUpdatedStudentProfileFalcuty($khoa_id)
    {
        if(Auth::check() && UserController::isGroupNoneId(env('GROUP_TRUONGDONVI')))
        {
            $DanhSach_SinhVien = SinhVien::join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
                -> where('bomon.idkhoa', '=', $khoa_id)
                -> select('sinhvien.*')
                -> get();
            $Khoa = Khoa::find($khoa_id);
            return view('subadmin.capnhatlylichdaunamkhoa', ['Khoa'=>$Khoa, 'DanhSach_SinhVien'=>$DanhSach_SinhVien]);
        }
        else
            return redirect()->route('home');
    }

    public function getUpdatedStudentProfileFalcuty_TruongDonVi($khoa_id)
    {
        if(Auth::check() && UserController::isGroupNoneId(env('GROUP_TRUONGDONVI')))
        {
            $DanhSach_SinhVien = SinhVien::join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
                -> where('bomon.idkhoa', '=', $khoa_id)
                -> select('sinhvien.*')
                -> get();
            $Khoa = Khoa::find($khoa_id);

            return view('truongdonvi.capnhatlylichdaunamkhoa', ['Khoa'=>$Khoa, 'DanhSach_SinhVien'=>$DanhSach_SinhVien]);
        }
        else
            return redirect()->route('home');
    }

    public function getSinhVien($mssv)
    {
        if(!empty($mssv))
        {
            $DanhSach_SinhVien = SinhVien::where('mssv', 'like', '%'.$mssv.'%')
                -> leftjoin('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> leftjoin('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> leftjoin('bomon', 'bomon.id', '=', 'nganh.idbomon')
                -> leftjoin('khoa', 'khoa.id', '=', 'bomon.idkhoa')
                -> leftjoin('lylich', 'lylich.sinhvien_id', '=', 'sinhvien.id')
                -> select('sinhvien.id', 'sinhvien.mssv', 'sinhvien.hochulot', 'sinhvien.ten', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa', 'lylich.sinhvien_id')
                -> groupBy('sinhvien.id')
                ->get()->toArray();

            return array('status' => true, 'Data' => $DanhSach_SinhVien);
        }
        else
        {
            return array('status' => false, 'message' => 'Không tìm thấy!');
        }
    }

    public static function GetSinhVienByID($idSinhVien = '')
    {
        return SinhVien::find($idSinhVien);
    }

    public function getSearchSinhVien($value, $type)
    {
        if(!empty($value))
        {
            switch ($type) {
                case '1':
                    $DanhSach_SinhVien = SinhVien::where('mssv', 'like', '%'.$value.'%')
                        -> leftjoin('lop', 'lop.id', '=', 'sinhvien.lop_id')
                        -> leftjoin('nganh', 'nganh.id', '=', 'lop.nganh_id')
                        -> leftjoin('bomon', 'bomon.id', '=', 'nganh.idbomon')
                        -> leftjoin('khoa', 'khoa.id', '=', 'bomon.idkhoa')
                        -> leftjoin('lylich', 'lylich.sinhvien_id', '=', 'sinhvien.id')
                        -> select('sinhvien.id', 'sinhvien.mssv', 'sinhvien.hochulot', 'sinhvien.ten', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa', 'lylich.sinhvien_id')
                        -> groupBy('sinhvien.id')
                        -> get()->toArray();

                    return array('status' => true, 'Data' => $DanhSach_SinhVien);

                    break;

                case '2':
                    $DanhSach_SinhVien = SinhVien::where('cmnd', 'like', '%'.$value.'%')
                        -> leftjoin('lop', 'lop.id', '=', 'sinhvien.lop_id')
                        -> leftjoin('nganh', 'nganh.id', '=', 'lop.nganh_id')
                        -> leftjoin('bomon', 'bomon.id', '=', 'nganh.idbomon')
                        -> leftjoin('khoa', 'khoa.id', '=', 'bomon.idkhoa')
                        -> leftjoin('lylich', 'lylich.sinhvien_id', '=', 'sinhvien.id')
                        -> select('sinhvien.id', 'sinhvien.mssv', 'sinhvien.hochulot', 'sinhvien.ten', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa', 'lylich.sinhvien_id')
                        -> groupBy('sinhvien.id')
                        -> get()->toArray();

                    return array('status' => true, 'Data' => $DanhSach_SinhVien);

                    break;

                // case '3':
                //     $DanhSach_SinhVien = SinhVien::where('hochulot', 'like', '%'.$value.'%')
                //         -> leftjoin('lop', 'lop.id', '=', 'sinhvien.lop_id')
                //         -> leftjoin('nganh', 'nganh.id', '=', 'lop.nganh_id')
                //         -> leftjoin('bomon', 'bomon.id', '=', 'nganh.idbomon')
                //         -> leftjoin('khoa', 'khoa.id', '=', 'bomon.idkhoa')
                //         -> leftjoin('lylich', 'lylich.sinhvien_id', '=', 'sinhvien.id')
                //         -> select('sinhvien.id', 'sinhvien.mssv', 'sinhvien.hochulot', 'sinhvien.ten', 'lop.tenlop', 'nganh.tennganh', 'khoa.tenkhoa', 'lylich.sinhvien_id')
                //         -> groupBy('sinhvien.id')
                //         -> get()->toArray();

                //     return array('status' => true, 'Data' => $DanhSach_SinhVien);

                //     break;

                
                default:
                    return array('status' => false, 'message' => 'Không tìm thấy!');

                    break;
            }
            
        }
        else
        {
            return array('status' => false, 'message' => 'Không tìm thấy!');
        }
    }

    public function getExportSinhVien()
    {
        $fileName = 'DanhSach_SinhVien';
        $ext = 'xls';
        $sheetName = $fileName;

        Excel::create($fileName, function($excel) use ($sheetName) {

            $excel->sheet($sheetName, function($sheet) {
                // Set freeze
                // $sheet->setFreeze('A6');
                // Set Orentation with ->setOrientation()
                $sheet->setOrientation('landscape');

                // Set font with ->setStyle()`
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Times New Roman',
                        'size'      =>  11
                    )
                ));

                // Set width for a single column
                $sheet->setWidth('A', 5);
                $sheet->setWidth('B', 11);
                $sheet->setWidth('C', 20);
                $sheet->setWidth('D', 7);
                $sheet->setWidth('E', 7);
                $sheet->setWidth('F', 10);
                $sheet->setWidth('G', 10);
                $sheet->setWidth('H', 27);
                $sheet->setWidth('I', 33);
                $sheet->setWidth('J', 13);


                $row = 1;
                $STT = 0;

                // Set Title
                // STT
                $sheet->cell('A' . $row, 'STT');

                // MSSV
                $sheet->cell('B' . $row, 'MSSV');

                // Họ chữ lót
                $sheet->cell('C' . $row, 'Họ chữ lót');
                
                // Tên
                $sheet->cell('D' . $row, 'Tên');

                // Giới tính
                $sheet->cell('E' . $row, 'Giới tính');

                // Ngày sinh
                $sheet->cell('F' . $row, 'Ngày sinh');

                // Lớp
                $sheet->cell('G' . $row, 'Lớp');

                // Ngành
                $sheet->cell('H' . $row, 'Ngành');

                // Khoa
                $sheet->cell('I' . $row, 'Khoa');

                // File hình
                $sheet->cell('J' . $row, 'File hình');

                // CMND
                $sheet->cell('K' . $row, 'CMND');

                // Ngày cấp CMND
                $sheet->cell('L' . $row, 'Ngày cấp');

                // Nơi cấp CMND
                $sheet->cell('M' . $row, 'Nơi cấp');

                // Địa chỉ
                $sheet->cell('N' . $row, 'Địa chỉ');

                // Điện thoại
                $sheet->cell('O' . $row, 'Điện thoại');

                // Email
                $sheet->cell('P' . $row, 'Email');


                // $row++;
                

                $DanhSach_SinhVien = SinhVien::all();
                foreach ($DanhSach_SinhVien as $SV) {
                    $row++;
                    $STT++;
                    // STT
                    $sheet->cell('A' . $row, function($cell) use($STT) {
                        // Set alignment to center
                        $cell->setAlignment('center');
                        // Set vertical alignment to middle
                        // $cell->setValignment('center');
                        // Set font weight to bold
                        // $cell->setFontWeight('bold');

                        // manipulate the cell
                        $cell->setValue($STT);
                    });

                    // MSSV
                    $sheet->cell('B' . $row, function($cell) use ($SV) {
                        // Set alignment to center
                        $cell->setAlignment('center');
                        // Set vertical alignment to middle
                        // $cell->setValignment('center');
                        // Set font weight to bold
                        // $cell->setFontWeight('bold');

                        // manipulate the cell
                        $cell->setValue(trim($SV->mssv));
                    });

                    // HoChuLot
                    $sheet->cell('C' . $row, $SV->hochulot);

                    // Ten
                    $sheet->cell('D' . $row, $SV->ten);

                    // GioiTinh
                    $sheet->cell('E' . $row, $SV->gioitinh ? 'Nam' : 'Nữ');


                    // NgaySinh
                    $sheet->cell('F' . $row, date('d/m/Y', strtotime($SV->ngaysinh)));

                    // Lop
                    $sheet->cell('G' . $row, $SV->lop->tenlop);

                    // Nganh
                    $sheet->cell('H' . $row, $SV->lop->nganh->tennganh);

                    // Khoa
                    $sheet->cell('I' . $row, $SV->lop->nganh->bomon->khoa->tenkhoa);

                    $sheet->cell('J' . $row, function($cell) use ($SV){
                        // Set alignment to center
                        // $cell->setAlignment('center');
                        // $cell->getHyperlink();
                        if($SV->hinhthe)
                        {
                            $filename = substr($SV->hinhthe, -13);
                            $cell->setUrl('HinhThe/'.$filename);

                            // manipulate the cell
                            $cell->setValue($filename);
                        }
                        else
                        {
                            $cell->setValue('Chưa up hình');
                        }
                    });

                    // CMND
                    $sheet->cell('K' . $row, $SV->cmnd);

                    $LyLich = LyLich::where('sinhvien_id', '=', $SV->id)->orderBy('id', 'desc')->first();
                    if($LyLich)
                    {
                        // Ngày cấp CMND
                        $sheet->cell('L' . $row, date('d/m/Y', strtotime($LyLich->ngaycapcmnd)) );

                        // Nơi cấp CMND
                        $sheet->cell('M' . $row, $LyLich->noicapcmnd);

                        // Địa chỉ
                        if($LyLich->xa_id)
                        {
                            $Xa = Xa::find($LyLich->xa_id);

                            $sheet->cell('N' . $row, $LyLich->hokhauthuongtru . ', ' . $Xa->tenxa . ', ' . $Xa->huyen->tenhuyen . ', ' . $Xa->huyen->tinh->tentinh);
                        }
                        else
                        {
                            $sheet->cell('N' . $row, $LyLich->hokhauthuongtru);
                        }

                        // Điện thoại
                        $sheet->cell('O' . $row, $LyLich->dienthoai);

                        // Email
                        $sheet->cell('P' . $row, $SV->email_agu);
                    }
                }
            });

        })->export($ext);
    }

    public function getImportSinhVien(Request $request)
    {
        echo "Import Excel";
        
        // print_r($errors[0]);
        // echo $errors->first('email');
        // print($errorsfirst['email']);
        // Excel::load('C:\Users\lhanh\Desktop\InGBNH_CDNSV_D1.xlsx', function ($reader){
        //     // get title
        //     $workbookTitle = $reader->getTitle();
        //     echo "<br> " . $workbookTitle . " asdcfd";
        //      // Lấy số dòng
        //     $reader->takeRows(env('MAX_ROW'));
        //     // Lấy & giới hạn số cột
        //     $reader->takeColumns(env('MAX_COLUMN'));

        //     foreach ($reader->toArray() as $key => $value) {
        //         foreach ($value as $v) {        
        //             echo "<br>";
        //             echo $v['sbd'] . ' - ' . $v['nganh'];

        //         }
        //     }
        //     // print_r($reader[0]);
        // });
    }

    public static function ValidationSinhVienImport($reader)
    {
        // $Result = array('' => , );
        // foreach ($reader->toArray() as $key => $value) {
        //     foreach ($value as $v) {        
        //         // 1. Kiểm tra tính hợp lệ của mã số sinh viên.
                    
                    

        //         // 2. Kiểm tra mã số sinh viên (trùng).

        //         // 3. Kiểm tra tính hợp lệ của email.
                    // $Email = ???;
                    $validator = $this->validateEmail($Email);
                    if ($validator->fails())
                    {
                        $errors = $validator->errors()->toArray();
                        foreach ($errors as $key => $value) {
                            foreach ($value as $key => $message) {
                                echo "<br> " . $message;
                            }
                        }
                    }
        //         // 4. Kiểm tra email (trùng).
        //         echo "<br>";
        //         echo $v['sbd'] . ' - ' . $v['nganh'];

        //     }
        // }
    }

    public static function hasMSSVDuplicate($MSSV)
    {
        $SV = SinhVien::where('mssv', trim($MSSV))->first();
        if($SV)
            return true;
        return false;
    }

    public static function hasMSSVDuplicate_Update($id, $MSSV)
    {
        $SV = SinhVien::where('id', '<>', $id)->where('mssv', trim($MSSV))->first();
        if($SV)
            return true;
        return false;
    }

    public static function validateMSSV($MSSV)
    {
        if(strlen(trim($MSSV)) === 9)
            return true;
        return false;
    }

    public static function hasEmailDuplicate($Email)
    {
        $SV = SinhVien::where('email_agu', trim($Email))->first();
        if($SV)
            return true;
        return false;

    }

    public static function hasEmailDuplicate_Update($id, $Email)
    {
        $SV = SinhVien::where('id', '<>', $id)->where('email_agu', trim($Email))->first();
        if($SV)
            return true;
        return false;
    }

    public static function validateEmail($Email)
    {
        $arrayValue = array('email' => $Email);
        $rules = [
            'email' => 'required|email',
        ];
        $messages = [
            'email.required' => ' - Vui lòng nhập email',
            'email.email' => ' - Không đúng định dạng email',
        ];
        return Validator::make($arrayValue, $rules, $messages);
    }

    public static function hasCMNDDuplicate($Cmnd)
    {
        $SV = SinhVien::where('cmnd', trim($Cmnd))->first();
        if($SV)
            return true;
        return false;
    }

    public static function hasCMNDDuplicate_Update($id, $Cmnd)
    {
        $SV = SinhVien::where('id', '<>', $id)->where('cmnd', trim($Cmnd))->first();
        if($SV)
            return true;
        return false;

    }


    public function SearchStudent()
    {
        $DanhSach_Khoa = Khoa::all();
        return view('subadmin.searchstudent', ['DanhSach_Khoa'=>$DanhSach_Khoa]);
    }

    /*
     * Permission: Admin
     * Action: Update student information
     */

    public function getCapNhatThongTin($id)
    {
        if(Auth::check() && $this::isIDSinhVien($id))
        {
            if(UserController::isGroupNoneId((env('GROUP_QUANTRIHETHONG'))) || UserController::isGroupNoneId(env('GROUP_CHUYENVIENHETHONG')))
            {

                $LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'desc')->first();
                $SV = SinhVien::find($id);
                if($LyLich)
                {
                    $DanhSach_AnhChiEm = $LyLich->anhchiem;
                }
                else
                {
                    $DanhSach_AnhChiEm = AnhChiEm::where('id', '=', 0)->get();
                }

                $DanhSach_DanToc = DanToc::all();
                $DanhSach_TonGiao = TonGiao::all();
                $DanhSach_Tinh = Tinh::all()->sortBy('tentinh');

                $DanhSach_MoiQuanHe = MoiQuanHe::all();
                $DanhSach_GioiTinh = GioiTinh::all()->sortBy('tengioitinh');
                $DanhSach_Lop = Lop::all()->sortBy('tenlop');

                $DanhSach_LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('lylich.id', 'desc')->get();

                
                return view('admin.sinhvien_thongtin_capnhat', ['SV'=>$SV, 'LyLich'=>$LyLich, 'DanhSach_AnhChiEm'=>$DanhSach_AnhChiEm, 'DanhSach_DanToc'=>$DanhSach_DanToc, 'DanhSach_TonGiao'=>$DanhSach_TonGiao, 'DanhSach_Tinh'=>$DanhSach_Tinh, 'DanhSach_MoiQuanHe'=>$DanhSach_MoiQuanHe, 'DanhSach_GioiTinh'=>$DanhSach_GioiTinh, 'DanhSach_Lop'=>$DanhSach_Lop, 'DanhSach_LyLich'=>$DanhSach_LyLich]);
            }
            else
            {
                return redirect()->route('home');
            }
        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function subadmin_show($id)
    {
        if(Auth::check() && $this::isIDSinhVien($id))
        {
            $LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'desc')->first();
            $SV = SinhVien::find($id);
            if($LyLich)
                $DanhSach_AnhChiEm = $LyLich->anhchiem;
            else
                $DanhSach_AnhChiEm = AnhChiEm::where('id', '=', 0)->get();
            $DanhSach_DanToc = DanToc::all();
            $DanhSach_TonGiao = TonGiao::all();
            $DanhSach_Tinh = Tinh::all()->sortBy('tentinh');
            $DanhSach_MoiQuanHe = MoiQuanHe::all();
            $DanhSach_GioiTinh = GioiTinh::all()->sortBy('tengioitinh');
            $DanhSach_Lop = Lop::all()->sortBy('tenlop');
            $DanhSach_LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'ASC')->get();
            return view('subadmin.studentshow', ['SV'=>$SV, 'LyLich'=>$LyLich, 'DanhSach_AnhChiEm'=>$DanhSach_AnhChiEm, 'DanhSach_DanToc'=>$DanhSach_DanToc, 'DanhSach_TonGiao'=>$DanhSach_TonGiao, 'DanhSach_Tinh'=>$DanhSach_Tinh, 'DanhSach_MoiQuanHe'=>$DanhSach_MoiQuanHe, 'DanhSach_GioiTinh'=>$DanhSach_GioiTinh, 'DanhSach_Lop'=>$DanhSach_Lop, 'DanhSach_LyLich'=>$DanhSach_LyLich]);
        }
        else
            return redirect()->route('home');
    }

    public function truongdonvi_show($id)
    {
        if(Auth::check() && $this::isIDSinhVien($id))
        {
            $LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'desc')->first();
            $SV = SinhVien::find($id);
            if($LyLich)
                $DanhSach_AnhChiEm = $LyLich->anhchiem;
            else
                $DanhSach_AnhChiEm = AnhChiEm::where('id', '=', 0)->get();
            $DanhSach_DanToc = DanToc::all();
            $DanhSach_TonGiao = TonGiao::all();
            $DanhSach_Tinh = Tinh::all()->sortBy('tentinh');
            $DanhSach_MoiQuanHe = MoiQuanHe::all();
            $DanhSach_GioiTinh = GioiTinh::all()->sortBy('tengioitinh');
            $DanhSach_Lop = Lop::all()->sortBy('tenlop');
            $DanhSach_LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'ASC')->get();
            return view('truongdonvi.sinhvien_detail_information', ['SV'=>$SV, 'LyLich'=>$LyLich, 'DanhSach_AnhChiEm'=>$DanhSach_AnhChiEm, 'DanhSach_DanToc'=>$DanhSach_DanToc, 'DanhSach_TonGiao'=>$DanhSach_TonGiao, 'DanhSach_Tinh'=>$DanhSach_Tinh, 'DanhSach_MoiQuanHe'=>$DanhSach_MoiQuanHe, 'DanhSach_GioiTinh'=>$DanhSach_GioiTinh, 'DanhSach_Lop'=>$DanhSach_Lop, 'DanhSach_LyLich'=>$DanhSach_LyLich]);
        }
        else
            return redirect()->route('home');
    }

    public function covanhoctap_show($id)
    {
        if(Auth::check() && $this::isIDSinhVien($id))
        {
            $LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'desc')->first();
            $SV = SinhVien::find($id);
            if($LyLich)
                $DanhSach_AnhChiEm = $LyLich->anhchiem;
            else
                $DanhSach_AnhChiEm = AnhChiEm::where('id', '=', 0)->get();
            $DanhSach_DanToc = DanToc::all();
            $DanhSach_TonGiao = TonGiao::all();
            $DanhSach_Tinh = Tinh::all()->sortBy('tentinh');
            $DanhSach_MoiQuanHe = MoiQuanHe::all();
            $DanhSach_GioiTinh = GioiTinh::all()->sortBy('tengioitinh');
            $DanhSach_Lop = Lop::all()->sortBy('tenlop');
            $DanhSach_LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'ASC')->get();
            return view('covanhoctap.studentshow', ['SV'=>$SV, 'LyLich'=>$LyLich, 'DanhSach_AnhChiEm'=>$DanhSach_AnhChiEm, 'DanhSach_DanToc'=>$DanhSach_DanToc, 'DanhSach_TonGiao'=>$DanhSach_TonGiao, 'DanhSach_Tinh'=>$DanhSach_Tinh, 'DanhSach_MoiQuanHe'=>$DanhSach_MoiQuanHe, 'DanhSach_GioiTinh'=>$DanhSach_GioiTinh, 'DanhSach_Lop'=>$DanhSach_Lop, 'DanhSach_LyLich'=>$DanhSach_LyLich]);
        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function giaovukhoa_show($id)
    {
        if(Auth::check() && $this::isIDSinhVien($id))
        {
            $LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'desc')->first();
            $SV = SinhVien::find($id);
            if($LyLich)
                $DanhSach_AnhChiEm = $LyLich->anhchiem;
            else
                $DanhSach_AnhChiEm = AnhChiEm::where('id', '=', 0)->get();
            $DanhSach_DanToc = DanToc::all();
            $DanhSach_TonGiao = TonGiao::all();
            $DanhSach_Tinh = Tinh::all()->sortBy('tentinh');
            $DanhSach_MoiQuanHe = MoiQuanHe::all();
            $DanhSach_GioiTinh = GioiTinh::all()->sortBy('tengioitinh');
            $DanhSach_Lop = Lop::all()->sortBy('tenlop');
            $DanhSach_LyLich = LyLich::where('sinhvien_id', '=', $id)->orderBy('id', 'ASC')->get();
            return view('giaovukhoa.studentshow', ['SV'=>$SV, 'LyLich'=>$LyLich, 'DanhSach_AnhChiEm'=>$DanhSach_AnhChiEm, 'DanhSach_DanToc'=>$DanhSach_DanToc, 'DanhSach_TonGiao'=>$DanhSach_TonGiao, 'DanhSach_Tinh'=>$DanhSach_Tinh, 'DanhSach_MoiQuanHe'=>$DanhSach_MoiQuanHe, 'DanhSach_GioiTinh'=>$DanhSach_GioiTinh, 'DanhSach_Lop'=>$DanhSach_Lop, 'DanhSach_LyLich'=>$DanhSach_LyLich]);
        }
        return redirect()->route('home');
    }

    public function postCapNhatThongTin(Request $request)
    {
        if(Auth::check() && (UserController::isGroupNoneId(env('GROUP_CHUYENVIENHETHONG')) || UserController::isGroupNoneId(env('GROUP_QUANTRIHETHONG'))))
        {
            $validator = $this::ValidateInformationBase($request);

            if($validator->fails())
            {
                return redirect()->route('getcapnhatthongtinsinhvien', ['id'=>$request->sinhvien_id])
                            ->withErrors($validator)
                            ->withInput();
            }
            else
            {
                $errorMessages;
                $result = true;
                $id = $request->sinhvien_id;
                // 1. Kiểm tra trùng mssv
                if($this::hasMSSVDuplicate_Update($id, $request->mssv))
                {
                    $result = false;
                    $errorMessages['mssv'] = 'MSSV này đã có (bị trùng)';
                }

                // 2. Kiểm tra trùng email
                if($this::hasEmailDuplicate_Update($id, $request->email))
                {
                    $result = false;
                    $errorMessages['email'] = 'Email này đã có (bị trùng)';
                }

                // 3. Kiểm tra trùng cmnd
                if($this::hasCMNDDuplicate_Update($id, $request->cmnd))
                {
                    $result = false;
                    $errorMessages['cmnd'] = 'Số cmnd này đã có (bị trùng)';
                }


                if($result)
                {
                    try {
                        $SV = SinhVien::find($id);
                        $objold = SinhVien::find($id)->toArray();
                        $mssv = trim($request->mssv);
                        
                        // 4. Check to rename profile picture
                        if($SV->mssv != $mssv)
                        {
                            // Rename profile picture
                            $oldname = $SV->hinhthe;
                            
                            $ext = pathinfo($oldname, PATHINFO_EXTENSION);

                            $newname = env('PIC_PATH_CARD') . $mssv . '.' . $ext;

                            if($oldname)
                            {
                                if(rename ($oldname , $newname))
                                {
                                    $SV->hinhthe = $newname;
                                }
                            }
                        }
                        
                        // 5. update
                        $SV->mssv = $mssv;
                        $SV->hochulot = trim($request->hovachulot);
                        $SV->ten = trim($request->ten);
                        $SV->ngaysinh = date('Y-m-d', strtotime($request->ngaysinh));
                        $SV->gioitinh = $request->gioitinh;
                        $SV->diemtrungtuyen = floatval($request->diemtrungtuyen);
                        $SV->lop_id = $request->lop;
                        $SV->email_agu = $request->email;

                        // Cập nhật email trong users
                        $User = User::where('cbgvsv_id', '=', $id)->where('idloaiuser', '=', 3)->first();
                        $User->email = $request->email;
                        $User->save();

                        $SV->cmnd = $request->cmnd;

                        $SV->save();

                        // Write log
                        try {
                            $objnew = SinhVien::find($id)->toArray();

                            LogController::storeobjectlog($objold, $objnew, LogLoaiHoatDong::UpdateRecord, '');
                            
                        } catch (Exception $e) {}
                        // End Write log

                        return redirect()->route('getcapnhatthongtinsinhvien', ['id'=>$request->sinhvien_id])
                            ->with(['success' => 'Lưu thông tin cập nhật thành công!']);

                    } catch (Exception $e) {
                        return redirect()->route('getcapnhatthongtinsinhvien', ['id'=>$request->sinhvien_id])
                            ->with(['danger' => 'Đã có lỗi trong quá trình cập nhập, vui lòng <b>refresh</b> và cập nhập lại.']);
                    }
                }
                else
                {
                    return redirect()->route('getcapnhatthongtinsinhvien', ['id'=>$request->sinhvien_id])
                        ->withErrors($errorMessages)
                        ->withInput();
                }

            }
        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function isIDSinhVien($Id)
    {
        $arrayValue = array('id' => $Id);

        $rules = [
            'id' => 'required|integer',
        ];

        $validator = Validator::make($arrayValue, $rules);

        if ($validator->fails())
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function ValidateInformationBase($request)
    {
        $rules = [
            'hovachulot' => 'required',
            'ten' => 'required',
            'mssv' => 'required|min:9|max:9',
            'ngaysinh' => 'required|date',
            'gioitinh' => 'required',
            'diemtrungtuyen' => 'required|numeric|min:0|max:50',
            'lop' => 'required',
            'email' => 'required|email',
            'cmnd' => 'required|numeric|min:100000000|max:99999999999',
        ];

        $messages = [
            'hovachulot.required'=> 'Vui lòng nhập họ và chữ lót',
            'ten.required'=> 'Vui lòng nhập tên',
            'mssv.required'=> 'Vui lòng nhập mã số sinh viên',
            'mssv.min'=> 'Mã số phải đủ 9 ký tự (gồm phần chữ và số)',
            'mssv.max'=> 'Mã số phải đủ 9 ký tự (gồm phần chữ và số)',
            'ngaysinh.required'=> 'Vui lòng nhập ngày sinh',
            'ngaysinh.date'=> 'Ngày sinh không đúng',
            'gioitinh.required'=> 'Vui lòng chọn giới tính',
            'diemtrungtuyen.required'=> 'Vui lòng nhập điểm trúng tuyển',
            'diemtrungtuyen.min'=> 'Điểm trúng tuyển không hợp lệ',
            'diemtrungtuyen.max'=> 'Điểm trúng tuyển không hợp lệ',
            'diemtrungtuyen.numeric'=> 'Điểm trúng tuyển không hợp lệ',
            'lop.required'=> 'Vui lòng chọn lớp',
            'email.required'=> 'Vui lòng nhập email',
            'email.email'=> 'Không đúng định dạng email',
            'cmnd.required'=> 'Vui lòng nhập số cmnd',
            'cmnd.min'=> 'Phải nhập đầy đủ số cmnd',
            'cmnd.max'=> 'Số cmnd quá dài (không hợp lệ)',
            'cmnd.numeric'=> 'Số cmnd không hợp lệ',
        ];

        return Validator::make($request->toArray(), $rules, $messages);
    }

    public function getSinhVienByKhoaNganhLop(Request $arrayNganhKhoaLopID)
    {
        if($arrayNganhKhoaLopID->MSSV)
        {
            $DanhSach_SinhVien = SinhVien::where('mssv', 'like', "%".$arrayNganhKhoaLopID->MSSV."%")
                -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
                -> join('khoa', 'khoa.id', '=', 'bomon.idKhoa')
                -> leftjoin('gioitinh', 'gioitinh.id', '=', 'sinhvien.gioitinh')
                -> leftjoin(DB::raw('(select * from lylich where id in (select max(id) as max_id from lylich group by sinhvien_id)) as lylich'), 'lylich.sinhvien_id', '=', 'sinhvien.id')
                -> leftjoin('xa', 'xa.id', '=', 'lylich.xa_id')
                -> leftjoin('huyen', 'huyen.id', '=', 'xa.huyen_id')
                -> leftjoin('tinh', 'tinh.id', '=', 'huyen.tinh_id')
                -> leftjoin('xa as xa_tamtru', 'xa_tamtru.id', '=', 'lylich.tamtru_xa_id')
                -> leftjoin('huyen as huyen_tamtru', 'huyen_tamtru.id', '=', 'xa_tamtru.huyen_id')
                -> leftjoin('tinh as tinh_tamtru', 'tinh_tamtru.id', '=', 'huyen_tamtru.tinh_id')
                -> leftjoin('dantoc', 'dantoc.id', '=', 'lylich.dantoc_id')
                -> leftjoin('tongiao', 'tongiao.id', '=', 'lylich.tongiao_id')
                -> orderBy('khoa.tenkhoa', 'ASC')
                -> orderBy('nganh.tennganh', 'ASC')
                -> orderBy('lop.tenlop', 'ASC')
                -> orderBy('sinhvien.mssv', 'ASC')
                -> select('sinhvien.*', 'lop.tenlop', 'nganh.tennganh', 'bomon.tenbomon', 'khoa.tenkhoa', 'gioitinh.tengioitinh', 'lylich.noisinh', 'lylich.ngaycapcmnd', 'lylich.noicapcmnd', 'lylich.xa_id', 'lylich.hokhauthuongtru', 'lylich.tamtru_xa_id', 'lylich.diachitamtru', 'dantoc.tendantoc as dantoc', 'tongiao.tentongiao as tongiao', 'lylich.email', 'lylich.dienthoai', 'lylich.ngayvaodoantncshcm', 'lylich.noivaodoantncshcm', 'lylich.ngayvaodangcsvn', 'lylich.noivaodangcsvn', 'lylich.picture', 'lylich.hongheo', 'lylich.hocanngheo', 'lylich.mocoicha', 'lylich.mocoime', 'lylich.conthuongbinh', 'lylich.conlietsy', 'lylich.tantat', 'lylich.hotencha', 'lylich.ngaysinhcha', 'lylich.dantoc_idcha', 'lylich.xa_idcha', 'lylich.hokhauthuongtrucha', 'lylich.nghenghiepcha', 'lylich.noilamvieccha', 'lylich.dienthoaicha', 'lylich.hotenme', 'lylich.ngaysinhme', 'lylich.dantoc_idme', 'lylich.xa_idme', 'lylich.hokhauthuongtrume', 'lylich.nghenghiepme', 'lylich.noilamviecme', 'lylich.dienthoaime', 'xa.tenxa', 'huyen.tenhuyen', 'tinh.tentinh', 'xa_tamtru.tenxa as tenxa_tamtru', 'huyen_tamtru.tenhuyen as tenhuyen_tamtru', 'tinh_tamtru.tentinh as tentinh_tamtru')
                -> get();
            return $DanhSach_SinhVien;
        }
        else
        {
            // if(!$arrayNganhKhoaLopID->KhoaID || count($arrayNganhKhoaLopID->KhoaID) <= 0)
            if(!$arrayNganhKhoaLopID->KhoaID)
            {
                $arrayNganhKhoaLopID->KhoaID = KhoaController::getArrayAllKhoaID();
            }

            // if(!$arrayNganhKhoaLopID->NganhID || count($arrayNganhKhoaLopID->NganhID) <= 0)
            if(!$arrayNganhKhoaLopID->NganhID)
            {
                $arrayNganhKhoaLopID->NganhID = NganhController::getArrayAllNganhID();
            }

            // if(!$arrayNganhKhoaLopID->LopID || count($arrayNganhKhoaLopID->LopID) <= 0)
            if(!$arrayNganhKhoaLopID->LopID)
            {
                $arrayNganhKhoaLopID->LopID = LopController::getArrayAllLopID();
            }



            // $DanhSach_SinhVien = SinhVien::whereIn('sinhvien.lop_id', $arrayNganhKhoaLopID->LopID)
            //     -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            //     -> whereIn('lop.nganh_id', $arrayNganhKhoaLopID->NganhID)
            //     -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            //     -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            //     -> whereIn('bomon.idkhoa', $arrayNganhKhoaLopID->KhoaID)
            //     -> join('khoa', 'khoa.id', '=', 'bomon.idKhoa')
            //     -> orderBy('khoa.tenkhoa', 'ASC')
            //     -> orderBy('nganh.tennganh', 'ASC')
            //     -> orderBy('lop.tenlop', 'ASC')
            //     -> orderBy('sinhvien.mssv', 'ASC')
            //     -> select('sinhvien.*', 'lop.*', 'nganh.*', 'bomon.*', 'khoa.*', 'sinhvien.id')
            //     -> get();
            // $lyLich = LyLich::orderBy('id', 'desc')->groupBy('sinhvien_id')->get();

            $DanhSach_SinhVien = SinhVien::whereIn('sinhvien.lop_id', $arrayNganhKhoaLopID->LopID)
                -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                -> whereIn('lop.nganh_id', $arrayNganhKhoaLopID->NganhID)
                -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
                -> whereIn('bomon.idkhoa', $arrayNganhKhoaLopID->KhoaID)
                -> join('khoa', 'khoa.id', '=', 'bomon.idKhoa')
                -> join('gioitinh', 'gioitinh.id', '=', 'sinhvien.gioitinh')
                -> orderBy('khoa.tenkhoa', 'ASC')
                -> orderBy('nganh.tennganh', 'ASC')
                -> orderBy('lop.tenlop', 'ASC')
                -> orderBy('sinhvien.mssv', 'ASC')
                -> leftjoin(DB::raw('(select * from lylich where id in (select max(id) as max_id from lylich group by sinhvien_id)) as tbl_lylich_limit'), 'tbl_lylich_limit.sinhvien_id', '=', 'sinhvien.id')
                -> leftjoin('xa', 'xa.id', '=', 'tbl_lylich_limit.xa_id')
                -> leftjoin('huyen', 'huyen.id', '=', 'xa.huyen_id')
                -> leftjoin('tinh', 'tinh.id', '=', 'huyen.tinh_id')
                -> leftjoin('xa as xa_tamtru', 'xa_tamtru.id', '=', 'tbl_lylich_limit.tamtru_xa_id')
                -> leftjoin('huyen as huyen_tamtru', 'huyen_tamtru.id', '=', 'xa_tamtru.huyen_id')
                -> leftjoin('tinh as tinh_tamtru', 'tinh_tamtru.id', '=', 'huyen_tamtru.tinh_id')
                -> leftjoin('dantoc', 'dantoc.id', '=', 'tbl_lylich_limit.dantoc_id')
                -> leftjoin('tongiao', 'tongiao.id', '=', 'tbl_lylich_limit.tongiao_id')
                -> select('sinhvien.*', 'lop.tenlop', 'nganh.tennganh', 'bomon.tenbomon', 'khoa.tenkhoa', 'gioitinh.tengioitinh', 'tbl_lylich_limit.noisinh', 'tbl_lylich_limit.ngaycapcmnd', 'tbl_lylich_limit.noicapcmnd', 'tbl_lylich_limit.xa_id', 'tbl_lylich_limit.hokhauthuongtru', 'tbl_lylich_limit.tamtru_xa_id', 'tbl_lylich_limit.diachitamtru', 'dantoc.tendantoc as dantoc', 'tongiao.tentongiao as tongiao', 'tbl_lylich_limit.email', 'tbl_lylich_limit.dienthoai', 'tbl_lylich_limit.ngayvaodoantncshcm', 'tbl_lylich_limit.noivaodoantncshcm', 'tbl_lylich_limit.ngayvaodangcsvn', 'tbl_lylich_limit.noivaodangcsvn', 'tbl_lylich_limit.picture', 'tbl_lylich_limit.hongheo', 'tbl_lylich_limit.hocanngheo', 'tbl_lylich_limit.mocoicha', 'tbl_lylich_limit.mocoime', 'tbl_lylich_limit.conthuongbinh', 'tbl_lylich_limit.conlietsy', 'tbl_lylich_limit.tantat', 'tbl_lylich_limit.hotencha', 'tbl_lylich_limit.ngaysinhcha', 'tbl_lylich_limit.dantoc_idcha', 'tbl_lylich_limit.xa_idcha', 'tbl_lylich_limit.hokhauthuongtrucha', 'tbl_lylich_limit.nghenghiepcha', 'tbl_lylich_limit.noilamvieccha', 'tbl_lylich_limit.dienthoaicha', 'tbl_lylich_limit.hotenme', 'tbl_lylich_limit.ngaysinhme', 'tbl_lylich_limit.dantoc_idme', 'tbl_lylich_limit.xa_idme', 'tbl_lylich_limit.hokhauthuongtrume', 'tbl_lylich_limit.nghenghiepme', 'tbl_lylich_limit.noilamviecme', 'tbl_lylich_limit.dienthoaime', 'xa.tenxa', 'huyen.tenhuyen', 'tinh.tentinh', 'xa_tamtru.tenxa as tenxa_tamtru', 'huyen_tamtru.tenhuyen as tenhuyen_tamtru', 'tinh_tamtru.tentinh as tentinh_tamtru')
                // -> select('sinhvien.*', 'lop.*', 'nganh.*', 'bomon.*', 'khoa.*', 'sinhvien.id', 'gioitinh.tengioitinh', 'tbl_lylich_limit.*')
                -> get();

            // dd($DanhSach_SinhVien->toArray());

            

            // dd($arrayNganhKhoaLopID->LopID);
            // dd(implode(', ', $arrayNganhKhoaLopID->LopID));
            // $DanhSach_SinhVien = DB::select('select * 
            // from
            //     (select tbl_sinhvien_lop_nganh_bomon.*, khoa.tenkhoa from
            //         (select tbl_sinhvien_lop_nganh.*, bomon.tenbomon, bomon.idkhoa from
                    
            //             (select tbl_sinhvien_lop.*, nganh.tennganh, nganh.idbomon from 
            //                 (select sinhvien.*, lop.tenlop, lop.nganh_id from sinhvien join lop on sinhvien.lop_id = lop.id where lop.id in (?)) as tbl_sinhvien_lop
            //                 join nganh on tbl_sinhvien_lop.nganh_id = nganh.id where tbl_sinhvien_lop.nganh_id in (15, 16)
            //             ) as tbl_sinhvien_lop_nganh
            //             join bomon on tbl_sinhvien_lop_nganh.idbomon = bomon.id
            //         ) as tbl_sinhvien_lop_nganh_bomon
            //         join khoa on tbl_sinhvien_lop_nganh_bomon.idkhoa = khoa.id where tbl_sinhvien_lop_nganh_bomon.idkhoa in (3, 4)
                    
            //         order by khoa.tenkhoa asc, tbl_sinhvien_lop_nganh_bomon.tenbomon asc, tbl_sinhvien_lop_nganh_bomon.tennganh asc, tbl_sinhvien_lop_nganh_bomon.tenlop asc
            //     ) as tbl_sinhvien_lop_nganh_bomon_khoa
            // left join
            //     (select * from lylich order by lylich.id desc limit  1) as tbl_lylich
            // on
            //     tbl_sinhvien_lop_nganh_bomon_khoa.id = tbl_lylich.sinhvien_id
            // group by tbl_sinhvien_lop_nganh_bomon_khoa.id
            // ', [implode(', ', $arrayNganhKhoaLopID->LopID)]);

            // dd($DanhSach_SinhVien->toArray());
            return $DanhSach_SinhVien;
        }
    }

    public function getSinhVienByKhoaNganhLopExport(Request $arrayNganhKhoaLopID)
    {
        $fileName = "DanhSachSinhVien";
        $fileExtend ="xls";
        $DanhSach_SinhVien = self::getSinhVienByKhoaNganhLop($arrayNganhKhoaLopID);
        return self::createFile($DanhSach_SinhVien, $fileName, $fileExtend);
    }

    public static function getSinhVienByLop($idLop)
    {
        $DanhSach_SinhVien = SinhVien::where('lop_id','=', $idLop)->get();
        return $DanhSach_SinhVien;
    }

    public function createFile($arrayThongTinSinhVien, $fileName, $fileExtend)
    {
        $sheetName = "ThongTinSinhVien";
        $rowNum = 0;

        // $arrayTitleSheet = ["STT", "MSSV", "HỌ", "TÊN", "GIỚI TÍNH", "NGÀY SINH", "EMAIL_AGU", "EMAIL KHÁC", "ĐIỆN THOẠI", "CMND", "NGÀY CẤP", "NƠI CẤP", "ĐIỂM TRÚNG TUYỂN", "LỚP", "NGÀNH", "BẬC ĐÀO TẠO", "HỆ ĐÀO TẠO", "BỘ MÔN", "KHOA", "THƯỜNG TRÚ", "TẠM TRÚ", "DÂN TỘC", "TÔN GIÁO", "NGÀY VÀO ĐOÀN", "NƠI VÀO ĐOÀN", "NGÀY VÀO ĐẢNG", "NƠI VÀO ĐẢNG", "HỘ NGHÈO", "CẬN NGHÈO", "MỒ CÔI CHA", "MỒ CÔI MẸ", "CON THƯƠNG BINH", "CON LIỆT SỸ", "TÀN TẬT", "HỌ TÊN CHA", "NĂM SINH", "THƯỜNG TRÚ", "NGHỀ NGHIỆP", "NƠI LÀM VIỆC", "ĐIỆN THOẠI", "HỌ TÊN MẸ", "NĂM SINH", "THƯỜNG TRÚ", "NGHỀ NGHIỆP", "NƠI LÀM VIỆC", "ĐIỆN THOẠI"];
        $arrayTitleSheet = ["STT", "MSSV", "HỌ", "TÊN", "GIỚI TÍNH", "NGÀY SINH", "EMAIL_AGU", "EMAIL KHÁC", "ĐIỆN THOẠI", "CMND", "NGÀY CẤP", "NƠI CẤP", "ĐIỂM TRÚNG TUYỂN", "LỚP", "NGÀNH", "BỘ MÔN", "KHOA", "THƯỜNG TRÚ", "XÃ", "HUYỆN", "TỈNH", "TẠM TRÚ", "XÃ (TẠM TRÚ)", "HUYỆN (TẠM TRÚ)", "TỈNH (TẠM TRÚ)", "DÂN TỘC", "TÔN GIÁO", "NGÀY VÀO ĐOÀN", "NƠI VÀO ĐOÀN", "NGÀY VÀO ĐẢNG", "NƠI VÀO ĐẢNG", "HỘ NGHÈO", "CẬN NGHÈO", "MỒ CÔI CHA", "MỒ CÔI MẸ", "CON THƯƠNG BINH", "CON LIỆT SỸ", "TÀN TẬT", "HỌ TÊN CHA", "NĂM SINH", "THƯỜNG TRÚ", "NGHỀ NGHIỆP", "NƠI LÀM VIỆC", "ĐIỆN THOẠI", "HỌ TÊN MẸ", "NĂM SINH", "THƯỜNG TRÚ", "NGHỀ NGHIỆP", "NƠI LÀM VIỆC", "ĐIỆN THOẠI"];
        $arrayColumnWidth = array(  'A' => 5, 
                                    'B' => 12, 
                                    'C' => 20, 
                                    'D' => 8, 
                                    'E' => 10, 
                                    'F' => 13, 
                                    'G' => 34, 
                                    'H' => 34, 
                                    'I' => 12, 
                                    'J' => 13, 
                                    'K' => 11, 
                                    'L' => 9, 
                                    'M' => 20, 
                                    'N' => 10, 
                                    'O' => 20, 
                                    'P' => 16, 
                                    'Q' => 20, 
                                    'R' => 50, 
                                    'S' => 17, 
                                    'T' => 19, 
                                    'U' => 10, 
                                    'V' => 50,
                                    'W' => 17, 
                                    'X' => 19, 
                                    'Y' => 16, 
                                    'Z' => 10,
                                    'AA' => 15, 
                                    'AB' => 17, 
                                    'AC' => 18, 
                                    'AD' => 18, 
                                    'AE' => 18, 
                                    'AF' => 15, 
                                    'AG' => 12, 
                                    'AH' => 15, 
                                    'AI' => 13, 
                                    'AJ' => 20, 
                                    'AK' => 20, 
                                    'AL' => 13, 
                                    'AM' => 9, 
                                    'AM' => 20, 
                                    'AN' => 11, 
                                    'AO' => 50, 
                                    'AP' => 14, 
                                    'AQ' => 50, 
                                    'AR' => 14, 
                                    'AS' => 20, 
                                    'AT' => 11, 
                                    'AU' => 50, 
                                    'AV' => 20,
                                    'AW' => 50,
                                    'AX' => 14, 
                                );

        Excel::create($fileName, function($excel) use ($sheetName, $arrayThongTinSinhVien, $arrayTitleSheet, $arrayColumnWidth, $rowNum) {

            $excel->sheet($sheetName, function($sheet) use($arrayThongTinSinhVien, $arrayTitleSheet, $arrayColumnWidth, $rowNum){
                
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

                // Set height for row
                // $sheet->getRowDimension(65000)->setRowHeight(19);

                $STT = intval(0);

                foreach ($arrayThongTinSinhVien as $key => $SinhVien) {
                    // dd(XaController::getDiaChi(1));
                    // $lyLich = $SinhVien->lylich->last();
                    // if($lyLich)
                    //     $rowRecordSinhVien = [
                    //         ++$STT,
                    //         $SinhVien->mssv,
                    //         $SinhVien->hochulot,
                    //         $SinhVien->ten,
                    //         GioiTinhController::getGioiTinh($SinhVien->gioitinh)->tengioitinh,
                    //         Carbon::createFromFormat("Y-m-d", $SinhVien->ngaysinh)->format("d/m/Y"),
                    //         $SinhVien->email_agu,
                    //         $lyLich->email,
                    //         $lyLich->dienthoai,
                    //         $SinhVien->cmnd,
                    //         Carbon::createFromFormat("Y-m-d", $lyLich->ngaycapcmnd)->format("d/m/Y"),
                    //         $lyLich->noicapcmnd,
                    //         $SinhVien->diemtrungtuyen,
                    //         $SinhVien->tenlop,
                    //         $SinhVien->tennganh,
                    //         BacDaoTaoController::getBacDaoTao($SinhVien->idbacdaotao)->tenbac,
                    //         HeDaoTaoController::getHeDaoTao($SinhVien->idhedaotao)->tenhe,
                    //         $SinhVien->tenbomon,
                    //         $SinhVien->tenkhoa,
                    //         $lyLich->hokhauthuongtru . $lyLich->thuongtru? ($lyLich->hokhauthuongtru . ", " . $lyLich->thuongtru->tenxa . ", " . $lyLich->thuongtru->huyen->tenhuyen . ", " . $lyLich->thuongtru->huyen->tinh->tentinh):'',
                    //         $lyLich->hokhautamtru . $lyLich->tamtru? ($lyLich->diachitamtru . ", " . $lyLich->tamtru->tenxa . ", " . $lyLich->tamtru->huyen->tenhuyen . ", " . $lyLich->tamtru->huyen->tinh->tentinh):'',
                    //         $lyLich->dantoc? $lyLich->dantoc->tendantoc : '',
                    //         $lyLich->tongiao? $lyLich->tongiao->tentongiao : '',
                    //         $lyLich->ngayvaodoantncshcm?Carbon::createFromFormat("Y-m-d", $lyLich->ngayvaodoantncshcm)->format("d/m/Y"):'',
                    //         $lyLich->noivaodoantncshcm,
                    //         $lyLich->ngayvaodangcsvn?Carbon::createFromFormat("Y-m-d", $lyLich->ngayvaodangcsvn)->format("d/m/Y"):'',
                    //         $lyLich->noivaodangcsvn,
                    //         $lyLich->hongheo,
                    //         $lyLich->honcanngheo,
                    //         $lyLich->mocoicha,
                    //         $lyLich->mocoime,
                    //         $lyLich->conthuongbinh,
                    //         $lyLich->conlietsy,
                    //         $lyLich->tantat,

                    //         $lyLich->hotencha,
                    //         $lyLich->ngaysinhcha?Carbon::createFromFormat("Y-m-d", $lyLich->ngaysinhcha)->format("d/m/Y"):'',
                    //         $lyLich->hokhauthuongtrucha . $lyLich->thuongtrucha? ($lyLich->hokhauthuongtrucha . ", " . $lyLich->thuongtrucha->tenxa . ", " . $lyLich->thuongtrucha->huyen->tenhuyen . ", " . $lyLich->thuongtrucha->huyen->tinh->tentinh):'',
                    //         $lyLich->nghenghiepcha,
                    //         $lyLich->noilamvieccha,
                    //         $lyLich->dienthoaicha,

                    //         $lyLich->hotenme,
                    //         $lyLich->ngaysinhme?Carbon::createFromFormat("Y-m-d", $lyLich->ngaysinhme)->format("d/m/Y"):'',
                    //         $lyLich->hokhauthuongtrume . $lyLich->thuongtrume? ($lyLich->hokhauthuongtrume . ", " . $lyLich->thuongtrume->tenxa . ", " . $lyLich->thuongtrume->huyen->tenhuyen . ", " . $lyLich->thuongtrume->huyen->tinh->tentinh):'',
                    //         $lyLich->nghenghiepme,
                    //         $lyLich->noilamviecme,
                    //         $lyLich->dienthoaime
                    //     ];
                    // else
                    //     $rowRecordSinhVien = [
                    //         ++$STT,
                    //         $SinhVien->mssv,
                    //         $SinhVien->hochulot,
                    //         $SinhVien->ten,
                    //         GioiTinhController::getGioiTinh($SinhVien->gioitinh)->tengioitinh,
                    //         Carbon::createFromFormat("Y-m-d", $SinhVien->ngaysinh)->format("d/m/Y"),
                    //         $SinhVien->email_agu,
                    //         "",
                    //         "",
                    //         $SinhVien->cmnd,
                    //         "",
                    //         "",
                    //         $SinhVien->diemtrungtuyen,
                    //         $SinhVien->tenlop,
                    //         $SinhVien->tennganh,
                    //         BacDaoTaoController::getBacDaoTao($SinhVien->idbacdaotao)->tenbac,
                    //         HeDaoTaoController::getHeDaoTao($SinhVien->idhedaotao)->tenhe,
                    //         $SinhVien->tenbomon,
                    //         $SinhVien->tenkhoa
                    //     ];
                    

                    $rowRecordSinhVien = [
                        ++$STT,
                        $SinhVien->mssv,
                        $SinhVien->hochulot,
                        $SinhVien->ten,
                        $SinhVien->tengioitinh,
                        $SinhVien->ngaysinh ? Carbon::createFromFormat("Y-m-d", $SinhVien->ngaysinh)->format("d/m/Y") : '',
                        $SinhVien->email_agu,
                        $SinhVien->email,
                        $SinhVien->dienthoai,
                        $SinhVien->cmnd,
                        $SinhVien->ngaycapcmnd ? Carbon::createFromFormat("Y-m-d", $SinhVien->ngaycapcmnd)->format("d/m/Y") : '',
                        $SinhVien->noicapcmnd,
                        $SinhVien->diemtrungtuyen,
                        $SinhVien->tenlop,
                        $SinhVien->tennganh,
                        $SinhVien->tenbomon,
                        $SinhVien->tenkhoa,
                        // $SinhVien->hokhauthuongtru . XaController::getDiaChi( $SinhVien->xa_id),
                        $SinhVien->hokhauthuongtru,
                        $SinhVien->tenxa,
                        $SinhVien->tenhuyen,
                        $SinhVien->tentinh,

                        // $SinhVien->diachitamtru . XaController::getDiaChi( $SinhVien->tamtru_xa_id),
                        $SinhVien->diachitamtru,
                        $SinhVien->tenxa_tamtru,
                        $SinhVien->tenhuyen_tamtru,
                        $SinhVien->tentinh_tamtru,

                        $SinhVien->dantoc,
                        $SinhVien->tongiao,
                        $SinhVien->ngayvaodoantncshcm ? Carbon::createFromFormat("Y-m-d", $SinhVien->ngayvaodoantncshcm)->format("d/m/Y"):'',
                        $SinhVien->noivaodoantncshcm,
                        $SinhVien->ngayvaodangcsvn ? Carbon::createFromFormat("Y-m-d", $SinhVien->ngayvaodangcsvn)->format("d/m/Y"):'',
                        $SinhVien->noivaodangcsvn,
                        $SinhVien->hongheo,
                        $SinhVien->honcanngheo,
                        $SinhVien->mocoicha,
                        $SinhVien->mocoime,
                        $SinhVien->conthuongbinh,
                        $SinhVien->conlietsy,
                        $SinhVien->tantat,

                        $SinhVien->hotencha,
                        $SinhVien->ngaysinhcha ? Carbon::createFromFormat("Y-m-d", $SinhVien->ngaysinhcha)->format("d/m/Y") : '',
                        $SinhVien->hokhauthuongtrucha . XaController::getDiaChi( $SinhVien->xa_idcha),
                        $SinhVien->nghenghiepcha,
                        $SinhVien->noilamvieccha,
                        $SinhVien->dienthoaicha,

                        $SinhVien->hotenme,
                        $SinhVien->ngaysinhme ? Carbon::createFromFormat("Y-m-d", $SinhVien->ngaysinhme)->format("d/m/Y") : '',
                        $SinhVien->hokhauthuongtrume  . XaController::getDiaChi( $SinhVien->xa_idme),
                        $SinhVien->nghenghiepme,
                        $SinhVien->noilamviecme,
                        $SinhVien->dienthoaime
                    ];
                    // Set record data for table
                    $sheet->row(++$rowNum, $rowRecordSinhVien);
                }
                
            });

        })->download($fileExtend);
    }

    public static function createStoreFile($arrayThongTinSinhVien, $fileName, $fileExtend, $storagePath)
    {
        $sheetName = "ThongTinSinhVien";
        $rowNum = 0;

        // $arrayTitleSheet = ["STT", "MSSV", "HỌ", "TÊN", "GIỚI TÍNH", "NGÀY SINH", "EMAIL", "CMND", "ĐIỂM TRÚNG TUYỂN", "LỚP", "NGÀNH", "BẬC ĐÀO TẠO", "HỆ ĐÀO TẠO", "BỘ MÔN", "KHOA"];
        $arrayTitleSheet = ["STT", "MSSV", "HỌ", "TÊN", "GIỚI TÍNH", "NGÀY SINH", "EMAIL", "CMND", "NGÀY CẤP", "NƠI CẤP", "ĐIỂM TRÚNG TUYỂN", "LỚP", "NGÀNH", "BẬC ĐÀO TẠO", "HỆ ĐÀO TẠO", "BỘ MÔN", "KHOA", "THƯỜNG TRÚ", "TẠM TRÚ", "DÂN TỘC", "TÔN GIÁO", "NGÀY VÀO ĐOÀN", "NƠI VÀO ĐOÀN", "NGÀY VÀO ĐẢNG", "NƠI VÀO ĐẢNG", "HỘ NGHÈO", "CẬN NGHÈO", "MỒ CÔI CHA", "MỒ CÔI MẸ", "CON THƯƠNG BINH", "CON LIỆT SỸ", "TÀN TẬT", "HỌ TÊN CHA", "NĂM SINH", "THƯỜNG TRÚ", "NGHỀ NGHIỆP", "NƠI LÀM VIỆC", "ĐIỆN THOẠI", "HỌ TÊN MẸ", "NĂM SINH", "THƯỜNG TRÚ", "NGHỀ NGHIỆP", "NƠI LÀM VIỆC", "ĐIỆN THOẠI", "HÌNH THẺ"];
        $arrayColumnWidth = array(  'A' => 5, 
                                    'B' => 12, 
                                    'C' => 20, 
                                    'D' => 8, 
                                    'E' => 10, 
                                    'F' => 13, 
                                    'G' => 34, 
                                    'H' => 15, 
                                    'I' => 24, 
                                    'J' => 10, 
                                    'K' => 30, 
                                    'L' => 16, 
                                    'M' => 16, 
                                    'N' => 20, 
                                    'O' => 30, 
                                    'P' => 20, 
                                    'Q' => 30, 
                                );

        Excel::create($fileName, function($excel) use ($sheetName, $arrayThongTinSinhVien, $arrayTitleSheet, $arrayColumnWidth, $rowNum) {

            $excel->sheet($sheetName, function($sheet) use($arrayThongTinSinhVien, $arrayTitleSheet, $arrayColumnWidth, $rowNum){
                
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

                // Set height for row
                $sheet->getRowDimension(65000)->setRowHeight(19);

                $STT = intval(0);

                foreach ($arrayThongTinSinhVien as $key => $SinhVien) {
                    $lyLich = $SinhVien->lylich->last();
                    $bacDaoTao = BacDaoTaoController::getBacDaoTao($SinhVien->idbacdaotao);
                    $heDaoTao = HeDaoTaoController::getHeDaoTao($SinhVien->idhedaotao);
                    if($lyLich)
                    {
                        $rowRecordSinhVien = [
                            ++$STT,
                            $SinhVien->mssv,
                            $SinhVien->hochulot,
                            $SinhVien->ten,
                            GioiTinhController::getGioiTinh($SinhVien->gioitinh)->tengioitinh,
                            Carbon::createFromFormat("Y-m-d", $SinhVien->ngaysinh)->format("d/m/Y"),
                            $SinhVien->email_agu,
                            $SinhVien->cmnd,
                            Carbon::createFromFormat("Y-m-d", $lyLich->ngaycapcmnd)->format("d/m/Y"),
                            $lyLich->noicapcmnd,
                            $SinhVien->diemtrungtuyen,
                            $SinhVien->tenlop,
                            $SinhVien->tennganh,
                            $bacDaoTao ? $bacDaoTao->tenbac : '',
                            $heDaoTao ? $heDaoTao->tenhe : '',
                            $SinhVien->tenbomon,
                            $SinhVien->tenkhoa,
                            $lyLich->hokhauthuongtru . $lyLich->thuongtru? (", " . $lyLich->thuongtru->tenxa . ", " . $lyLich->thuongtru->huyen->tenhuyen . ", " . $lyLich->thuongtru->huyen->tinh->tentinh):'',
                            $lyLich->hokhautamtru . $lyLich->tamtru? (", " . $lyLich->tamtru->tenxa . ", " . $lyLich->tamtru->huyen->tenhuyen . ", " . $lyLich->tamtru->huyen->tinh->tentinh):'',
                            $lyLich->dantoc? $lyLich->dantoc->tendantoc : '',
                            $lyLich->tongiao? $lyLich->tongiao->tentongiao : '',
                            $lyLich->ngayvaodoantncshcm?Carbon::createFromFormat("Y-m-d", $lyLich->ngayvaodoantncshcm)->format("d/m/Y"):'',
                            $lyLich->noivaodoantncshcm,
                            $lyLich->ngayvaodangcsvn?Carbon::createFromFormat("Y-m-d", $lyLich->ngayvaodangcsvn)->format("d/m/Y"):'',
                            $lyLich->noivaodangcsvn,
                            $lyLich->hongheo,
                            $lyLich->honcanngheo,
                            $lyLich->mocoicha,
                            $lyLich->mocoime,
                            $lyLich->conthuongbinh,
                            $lyLich->conlietsy,
                            $lyLich->tantat,

                            $lyLich->hotencha,
                            $lyLich->ngaysinhcha?Carbon::createFromFormat("Y-m-d", $lyLich->ngaysinhcha)->format("d/m/Y"):'',
                            $lyLich->hokhauthuongtrucha . $lyLich->thuongtrucha? (", " . $lyLich->thuongtrucha->tenxa . ", " . $lyLich->thuongtrucha->huyen->tenhuyen . ", " . $lyLich->thuongtrucha->huyen->tinh->tentinh):'',
                            $lyLich->nghenghiepcha,
                            $lyLich->noilamvieccha,
                            $lyLich->dienthoaicha,

                            $lyLich->hotenme,
                            $lyLich->ngaysinhme?Carbon::createFromFormat("Y-m-d", $lyLich->ngaysinhme)->format("d/m/Y"):'',
                            $lyLich->hokhauthuongtrume . $lyLich->thuongtrume? (", " . $lyLich->thuongtrume->tenxa . ", " . $lyLich->thuongtrume->huyen->tenhuyen . ", " . $lyLich->thuongtrume->huyen->tinh->tentinh):'',
                            $lyLich->nghenghiepme,
                            $lyLich->noilamviecme,
                            $lyLich->dienthoaime,
                            $SinhVien->hinhthe ? ('=HYPERLINK("' . substr(strrchr($SinhVien->hinhthe, '/'), 1) . '", "' . substr(strrchr($SinhVien->hinhthe, '/'), 1) . '")') : "Chưa có hình",
                        ];
                    }
                    else
                    {
                        $rowRecordSinhVien = [
                            ++$STT,
                            $SinhVien->mssv,
                            $SinhVien->hochulot,
                            $SinhVien->ten,
                            GioiTinhController::getGioiTinh($SinhVien->gioitinh)->tengioitinh,
                            Carbon::createFromFormat("Y-m-d", $SinhVien->ngaysinh)->format("d/m/Y"),
                            $SinhVien->email_agu,
                            $SinhVien->cmnd,
                            "",
                            "",
                            $SinhVien->diemtrungtuyen,
                            $SinhVien->tenlop,
                            $SinhVien->tennganh,
                            $bacDaoTao ? $bacDaoTao->tenbac : '',
                            $heDaoTao ? $heDaoTao->tenhe : '',
                            $SinhVien->tenbomon,
                            $SinhVien->tenkhoa,
                            "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
                            $SinhVien->hinhthe ? ('=HYPERLINK("' . substr(strrchr($SinhVien->hinhthe, '/'), 1) . '", "' . substr(strrchr($SinhVien->hinhthe, '/'), 1) . '")') : "Chưa có hình",
                        ];
                    }
                    
                    // Set record data for table
                    $sheet->row(++$rowNum, $rowRecordSinhVien);
                }
                
            });
        })->store($fileExtend, $storagePath);
    }
}
