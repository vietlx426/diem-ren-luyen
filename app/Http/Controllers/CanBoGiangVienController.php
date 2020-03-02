<?php

namespace App\Http\Controllers;

use App\CanBoGiangVien;
use Illuminate\Http\Request;
use App\GioiTinh;
use App\HocVi;
use App\HocHam;
use App\Khoa;
use App\BoMon;
use App\Tinh;
use App\DanToc;
use App\TonGiao;
use App\LoaiNgoaiNgu;
use App\LoaiCBGV;
use App\User;
use Excel;
use App\Http\Requests\CanBoGiangVienRequest;

class CanBoGiangVienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $DS_CBGV = CanBoGiangVien::all();
        return view('subadmin.stafflist', ['DS_CBGV' => $DS_CBGV]);
    }

    public function adminindex()
    {
        $DS_CBGV = CanBoGiangVien::leftjoin('bomon', 'bomon.id', '=', 'canbogiangvien.bomonto_id')
            -> leftjoin('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            -> orderBy('khoa.tenkhoa')
            -> orderBy('bomon.tenbomon')
            -> orderBy('canbogiangvien.ten')
            -> select('canbogiangvien.*')
            -> get();
        return view('admin.canbogiangvien', ['DS_CBGV' => $DS_CBGV]);
    }

    public function subadmin_index()
    {
        $dsCanBoGiangVien = CanBoGiangVien::orderBy('ten', 'asc')->get();
        return view('subadmin.canbogiangvienlist',['dsCanBoGiangVien' => $dsCanBoGiangVien]);
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

    public function admincreate()
    {
        $DS_GioiTinh = GioiTinh::all();
        $DS_Khoa = Khoa::all();
        $DS_BoMon = BoMon::all();
        $DS_LoaiCBGV = LoaiCBGV::all();

        return view('admin.canbogiangvien_create', ['DS_GioiTinh' => $DS_GioiTinh, 'DS_Khoa' => $DS_Khoa, 'DS_BoMon'=>$DS_BoMon, 'DS_LoaiCBGV' => $DS_LoaiCBGV]);
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

    public function storeCanBoGiangVien($request='')
    {
        if($request)
        {
            try {

                $canBoGiangVien = new CanBoGiangVien();
                $canBoGiangVien->macanbogiangvien = $request->macanbogiangvien;
                $canBoGiangVien->hochulot = $request->hochulot;
                $canBoGiangVien->ten = $request->ten;
                $canBoGiangVien->gioitinh_id = $request->gioitinh;
                $canBoGiangVien->dienthoaicanhan = $request->dienthoaicanhan;
                $canBoGiangVien->email = $request->email;
                $canBoGiangVien->bomonto_id = $request->bomonto;
                // $canBoGiangVien->bophancongtac = $request->bophancongtac;
                $canBoGiangVien->loaicbgv_id = $request->loaicbgv;
                $canBoGiangVien->ghichu = $request->ghichu;
                $canBoGiangVien->save();
                return $canBoGiangVien;
            } catch (Exception $e) {
                return "";
            }
        }
        else
            return "";
    }

    public function storeUser($canBoGiangVien='')
    {
        try {
            $user = new User();
            $user->name = $canBoGiangVien->hochulot . " " . $canBoGiangVien->ten;
            $user->email = $canBoGiangVien->email;
            $user->password = bcrypt($canBoGiangVien->email);
            $user->cbgvsv_id = $canBoGiangVien->id;
            $user->idloaiuser = 1;
            $user->idtrangthaiuser = 1;
            $user->save();
        } catch (Exception $e) {
            
        }
    }

    public function adminstore(CanBoGiangVienRequest $request)
    {
        try {
            $resultValidate = self::ValidateStore($request);
            if($resultValidate['result'])
            {
                $canBoGiangVien = self::storeCanBoGiangVien($request);
                self::storeUser($canBoGiangVien);

                return redirect()->route('admin_canbogiangvien')->with('success', "Lưu thành công.");
            }
            else
                return redirect()->back()->withInput()->with('warning', $resultValidate['messages']);
        } catch (Exception $e) {
            return redirect()->route('admin_canbogiangvien')->with('warning', "Lưu không thành công. Vui lòng thực hiện lại.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CanBoGiangVien  $canBoGiangVien
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $CBGV = CanBoGiangVien::find($id);
        $DS_GioiTinh = GioiTinh::all();
        $DS_HocVi = HocVi::all();
        $DS_HocHam = HocHam::all();
        $DS_Khoa = Khoa::all();
        $DS_Tinh = Tinh::all();
        $DS_DanToc = DanToc::all();
        $DS_TonGiao = TonGiao::all();
        $DS_NgoaiNgu = LoaiNgoaiNgu::all();
        $DS_LoaiCBGV = LoaiCBGV::all();

        return view('subadmin.staffedit', ['CBGV' => $CBGV, 'DS_GioiTinh' => $DS_GioiTinh, 'DS_HocVi' => $DS_HocVi, 'DS_HocHam' => $DS_HocHam, 'DS_Khoa' => $DS_Khoa, 'DS_Tinh' => $DS_Tinh, 'DS_DanToc' => $DS_DanToc, 'DS_TonGiao' => $DS_TonGiao, 'DS_NgoaiNgu' => $DS_NgoaiNgu, 'DS_LoaiCBGV' => $DS_LoaiCBGV]);
    }

    public function adminshow($id)
    {
        $CBGV = CanBoGiangVien::find($id);
        $DS_GioiTinh = GioiTinh::all();
        
        $DS_Khoa = Khoa::all();
        $DS_BoMon = BoMon::all();
        
        $DS_LoaiCBGV = LoaiCBGV::all();

        return view('admin.canbogiangvien_edit', ['CBGV' => $CBGV, 'DS_GioiTinh' => $DS_GioiTinh, 'DS_Khoa' => $DS_Khoa, 'DS_BoMon'=>$DS_BoMon, 'DS_LoaiCBGV' => $DS_LoaiCBGV]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CanBoGiangVien  $canBoGiangVien
     * @return \Illuminate\Http\Response
     */
    public function edit(CanBoGiangVien $canBoGiangVien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CanBoGiangVien  $canBoGiangVien
     * @return \Illuminate\Http\Response
     */

    public function updateCanBoGiangVien($idStaff='', $request='')
    {
        try {
            $canBoGiangVien = CanBoGiangVien::find($idStaff);
            $canBoGiangVien->macanbogiangvien = $request->macanbogiangvien;
            $canBoGiangVien->hochulot = $request->hochulot;
            $canBoGiangVien->ten = $request->ten;
            $canBoGiangVien->gioitinh_id = $request->gioitinh;
            $canBoGiangVien->dienthoaicanhan = $request->dienthoaicanhan;
            $canBoGiangVien->email = $request->email;
            $canBoGiangVien->bomonto_id = $request->bomonto;
            // $canBoGiangVien->bophancongtac = $request->bophancongtac;
            $canBoGiangVien->loaicbgv_id = $request->loaicbgv;
            $canBoGiangVien->ghichu = $request->ghichu;
            $canBoGiangVien->save();
            return $canBoGiangVien;
        } catch (Exception $e) {
            return "";
        }
    }

    public function UpdateUser($canBoGiangVien='')
    {
        try {
            $user = User::where('cbgvsv_id', '=', $canBoGiangVien->id)
                -> where('idloaiuser', '=', 1)
                -> first();
            if($user)
            {
                $user->name = $canBoGiangVien->hochulot . " " . $canBoGiangVien->ten;
                $user->email = $canBoGiangVien->email;
                $user->save();
            }
            else
                self::storeUser($canBoGiangVien);
        } catch (Exception $e) {
            
        }
    }

    public function update(CanBoGiangVienRequest $request)
    {
        $canBoGiangVien = CanBoGiangVien::find($request->id);
        if($canBoGiangVien)
        {
            try {
                $idCanBoGiangVien = $canBoGiangVien->id;
                $resultValidate = self::ValidateUpdate($idCanBoGiangVien, $request);

                if($resultValidate['result'])
                {
                    $canBoGiangVien = self::updateCanBoGiangVien($idCanBoGiangVien, $request);
                    self::updateUser($canBoGiangVien);

                    return redirect()->route('admin_canbogiangvien')->with('success', "Lưu thành công.");
                }
                else
                    return redirect()->back()->withInput()->with('warning', $resultValidate['messages']);
                
            } catch (Exception $e) {
                return redirect()->route('admin_canbogiangvien_edit', ['id'=>$request->id])->with('warning', "Lưu (cập nhật) không thành công. Vui lòng thực hiện lại.");
            }
        }
        else
            return redirect()->route('admin_canbogiangvien')->with('warning', "Lưu (cập nhật) không thành công. Vui lòng thực hiện lại.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CanBoGiangVien  $canBoGiangVien
     * @return \Illuminate\Http\Response
     */
    public function destroy(CanBoGiangVien $canBoGiangVien)
    {
        //
    }

    // Function my define
    public static function CanBoGiangVienCount()
    {
        return count(CanBoGiangVien::all());
    }

    public static function DanhSachCanBoGiangVien()
    {
        return CanBoGiangVien::orderBy('ten', 'asc')->get();
    }

    public function ValidateStore($request='')
    {
        if($request)
        {
            $arrayResult = array('result' => true, 'messages' => "");

            // 1. Check is exist id staff
            if(self::isExistCodeStaff($request->macanbogiangvien))
            {
                $arrayResult['result'] = false;
                $arrayResult['messages'] .= "<br>Mã cán bộ giảng viên đã tồn tại.";
            }

            // 2. Check is exist email staff
            if(self::isExistEmailStaff($request->email))
            {
                $arrayResult['result'] = false;
                $arrayResult['messages'] .= "<br>Email đã tồn tại trong danh sách cán bộ giảng viên.";
            }

            // 3. Check is exist email user
            if(self::isExistEmailUser($request->email))
            {
                $arrayResult['result'] = false;
                $arrayResult['messages'] .= "<br>Email đã tồn tại trong danh sách người dùng (user).";
            }

            return $arrayResult;
        }
        else
            return array('result'=>false, 'messages'=> "Không có dữ liệu");
    }

    public function ValidateUpdate($idStaff='', $request='')
    {
        if($request)
        {
            $arrayResult = array('result' => true, 'messages' => "");

            // 1. Check is exist id staff
            if(self::isExistCodeStaffUpdate($idStaff, $request->macanbogiangvien))
            {
                $arrayResult['result'] = false;
                $arrayResult['messages'] .= "<br>Mã cán bộ giảng viên đã tồn tại.";
            }

            // 2. Check is exist email staff
            if(self::isExistEmailStaffUpdate($idStaff, $request->email))
            {
                $arrayResult['result'] = false;
                $arrayResult['messages'] .= "<br>Email đã tồn tại trong danh sách cán bộ giảng viên.";
            }

            // 3. Check is exist email user
            if(self::isExistEmailUserUpdate($idStaff, $request->email))
            {
                $arrayResult['result'] = false;
                $arrayResult['messages'] .= "<br>Email đã tồn tại trong danh sách người dùng (user).";
            }

            return $arrayResult;
        }
        else
            return array('result'=>false, 'messages'=> "Không có dữ liệu");
    }

    public function isExistCodeStaff($codeStaff='')
    {
        $canBoGiangVien = CanBoGiangVien::where('macanbogiangvien', '=', $codeStaff)->get();
        return count($canBoGiangVien);
    }

    public function isExistCodeStaffUpdate($idStaff='', $codeStaff='')
    {
        $canBoGiangVien = CanBoGiangVien::where('macanbogiangvien', '=', $codeStaff)
            -> where('id', '<>', $idStaff)
            -> get();
        
        return count($canBoGiangVien);
    }

    public function isExistEmailStaff($email='')
    {
        $canBoGiangVien = CanBoGiangVien::where('email', '=', $email)->get();
        return count($canBoGiangVien);
    }

    public function isExistEmailStaffUpdate($idStaff='', $email='')
    {
        $canBoGiangVien = CanBoGiangVien::where('email', '=', $email)
            -> where('id', '<>', $idStaff)
            -> get();
        return count($canBoGiangVien);
    }

    public function isExistEmailUser($email='')
    {
        $user = User::where('email', '=', $email)->get();
        return count($user);
    }

    public function isExistEmailUserUpdate($idStaff='', $email='')
    {
        $user = User::where('email', '=', $email)
            -> where('cbgvsv_id', '<>', $idStaff)
            -> where('idloaiuser', '=', 1)
            -> get();
        return count($user);
    }

    public function ImportCanBoGiangVien()
    {
    	return view('admin.canbogiangvien_import');
    }

    public function AdminStoreImportCanBoGiangVien(Request $request)
    {
		$MAX_ROW = 10000;

    	if($request->hasFile('input_file')){
	        $path = $request->file('input_file')->getRealPath();

	        $reader = Excel::load($request->file('input_file')->getRealPath());

			$numRow = $reader->get()->count();
			$numRow = min($numRow, $MAX_ROW);

			// Lấy số dòng
            $numColumn = 7;
            $reader->takeRows($numRow);

            // Lấy & giới hạn số cột
            $reader->takeColumns($numColumn);

            $countRowExcel = 1;
            $arrayMessage = array('result' => true, 'message' => "" );

            // foreach ($reader->toArray() as $key => $banCanSu) {
            // 	$countRowExcel++;

            // 	$resultMessage = self::ValidateBanCanSuImport($banCanSu);

            // 	if($resultMessage['result'] == false)
            // 	{
            // 		$arrayMessage['result'] = false;
			// 		$arrayMessage['message'] .= "&#13; Dòng " . $countRowExcel . ": " . $resultMessage['message'];
            // 	}
            // }

            if($arrayMessage['result'])
            {
            	foreach ($reader->toArray() as $key => $canBoGiangVien) {
            		// Lưu cán bộ giảng viên
            		self::StoreImportCanBoGiangVien($canBoGiangVien);
				}
				return redirect()->route('admin_canbogiangvien_import')->with('success', "Import thành công.");
            }
            else
            	return redirect()->route('admin_canbogiangvien_import')->withInput()->with(['message'=>$arrayMessage['message']]);
	    }
	    else
	    	return redirect()->back()->with(['danger'=>"Không tìm thấy file để import.<br>Vui lòng refresh (hoặc nhấn F5) và chọn/nhập lại thông tin"]);
    }

    public function StoreImportCanBoGiangVien($CBGV)
    {
        $canBoGiangVien = new CanBoGiangVien();
        $canBoGiangVien->macanbogiangvien = $CBGV['ma'];
        $canBoGiangVien->hochulot = $CBGV['hochulot'];
        $canBoGiangVien->ten = $CBGV['ten'];
        $canBoGiangVien->gioitinh_id = $CBGV['gioitinh'];
        $canBoGiangVien->dienthoaicanhan = $CBGV['dienthoai'];
        $canBoGiangVien->email = $CBGV['email'];
        $canBoGiangVien->bomonto_id = $CBGV['mabomon'];
        $canBoGiangVien->save();
        self::storeUser($canBoGiangVien);
        return "";
    }

}
