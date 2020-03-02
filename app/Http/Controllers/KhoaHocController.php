<?php

namespace App\Http\Controllers;

use App\KhoaHoc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\KhoaHocRequest;
use App\BacDaoTao;

class KhoaHocController extends Controller
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
        $dsKhoaHoc = KhoaHoc::orderBy('nambatdau', 'asc')->orderBy('tenkhoahoc', 'asc')->get();
        return view('admin.khoahoclist', ['dsKhoaHoc'=>$dsKhoaHoc]);
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
        $dsBacDaoTao = BacDaoTao::orderBy('tenbac', 'asc')->get();

        return view('admin.khoahoccreate', ['dsBacDaoTao'=>$dsBacDaoTao]);
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

    public function adminstore(Request $request)
    {
        try {
            $khoaHoc = new KhoaHoc();
            $khoaHoc->makhoahoc = trim($request->tenkhoahoc);
            $khoaHoc->tenkhoahoc = trim($request->tenkhoahoc);
            $khoaHoc->nambatdau = trim($request->nambatdau);
            $khoaHoc->namketthuc = trim($request->namketthuc);
            $khoaHoc->bacdaotao_id = trim($request->bacdaotao);
            $khoaHoc->save();

            return redirect()->route('admin_khoahoc_index')->with('success', "Lưu thành công");
        } catch (\Throwable $th) {
            //throw $th;
        }
        return redirect()->route('admin_khoahoc_index')->with('danger', "Lưu không thành công. Vui lòng thử lại");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KhoaHoc  $khoaHoc
     * @return \Illuminate\Http\Response
     */
    public function show(KhoaHoc $khoaHoc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KhoaHoc  $khoaHoc
     * @return \Illuminate\Http\Response
     */
    public function adminedit($idKhoaHoc='')
    {
        $dsBacDaoTao = BacDaoTao::orderBy('tenbac', 'asc')->get();
        $khoaHoc = KhoaHoc::find($idKhoaHoc);

        return view('admin.khoahocedit', ['dsBacDaoTao'=>$dsBacDaoTao, 'khoaHoc'=>$khoaHoc]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KhoaHoc  $khoaHoc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KhoaHoc $khoaHoc)
    {
        //
    }

    public function adminupdate(KhoaHocRequest $request)
    {
        try {
            $khoaHoc = KhoaHoc::find($request->idkhoahoc);
            $khoaHoc->makhoahoc = trim($request->tenkhoahoc);
            $khoaHoc->tenkhoahoc = trim($request->tenkhoahoc);
            $khoaHoc->nambatdau = trim($request->nambatdau);
            $khoaHoc->namketthuc = trim($request->namketthuc);
            $khoaHoc->bacdaotao_id = trim($request->bacdaotao);
            $khoaHoc->save();

            return redirect()->route('admin_khoahoc_index')->with('success', "Lưu thành công");
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('admin_khoahoc_index')->with('danger', "Lưu không thành công. Vui lòng thử lại<br>" . $th->getMessage());

        }
        return redirect()->route('admin_khoahoc_index')->with('danger', "Lưu không thành công. Vui lòng thử lại");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KhoaHoc  $khoaHoc
     * @return \Illuminate\Http\Response
     */
    public function destroy(KhoaHoc $khoaHoc)
    {
        //
    }

    public function admindestroy($idKhoaHoc = '')
    {
        $khoaHoc = KhoaHoc::find($idKhoaHoc);
        if($khoaHoc)
        {
            $khoaHocLop = Lop::where('khoahoc_id', '=', $idKhoaHoc)->first();
            if($khoaHocLop)
                return redirect()->route('admin_khoahoc_index')->with('danger', "Không thể xóa, khóa học đã được liên kết với table lớp");
            else
            {
                KhoaHoc::destroy($idKhoaHoc);
                return redirect()->route('admin_khoahoc_index')->with('success', "Xóa thành công");
            }
        }
        else
            return redirect()->route('admin_khoahoc_index')->with('danger', "Không tìm thấy thông tin khóa học để xóa");
    }
}
