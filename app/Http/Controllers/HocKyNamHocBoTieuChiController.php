<?php

namespace App\Http\Controllers;

use App\HocKyNamHocBoTieuChi;
use Illuminate\Http\Request;
use App\HocKyNamHoc;
use App\BoTieuChi;
use App\Http\Requests\HocKyNamHocBoTieuChiRequest;
use App\SinhVien;
use App\TieuChi;
use App\BangDiemRenLuyen;

class HocKyNamHocBoTieuChiController extends Controller
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
        $dsHocKyNamHoc = HocKyNamHoc::orderBy('hocky_namhoc.id', 'desc')->get();
        return view('admin.hockynamhocbotieuchilist', ['dsHocKyNamHoc' => $dsHocKyNamHoc]);
    }

    public function truongdonviindex()
    {
        $dsHocKyNamHoc = HocKyNamHoc::orderBy('hocky_namhoc.id', 'desc')->get();
        return view('truongdonvi.hockynamhocbotieuchilist', ['dsHocKyNamHoc' => $dsHocKyNamHoc]);
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

    public function admincreate($idHocKyNamHoc='')
    {
        $hocKyNamHoc = HocKyNamHoc::find($idHocKyNamHoc);
        $dsBoTieuChi = BoTieuChi::orderBy('id', 'desc')->take(5)->get();
        return view('admin.hockynamhocbotieuchicreate', ['hocKyNamHoc'=>$hocKyNamHoc, 'dsBoTieuChi'=>$dsBoTieuChi]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
    }

    public function adminstore(HocKyNamHocBoTieuChiRequest $request)
    {
        try {
            $hocKyNamHocBoTieuChi = new HocKyNamHocBoTieuChi();
            $hocKyNamHocBoTieuChi->hockynamhoc_id = $request->idhockynamhoc;
            $hocKyNamHocBoTieuChi->botieuchi_id = $request->botieuchi;
            $hocKyNamHocBoTieuChi->save();
            return redirect()->route('admin_hockynamhocbotieuchi_index')->with('success', "Lưu thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('danger', "Lưu không thành công<br>" . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HocKyNamHocBoTieuChi  $hocKyNamHocBoTieuChi
     * @return \Illuminate\Http\Response
     */
    public function show(HocKyNamHocBoTieuChi $hocKyNamHocBoTieuChi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HocKyNamHocBoTieuChi  $hocKyNamHocBoTieuChi
     * @return \Illuminate\Http\Response
     */
    public function edit(HocKyNamHocBoTieuChi $hocKyNamHocBoTieuChi)
    {
        //
    }

    public function adminedit($idHocKyNamHocBoTieuChi='')
    {
        $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::find($idHocKyNamHocBoTieuChi);
        $dsBoTieuChi = BoTieuChi::orderBy('id', 'desc')->take(5)->get();
        return view('admin.hockynamhocbotieuchiedit', ['hocKyNamHocBoTieuChi'=>$hocKyNamHocBoTieuChi, 'dsBoTieuChi'=>$dsBoTieuChi]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HocKyNamHocBoTieuChi  $hocKyNamHocBoTieuChi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HocKyNamHocBoTieuChi $hocKyNamHocBoTieuChi)
    {
        //
    }

    public function adminupdate(HocKyNamHocBoTieuChiRequest $request)
    {
        try {
            // TODO: Kiểm tra xem bộ tiêu chí đã dược áp dụng cộng điểm chưa, nếu chưa thì ko cho update
            $hocKyNamHocBoTieuChi = HocKyNamHocBoTieuChi::find($request->idhockynamhocbotieuchi);
            $hocKyNamHocBoTieuChi->botieuchi_id = $request->botieuchi;
            $hocKyNamHocBoTieuChi->save();
            return redirect()->route('admin_hockynamhocbotieuchi_index')->with('success', "Lưu thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('danger', "Lưu không thành công<br>" . $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HocKyNamHocBoTieuChi  $hocKyNamHocBoTieuChi
     * @return \Illuminate\Http\Response
     */
    public function destroy(HocKyNamHocBoTieuChi $hocKyNamHocBoTieuChi)
    {
        //
    }

    public function admingeneratemark($idHocKyNamHoc, $idBoTieuChi)
    {
        $dsSinhVien = SinhVien::leftjoin('lop', 'lop.id', '=', 'sinhvien.lop_id')
            ->leftjoin('khoahoc', 'khoahoc.id', '=', 'lop.khoahoc_id')
            ->where('khoahoc.namketthuc', '>=', date('Y'))
            ->select('sinhvien.*')
            ->get();
        $dsTieuChi = TieuChi::where('botieuchi_id', '=', $idBoTieuChi)->get();
        
        foreach($dsSinhVien as $key => $sinhVien)
        {
            foreach ($dsTieuChi as $key => $tieuChi) {
                BangDiemRenLuyen::firstOrCreate(array('hocky_namhoc_id'=>$idHocKyNamHoc, 'sinhvien_id'=>$sinhVien->id, 'tieuchi_id'=>$tieuChi->id, 'maxdiem'=>$tieuChi->diemtoida));
            }
        }
        HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $idHocKyNamHoc)->where('botieuchi_id', '=', $idBoTieuChi)->update(['taobangdiem'=>1]);
        return redirect()->route('admin_hockynamhocbotieuchi_index')->with('success', "Tạo bảng điểm thành công.");
    }

    public static function hasBangDiemTieuChi($hocKyNamHocBoTieuChi)
    {
        $dsIdTieuChi=TieuChi::where('botieuchi_id', '=', $hocKyNamHocBoTieuChi->botieuchi_id)->get();

        $dsBangDiemTieuChi = BangDiemRenLuyen::where('hocky_namhoc_id', '=', $hocKyNamHocBoTieuChi->hockynamhoc_id)
            ->whereIn('tieuchi_id', $dsIdTieuChi)
            ->get();
        return count($dsBangDiemTieuChi);
    }

    public static function HocKyNamHocBoTieuChi($idHocKyNamHoc)
    {
        return HocKyNamHocBoTieuChi::where('hockynamhoc_id', '=', $idHocKyNamHoc)->first();
    }

}
