<?php

namespace App\Http\Controllers;

use App\BoTieuChi;
use Illuminate\Http\Request;
use App\Http\Requests\BoTieuChiRequest;
use File;
use App\TieuChi;
use App\HocKyNamHocBoTieuChi;

class BoTieuChiController extends Controller
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

    public function adminindex()
    {
        $dsBoTieChi = BoTieuChi::all();
        return view('admin.botieuchilist', ['dsBoTieuChi'=>$dsBoTieChi]);
    }

    public function truongdonviindex()
    {
        $dsBoTieChi = BoTieuChi::all();
        return view('truongdonvi.botieuchilist', ['dsBoTieuChi'=>$dsBoTieChi]);
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
        return view('admin.botieuchicreate');
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

    public function adminstore(BoTieuChiRequest $request)
    {
        try {
            $boTieuChi = new BoTieuChi();
            $boTieuChi->tenbotieuchi = $request->tenbotieuchi;
            $boTieuChi->mota = $request->motabotieuchi;
            $boTieuChi->save();

            if($request->hasFile('input_file'))
            {
                // Upload file minh chứng
                $filename = 'VanBan_BoTieuChi_'.$boTieuChi->id;
                $fullFileName = self::UploadFile($request->file('input_file'), $filename);
                $boTieuChi->filename = $fullFileName;
                $boTieuChi->save();
            }

            return redirect()->route('admin_botieuchi_index')->with('success', 'Lưu thành công.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('danger', 'Lưu không thành công.<br>' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BoTieuChi  $boTieuChi
     * @return \Illuminate\Http\Response
     */
    public function show(BoTieuChi $boTieuChi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BoTieuChi  $boTieuChi
     * @return \Illuminate\Http\Response
     */
    public function adminedit($idBoTieuChi)
    {
        $boTieuChi = BoTieuChi::find($idBoTieuChi);
        return view('admin.botieuchiedit', ['boTieuChi'=>$boTieuChi]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BoTieuChi  $boTieuChi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BoTieuChi $boTieuChi)
    {
        //
    }

    public function adminupdate(BoTieuChiRequest $request)
    {
        try {
            $boTieuChi = BoTieuChi::find($request->idbotieuchi);
            $boTieuChi->tenbotieuchi = $request->tenbotieuchi;
            $boTieuChi->mota = $request->motabotieuchi;
            $boTieuChi->save();
            if($request->hasFile('input_file'))
            {
                // Upload file minh chứng
                $filename = 'VanBan_BoTieuChi_'.$boTieuChi->id;
                $fullFileName = self::UploadFile($request->file('input_file'), $filename);
                $boTieuChi->filename = $fullFileName;
                $boTieuChi->save();
            }

            return redirect()->route('admin_botieuchi_index')->with('success', 'Lưu thành công.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('danger', 'Lưu không thành công.<br>' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BoTieuChi  $boTieuChi
     * @return \Illuminate\Http\Response
     */
    public function destroy(BoTieuChi $boTieuChi)
    {
        //
    }

    public function admindestroy($idBoTieuChi)
    {
        try {
            if(count(HocKyNamHocBoTieuChi::where('botieuchi_id', '=', $idBoTieuChi)->get()) == 0)
                if(count(TieuChi::where('botieuchi_id', '=', $idBoTieuChi)->get()) == 0)
                {
                    BoTieuChi::destroy($idBoTieuChi);
                    return redirect()->route('admin_botieuchi_index', ['idbotieuchi'=>$idBoTieuChi])->with('success', 'Xóa thành công.');
                }
                else
                    return redirect()->route('admin_botieuchi_index', ['idbotieuchi'=>$idBoTieuChi])->with('danger', 'Không thể xóa vì bộ tiêu chí đã có tiêu chí con');
            else
                return redirect()->route('admin_botieuchi_index', ['idbotieuchi'=>$idBoTieuChi])->with('danger', 'Không thể xóa vì bộ tiêu chí đã được áp dụng');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('danger', 'Xóa không thành công.<br>' . $th->getMessage());
        }
    }

    // Function my define
    public function UploadFile($inpFile, $fileName)
    {
        if(!is_null($inpFile))
        {
            $ext = $inpFile->getClientOriginalExtension();
            $pathFile = storage_path().'/botieuchi/';

            $inpFile->move($pathFile, $fileName.'.'.$ext);

            return $pathFile . $fileName.'.'.$ext;
        }
    }

    public function DownloadFile($idBoTieuChi)
    {
        try {
            $boTieuChi = BoTieuChi::find($idBoTieuChi);
            $file = $boTieuChi->filename;
            $substr = explode(".", $file);
            return response()->download($file, 'VanBan_BoTieuChi' . $boTieuChi->id . "." . $substr[1]);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('waring', "Lỗi <br>" . $th->getMessage());
        }
    }

    public function admindownload($idBoTieuChi)
    {
        return self::DownloadFile($idBoTieuChi);
    }
}
