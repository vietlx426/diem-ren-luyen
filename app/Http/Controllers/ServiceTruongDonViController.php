<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceTruongDonViController extends Controller
{
    public function index()
    {
        $studentTotal = ServiceSinhVienController::SinhVienCount();
        $classTotal = LopController::LopCount();
        $staffTotal = CanBoGiangVienController::CanBoGiangVienCount();
        $adviserTotal = CoVanHocTapController::CoVanHocTapCount();
		$dataStaticalKind = ServiceAdminController::StaticalKind();

        return view('truongdonvi.index', ['studentTotal'=>$studentTotal, 'classTotal'=>$classTotal, 'staffTotal'=>$staffTotal, 'dataStaticalKind'=>$dataStaticalKind, 'adviserTotal'=>$adviserTotal]);
	}
}
