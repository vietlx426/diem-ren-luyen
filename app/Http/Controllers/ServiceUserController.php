<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class ServiceUserController extends Controller
{
    public static function isGroupOfUserCurrent($idGroup)
    {
    	if(Auth::check())
    	{
    		$DS_GroupOfUserCurrent = Auth::user()->usergroup;
    		foreach ($DS_GroupOfUserCurrent as $key => $group) {
    			if(intval($group->idGroup) == intval($idGroup))
    				return true;
            }
            
            $idCBGVSV = Auth::user()->cbgvsv_id;
            $idLoaiCBGVSV = Auth::user()->idloaiuser;

            switch ($idGroup) {
                case env('GROUP_SINHVIEN'):
                    if($idLoaiCBGVSV == 3)
                    {
                        $sinhVien = SinhVienController::GetSinhVienByID(idCBGVSV);
                        return $sinhVien ? true : false;
                    }
                    return false;
                    break;

                case env('GROUP_BANCANSU'):
                    if($idLoaiCBGVSV == 3)
                        return BanCanSuController::isBanCanSu($idCBGVSV);
                    return false;
                    break;
                
                case env('GROUP_COVANHOCTAP'):
                    if($idLoaiCBGVSV == 1)
                        return CoVanHocTapController::isCoVanHocTap($idCBGVSV);
                    return false;
                    break;
                
                case env('GROUP_GIAOVUKHOA'):
                    if($idLoaiCBGVSV == 1)
                        return GiaoVuKhoaController::isGiaoVuKhoa($idCBGVSV);
                    return false;
                    break;
                
                case env('GROUP_CHUYENVIEN'):
                    if($idLoaiCBGVSV == 1)
                        return ChuyenVienQuanLyLopController::isChuyenVienQuanLyLop($idCBGVSV);
                    return false;
                    break;
                
                // case env('GROUP_TRUONGDONVI'):
                //     if($idLoaiCBGVSV == 1)
                //         return ChuyenVienQuanLyLopController::isChuyenVienQuanLyLop($idCBGVSV);
                //     return false;
                //     break;
                    
                default:
    	            return false;
                    break;
            }
    	}
    	
    	return false;
    }

    public static function DSGroupOfUserCurrent()
    {
        if(Auth::check())
        {
            $DS_GroupOfUserCurrent = Auth::user()->usergroup;
            return $DS_GroupOfUserCurrent;
        }
        
        return false;
    }

    public static function UserCount()
    {
        return count(User::all());
    }

    public static function PermissionList()
    {
        $arrayPermission = array(
            'truongdonvi' => false,
            'chuyenvien_lop' => false,
            'giaovukhoa' => false,
            'covanhoctap' => false,
            'bancansu' => false
        );

        if(Auth::check())
        {
            if(Auth::user()->idloaiuser == 1)
            {
                $idCBGV = Auth::user()->cbgvsv_id;
                if(ChuyenVienQuanLyLopController::isChuyenVienQuanLyLop($idCBGV))
                    $arrayPermission['chuyenvien_lop'] = true;
                if(GiaoVuKhoaController::isGiaoVuKhoa($idCBGV))
                    $arrayPermission['giaovukhoa'] = true;
                if(CoVanHocTapController::isCoVanHocTap($idCBGV))
                    $arrayPermission['covanhoctap'] = true;
            }

            if(Auth::user()->idloaiuser == 3)
            {
                $idSinhVien = Auth::user()->cbgvsv_id;
                if(BanCanSuController::isBanCanSu($idSinhVien))
                    $arrayPermission['bancansu'] = true;
            }
        }
        
        return $arrayPermission;
    }

    public static function PermissionListWithIdUser($idUser='')
    {
        $arrayPermission = array(
            'chuyenvien_lop' => false,
            'giaovukhoa' => false,
            'covanhoctap' => false,
            'bancansu' => false
        );

        $user = User::find($idUser);
        if($user->idloaiuser == 1)
        {
            $idCBGV = $user->cbgvsv_id;
            if(ChuyenVienQuanLyLopController::isChuyenVienQuanLyLop($idCBGV))
                $arrayPermission['chuyenvien_lop'] = true;
            if(GiaoVuKhoaController::isGiaoVuKhoa($idCBGV))
                $arrayPermission['giaovukhoa'] = true;
            if(CoVanHocTapController::isCoVanHocTap($idCBGV))
                $arrayPermission['covanhoctap'] = true;
        }

        if($user->idloaiuser == 3)
        {
            $idSinhVien = $user->cbgvsv_id;
            if(BanCanSuController::isBanCanSu($idSinhVien))
                $arrayPermission['bancansu'] = true;
        }
        
        return $arrayPermission;
    }

    public static function PermissionListWithIdCBGV($idCBGV='')
    {
        $arrayPermission = array(
            'chuyenvien_lop' => false,
            'giaovukhoa' => false,
            'covanhoctap' => false,
            'bancansu' => false
        );
        if(ChuyenVienQuanLyLopController::isChuyenVienQuanLyLop($idCBGV))
            $arrayPermission['chuyenvien_lop'] = true;
        if(GiaoVuKhoaController::isGiaoVuKhoa($idCBGV))
            $arrayPermission['giaovukhoa'] = true;
        if(CoVanHocTapController::isCoVanHocTap($idCBGV))
            $arrayPermission['covanhoctap'] = true;
        
        return $arrayPermission;
    }

    public static function GetStringPermissionWithIdCBGV($idCBGV='')
    {
        $arrayPermission = self::PermissionListWithIdCBGV($idCBGV);
        $arrayStringPermission = array();

        $user = User::where('cbgvsv_id', '=', $idCBGV)->where('idloaiuser', '=', 1)->first();
        $AdminPermission = UserController::PermissionMaxLevel($user?$user->id:'');

        if($AdminPermission == env('GROUP_CHUYENVIENHETHONG') || $AdminPermission == env('GROUP_QUANTRIHETHONG'))
            array_push($arrayStringPermission, "Quản trị");
        if($arrayPermission['chuyenvien_lop'])
            array_push($arrayStringPermission, "Chuyên viên");
        if($arrayPermission['giaovukhoa'])
            array_push($arrayStringPermission, "Giáo vụ");
        if($arrayPermission['covanhoctap'])
            array_push($arrayStringPermission, "Cố vấn học tập");
        if($arrayPermission['bancansu'])
            array_push($arrayStringPermission, "Ban cán sự");
            
        return $arrayStringPermission;
    }
}
