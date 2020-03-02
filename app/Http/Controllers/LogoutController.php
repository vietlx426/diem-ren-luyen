<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

class LogoutController extends Controller
{
    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('login');
    }

    public function Logout()
    {
    	if(Auth::check())
        {
            Session::flush();
            Auth::logout();
        }
        return redirect()->route('index');
    }
}
