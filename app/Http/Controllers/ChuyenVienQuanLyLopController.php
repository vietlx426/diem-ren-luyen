<?php

namespace App\Http\Controllers;

use App\ChuyenVienQuanLyLop;
use Illuminate\Http\Request;
use Auth;
use App\CanBoGiangVien;
use App\Khoa;

class ChuyenVienQuanLyLopController extends Controller
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
        $dsChuyenVienQuanLyLop = ChuyenVienQuanLyLop::where('trangthai_id', '=', 1)
            -> leftjoin('canbogiangvien', 'canbogiangvien.id', '=', 'chuyenvien_lop.cbgv_id')
            -> orderBy('canbogiangvien.ten', 'asc')
            -> orderBy('canbogiangvien.hochulot', 'asc')
            -> select('chuyenvien_lop.cbgv_id')
            -> groupBy('chuyenvien_lop.cbgv_id')
            -> get();

        return view('admin.chuyenvienquanlyloplist', ['dsChuyenVienQuanLyLop'=>$dsChuyenVienQuanLyLop]);
    }

    public function truongdonviindex()
    {
        $dsChuyenVienQuanLyLop = ChuyenVienQuanLyLop::where('trangthai_id', '=', 1)
            -> leftjoin('canbogiangvien', 'canbogiangvien.id', '=', 'chuyenvien_lop.cbgv_id')
            -> orderBy('canbogiangvien.ten', 'asc')
            -> orderBy('canbogiangvien.hochulot', 'asc')
            -> select('chuyenvien_lop.cbgv_id')
            -> groupBy('chuyenvien_lop.cbgv_id')
            -> get();

        return view('truongdonvi.chuyenvienquanlyloplist', ['dsChuyenVienQuanLyLop'=>$dsChuyenVienQuanLyLop]);
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
        $dsCanBoGiangVien = CanBoGiangVien::orderBy('ten')->get();
        $dsKhoa = Khoa::where('loaikhoaphong_id', '=', 1)->orderBy('tenkhoa', 'asc')->get();
        
        return view('admin.chuyenvienquanlylopcreate', ['dsCanBoGiangVien'=>$dsCanBoGiangVien, 'dsKhoa'=>$dsKhoa]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idCBGV = $request->cbgv;

        foreach ($request->lop as $key => $idLop) {
            $chuyenVienQuanLyLop = ChuyenVienQuanLyLop::where('cbgv_id', '=', $idCBGV)
                -> where('lop_id', '=', $idLop)
                -> get();
            if(count($chuyenVienQuanLyLop) == 0)
            {
                $chuyenVienQuanLyLop = new ChuyenVienQuanLyLop();
                $chuyenVienQuanLyLop->cbgv_id = $idCBGV;
                $chuyenVienQuanLyLop->lop_id = $idLop;
                $chuyenVienQuanLyLop->trangthai_id = 1;
                $chuyenVienQuanLyLop->save();
            }
        }
    }

    public function adminstore(Request $request)
    {
        $arrayResult = self::ValidateStore($request);
        if($arrayResult['result'])
        {
            try {
                /* 1. Delete lớp quản lý hiện tại */
                self::RemoveClassCurrent($request->cbgv, $request->lop);

                /* 2. Lưu mới */    
                self::store($request);

                return redirect()->route('admin_expers')->with('success', "Lưu thành công!");
            } catch (Exception $e) {
                return redirect()->route('admin_expers_create')->with('danger', "Lưu không thành công! Vui lòng thử lại.");
            }
            
        }
        else
        {
            return redirect()->back()->withInput()->with('warning', $arrayResult['messages']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChuyenVienQuanLyLop  $chuyenVienQuanLyLop
     * @return \Illuminate\Http\Response
     */
    public function show(ChuyenVienQuanLyLop $chuyenVienQuanLyLop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChuyenVienQuanLyLop  $chuyenVienQuanLyLop
     * @return \Illuminate\Http\Response
     */
    public function edit(ChuyenVienQuanLyLop $chuyenVienQuanLyLop)
    {
        //
    }

    public function adminedit($idCBGV='')
    {
        $dsCanBoGiangVien = CanBoGiangVien::orderBy('ten')->get();
        $dsKhoa = Khoa::where('loaikhoaphong_id', '=', 1)->orderBy('tenkhoa', 'asc')->get();
        $dsLopDangPhuTrach = ChuyenVienQuanLyLop::where('cbgv_id', '=', $idCBGV)->get();
        $canBoGiangVien = CanBoGiangVien::find($idCBGV);
        
        return view('admin.chuyenvienquanlylopedit', ['canBoGiangVien'=>$canBoGiangVien, 'dsCanBoGiangVien'=>$dsCanBoGiangVien, 'dsKhoa'=>$dsKhoa, 'dsLopDangPhuTrach'=>$dsLopDangPhuTrach]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChuyenVienQuanLyLop  $chuyenVienQuanLyLop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChuyenVienQuanLyLop $chuyenVienQuanLyLop)
    {
        //
    }

    public function adminupdate(Request $request)
    {
        $arrayResult = self::ValidateUpdate($request);
        if($arrayResult['result'])
        {
            try {
                /* 1. Delete lớp quản lý hiện tại */
                self::RemoveClassCurrent($request->cbgv, $request->lop);

                /* 2. Lưu mới */    
                self::store($request);

                return redirect()->route('admin_expers')->with('success', "Lưu thành công!");
            } catch (Exception $e) {
                return redirect()->route('admin_expers_edit', ['id'=>$request->cbgv])->with('danger', "Lưu không thành công! Vui lòng thử lại.");
            }
        }
        else
        {
            return redirect()->back()->withInput()->with('warning', $arrayResult['messages']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChuyenVienQuanLyLop  $chuyenVienQuanLyLop
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChuyenVienQuanLyLop $chuyenVienQuanLyLop)
    {
        //
    }

    public function admindestroy($idCBGV)
    {
        try {
            ChuyenVienQuanLyLop::where('cbgv_id', '=', $idCBGV)
                -> update(['trangthai_id' => 2]);
        } catch (\Throwable $th) {
            return redirect()->route('admin_expers')->with("warning", "Xóa bị lỗi<br>" . $th->getMessage());
        }
        return redirect()->route('admin_expers')->with("success", "Xóa thành công");
    }

    // Function my define
    public function chuyenvien_lop_danhgiadiemrenluyen()
    {
        $idCBGVSV = Auth::user()->cbgvsv_id;
        $listLop = ChuyenVienQuanLyLop::where('cbgv_id', '=', $idCBGVSV)
            -> where('trangthai_id', '=', 1)
            -> join('lop', 'lop.id', '=', 'chuyenvien_lop.lop_id')
            -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>=', date('Y'))
            -> select('lop.*')
            -> orderBy('lop.tenlop', 'asc')
            -> get();
        return view('subadmin.danhgiadiemrenluyen_loplist', ['listLop'=>$listLop]);
    }

    public static function isChuyenVienQuanLyLop($idCBGV='')
    {
        $chuyenVienQuanLyLop = ChuyenVienQuanLyLop::where('cbgv_id', '=', $idCBGV)
            -> where('trangthai_id', '=', 1)
            -> get();
        return count($chuyenVienQuanLyLop) ? true : false;
    }

    public static function ChuyenVienQuanLyLop($idCBGV='')
    {
        $dsChuyenVienQuanLyLop = ChuyenVienQuanLyLop::where('cbgv_id', '=', $idCBGV)
            -> where('trangthai_id', '=', 1)
            -> get();
        return $dsChuyenVienQuanLyLop;
    }

    public function ValidateStore($request='')
    {
        $arrayResult = array('result' => true, 'messages'=>"");
        if($request)
        {
            if($request->cbgv)
            {
                $canBoGiangVien = ChuyenVienQuanLyLop::leftjoin('lop', 'lop.id', 'chuyenvien_lop.lop_id')
                    -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
                    -> where('khoahoc.namketthuc', '>', date('Y'))
                    -> where('chuyenvien_lop.cbgv_id', '=', $request->cbgv_id)
                    -> select('chuyenvien_lop.*')
                    -> get();
                if(count($canBoGiangVien) > 0)
                {
                    $arrayResult['result'] = false;
                    $arrayResult['messages'] .= "<br>Cán bộ quản lý có trong dữ liệu";
                }
            }
            else
            {
                $arrayResult['result'] = false;
                $arrayResult['messages'] .= "<br>Vui lòng chọn cán bộ quản lý";
            }

            if(count($request->lop) == 0)
            {
                $arrayResult['result'] = false;
                $arrayResult['messages'] .= "<br>Vui lòng chọn lớp quản lý";
            }
            
        }
        return $arrayResult;
    }

    public function ValidateUpdate($request='')
    {
        $arrayResult = array('result' => true, 'messages'=>"");
        if($request)
        {
            if(!$request->cbgv)
            {
                $arrayResult['result'] = false;
                $arrayResult['messages'] .= "<br>Vui lòng chọn cán bộ quản lý";
            }

            if(count($request->lop) == 0)
            {
                $arrayResult['result'] = false;
                $arrayResult['messages'] .= "<br>Phải chọn lớp";
            }
            
        }
        return $arrayResult;
    }

    public function RemoveClassCurrent($idCBGV='', $arrayLop)
    {
        ChuyenVienQuanLyLop::leftjoin('lop', 'lop.id', 'chuyenvien_lop.lop_id')
            -> leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            -> where('khoahoc.namketthuc', '>', date('Y'))
            -> where('chuyenvien_lop.cbgv_id', '=', $idCBGV)
            -> whereNotIn('chuyenvien_lop.lop_id', $arrayLop)
            -> select('chuyenvien_lop.*')
            -> delete();
    }
}
