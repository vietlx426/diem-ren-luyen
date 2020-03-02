<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// ----------------Test-------------------------
// Route::get('test', 'BoMonController@WriteNewInsertRecordLog')->name("test");

Route::get('encrypt', 'EncryptionController@Encrytion');
Route::get('getExportSinhVien', 'SinhVienController@getExportSinhVien')
	->name('exportsinhvien');

Route::get('getImportSinhVien', 'SinhVienController@getImportSinhVien')
	->name('importsinhvien');

Route::get('searchstudent', 'SinhVienController@SearchStudent') ->name('exportsinhvien');

Route::get('profilesv', 'LyLichSinhVienRegisterController@create')
	->name('profilesv');

Route::post('post_profilesv', 'LyLichSinhVienRegisterController@store')
	->name('post_profilesv');

Route::get('welcome', function(){
	return redirect('/');// view('sinhvien.index');
})->name('welcome');

Route::get('instruction', function(){
	return view('sinhvien.instruction');
})->name('instruction');

Route::get('profile-instruction', function(){
	return view('sinhvien.profile_instruction');
})->name('profile_instruction');


// ---------------------------------------

// Route::get('', function(){
//     return redirect()->route('redirect-login');
// })->name('index');

Route::get('', 'Auth\LoginController@RedirectDashboard')->name('index');

Route::get('home', 'Auth\LoginController@RedirectDashboard'
    // return redirect()->route('redirect-login');
    // return view('index');
)->name('home');




Route::get('/info-alert', function(){
	return view('layout.alertmessage.infoalert');
})->name('info.alert');



Route::get('lopajax/{id}', 'LopController@getLop')->name('lopajax');
Route::get('huyenajax/{tinh_id?}', 'HuyenController@getHuyen')->name('huyenajax');
Route::get('xaajax/{huyen_id?}', 'XaController@getXa')->name('xaajax');
Route::get('searchsinhvienajax/{mssv?}', 'SinhVienController@getSinhVien')->name('searchsinhvienajax');
Route::get('searchsinhvienajax2/{value?}/{type?}', 'SinhVienController@getSearchSinhVien')->name('searchsinhvienajax_multiparameter');





Route::middleware('chuyenvienhethong')->prefix('subadmin')->group(function(){
	Route::get('', 'SubAdminController@index')->name('subadmin');

	// Danh sách sinh viên
	Route::get('search-student-id', function(){
		return view('subadmin.timsinhvien');
	}) ->name('studentsearch');

	// Route::get('student-list', 'SinhVienController@getStudentList')
	// 	->name('studentlist');

	Route::get('student-list', 'SinhVienController@index')
		->name('studentlist');

	// Route::get('student-profile', 'SinhVienController@getStudentProfile')
	// 	->name('studentprofileurl');

	Route::get('student-profile/{id?}', 'SinhVienController@getStudentProfile')
		->name('studentprofile')
		->where('id', '[0-9]+');

	Route::get('student-profile-pic', 'SinhVienController@getStudentProfilePic')
		->name('studentprofilepicurl');

	Route::get('student-profile-pic/{id?}', 'SinhVienController@getStudentProfilePic')
		->name('studentprofilepic')
		->where('id', '[0-9]+');

	Route::post('student-profile', 'SinhVienController@postPicforStudentCard')
		-> name('postpicforstudentcard');

	Route::get('updated-student-profile', 'SinhVienController@getUpdatedStudentProfile')
		->name('updatedstudentprofile');

	Route::get('updated-student-profile/khoa/{id}', 'SinhVienController@getUpdatedStudentProfileFalcuty')
		->name('updatedstudentprofilefalcuty');

	Route::get('loaihd','LoaiHoatDongSuKienController@index')->name('loaihd');

	Route::post('loaihd','LoaiHoatDongSuKienController@store')->name('post_loaihd');
	
	Route::post('loaihd/update', 'LoaiHoatDongSuKienController@update')
		->name('post_loaihd_update');

	Route::get('loaihd/del/{id}', 'LoaiHoatDongSuKienController@destroy')
		->name('loaihd_destroy')
		->where('id', '[0-9]+');

	Route::get('hoatdongsukien','HoatDongSuKienController@index')->name('hoatdongsukien');
	Route::post('hoatdongsukien','HoatDongSuKienController@store')->name('post_hdsk');	
	Route::get('hoatdongsukien/add','HoatDongSuKienController@create')->name('subadmin_hoatdongsukien_add');
	Route::post('hoatdongsukien/add','HoatDongSuKienController@store')->name('post_subadmin_hoatdongsukien_add');
	Route::get('hoatdongsukien/update/{id}','HoatDongSuKienController@edit')->name('subadmin_hoatdongsukien_edit')
		->where('id','[0-9]+');
	Route::post('hoatdongsukien/update/{id}','HoatDongSuKienController@update')->name('post_subadmin_hoatdongsukien_edit')
		->where('id','[0-9]+');

	Route::post('hoatdongsukien/update', 'HoatDongSuKienController@update')
			->name('post_hdsk_update');

	Route::get('hoatdongsukien/del/{id}', 'HoatDongSuKienController@destroy')
			->name('hdsk_destroy')
			->where('id', '[0-9]+');
	Route::get('hoatdongsukien/excel','HoatDongSuKienController@excel')->name('export_excel');

	Route::get('hoatdongsukien/import', 'HoatDongSuKienController@ImportHDSK')->name('hdsk_import');

	Route::post('hoatdongsukien/import', 'HoatDongSuKienController@storeImportHDSK')->name('post_hdsk_import');
	Route::get('hoatdongsukien-danhsachsinhvien/{idhoatdongsukien}','DangKyHoatDongSuKienController@show')->name('subadmin_hoatdongsukien_danhsachsinhvien');

	Route::get('hoatdongsukien/danhsachsinhvien/import','DangKyHoatDongSuKienController@ImportStudent')->name('sv_hdsk_import');
	Route::post('hoatdongsukien-danhsachsinhvien/import','DangKyHoatDongSuKienController@storeImportStudent')->name('post_sinhvien_hoatdongsukien_import');

	Route::get('hoatdongsukien/danhsachsinhvien/export/{idhoatdongsukien}','DangKyHoatDongSuKienController@excel')->name('sv_hdsk_export');
	Route::get('hoatdongsukien/danhsachsinhvien/del/{id}', 'DangKyHoatDongSuKienController@destroy')
			->name('dkhdsk_destroy')
			->where('id', '[0-9]+');

	/**
	 * User
	 */
		Route::get('user', 'UserController@index')->name('user');
		Route::get('user-group/edit/{iduser?}', 'UserController@show')->name('usergroupedit');
		Route::post('user-group/update', 'UserController@update')->name('postusergroupupdate');
		Route::get('user-group/filter/khoa/{id?}', 'UserController@showKhoa')->name('usergroupkhoa');
		Route::get('user-group/filter/nganh/{id?}', 'UserController@showNganh')->name('usergroupnganh');
		Route::get('user-group/filter/khoahoc/{id?}', 'UserController@showKhoaHoc')->name('usergroupkhoahoc');
		Route::get('user-group/filter/lop/{lop?}', 'UserController@showLop')->name('usergrouplop');
		Route::get('user-group/filter/mssv/{mssv?}', 'UserController@showMSSV')->name('usergroupmssv');
		Route::get('user-group/filter/email/{email?}', 'UserController@showEmail')->name('usergroupemail');
		Route::get('user-group/donvi/{iduser?}/{idloaiuser?}', 'UserController@getDonVi')->name('getdonvi');
	/**
	 * User
	 */

	/**
	 * Student
	 */
		Route::get('staff', 'CanBoGiangVienController@index')->name('staff');
		Route::get('staff/edit/{idstaff?}', 'CanBoGiangVienController@show')->name('staffedit');
		Route::post('staff/update', 'CanBoGiangVienController@update')->name('poststaffupdate');
		Route::get('student/edit/{id?}', 'SinhVienController@show')->name('studentedit');
		Route::post('student/update', 'SinhVienController@update')->name('poststudentupdate');

		Route::get('student/filter/khoa/{id?}', 'SinhVienController@showKhoa')->name('studentbykhoa');
		Route::get('student/filter/nganh/{id?}', 'SinhVienController@showNganh')->name('studentbynganh');
		Route::get('student/filter/khoahoc/{id?}', 'SinhVienController@showKhoaHoc')->name('studentbykhoahoc');
		Route::get('student/filter/lop/{lop?}', 'SinhVienController@showLop')->name('studentbylop');
		Route::get('student/filter/mssv/{mssv?}', 'SinhVienController@showMSSV')->name('studentbymssv');
		Route::get('student/filter/email/{email?}', 'SinhVienController@showEmail')->name('studentbyemail');
		
	/**
	 * End Student
	 */

	/**
	 * Staff
	 */
		Route::get('s/edit/{id?}', 'SinhVienController@show')->name('studentedit');
		Route::post('student/update', 'SinhVienController@update')->name('poststudentupdate');

		Route::get('student/filter/khoa/{id?}', 'SinhVienController@showKhoa')->name('studentbykhoa');
		Route::get('student/filter/nganh/{id?}', 'SinhVienController@showNganh')->name('studentbynganh');
		Route::get('student/filter/khoahoc/{id?}', 'SinhVienController@showKhoaHoc')->name('studentbykhoahoc');
		Route::get('student/filter/lop/{lop?}', 'SinhVienController@showLop')->name('studentbylop');
		Route::get('student/filter/mssv/{mssv?}', 'SinhVienController@showMSSV')->name('studentbymssv');
		Route::get('student/filter/email/{email?}', 'SinhVienController@showEmail')->name('studentbyemail');
		
	/**
	 * End Staff
	 */

});

/**
 * --------- Admin, Danh mục ---------
 */
Route::middleware('quantrihethong')->prefix('admin')->group(function(){
	Route::get('', function(){
		return view('admin.index');
		}) ->name('admin');

	Route::get('trangthaihocky', 'TrangThaiHocKyController@index')
		->name('trangthaihocky');

	Route::post('trangthaihocky', 'TrangThaiHocKyController@store')
		->name('post_trangthaihocky');

	Route::post('trangthaihocky/update', 'TrangThaiHocKyController@update')
		->name('post_trangthaihocky_update');

	Route::get('trangthaihocky/del/{id}', 'TrangThaiHocKyController@destroy')
		->name('trangthaihocky_destroy')
		->where('id', '[0-9]+');

	Route::get('hocky', 'HocKyController@index')
		->name('hocky');

	Route::post('hocky', 'HocKyController@store')
		->name('post_hocky');

	Route::post('hocky/update', 'HocKyController@update')
		->name('post_hocky_update');

	Route::get('hocky/del/{id}', 'HocKyController@destroy')
		->name('hocky_destroy')
		->where('id', '[0-9]+');

	Route::get('namhoc', 'NamHocController@index')
		->name('namhoc');

	Route::post('namhoc', 'NamHocController@store')
		->name('post_namhoc');

	Route::post('namhoc/update', 'NamHocController@update')
		->name('post_namhoc_update');

	Route::get('namhoc/del/{id}', 'NamHocController@destroy')
		->name('namhoc_destroy')
		->where('id', '[0-9]+');

	Route::get('hockynamhoc', 'HocKyNamHocController@index')
		->name('hockynamhoc');

	Route::post('hockynamhoc', 'HocKyNamHocController@store')
		->name('post_hockynamhoc');

	Route::post('hockynamhoc/update', 'HocKyNamHocController@update')->name('post_hockynamhoc_update');

	Route::get('hockynamhoc/del/{id}', 'HocKyNamHocController@destroy')
		->name('hockynamhoc_destroy')
		->where('id', '[0-9]+');

	// Tiêu chí
	Route::get('tieuchi', 'TieuChiController@index')
		->name('tieuchi');

	Route::post('tieuchi', 'TieuChiController@store')
		->name('post_tieuchi');

	Route::post('tieuchi/update', 'TieuChiController@update')
		->name('post_tieuchi_update');

	Route::get('tieuchi/del/{id}', 'TieuChiController@destroy')
		->name('tieuchi_destroy')
		->where('id', '[0-9]+');

	// Bậc đào tạo
	Route::get('bacdaotao', 'BacDaoTaoController@index')
		-> name('bacdaotao');

	Route::post('bacdaotao', 'BacDaoTaoController@store')
		->name('post_bacdaotao');

	Route::post('bacdaotao/update', 'BacDaoTaoController@update')
		->name('post_bacdaotao_update');

	Route::get('bacdaotao/del/{id}', 'BacDaoTaoController@destroy')
		->name('bacdaotao_destroy')
		->where('id', '[0-9]+');

	// Hệ đào tạo
	Route::get('hedaotao', 'HeDaoTaoController@index')
		-> name('hedaotao');

	Route::post('hedaotao', 'HeDaoTaoController@store')
		->name('post_hedaotao');

	Route::post('hedaotao/update', 'HeDaoTaoController@update')
		->name('post_hedaotao_update');

	Route::get('hedaotao/del/{id}', 'HeDaoTaoController@destroy')
		->name('hedaotao_destroy')
		->where('id', '[0-9]+');

	// Dân tộc
	Route::get('dantoc', 'DanTocController@index')
		-> name('dantoc');

	Route::post('dantoc', 'DanTocController@store')
		->name('post_dantoc');

	Route::post('dantoc/update', 'DanTocController@update')
		->name('post_dantoc_update');

	Route::get('dantoc/del/{id}', 'DanTocController@destroy')
		->name('dantoc_destroy')
		->where('id', '[0-9]+');

	// Tôn giáo
	Route::get('tongiao', 'TonGiaoController@index')
		-> name('tongiao');

	Route::post('tongiao', 'TonGiaoController@store')
		->name('post_tongiao');

	Route::post('tongiao/update', 'TonGiaoController@update')
		->name('post_tongiao_update');

	Route::get('tongiao/del/{id}', 'TonGiaoController@destroy')
		->name('tongiao_destroy')
		->where('id', '[0-9]+');

	// Loại điểm (loại tiêu chí)
	Route::get('loaidiem', 'LoaiDiemController@index')
		-> name('loaidiem');

	Route::post('loaidiem', 'LoaiDiemController@store')
		->name('post_loaidiem');

	Route::post('loaidiem/update', 'LoaiDiemController@update')
		->name('post_loaidiem_update');

	Route::get('loaidiem/del/{id}', 'LoaiDiemController@destroy')
		->name('loaidiem_destroy')
		->where('id', '[0-9]+');

	// Trạng thái tiêu chí
	Route::get('trangthaitieuchi', 'TrangThaiTieuChiController@index')
		-> name('trangthaitieuchi');

	Route::post('trangthaitieuchi', 'TrangThaiTieuChiController@store')
		->name('post_trangthaitieuchi');

	Route::post('trangthaitieuchi/update', 'TrangThaiTieuChiController@update')
		->name('post_trangthaitieuchi_update');

	Route::get('trangthaitieuchi/del/{id}', 'TrangThaiTieuChiController@destroy')
		->name('trangthaitieuchi_destroy')
		->where('id', '[0-9]+');

	// Xếp loại điểm rèn luyện
	Route::get('xeploaidiemrenluyen', 'XepLoaiDiemRenLuyenController@index')
		-> name('xeploaidiemrenluyen');

	Route::post('xeploaidiemrenluyen', 'XepLoaiDiemRenLuyenController@store')
		->name('post_xeploaidiemrenluyen');

	Route::post('xeploaidiemrenluyen/update', 'XepLoaiDiemRenLuyenController@update')
		->name('post_xeploaidiemrenluyen_update');

	Route::get('xeploaidiemrenluyen/del/{id}', 'XepLoaiDiemRenLuyenController@destroy')
		->name('xeploaidiemrenluyen_destroy')
		->where('id', '[0-9]+');

	Route::get('khoa', 'KhoaController@index')
		->name('khoa');

	Route::post('khoa', 'KhoaController@store')
		->name('post_khoa');

	Route::post('khoa/update', 'KhoaController@update')
		->name('post_khoa_update');

	Route::get('khoa/del/{id}', 'KhoaController@destroy')
		->name('khoa_destroy')
		->where('id', '[0-9]+');

	Route::get('bomon', 'BoMonController@index')
		->name('bomon');

	Route::post('bomon', 'BoMonController@store')
		->name('post_bomon');

	Route::post('bomon/update', 'BoMonController@update')
		->name('post_bomon_update');

	Route::get('bomon/del/{id}', 'BoMonController@destroy')
		->name('bomon_destroy')
		->where('id', '[0-9]+');

	Route::get('nganh', 'NganhController@index')
		->name('nganh');

	Route::post('nganh', 'NganhController@store')
		->name('post_nganh');

	Route::post('nganh/update', 'NganhController@update')
		->name('post_nganh_update');

	Route::get('nganh/del/{id}', 'NganhController@destroy')
		-> name('nganh_destroy')
		-> where('id', '[0-9]+');

	Route::get('lop', 'LopController@index')
		->name('lop');

	Route::post('lop', 'LopController@store')
		->name('post_lop');

	Route::post('lop/update', 'LopController@update')
		->name('post_lop_update');

	Route::get('lop/del/{id}', 'LopController@destroy')
		-> name('lop_destroy')
		-> where('id', '[0-9]+');

	Route::get('sinhvien/loc', 'AdminSinhVienTimKiemController@index')->name('admin_sinhvien_timkiem');
	Route::get('sinhvien/import', 'ServiceSinhVienController@ImportStudent')->name('admin_sinhvien_import');
	Route::post('sinhvien/import', 'ServiceSinhVienController@storeImportStudent')->name('post_admin_sinhvien_import');

	Route::get('canbogiangvien', 'CanBoGiangVienController@adminindex')->name('admin_canbogiangvien');
	Route::get('canbogiangvien/add', 'CanBoGiangVienController@admincreate')->name('admin_canbogiangvien_add');
	Route::get('canbogiangvien/edit/{id?}', 'CanBoGiangVienController@adminshow')->name('admin_canbogiangvien_edit');
	Route::post('canbogiangvien/import', 'ServiceSinhVienController@storeImportStudent')->name('post_admin_canbogiangvien_import');

	/* --------- Group route Ajax --------- */
	Route::post('getnganhbykhoa', 'NganhController@getNganhByKhoa')->name('admin_getnganhbykhoa');
	Route::post('getlopbynganh', 'LopController@getLopByNganh')->name('admin_getlopbynganh');
	Route::post('getsinhvienfilter', 'SinhVienController@getSinhVienByKhoaNganhLop')->name('admin_getsinhvienbykhoanganhlop');
	Route::get('getsinhvienfilterexport', 'SinhVienController@getSinhVienByKhoaNganhLopExport')->name('admin_getsinhvienbykhoanganhlopexport');
	Route::get('sinhvien/xoa/{id?}', 'SinhVienController@destroy')->name('sinhviendestroy');
	/* --------- End Group route Ajax --------- */


	Route::get('capnhatthongtinsinhvien', function(){
		return view('admin.capnhatthongtinsinhvien');
	})->name('capnhatthongtinsinhvien');

	Route::get('sinhvien/update/{id?}', 'SinhVienController@getCapNhatThongTin')
		-> name('admin_getcapnhatthongtinsinhvien')
		-> where('id', '[0-9]+');

	Route::post('sinhvien/update', 'SinhVienController@update')->name('admin_poststudentupdate');

	Route::post('capnhatthongtinsinhvien', 'SinhVienController@postCapNhatThongTin')
		-> name('post_capnhatthongtinsinhvien');
});
/**
 * --------- End Admin, Danh mục ---------
 */

/**
 * --------- Sinh viên ---------
 */
Route::middleware('sinhvien')->prefix('sinhvien')->group(function(){
	Route::get('', function(){
		return view('sinhvien.index');
		}) ->name('sinhvien');


	//Bang Diem
	Route::get('bangdiemrenluyen/chamdiem','BangDiemRenLuyenController@sinhvien_index')
		->name('sinhvien_bangdiemrenluyen_danhgia');
	Route::get('bangdiemrenluyen','BangDiemRenLuyenController@indexDSL')
		->name('bangdiemrenluyen');
	Route::get('bangdiemrenluyen/{id?}','BangDiemRenLuyenController@DSL')
		->name('bangdiemrenluyenbykhoa')
		->where('id', '[0-9]+');

	Route::get('bangdiemrenluyen/khoa/{id?}','BangDiemRenLuyenController@DSSV')
		->name('bangdiemrenluyenbylop')
		->where('id', '[0-9]+');

	Route::post('bangdiemrenluyen/add','BangDiemRenLuyenController@sinhvien_store')
		->name('sinhvien_bangdiemrenluyen_danhgia_post');
	
	Route::get('profile', 'SinhVienController@getProfile')
		-> name('profile');

	Route::post('profile','SinhVienController@postProfile')
		-> name('postprofile');

	Route::get('profile-print', 'SinhVienController@getPrintProfile')
	-> name('profile_print');
	
});
/**
 * --------- End Sinh viên ---------
 */

/**
 * --------- Ban cán sự lớp ---------
 */
Route::middleware('bancansu')->prefix('bancansu')->group(function(){
	Route::get('', function(){
		return view('bancansu.index');
	}) ->name('bancansu');

	Route::get('danhgiadiemrenluyen', 'ServiceDanhGiaDiemRenLuyenController@BanCanSuDanhGiaDiemRenLuyen_show') ->name('bancansu_danhgiadiemrenluyen');

	Route::post('danhgiadiemrenluyen', 'ServiceDanhGiaDiemRenLuyenController@BanCanSuDanhGiaDiemRenLuyen_store') ->name('post_bancansu_danhgiadiemrenluyen');

	Route::get('danhgiadiemrenluyen/export/hienhanh', 'ServiceDanhGiaDiemRenLuyenController@exportBangDiem_BanCanSu') ->name('bancansu_danhgiadiemrenluyen_export');

});
/**
 * --------- End Ban cán sự lớp ---------
 */

/**
 * --------- Cố vấn học tập ---------
 */
Route::middleware('covanhoctap')->prefix('covanhoctap')->group(function(){
	Route::get('', function(){
		return view('covanhoctap.index');
		}) ->name('covanhoctap');
});
/**
 * --------- End Cố vấn học tập ---------
 */

/**
 * --------- Giáo vụ khoa ---------
 */
Route::middleware('giaovukhoa')->prefix('giaovukhoa')->group(function(){
	Route::get('', function(){
		return view('giaovukhoa.index');
		}) ->name('giaovukhoa');
});
/**
 * --------- End Giáo vụ khoa ---------
 */


/**
 * --------- Đánh Giá Điểm Rèn Luyện ---------
 */
Route::prefix('danhgia')->group(function(){
	Route::get('', 'DanhGiaDiemRenLuyenController@index')->name('danhgia');
});
/**
 * --------- End Đánh Giá Điểm Rèn Luyện ---------
 */


/**
 * --------- Trưởng đơn vị ---------
 */
Route::prefix('truongdonvi')->group(function(){
	Route::get('', function(){
		return view('truongdonvi.index');
		}) ->name('truongdonvi');

	Route::get('updated-student-profile', 'SinhVienController@getUpdatedStudentProfile_TruongDonVi')
		->name('updatedstudentprofile_truongdonvi');


	Route::get('updated-student-profile/khoa/{id}', 'SinhVienController@getUpdatedStudentProfileFalcuty_TruongDonVi')
		->name('updatedstudentprofilefalcuty_truongdonvi');
	
	Route::get('student-profile/{id?}', 'SinhVienController@getStudentProfile_TruongDonVi')
		->name('studentprofile_truongdonvi')
		->where('id', '[0-9]+');
	
});
/**
 * --------- End Trưởng đơn vị ---------
 */


// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

/* --------- middleware gest --------- */
Route::middleware('guest')->group(function(){
	Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider')
		->name('gsignin');

	Route::get('redirect-login', 'Auth\LoginController@RedirectLogin')
		->name('redirect-login');


	Route::get('login-local', function ()
	{
		return redirect()->route('login');
	})->name('login_local');

	// Route::get('login', function ()
	// 	{
	// 		return redirect()->route('login');
	// 	}
	// )->name('gsignin');

	Route::get('{provider}/callback', 'Auth\LoginController@handleProviderCallback')
		->name('callback');
});

/* --------- middleware auth --------- */
Route::middleware('auth')->group(function(){
	Route::get('logout', 'LogoutController@Logout')->name('logout');
	// Route::get('signout/{provider}', 'Auth\LoginController@Logout')->name('signout');
	Route::get('signout/{provider}', 'Auth\LoginController@Logout')->name('signout');
	
	Route::get('profile', 'LogoutController@Logout')->name('profile');
});
Auth::routes();

