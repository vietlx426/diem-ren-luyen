<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LogLoaiHoatDong
{
    const NewInsertRecord = '1';
    const UpdateRecord = '2';
    const DeleteRecord = '3';
}

class LogController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  email, ip, loaihoatdong, giatricu, giatrimoi, ghichu
     * @return bool (true/false)
     */
    public static function storelog($iduser,$email='', $ip='', $loaihoatdong='1', $giatricu='', $giatrimoi, $ghichu='')
    {
        try {
            $Log = new Log();
            $Log->iduser = $iduser;
            $Log->email = $email;
            $Log->ip = $ip;
            $Log->loaihoatdong = $loaihoatdong;
            $Log->giatricu = $giatricu;
            $Log->giatrimoi = $giatrimoi;
            $Log->ghichu = $ghichu;
            $Log->save();
            return true;
            
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  objold, objnew, loaihoatdong, ghichu
     * @return bool (true/false)
     */
    public static function storeobjectlog($objold='', $objnew, $loaihoatdong='1', $ghichu='')
    {
        try {
            if($objold != '')
            {
                $GiaTriCu = LogController::ConvertObjectToString($objold);
            }
            else
            {
                $GiaTriCu = '';
            }

            if($objnew != '')
            {
                $GiaTriMoi = LogController::ConvertObjectToString($objnew);
            }
            else
            {
                $GiaTriMoi = '';
            }
            
            $IDUser = LogController::getIDUser();
            $Email = LogController::getEmailUser();
            $IPUser = LogController::getIPUser();

            $result = LogController::storelog($IDUser, $Email, $IPUser, $loaihoatdong, $GiaTriCu, $GiaTriMoi, $ghichu);
            
            return $result;
            
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Log $log)
    {
        //
    }

    /**
     * Convert object to string (field: content).
     *
     * @param  \App\object
     * @return $str
     */
    public static function ConvertObjectToString($obj)
    {
        $str = "";

        foreach ($obj as $key => $value) {
             $str .= $key. ": " . $value."; ";
        }

        return $str;
    }

    public static function getIDUser()
    {
        $IDUser = '';
        if(Auth::check())
        {
            $IDUser = Auth::user()->id;
        }

        return $IDUser;
    }

    public static function getEmailUser()
    {
        // $EmailUser = 'admin@gmail.com';
        if(Auth::check())
        {
            $EmailUser = Auth::user()->email;
        }

        return $EmailUser;
    }

    public static function getIPUser()
    {
        $IPUser = '';
        // if(Auth::check())
        // {
        //     $IDUser = Auth::user()->id;
        // }

        return $IPUser;
    }
}
