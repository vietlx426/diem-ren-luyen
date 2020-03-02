<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\UserGroupController;
use App\User;
use App\Group;
use App\SinhVien;
use App\Khoa;
use App\Nganh;
use App\KhoaHoc;
use App\UserGroup;
use Hash;
use DB;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
        $DS_Khoa = Khoa::all();
        $DS_Nganh = Nganh::all();
        $DS_KhoaHoc = KhoaHoc::all();
        $DS_User = User::offset(100)->limit(100)->get();
        return view('admin.user', ['DS_Khoa' => $DS_Khoa, 'DS_Nganh' => $DS_Nganh, 'DS_KhoaHoc' => $DS_KhoaHoc]);
    }

    public function show($iduser)
    {
        $User = User::find($iduser);
        $DS_Group = Group::all();
        return view('admin.user_group_edit', ['User' => $User, 'DS_Group' => $DS_Group]);
    }

    public function showKhoa($idKhoa)
    {
        $DS_User = User::where('idloaiuser', '=', '3')
            -> join('sinhvien', 'sinhvien.id', '=', 'users.cbgvsv_id')
            -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            -> where('khoa.id', '=', $idKhoa)
            -> select('users.*')
            -> get();

        return $DS_User->toArray();
    }

    public function showNganh($idNganh)
    {
        $DS_User = User::where('idloaiuser', '=', '3')
            -> join('sinhvien', 'sinhvien.id', '=', 'users.cbgvsv_id')
            -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            -> where('nganh.id', '=', $idNganh)
            -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            -> select('users.*')
            -> get();

        return $DS_User->toArray();
    }

    public function showKhoaHoc($idKhoaHoc)
    {
        $DS_User = User::where('idloaiuser', '=', '3')
            -> join('sinhvien', 'sinhvien.id', '=', 'users.cbgvsv_id')
            -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            -> where('lop.khoahoc_id', '=', $idKhoaHoc)
            // -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            // -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            // -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            -> select('users.*')
            -> get();

        return $DS_User->toArray();
    }

    public function showLop($tenLop)
    {
        $DS_User = User::where('idloaiuser', '=', '3')
            -> join('sinhvien', 'sinhvien.id', '=', 'users.cbgvsv_id')
            -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            -> where('lop.tenlop', 'like', '%'. $tenLop . '%')
            // -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            // -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            // -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            -> select('users.*')
            -> get();

        return $DS_User->toArray();
    }

    public function showMSSV($MSSV)
    {
        $DS_User = User::where('idloaiuser', '=', '3')
            -> join('sinhvien', 'sinhvien.id', '=', 'users.cbgvsv_id')
            -> where('sinhvien.mssv', '=', $MSSV)
            // -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            // -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            // -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            // -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            -> select('users.*')
            -> get();

        return $DS_User->toArray();
    }

    public function showEmail($Email)
    {
        $DS_User = User::where('email', 'like', '%'.$Email.'%')
            // -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            // -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            // -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            // -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            // -> select('users.*')
            -> get();

        return $DS_User->toArray();
    }

    public function getDonVi($idUser, $idLoaiUser)
    {
        switch ($idLoaiUser) {
            // case '1':
            //     $DonVi = User::find($idUser)
            //     -> join('sinhvien', 'sinhvien.id', '=', 'users.cbgvsv_id')
            //     -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
            //     // -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
            //     // -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
            //     // -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
            //     -> select('lop.id', 'lop.tenlop')
            //     -> get();
            //     break;

            case '3':
                $DonVi = User::find($idUser)
                -> join('sinhvien', 'sinhvien.id', '=', 'users.cbgvsv_id')
                -> join('lop', 'lop.id', '=', 'sinhvien.lop_id')
                // -> join('nganh', 'nganh.id', '=', 'lop.nganh_id')
                // -> join('bomon', 'bomon.id', '=', 'nganh.idbomon')
                // -> join('khoa', 'khoa.id', '=', 'bomon.idkhoa')
                -> select('lop.id', 'lop.tenlop as tendonvi')
                -> get();
                break;
            
            default:
                # code...
                break;
        }

        return $DonVi->toArray();
        
    }

    public function update(Request $request)
    {
        if(Auth::check() && (UserController::isGroupNoneId(env('GROUP_CHUYENVIENHETHONG')) || UserController::isGroupNoneId(env('GROUP_QUANTRIHETHONG'))))
        {
            $User = User::find($request->id);
            if($User)
            {
                // Update user
                try {
                    $User->idtrangthaiuser = $request->TrangThaiUser;
                    if(intval($User->idloaiuser) != intval('3'))
                    {
                        $User->name = $request->Name;
                        $User->email = $request->Email;
                    }

                    $User->save();
                } catch (Exception $e) {

                    return redirect()->back()->with(['danger' => 'Có lỗi trong quá trình lưu (cập nhật).<br>Vui lòng nhấn F5 (refresh) và thử lại.']);
                }

                // Update group-user
                try {

                    UserGroup::where('idUser', '=', $User->id)->delete();
                    if($request->GroupPermission)
                    {
                        foreach ($request->GroupPermission as $key => $value) {
                            $UserGroup = new UserGroup();
                            $UserGroup->idUser = $User->id;
                            $UserGroup->idGroup = $value;
                            $UserGroup->save();
                        }
                    }

                    return redirect()->back()->with(['success' => 'Lưu (cập nhật thành công)!']);
                    
                } catch (Exception $e) {

                    return redirect()->back()->with(['danger' => 'Có lỗi trong quá trình lưu (cập nhật).<br>Vui lòng nhấn F5 (refresh) và thử lại.']);
                }
                
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
     * Kiểm tra user có thuộc groups,  không cần tham số idUser đầu vào.
     *
     * @return giá trị true/false.
     */
	// Kiểm tra có thuộc group hay không, không cần tham số idUser đầu vào.
    public static function isGroupNoneId($idGroup)
    {
    	if(Auth::check())
    	{
            $idUser = Auth::user()->id;
    		return self::PermissionMaxLevel($idUser) == $idGroup ? true : false;
    	}
    	else
    		return 0;
    }

    public static function isGroupWithIdUser($idUser, $idGroup)
    {
        return UserGroupController::isGroup($idUser, $idGroup);
    }

	/**
     * Lấy giá trị idGroup có quyền cao nhất, không cần tham số idUser đầu vào (idGroup nhỏ thì có quyền cao).
     *
     * @return giá trị idGroup có quyền cao nhất, nếu không có trả vể 0.
     */
	// Lấy giá trị idGroup có quyền cao nhất, không cần tham số idUser đầu vào.
    public static function PermissionMaxLevelNoneId()
    {
    	if(Auth::check())
    	{
    		$idUser = Auth::user()->id;
    		return UserController::PermissionMaxLevel($idUser);
    	}
    	else
    		return 0;
    }

    /**
     * Lấy giá trị idGroup có quyền cao nhất, tham số đầu vào idUser (idGroup nhỏ thì có quyền cao).
     *
     * @return integer, giá trị idGroup có quyền cao nhất, nếu không có trả vể 0.
     */
    public static function PermissionMaxLevel($idUser='')
    {
    	if($idUser=='')
    		return 0;
    	$PermissionMaxLevel = UserGroupController::GroupMaxLevel($idUser);
    	return $PermissionMaxLevel;
    }

    /**
     * Lấy các (danh sách) giá trị idGroup tham số đầu vào idUser (idGroup nhỏ thì có quyền cao).
     *
     * @return integer, giá trị idGroup có quyền cao nhất, nếu không có trả vể 0.
     */
    public static function PermissionLevels($idUser='')
    {
        if($idUser=='')
            return 0;
        $PermissionLevel = UserGroupController::GroupLevel($idUser);
        return $PermissionLevel;
    }

    public static function UpdateToken($idUser, $Token)
    { 
        try {
            $User = User::find($idUser);
            $User->token = $Token;
            $User->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getDonViByUser($User)
    {
        return UserController::getDonViByIDUserAndIDLoaiUser($User->id, $User->idloaiuser);
    }

    public static function getDonViByIDUserAndIDLoaiUser($idUser, $idLoaiUser)
    {
        if($idLoaiUser == '1') // => cán bộ giảng viên
        {
            return 'Chưa xác dev UserController function getDonViByIDUserAndIDLoaiUser';
        }
        else
        {
            if($idLoaiUser == '3')
            {
                $SinhVien = SinhVien::find($idUser);
                if($SinhVien)
                {
                    return $SinhVien->lop->tenlop;
                }
                else
                    return 'Chưa xác định';
            }
        }
    }

    public function showchangepassword()
    {
        return view('auth.changepassword');
    }

    public function storechangepassword(Request $request)
    {
        $arrayResult = self::ValidateInputChangePassword($request);

        if($arrayResult['result'])
        {
            $resultOldPassword = self::CheckOldPassword($request->oldpassword);
            $resultCompareNewPassword = self::CompareNewPassword($request->newpassword, $request->confirmnewpassword);
            
            if(!$resultOldPassword['result'])
            {
                $arrayResult['result'] = false;
                $arrayResult['message'] .= $resultOldPassword['message'];
            }

            if(!$resultCompareNewPassword['result'])
            {
                $arrayResult['result'] = false;
                $arrayResult['message'] .= $resultCompareNewPassword['message'];
            }

            if($arrayResult['result'])
            {
                $user = User::find(Auth::user()->id);
                $user->password = bcrypt($request->newpassword);
                $user->save();

                return redirect()->route('home')->with('success', "Đổi mật khẩu thành công!");

            }
        }
    
        return redirect()->back()->withInput()->with('warning', $arrayResult['message']);
    }

    public function ValidateInputChangePassword($request='')
    {
        $arrayResult = array('result' => true, 'message'=>"");
        
        if(!$request->oldpassword)
        {
            $arrayResult['result'] = false;
            $arrayResult['message'] .= "<br> Vui lòng nhập mật khẩu cũ";
        }

        if(!$request->newpassword)
        {
            $arrayResult['result'] = false;
            $arrayResult['message'] .= "<br> Vui lòng nhập mật khẩu mới";
        }

        if(!$request->confirmnewpassword)
        {
            $arrayResult['result'] = false;
            $arrayResult['message'] .= "<br> Vui lòng nhập xác nhận mật khẩu mới";
        }

        return $arrayResult;
    }

    public function CheckOldPassword($oldpassword='')
    {
        $arrayResult = array('result' => true, 'message'=>"");

        if(Auth::check())
        {
            $user = User::find(Auth::user()->id);
            if(!Hash::check($oldpassword, $user->password))
            {
                $arrayResult['result'] = false;
                $arrayResult['message'] = "<br> Mật khẩu cũ không đúng";
            }
        }

        return $arrayResult;
    }

    public function CompareNewPassword($newpassword='', $confirmnewpassword='')
    {
        $arrayResult = array('result' => true, 'message'=>"");

        if(strcmp($newpassword, $confirmnewpassword) != 0)
        {
            $arrayResult['result'] = false;
            $arrayResult['message'] = "<br> Mật khẩu xác nhận không đúng";
        }

        return $arrayResult;
    }

    public function resetpassdefault(Request $request)
    {
        if(Auth::check())
        {
            $user = User::find($request->id);
            if($user)
            {
                $groupAdmin = UserGroup::where('idUser', '=', $user->id)->whereIn('idGroup', [1, 2])->get();
                if(count($groupAdmin) > 0)
                {
                    $userLoging = Auth::user();
                    $groupAdminOfUserLoging = UserGroup::where('idUser', '=', $userLoging->id)->where('idGroup', 1)->first();
                    if($groupAdminOfUserLoging)
                    {
                        return self::ResetPasswordDefault($user);
                    }
                    else
                        return array('result' => false, 'message' => "Bạn không có quyền reset mật khẩu cho user này!");
                }
                else
                {
                    return self::ResetPasswordDefault($user);
                }
            }
            else
                return array('result' => false, 'message' => "Hệ thống không tìm thấy thông tin user!");
        }
        else
            return array('result' => false, 'message' => "Bạn không có quyền reset mật khẩu cho user này!");
    }

    public function ResetPasswordDefault($user)
    {
        try {
            $newPass = $user->email;
            if($user->idloaiuser == 3) // Sinh viên
            {
                $sinhVien = SinhVien::find($user->cbgvsv_id);
                if($sinhVien)
                    $newPass = $sinhVien->cmnd;
            }
            $user->password = bcrypt($newPass);
            $user->save();

            return array('result' => true, 'message' => "Reset mật khẩu thành công!");
        } catch (\Throwable $th) {
            return array('result' => false, 'message' => "Lỗi (vui lòng liên hệ quản trị hệ thống)!\n". $th->getMessage());
        }
    }
}