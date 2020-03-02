<?php

namespace App\Http\Controllers;

use App\BanCanSu;
use Illuminate\Http\Request;
use App\HocKyNamHoc;
use App\Lop;
use App\ChucVuBanCanSu;
use App\SinhVien;
use App\UserGroup;
use App\User;
use App\Http\Requests\ServiceImportBanCanSuRequest;
use Excel;

class BanCanSuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $HocKyNamHoc_HienTai = HocKyNamHoc::where('idtrangthaihocky', '=', 2)->first();
        $DS_HocKyNamHoc = HocKyNamHoc::where('idtrangthaihocky', '<', 2)->take(8)->get();
        $DS_BanCanSu_HienTai = self::getDSBanCanSuDuongChuc($HocKyNamHoc_HienTai->id);
        return view('subadmin.bancansulist', ['DS_BanCanSu_HienTai' => $DS_BanCanSu_HienTai, 'HocKyNamHoc_HienTai' => $HocKyNamHoc_HienTai, 'DS_HocKyNamHoc' => $DS_HocKyNamHoc]);
    }

    public function adminindex($idHocKyHienChon = '')
    {
        $HocKyNamHoc_HienTai = HocKyNamHoc::where('idtrangthaihocky', '=', 2)->first();
        if($idHocKyHienChon=='')
            $hocKyNamHoc_HienChon = $HocKyNamHoc_HienTai;
        else
            $hocKyNamHoc_HienChon = HocKyNamHoc::find($idHocKyHienChon);

        $DS_HocKyNamHoc = HocKyNamHoc::where('idtrangthaihocky', '<', 2)->take(8)->get();

        $DS_BanCanSu = self::getDSBanCanSuDuongChuc($hocKyNamHoc_HienChon->id);
        return view('admin.bancansulist', ['DS_BanCanSu' => $DS_BanCanSu, 'hocKyNamHoc_HienChon'=>$hocKyNamHoc_HienChon, 'HocKyNamHoc_HienTai' => $HocKyNamHoc_HienTai, 'DS_HocKyNamHoc' => $DS_HocKyNamHoc]);

    }

    public function truongdonviindex($idHocKyHienChon = '')
    {
        $HocKyNamHoc_HienTai = HocKyNamHoc::where('idtrangthaihocky', '=', 2)->first();
        if($idHocKyHienChon=='')
            $hocKyNamHoc_HienChon = $HocKyNamHoc_HienTai;
        else
            $hocKyNamHoc_HienChon = HocKyNamHoc::find($idHocKyHienChon);
        $DS_HocKyNamHoc = HocKyNamHoc::where('idtrangthaihocky', '<', 2)->take(8)->get();
        $DS_BanCanSu = self::getDSBanCanSuDuongChuc($hocKyNamHoc_HienChon->id);
        return view('truongdonvi.bancansulist', ['DS_BanCanSu' => $DS_BanCanSu, 'hocKyNamHoc_HienChon'=>$hocKyNamHoc_HienChon, 'HocKyNamHoc_HienTai' => $HocKyNamHoc_HienTai, 'DS_HocKyNamHoc' => $DS_HocKyNamHoc]);
    }

    public function adminimport()
    {
        return view('admin.bancansuimport');
    }
    
    public function adminimportstore(ServiceImportBanCanSuRequest $request)
    {
		$MAX_ROW = 301;

    	if($request->hasFile('input_file')){
	        $path = $request->file('input_file')->getRealPath();

	        $reader = Excel::load($request->file('input_file')->getRealPath());

			$numRow = $reader->get()->count();
			$numRow = min($numRow, $MAX_ROW);

			// Lấy số dòng
            $numColumn = 6;
            $reader->takeRows($numRow);

            // Lấy & giới hạn số cột
            $reader->takeColumns($numColumn);

            $countRowExcel = 1;
            $arrayMessage = array('result' => true, 'message' => "" );

            foreach ($reader->toArray() as $key => $banCanSu) {
            	$countRowExcel++;

            	$resultMessage = self::ValidateBanCanSuImport($banCanSu);

            	if($resultMessage['result'] == false)
            	{
            		$arrayMessage['result'] = false;
					$arrayMessage['message'] .= "&#13; Dòng " . $countRowExcel . ": " . $resultMessage['message'];
            	}
            }

            if($arrayMessage['result'])
            {
                $idHocKyHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
            	foreach ($reader->toArray() as $key => $banCanSu) {
            		// Lưu ban cán sự
            		self::StoreBanCanSu($banCanSu, $idHocKyHienHanh);
				}
				return redirect()->route('admin_bancansu_import')->with('success', "Import thành công.");
            }
            else
            	return redirect()->route('admin_bancansu_import')->withInput()->with(['message'=>$arrayMessage['message']]);
	    }
	    else
	    	return redirect()->back()->with(['danger'=>"Không tìm thấy file để import.<br>Vui lòng refresh (hoặc nhấn F5) và chọn/nhập lại thông tin"]);
    }

    public function StoreBanCanSu($banCanSu, $idHocKy)
    {
        try {
            $sinhVien = ServiceSinhVienController::GetSinhVienByMSSV(trim($banCanSu['mssv']));
            $chucVu = ChucVuBanCanSuController::GetChucVuBanCanSuByTenChucVu(trim($banCanSu['chuc_vu']));

            $banCanSu = new BanCanSu();
            $banCanSu->hocky_namhoc_id = $idHocKy;
            $banCanSu->sinhvien_id = $sinhVien->id;
            $banCanSu->chucvubancansu_id = $chucVu->id;
            $banCanSu->save();
        } catch (\Throwable $th) {
        }
    }

    public function ValidateBanCanSuImport($banCanSu)
    {
    	$arrayMessage = array('result' => true, 'message' => "" );

    	// Kiểm tra mssv
    	if(empty(trim($banCanSu['mssv'])))
    	{
    		$arrayMessage['result'] = false;
    		$arrayMessage['message'] .= "Không có mssv; ";
    	}

    	// Kiểm tra chức vụ
    	if(empty(trim($banCanSu['chuc_vu'])))
    	{
    		$arrayMessage['result'] = false;
    		$arrayMessage['message'] .= "Không có chức vụ; ";
        }
        else
            // Kiểm tra chức vụ có trong danh mục hay không
            if(!self::isExistChucVu(trim($banCanSu['chuc_vu'])))
            {
                $arrayMessage['result'] = false;
    		    $arrayMessage['message'] .= "Chức vụ không khớp trong cơ sở dữ liệu; ";
            }
        
        if($arrayMessage['result'])
            if(self::isExistBanCanSu(trim($banCanSu['mssv']), trim($banCanSu['chuc_vu'])))
            {
                $arrayMessage['result'] = false;
    		    $arrayMessage['message'] .= "Sinh viên với chức vụ này đã có trong cơ sở dữ liệu; ";
            }

    	return $arrayMessage;
    }

    public function isExistChucVu($tenChucVu = '')
    {
        $chucVu = ChucVuBanCanSuController::GetChucVuBanCanSuByTenChucVu($tenChucVu);
        return $chucVu ? true : false;
    }

    public function isExistBanCanSu($mssv = '', $tenChucVu = '')
    {
        $idHocKyHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        $sinhVien = ServiceSinhVienController::GetSinhVienByMSSV($mssv);
        $chucVu = ChucVuBanCanSuController::GetChucVuBanCanSuByTenChucVu($tenChucVu);

        $banCanSu = self::GetBanCanSu($idHocKyHienHanh, $sinhVien?$sinhVien->id:'', $chucVu?$chucVu->id:'');

        return $banCanSu ? true : false;
    }

    public static function getDSBanCanSuDuongChuc($idHocKyNamHoc)
    {
        $DS_BanCanSu = BanCanSu::where('duongchuc', '=', 1)
            -> where('bancansu.hocky_namhoc_id', '=', $idHocKyNamHoc)
            -> leftjoin('sinhvien', 'sinhvien.id', '=', 'bancansu.sinhvien_id')
            -> leftjoin('lop', 'lop.id', '=', 'sinhvien.lop_id')
            -> leftjoin('chucvubancansu', 'chucvubancansu.id', '=', 'bancansu.chucvubancansu_id')
            -> select('sinhvien.*', 'bancansu.hocky_namhoc_id', 'lop.tenlop', 'chucvubancansu.tenchucvubancansu')
            -> orderBy('lop.tenlop', 'asc')
            -> get();
        return $DS_BanCanSu;
    }

    public static function getDSBanCanSu($idHocKyNamHoc)
    {
        $DS_BanCanSu = BanCanSu::where('bancansu.hocky_namhoc_id', '=', $idHocKyNamHoc)
            -> leftjoin('sinhvien', 'sinhvien.id', '=', 'bancansu.sinhvien_id')
            -> leftjoin('lop', 'lop.id', '=', 'sinhvien.lop_id')
            -> leftjoin('chucvubancansu', 'chucvubancansu.id', '=', 'bancansu.chucvubancansu_id')
            -> select('sinhvien.*', 'bancansu.hocky_namhoc_id', 'lop.tenlop', 'chucvubancansu.tenchucvubancansu')
            -> groupBy('lop.tenlop')
            -> get();
        return $DS_BanCanSu;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $DS_HocKyNamHoc = HocKyNamHoc::where('idtrangthaihocky', '>', 1)->take(4)->get();
        $DS_Lop = Lop::leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date("Y"))
            -> select('lop.*')
            -> orderBy('lop.tenlop', 'asc')
            -> get();

        $DS_ChucVuBanCanSu = ChucVuBanCanSu::all();

        return view('subadmin.bancansu_add', ['DS_HocKyNamHoc' => $DS_HocKyNamHoc, 'DS_Lop' => $DS_Lop, 'DS_ChucVuBanCanSu' => $DS_ChucVuBanCanSu]);
    }

    public function admincreate()
    {
        $DS_HocKyNamHoc = HocKyNamHoc::where('idtrangthaihocky', '>', 1)->take(4)->get();
        $DS_Lop = Lop::leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date("Y"))
            -> select('lop.*')
            -> orderBy('lop.tenlop', 'asc')
            -> get();

        $DS_ChucVuBanCanSu = ChucVuBanCanSu::all();

        return view('admin.bancansuadd', ['DS_HocKyNamHoc' => $DS_HocKyNamHoc, 'DS_Lop' => $DS_Lop, 'DS_ChucVuBanCanSu' => $DS_ChucVuBanCanSu]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idHocKyNamHoc = $request->selected_idhockynamhhoc;
        $idLop = $request->selected_idlop;

        // 1. Remove monitor list at semeter and class
        self::DeleteMonitorListAtSemeterClass($idHocKyNamHoc, $idLop);

        // 2. Remove monitor group at semeter and class
        self::DeleteUserGroup($idLop);

        // 3. Add monitor list new
        foreach ($request->toArray() as $key => $value) {
            $arrayNameCheckbox = explode("_", $key);
            if($arrayNameCheckbox[0] == "chk" && count($arrayNameCheckbox) == 3)
            {
                try {
                    $banCanSu = new BanCanSu();
                    $banCanSu->hocky_namhoc_id = $idHocKyNamHoc;
                    $banCanSu->sinhvien_id = $arrayNameCheckbox[1];
                    $banCanSu->chucvubancansu_id = $arrayNameCheckbox[2];
                    $banCanSu->thoigianbatdau = date("Y-m-d");
                    $banCanSu->duongchuc = 1;
                    $banCanSu->save();

                    $userGroup = new UserGroup();
                    $userGroup->idUser = User::where('cbgvsv_id', '=', $banCanSu->sinhvien_id)->where('idloaiuser', '=', 3)->first()->id;
                    $userGroup->idGroup = 7;
                    $userGroup->save();
                } catch (Exception $e) {
                    
                }
            }
        }

        return redirect()->route('subadmin_bancansu_add')->with('success', "Lưu thành công");
    }

    public function adminstore(Request $request)
    {
        $idHocKyNamHoc = $request->selected_idhockynamhhoc;
        $idLop = $request->selected_idlop;

        // 1. Remove monitor list at semeter and class
        self::DeleteMonitorListAtSemeterClass($idHocKyNamHoc, $idLop);

        // 2. Remove monitor group at semeter and class
        self::DeleteUserGroup($idLop);

        // 3. Add monitor list new
        foreach ($request->toArray() as $key => $value) {
            $arrayNameCheckbox = explode("_", $key);
            if($arrayNameCheckbox[0] == "chk" && count($arrayNameCheckbox) == 3)
            {
                try {
                    $banCanSu = new BanCanSu();
                    $banCanSu->hocky_namhoc_id = $idHocKyNamHoc;
                    $banCanSu->sinhvien_id = $arrayNameCheckbox[1];
                    $banCanSu->chucvubancansu_id = $arrayNameCheckbox[2];
                    $banCanSu->thoigianbatdau = date("Y-m-d");
                    $banCanSu->duongchuc = 1;
                    $banCanSu->save();

                    $userGroup = new UserGroup();
                    $userGroup->idUser = User::where('cbgvsv_id', '=', $banCanSu->sinhvien_id)->where('idloaiuser', '=', 3)->first()->id;
                    $userGroup->idGroup = 7;
                    $userGroup->save();
                } catch (Exception $e) {
                    
                }
            }
        }

        return redirect()->route('admin_bancansu_create')->with('success', "Lưu thành công");
    }

    public function DeleteMonitorListAtSemeterClass($idHocKyNamHoc, $idLop)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->select('id')->get();
        if($DS_SinhVien)
            $DS_SinhVien = $DS_SinhVien->toArray();

        try {
            BanCanSu::where('hocky_namhoc_id', '=', $idHocKyNamHoc)
            -> whereIn('sinhvien_id', $DS_SinhVien)
            -> delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function DeleteUserGroup($idLop)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->select('id')->get();
        if($DS_SinhVien)
            $DS_SinhVien = $DS_SinhVien->toArray();

        $DS_SinhVien_User = User::whereIn('cbgvsv_id', $DS_SinhVien)
            -> where('idloaiuser', '=', 3)
            -> select('id')->get();
        if($DS_SinhVien_User)
            $DS_SinhVien_User = $DS_SinhVien_User->toArray();

        $DS_BanCanSu_User = BanCanSu::whereIn('sinhvien_id', $DS_SinhVien)
            -> join('users', 'users.cbgvsv_id', '=', 'bancansu.sinhvien_id')
            -> where('users.idloaiuser', '=', 3)
            -> select('users.id')->get();

        if($DS_BanCanSu_User)
            $DS_BanCanSu_User = $DS_BanCanSu_User->toArray();
        
        try {
            $DS_UserGroup = UserGroup::where('idGroup', '=', 7)
            -> whereNotIn('idUser', $DS_BanCanSu_User)
            -> whereIn('idUser', $DS_SinhVien_User)
            -> delete();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BanCanSu  $banCanSu
     * @return \Illuminate\Http\Response
     */
    public function show(BanCanSu $banCanSu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BanCanSu  $banCanSu
     * @return \Illuminate\Http\Response
     */
    public function edit(BanCanSu $banCanSu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BanCanSu  $banCanSu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BanCanSu $banCanSu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BanCanSu  $banCanSu
     * @return \Illuminate\Http\Response
     */
    public function destroy(BanCanSu $banCanSu)
    {
        //
    }

    public function getDSSinhVienTheoLop($idLop)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->get();
        $DS_ChucVuBanCanSu = ChucVuBanCanSuController::getDanhSachChucVuBanCanSu($idLop);


        if($DS_SinhVien)
        {
            $DS_SinhVien = $DS_SinhVien->toArray();
            foreach ($DS_SinhVien as $key => $value) {
                $DS_SinhVien[$key]['bithu'] = 1;
            }
            print_r($DS_SinhVien);
        }
        else
            return $DS_SinhVien;
    }

    public function getDSSinhVienTheoLopTheoHocKy($idLop, $idHocKyNamHoc)
    {
        $DS_SinhVien = SinhVien::where('lop_id', '=', $idLop)->get();
        $DS_ChucVuBanCanSu = ChucVuBanCanSu::all();


        if($DS_SinhVien)
        {
            // $DS_SinhVien = $DS_SinhVien->toArray();
            foreach ($DS_SinhVien as $key => $value) {
                foreach ($DS_ChucVuBanCanSu as $keyChucVuBanCanSu => $valueChucVuBanCanSu) {
                    // echo "<br><br>".$value->mssv . " - " . $value->hochulot . " " . $value->ten;
                    // print_r(count(self::getBanCanSuTheo_HocKy_SinhVien_ChucVu($idHocKyNamHoc, $value->id, $valueChucVuBanCanSu->id)));
                    if(count(self::getBanCanSuTheo_HocKy_SinhVien_ChucVu($idHocKyNamHoc, $value->id, $valueChucVuBanCanSu->id)) > 0)
                    {
                        $DS_SinhVien[$key][$keyChucVuBanCanSu] = "1";
                    }
                    else
                        $DS_SinhVien[$key][$keyChucVuBanCanSu] = "0";
                }
            }
            return $DS_SinhVien->toArray();
        }
        else
            return $DS_SinhVien;
    }

    public function getBanCanSuTheo_HocKy_SinhVien_ChucVu($idhockynamhoc='', $idsinhvien='', $idchucvu='')
    {
        $BanCanSu = BanCanSu::where('hocky_namhoc_id', '=', $idhockynamhoc)
            -> where('sinhvien_id', '=', $idsinhvien)
            -> where('chucvubancansu_id', '=', $idchucvu)
            -> get();

        if($BanCanSu)
            return $BanCanSu->toArray();
        return $BanCanSu;
    }

    public static function isBanCanSu($idSinhVien='')
    {
        $banCanSu = BanCanSu::where('sinhvien_id', '=', $idSinhVien)
            -> where('duongchuc', '=', 1)
            -> get();
        return count($banCanSu) ? true : false;
    }

    public function GetBanCanSu($idHocKy = '', $idSinhVien = '', $idChucVuBanCanSu = '')
    {
        $banCanSu = BanCanSu::where('hocky_namhoc_id', '=', $idHocKy)
            -> where('sinhvien_id', '=', $idSinhVien)
            -> where('chucvubancansu_id', '=', $idChucVuBanCanSu)
            -> first();
        
        return $banCanSu;
    }
}
