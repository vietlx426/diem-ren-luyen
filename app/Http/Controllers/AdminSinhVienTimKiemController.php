<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Khoa;
use App\Nganh;
use App\Lop;
use App\GioiTinh;
use App\SinhVien;
use App\User;
use App\Http\Requests\SinhVienRequest;

class AdminSinhVienTimKiemController extends Controller
{
    public function index()
    {
		$idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
		$DanhSach_Khoa = Khoa::where('loaikhoaphong_id', '=', 1)-> orderBy('tenkhoa', 'asc')->get();
		return view('admin.sinhvien_timkiem', ['DanhSach_Khoa' => $DanhSach_Khoa, 'idHocKyNamHocHienHanh'=>$idHocKyNamHocHienHanh]);
    }
    

    public function subadmin_index()
    {
        $DanhSach_Khoa = Khoa::orderBy('tenkhoa', 'asc')->get();
        return view('subadmin.sinhvientimkiem', ['DanhSach_Khoa' => $DanhSach_Khoa]);
	}
	
	public function truongdonviindex()
    {
		$DanhSach_Khoa = Khoa::where('loaikhoaphong_id', '=', 1)-> orderBy('tenkhoa', 'asc')->get();
		return view('truongdonvi.sinhvien_timkiem', ['DanhSach_Khoa' => $DanhSach_Khoa]);
    }

    public function create()
    {
    	$DS_GioiTinh = GioiTinh::all();
    	$DS_Lop = Lop::leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
    		-> where('khoahoc.namketthuc', '>=', date("Y"))
    		-> select('lop.*')
    		-> orderBy('lop.tenlop', 'asc')
    		-> get();
    	return view('admin.sinhvien_create', ['DS_GioiTinh'=>$DS_GioiTinh, 'DS_Lop'=>$DS_Lop]);
    }

    public function store(SinhVienRequest $request)
    {

    	print_r($request->toArray());
    	if(self::isExistMSSV($request->mssv))
    	{
    		return redirect()->back()->with('warning', "MSSV đã tồn tại.");
    	}
    	else
    		if(self::isExistEmail($request->email))
    		{
    			return redirect()->back()->with('warning', "Email đã tồn tại.");
    		}
    		else
    		{
    			try {
    				$sinhVien = new SinhVien();
    				$sinhVien->mssv = $request->mssv;
    				$sinhVien->hochulot = $request->hochulot;
    				$sinhVien->ten = $request->ten;
    				$sinhVien->gioitinh = $request->gioitinh;
    				$sinhVien->email_agu = $request->email;
    				$sinhVien->ngaysinh = date('Y-m-d', strtotime($request->ngaysinh));
    				$sinhVien->cmnd = $request->cmnd;
    				$sinhVien->lop_id = $request->lop;
    				$sinhVien->diemtrungtuyen = $request->diemtrungtuyen;
    				$sinhVien->save();
					self::StoreUser($sinhVien);
    				return redirect()->route('admin_sinhvien_timkiem')->with('success', 'Lưu thành công!');
    			} catch (Exception $e) {
    				return redirect()->route('admin_sinhvien_create')->with('warning', "Lưu không thành công. Vui lòng thử lại.");
    			}
    		}

    	// return view('admin.sinhvien_create', ['DS_GioiTinh'=>$DS_GioiTinh]);
    }

    public function StoreUser($sinhVien='')
    {
    	$user = new User();
    	$user->name = $sinhVien->hochulot . ' ' . $sinhVien->ten;
    	$user->email = $sinhVien->email_agu;
    	$user->password = bcrypt($sinhVien->cmnd);
    	$user->cbgvsv_id = $sinhVien->id;
    	$user->idloaiuser = 3;
    	$user->idtrangthaiuser = 1;
    	$user->save();
    }

    public function isExistMSSV($mssv='')
    {
    	return SinhVien::where('mssv', '=', $mssv)->first() ? true : false;
    }
    public function isExistEmail($email='')
    {
    	return SinhVien::where('email_agu', '=', $email)->first() ? true : false;
    }
}
