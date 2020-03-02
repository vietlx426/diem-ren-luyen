<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class GroupController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

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
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }

    // public static function GroupAllLevel($idUser='')
    // {
    //     $tblGroupAllLevel = Group::where('idUser', $idUser) 
    //         ->select('idGroup')
    //         ->orderBy('idGroup', 'desc')
    //         ->get();
    //     return $tblGroupAllLevel;
    // }

    // public static function GroupMaxLevel($idUser='')
    // {
    //     $tblGroupAllLevel = GroupController::GroupAllLevel($idUser)->orderBy('idGroup', 'desc');

    //     echo count($tblGroupAllLevel);
    //     // if(count($tblGroupAllLevel)>0)
    //     //     return $tblGroupAllLevel[0];

    //     // return 0;
    // }
}
