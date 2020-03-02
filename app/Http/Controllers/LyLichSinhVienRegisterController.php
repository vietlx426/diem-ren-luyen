<?php

namespace App\Http\Controllers;

use App\LyLichSinhVienRegister;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LyLichSinhVienRegisterRequest;
use App\AnhChiEmSinhVienRegister;
use File;
use App\Nganh;
use App\Lop;
use App\DanToc;
use App\TonGiao;
use App\MoiQuanHe;

class LyLichSinhVienRegisterController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $DanhSach_Nganh = Nganh::all();
        $DanhSach_Lop = Lop::all();
        $DanhSach_DanToc = DanToc::all()->sortBy('tendantoc');
        $DanhSach_TonGiao = TonGiao::all()->sortBy('tentongiao');
        $DanhSach_MoiQuanHe = MoiQuanHe::all();

        return view('sinhvien.profile_register_add', ['DanhSach_Nganh' => $DanhSach_Nganh, 'DanhSach_Lop' => $DanhSach_Lop, 'DanhSach_DanToc' => $DanhSach_DanToc, 'DanhSach_TonGiao' => $DanhSach_TonGiao, 'DanhSach_MoiQuanHe' => $DanhSach_MoiQuanHe]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LyLichSinhVienRegisterRequest $request)
    {
        // Kiểm tra số cmnd đã tồn tại chưa?
        if(!$this::isExistCMND($request->cmnd))
        {

            $LyLichSinhVienRegister = new LyLichSinhVienRegister();

            $LyLichSinhVienRegister->mssv = $request->mssv;
            $LyLichSinhVienRegister->holot = $request->holot;
            $LyLichSinhVienRegister->ten = $request->ten;
            $LyLichSinhVienRegister->gioitinh = $request->gioitinh;
            $LyLichSinhVienRegister->lop_id = $request->lop;
            $LyLichSinhVienRegister->khoahoc_id = LopController::getKhoaHocID($request->lop);
            $LyLichSinhVienRegister->nganh_id = $request->nganh;
            $LyLichSinhVienRegister->bomon_id = NganhController::getBoMonID($request->nganh);
            $LyLichSinhVienRegister->khoa_id = BoMonController::getKhoaID($LyLichSinhVienRegister->bomon_id);
            $LyLichSinhVienRegister->diemtrungtuyendaihoc = $request->diemtrungtuyen;
            $LyLichSinhVienRegister->ngaysinh = $request->namsinh;
            $LyLichSinhVienRegister->noisinh = $request->noisinh;
            $LyLichSinhVienRegister->cmnd = $request->cmnd;
            $LyLichSinhVienRegister->ngaycapcmnd = $request->ngaycapcmnd;
            $LyLichSinhVienRegister->noicap = $request->noicapcmnd;
            $LyLichSinhVienRegister->hokhauthuongtru = $request->hokhauthuongtru;
            $LyLichSinhVienRegister->dantoc_id = $request->dantoc;
            $LyLichSinhVienRegister->tongiao_id = $request->tongiao;
            $LyLichSinhVienRegister->email = $request->email;
            $LyLichSinhVienRegister->dienthoai = $request->dienthoai;
            $LyLichSinhVienRegister->ngayvaodoantncshcm = $request->ngayvaodoan;
            $LyLichSinhVienRegister->noivaodoantncshcm = $request->vaodoantai;
            $LyLichSinhVienRegister->ngayvaodangcsvn = $request->ngayvaodang;
            $LyLichSinhVienRegister->noivaodangcsvn = $request->vaodangtai;

            // Thông tin cha
            $LyLichSinhVienRegister->hotencha = $request->cha_hoten;
            $LyLichSinhVienRegister->namsinhcha = $request->cha_namsinh;
            $LyLichSinhVienRegister->dantoc_idcha = $request->cha_dantoc;
            $LyLichSinhVienRegister->hokhauthuongtrucha = $request->cha_hokhauthuongtru;
            $LyLichSinhVienRegister->nghenghiepcha = $request->cha_nghenghiep;
            $LyLichSinhVienRegister->dienthoaicha = $request->cha_dienthoai;

            // Thông tin mẹ
            $LyLichSinhVienRegister->hotenme = $request->me_hoten;
            $LyLichSinhVienRegister->namsinhme = $request->me_namsinh;
            $LyLichSinhVienRegister->dantoc_idme = $request->me_dantoc;
            $LyLichSinhVienRegister->hokhauthuongtrume = $request->me_hokhauthuongtru;
            $LyLichSinhVienRegister->nghenghiepme = $request->me_nghenghiep;
            $LyLichSinhVienRegister->dienthoaime = $request->me_dienthoai;
            
            //Save
            $LyLichSinhVienRegister->save();

            // Thông tin Anh, Chị, Em ruột
            for ($i=0; $i < count($request->anhchiem_inp_hoten); $i++) { 
                $AnhChiEmSinhVienRegister = new AnhChiEmSinhVienRegister();

                $AnhChiEmSinhVienRegister->lylichsinhvienregister_id = $LyLichSinhVienRegister->id;
                $AnhChiEmSinhVienRegister->moiquanhe_id = $request->anhchiem_sel_moiquanhe[$i];
                $AnhChiEmSinhVienRegister->hoten = $request->anhchiem_inp_hoten[$i];
                $AnhChiEmSinhVienRegister->namsinh = $request->anhchiem_dat_namsinh[$i];
                $AnhChiEmSinhVienRegister->nghenghiep = $request->anhchiem_inp_nghenghiep[$i];
                $AnhChiEmSinhVienRegister->noio = $request->anhchiem_inp_noio[$i];
                $AnhChiEmSinhVienRegister->save();
            }

            // Upload picture profile
            if($request->hasFile('picprofile'))
            {
                $filename = 'picprofile_'.$LyLichSinhVienRegister->id;
                try {
                    $this::UploadPicture($request->file('picprofile'), $filename);
                    $LyLichSinhVienRegister->picture = $filename;
                    $LyLichSinhVienRegister->save();    
                } catch (Exception $e) {
                    
                }
                
            }

            return redirect()->route('profilesv')->withInput()->with('success', '- Đã lưu thành công!');
        }
        else
        {
            return redirect()->route('profilesv')->withInput()->with('warning', '- Số chứng minh nhân dân đã tồn tại. Vui lòng kiểm tra lại số chứng minh nhân dân!');
        }

        // return redirect()->route('profilesv')->with('success', '- Đã lưu thông tin thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LyLichSinhVienRegister  $lyLichSinhVienRegister
     * @return \Illuminate\Http\Response
     */
    public function show(LyLichSinhVienRegister $lyLichSinhVienRegister)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LyLichSinhVienRegister  $lyLichSinhVienRegister
     * @return \Illuminate\Http\Response
     */
    public function edit(LyLichSinhVienRegister $lyLichSinhVienRegister)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LyLichSinhVienRegister  $lyLichSinhVienRegister
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LyLichSinhVienRegister $lyLichSinhVienRegister)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LyLichSinhVienRegister  $lyLichSinhVienRegister
     * @return \Illuminate\Http\Response
     */
    public function destroy(LyLichSinhVienRegister $lyLichSinhVienRegister)
    {
        //
    }

    /*
    * ------ Upload picture to images/upload/profile -----*
    */
    public static function UploadPicture($img, $filename)
    {
        if(!is_null($img))
        {
            $ext = $img->getClientOriginalExtension();
            $img->move('images/upload/profile', $filename.'.'.$ext);
        }
    }

    // Kiểm tra sự tồn tại của số cmnd
    public function isExistCMND($cmnd)
    {
        $CMND = LyLichSinhVienRegister::where('cmnd', '=', $cmnd)->get();
        if(count($CMND) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
