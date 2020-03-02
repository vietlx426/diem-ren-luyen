<?php

namespace App\Http\Controllers;

use App\ImportTemplate;
use Illuminate\Http\Request;

class ImportTemplateController extends Controller
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
     * @param  \App\ImportTemplate  $importTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(ImportTemplate $importTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImportTemplate  $importTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(ImportTemplate $importTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImportTemplate  $importTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImportTemplate $importTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImportTemplate  $importTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImportTemplate $importTemplate)
    {
        //
    }

    // Function my define
    public function download($id='')
    {
        $file= storage_path(). "/import_templates/". $id . ".xlsx";

        return response()->download($file, 'import_template_' . $id . '.xlsx');
    }
}
