<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceUserController;
use Socialite, Session, URL, Redirect;
use Auth;
use App\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        if(!Session::has('pre_url')){
            Session::put('pre_url', URL::previous());
        }else{
            if(URL::previous() != URL::to('login')) Session::put('pre_url', URL::previous());
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $UserProviderAuth = $this->getUserAuthenticatedFromProvider($provider);

            if($UserProviderAuth)
            {
                $User = $this->findUserInDatabase($UserProviderAuth);
                if($User)
                {
                    if($this->LoginUser($User, true))
                    {
                        return $this->RedirectDashboard($User);
                    }
                    // else
                    // {
                    //     // return view('layout.alertmessage.notmailaguindb');
                    //     // return redirect()->route('info.alert')->with('status', 'Tài khoản vừa đăng nhập chưa có trong hệ thống.<br><br>Vui lòng liên hệ quản trị hệ thống (nntrong@agu.edu.vn - 0949.309.899!');
                    // }
                }
                // else
                // {
                //     // return view('layout.alertmessage.notmailagu');
                //     return redirect()->route('info.alert')->with('status', 'Tài khoản email đăng nhập không phải email trường Đại học An Giang.<br><br>Vui lòng sử dụng email trường Đại học An Giang (...@agu.edu.vn) để đăng nhập!');
                //     // return redirect()->route('info.notmailagu')->with(['status' => "Tài khoản hiện tại chưa có trong hệ thống.<br>Vui lòng liên hệ administrator."]);
                // }
            }
            else
            {
                return redirect()->route('redirect-login');
            }
            return redirect()->route('redirect-login');
            
        } catch (Exception $e) {
            return redirect()->route('home');

        }

        
        // return Redirect::to(Session::get('pre_url'));
    }

    public function LoginUser($user, $remember)
    {
        return Auth::loginUsingId($user->id, $remember);
       // return true;
    }

    // protected function RedirectDashboard($user)
    protected function RedirectDashboard()
    {
        $Permission = UserController::PermissionMaxLevelNoneId();
        $arrayPermission = ServiceUserController::PermissionList();

        if($Permission)
        {
            if($Permission == Permission::QuanTriHeThong)
                return redirect()->route('admin');

            if($Permission == env('GROUP_CHUYENVIENHETHONG'))
                return redirect()->route('admin');

            if($Permission == env('GROUP_TRUONGDONVI'))
                return redirect()->route('truongdonvi');

            if($Permission == env('GROUP_CHUYENVIEN') || $arrayPermission['chuyenvien_lop'])
                return redirect()->route('subadmin');

            if($Permission == env('GROUP_GIAOVUKHOA') || $arrayPermission['giaovukhoa'])
                return redirect()->route('giaovukhoa');

            if($Permission == env('GROUP_COVANHOCTAP') || $arrayPermission['covanhoctap'])
                return redirect()->route('covanhoctap');

            if($Permission == env('GROUP_BANCANSU') || $arrayPermission['bancansu'])
                return redirect()->route('bancansu');

            if($Permission == env('GROUP_SINHVIEN'))
                return redirect()->route('sinhvien');
        }
        else
        {
            if($arrayPermission['chuyenvien_lop'])
                return redirect()->route('subadmin');

            if($arrayPermission['giaovukhoa'])
                return redirect()->route('giaovukhoa');

            if($arrayPermission['covanhoctap'])
                return redirect()->route('covanhoctap');

            if($arrayPermission['bancansu'])
                return redirect()->route('bancansu');
        }

        try {
            Session::flush();
            Auth::logout();
            return redirect()->route('login');
        } catch (Exception $e) {
            return redirect()->route('login');
        }
        
        

        // switch($Permission)
        // {
        //     case Permission::QuanTriHeThong:
        //         return redirect()->route('admin');
        //         break;

        //     case env('GROUP_CHUYENVIENHETHONG'):
        //         return redirect()->route('admin');
        //         break;

        //     case env('GROUP_TRUONGDONVI'):
        //         return redirect()->route('updatedstudentprofile_truongdonvi');
        //         break;

        //     case env('GROUP_CHUYENVIEN'):
        //         return redirect()->route('subadmin');
        //         break;

        //     case env('GROUP_GIAOVUKHOA'):
        //         return redirect()->route('giaovukhoa');
        //         break;

        //     case env('GROUP_COVANHOCTAP'):
        //         return redirect()->route('covanhoctap');
        //         break;

        //     case env('GROUP_BANCANSU'):
        //         return redirect()->route('bancansu');
        //         break;

        //     case env('GROUP_SINHVIEN'):
        //         return redirect()->route('sinhvien');
        //         break;

        //     default:
        //         return self::Logout();// redirect()->route('login');
        //         // return redirect()->route('welcome');
        //         // Auth::logout();
        // }
    }

    protected function RedirectLogin()
    {
        if(env('PROVIDER') == "LOCAL")
        {
            return self::LoginLocal();
        }
        else
        {
            $provider = env('PROVIDER');
            return self::redirectToProvider($provider);
        }
    }

    public function LoginLocal()
    {
        return redirect()->route('login');
        // echo "string";
        // return view('auth.login');
    }

    protected function getUserAuthenticatedFromProvider($provider)
    {
        try {
            $UserProviderAuth = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            $UserProviderAuth = "";
        }

        return $UserProviderAuth;
    }


    protected function findUserInDatabase($user)
    {
        $User = User::where('email', $user->email)
            ->where('idtrangthaiuser','=', env('TrangThaiUser_Unlock'))
            ->first();
        return $User;
    }

    public function Logout()
    {
        // if(Auth::check())
        // {
            Session::flush();
            Auth::logout();
        // }
        return redirect()->route('home');
    }
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // public static function Login(LoginRequest $request)
    // protected  function Login(Request $request)
    // {
    //     if($request->Remember == 'remember-me')
    //         $remember = true;
    //     else
    //         $remember = false;

    //     // $result_login = Auth::attempt(['username' => $request->Email, 'password' => $request->Password], $remember);
    
    //     // if(!$result_login)
    //     // {
    //         // $result_login = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
    //     // }

    //     $user = array('email' => $request->email, 'password' => $request->password);
    //     $result_login = Auth::login($user, true);
    //         echo $request->email;
    //     print_r($result_login);

    //     // if($result_login)
    //     // {
    //     //     $Permission = UserController::PermissionMaxLevelNoneId();
    //     //     switch($Permission)
    //     //     {
    //     //         case Permission::QuanTriHeThong:
    //     //             return redirect()->route('admin');
    //     //             break;
    //     //         case Permission::ChuyenVienHeThong:
    //     //             echo "return redirect()->route('Chuyên viên hệ thống')";
    //     //             break;
    //     //         case Permission::TruongDonVi:
    //     //             echo "return redirect()->route('Trưởng đơn vị')";
    //     //             break;
    //     //         case Permission::ChuyenVien:
    //     //             echo "return redirect()->route('Chuyên viên')";
    //     //             break;
    //     //         case Permission::GiaoVu:
    //     //             echo "return redirect()->route('Giáo vụ khoa')";
    //     //             break;
    //     //         case Permission::CoVanHocTap:
    //     //             echo "return redirect()->route('Cố vấn học tập')";
    //     //             break;
    //     //         case Permission::BanCanSu:
    //     //             echo "return redirect()->route('Ban cán sự')";
    //     //             break;
    //     //         case Permission::SinhVien:
    //     //             echo "return redirect()->route('Sinh viên')";
    //     //             break;
    //     //         default:
    //     //             Auth::logout();
    //     //     }
    //     // }
    //     // return redirect()->route('login')->with(['status' => ' - Email hoặc mật khẩu chưa đúng!', 'alarmlevel'=>'danger']);
    // }
}

/**
* Class Type Permission user
*/
class Permission
{
    const QuanTriHeThong = 1;
    const ChuyenVienHeThong = 2;
    const TruongDonVi = 3;
    const ChuyenVien = 4;
    const GiaoVu = 5;
    const CoVanHocTap = 6;
    const BanCanSu = 7;
    const SinhVien = 8;
}