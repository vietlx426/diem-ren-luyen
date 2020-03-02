<?php

namespace App\Http\Controllers;

use App\CoVanHocTap;
use Illuminate\Http\Request;
use App\Http\Requests\CoVanHocTapRequest;
use App\Lop;
use Auth;

class CoVanHocTapController extends Controller
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

    public function admin_index()
    {
        $dsCoVanHocTap = CoVanHocTap::where('trangthai_id', '=', 1)
            -> leftjoin('lop', 'lop.id', '=', 'covanhoctap.lop_id')
            -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date('Y'))
            -> select('covanhoctap.*')
            -> get();
        return view('admin.covanhoctaplist',['dsCoVanHocTap' => $dsCoVanHocTap]);
    }

    public function subadmin_index()
    {
        $dsCoVanHocTap = CoVanHocTap::where('trangthai_id', '=', 1)
            -> leftjoin('lop', 'lop.id', '=', 'covanhoctap.lop_id')
            -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date('Y'))
            -> select('covanhoctap.*')
            -> get();
        return view('subadmin.covanhoctaplist',['dsCoVanHocTap' => $dsCoVanHocTap]);
    }

    public function truongdonvi_index()
    {
        $dsCoVanHocTap = CoVanHocTap::where('trangthai_id', '=', 1)
            -> leftjoin('lop', 'lop.id', '=', 'covanhoctap.lop_id')
            -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date('Y'))
            -> select('covanhoctap.*')
            -> get();
        return view('truongdonvi.covanhoctaplist',['dsCoVanHocTap' => $dsCoVanHocTap]);
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

    public function admin_create()
    {
        $dsCanBoGiangVien = CanBoGiangVienController::DanhSachCanBoGiangVien();
        $dsLop = Lop::leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date('Y'))
            -> orderBy('lop.tenlop', 'asc')
            -> select('lop.*')
            -> get();

        return view('admin.covanhoctapcreate', ['dsCanBoGiangVien'=>$dsCanBoGiangVien, 'dsLop'=>$dsLop]);
    }

    public function subadmin_create()
    {
        $dsCanBoGiangVien = CanBoGiangVienController::DanhSachCanBoGiangVien();
        $dsLop = Lop::leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date('Y'))
            -> orderBy('lop.tenlop', 'asc')
            -> select('lop.*')
            -> get();

        return view('subadmin.covanhoctapcreate', ['dsCanBoGiangVien'=>$dsCanBoGiangVien, 'dsLop'=>$dsLop]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($idCBGV, $idLop, $idHocKyNamHoc)
    {
        try {
            $coVanHocTap = new CoVanHocTap();
            $coVanHocTap->canbogiangvien_id = $idCBGV;
            $coVanHocTap->lop_id = $idLop;
            $coVanHocTap->hockynamhoc_id_batdau = $idHocKyNamHoc;
            $coVanHocTap->trangthai_id = 1;
            $coVanHocTap->save();
        } catch (Exception $e) {
            
        }
        return true;
    }

    public function admin_store(CoVanHocTapRequest $request)
    {
        $idCBGV = $request->cbgv;
        $idLop = $request->lop;
        $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        
        // 1. Kiểm tra tồn tại
        if(self::isExistCoVanHocTap($idCBGV, $idLop, $idHocKyNamHocHienHanh))
        {
            return redirect()->back()->withInput()->with('warning', 'Giảng viên phụ trách lớp này đã tồn tại.');
        }
        else
        {
            // 2. Store
            self::store($idCBGV, $idLop, $idHocKyNamHocHienHanh);
            return redirect()->route('admin_covanhoctap')->with('success', 'Lưu thành công!');
        }
    }

    public function subadmin_store(CoVanHocTapRequest $request)
    {
        $idCBGV = $request->cbgv;
        $idLop = $request->lop;
        $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        
        // 1. Kiểm tra tồn tại
        if(self::isExistCoVanHocTap($idCBGV, $idLop, $idHocKyNamHocHienHanh))
        {
            return redirect()->back()->withInput()->with('warning', 'Giảng viên phụ trách lớp này đã tồn tại.');
        }
        else
        {
            // 2. Store
            self::store($idCBGV, $idLop, $idHocKyNamHocHienHanh);
            return redirect()->route('subadmin_covanhoctap')->with('success', 'Lưu thành công!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CoVanHocTap  $coVanHocTap
     * @return \Illuminate\Http\Response
     */
    public function show(CoVanHocTap $coVanHocTap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CoVanHocTap  $coVanHocTap
     * @return \Illuminate\Http\Response
     */
    public function edit(CoVanHocTap $coVanHocTap)
    {
        //
    }


    public function admin_edit($idCoVanHocTap='')
    {
        $coVanHocTap = CoVanHocTap::find($idCoVanHocTap);
        $dsCanBoGiangVien = CanBoGiangVienController::DanhSachCanBoGiangVien();
        $dsLop = Lop::leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date('Y'))
            -> orderBy('lop.tenlop', 'asc')
            -> select('lop.*')
            -> get();

        return view('admin.covanhoctapedit', ['coVanHocTap'=>$coVanHocTap, 'dsCanBoGiangVien'=>$dsCanBoGiangVien, 'dsLop'=>$dsLop]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CoVanHocTap  $coVanHocTap
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, CoVanHocTap $coVanHocTap)
    // {
    //     //
    // }

    public function update($idCVHT, $idCBGV, $idLop, $idHocKyNamHoc)
    {
        try {
            $coVanHocTap = CoVanHocTap::find($idCVHT);
            if(!$coVanHocTap)
                $coVanHocTap = new CoVanHocTap();
            $coVanHocTap->canbogiangvien_id = $idCBGV;
            $coVanHocTap->lop_id = $idLop;
            $coVanHocTap->hockynamhoc_id_batdau = $idHocKyNamHoc;
            $coVanHocTap->trangthai_id = 1;
            $coVanHocTap->save();
        } catch (Exception $e) {
            
        }
        return true;
    }

    public function admin_update(CoVanHocTapRequest $request)
    {
        $idCVHT = $request->idcovanhoctap;
        $idCBGV = $request->cbgv;
        $idLop = $request->lop;

        $idHocKyNamHocHienHanh = HocKyNamHocController::getIdHocKyNamHocHienHanh();
        
        // 1. Kiểm tra tồn tại
        if(self::isExistCoVanHocTapUpdate($idCVHT, $idCBGV, $idLop, $idHocKyNamHocHienHanh))
        {
            return redirect()->back()->withInput()->with('warning', 'Giảng viên phụ trách lớp này đã tồn tại.');
        }
        else
        {
            // 2. Update
            self::update($idCVHT,$idCBGV, $idLop, $idHocKyNamHocHienHanh);
            return redirect()->route('admin_covanhoctap')->with('success', 'Lưu thành công!');
        }
    }

    public function subadmin_updatestatus($idCoVanHocTap)
    {
        try {
            $coVanHocTap = CoVanHocTap::find($idCoVanHocTap);
            $coVanHocTap->trangthai_id = 2;
            $coVanHocTap->save();
        } catch (Exception $e) {
            return redirect()->route('subadmin_covanhoctap')->with('success', 'Xóa không thành công!');
        }
        return redirect()->route('subadmin_covanhoctap')->with('success', 'Xóa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CoVanHocTap  $coVanHocTap
     * @return \Illuminate\Http\Response
     */
    public function destroy(CoVanHocTap $coVanHocTap)
    {
        //
    }

    // Function my define

    public function admin_destroy($id='')
    {
        if(Auth::check())
        {
            CoVanHocTap::destroy($id);
            return redirect()->route('admin_covanhoctap')->with("success", "Xóa thành công!");
        }
        return redirect()->route('home');
    }

    public function subadmin_destroy($id='')
    {
        if(Auth::check())
        {
            CoVanHocTap::destroy($id);
            return redirect()->route('subadmin_covanhoctap')->with("success", "Xóa thành công!");
        }
        return redirect()->route('home');
    }

    public function isExistCoVanHocTap($idCBGV, $idLop, $idHocKyNamHoc)
    {
        $coVanHocTap = CoVanHocTap::where('canbogiangvien_id', '=', $idCBGV)
            -> where('lop_id', '=', $idLop)
            -> where('hockynamhoc_id_batdau', '=', $idHocKyNamHoc)
            -> where('trangthai_id', '=', 1)
            -> get();
        return count($coVanHocTap)>0? true : false;
    }

    public function isExistCoVanHocTapUpdate($idCVHT, $idCBGV, $idLop, $idHocKyNamHoc)
    {
        $coVanHocTap = CoVanHocTap::where('canbogiangvien_id', '=', $idCBGV)
            -> where('lop_id', '=', $idLop)
            -> where('hockynamhoc_id_batdau', '=', $idHocKyNamHoc)
            -> where('id', '<>', $idCVHT)
            -> where('trangthai_id', '=', 1)
            -> get();

        return count($coVanHocTap)>0? true : false;
    }

    public static function isCoVanHocTap($idCBGV='')
    {
        $coVanHocTap = CoVanHocTap::where('canbogiangvien_id', '=', $idCBGV)-> where('trangthai_id', '=', 1)-> get();
        return count($coVanHocTap) ? true : false;
    }

    public static function CoVanHocTapCount()
    {
        return count(CoVanHocTap::select('canbogiangvien_id')->groupBy('canbogiangvien_id')->get());
    }
}
