<?php

namespace App\Http\Controllers;

use App\UserGroup;
use Illuminate\Http\Request;


class UserGroupController extends Controller
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
     * Display the specified resource.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function show(UserGroup $userGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(UserGroup $userGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserGroup $userGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserGroup $userGroup)
    {
        //
    }

    /**
     * Kiểm tra idUser có trong group hay không?
     *
     * @return true/false.
     */
    public static function isGroup($idUser, $idGroup)
    {
        $Group = UserGroup::where('idUser', $idUser) 
            -> where('idGroup', $idGroup)
            ->get();
        if($Group)
            return true;
        return false;
    }

    /**
     * Lấy danh sách idGroup của user, tham số đầu vào idUser.
     *
     * @return table, danh sách idGroup.
     */
    public static function GroupAllLevel($idUser='')
    {
        $tblGroupAllLevel = UserGroup::where('idUser', $idUser) 
            ->select('idGroup')
            ->orderBy('idGroup', 'desc')
            ->get();
        return $tblGroupAllLevel;
    }

    /**
     * Lấy giá trị idGroup có quyền cao nhất, tham số đầu vào idUser (giá trị idGroup nhỏ thì có quyền cao).
     *
     * @return integer, giá trị idGroup có quyền cao nhất, nếu không có return 0.
     */
    public static function GroupMaxLevel($idUser='')
    {
        $tblGroupAllLevel = UserGroupController::GroupAllLevel($idUser);
        if(count($tblGroupAllLevel)>0)
            return $tblGroupAllLevel[0]->idGroup;

        return 0;
    }

    /**
     * Lấy các (danh sách) giá trị idGroup, tham số đầu vào idUser (giá trị idGroup nhỏ thì có quyền cao).
     *
     * @return integer, giá trị idGroup có quyền cao nhất, nếu không có return 0.
     */
    public static function GroupLevel($idUser='')
    {
        $tblGroupAllLevel = UserGroupController::GroupAllLevel($idUser);
        if(count($tblGroupAllLevel)>0)
            return $tblGroupAllLevel;

        return 0;
    }
}
