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
// Test performance
// Route::get('updatediem/{start}/{end}', 'TestController@UPDATEDIEM');
// TODO: Chức năng nén và xuất file + hình theo lớp
// Route::get('compression', 'EncryptionController@TestCompression');

// Route::get('encrypt', 'EncryptionController@Encrytion');
// Route::get('getExportSinhVien', 'SinhVienController@getExportSinhVien')
// 	->name('exportsinhvien');

// Route::get('getImportSinhVien', 'SinhVienController@getImportSinhVien')
// 	->name('importsinhvien');

// Route::get('searchstudent', 'SinhVienController@SearchStudent') ->name('exportsinhvien');

// Route::get('profilesv', 'LyLichSinhVienRegisterController@create')
// 	->name('profilesv');

// Route::post('post_profilesv', 'LyLichSinhVienRegisterController@store')
// 	->name('post_profilesv');

// Route::get('welcome', function(){
// 	return redirect('/');
// })->name('welcome');

// Route::get('instruction', function(){
// 	return view('sinhvien.instruction');
// })->name('instruction');

// Route::get('profile-instruction', function(){
// 	return view('sinhvien.profile_instruction');
// })->name('profile_instruction');
// ---------------------------------------

Route::get('', 'Auth\LoginController@RedirectDashboard')->name('index');
Route::get('home', 'Auth\LoginController@RedirectDashboard')->name('home');

Route::get('/info-alert', function(){
	return view('layout.alertmessage.infoalert');
})->name('info.alert');



Route::middleware('auth')->group(function(){
	Route::middleware('chuyenvienhethong')->prefix('subadmin')->group(function(){
		Route::get('', 'SubAdminController@index')->name('subadmin');
		
		// Tìm kiếm, thống kê
		Route::get('search-filter', 'ServiceSearchFilterController@subadminindex')->name('subadminsearchfilterindex');

		// Loại hoạt động sự kiện
		Route::get('loaihd','LoaiHoatDongSuKienController@index')->name('loaihd');
		Route::post('loaihd','LoaiHoatDongSuKienController@store')->name('post_loaihd');
		Route::post('loaihd/update', 'LoaiHoatDongSuKienController@update')->name('post_loaihd_update');
		Route::get('loaihd/del/{id}', 'LoaiHoatDongSuKienController@destroy')->name('loaihd_destroy')->where('id', '[0-9]+');
		
		// Hoạt động sự kiện
		Route::get('hoatdongsukien','HoatDongSuKienController@index')->name('hoatdongsukien');
		Route::get('hoatdongsukien-danhsachsinhvien/{idhoatdongsukien}','DangKyHoatDongSuKienController@show')->name('subadmin_hoatdongsukien_danhsachsinhvien');
		
		// Ban cán sự
		Route::get('bancansu', 'BanCanSuController@index')->name('subadmin_bancansu');
		Route::get('bancansu/add', 'BanCanSuController@create')->name('subadmin_bancansu_add');
		Route::post('bancansu/add', 'BanCanSuController@store')->name('post_subadmin_bancansu_add');
		
		// Staff (Nhân viên)
		Route::get('staff', 'CanBoGiangVienController@index')->name('staff');
		Route::get('staff/edit/{idstaff?}', 'CanBoGiangVienController@show')->name('staffedit');
		Route::post('staff/update', 'CanBoGiangVienController@update')->name('poststaffupdate');

		// Student
		Route::get('student/edit/{id?}', 'SinhVienController@show')->name('studentedit');
		Route::post('student/update', 'SinhVienController@update')->name('poststudentupdate');
		Route::get('student/filter/khoa/{id?}', 'SinhVienController@showKhoa')->name('studentbykhoa');
		Route::get('student/filter/nganh/{id?}', 'SinhVienController@showNganh')->name('studentbynganh');
		Route::get('student/filter/khoahoc/{id?}', 'SinhVienController@showKhoaHoc')->name('studentbykhoahoc');
		Route::get('student/filter/lop/{lop?}', 'SinhVienController@showLop')->name('studentbylop');
		Route::get('student/filter/mssv/{mssv?}', 'SinhVienController@showMSSV')->name('studentbymssv');
		Route::get('student/filter/email/{email?}', 'SinhVienController@showEmail')->name('studentbyemail');

		// Staff
		Route::get('student/edit/{id?}', 'SinhVienController@show')->name('studentedit');
		Route::post('student/update', 'SinhVienController@update')->name('poststudentupdate');
		Route::get('student/filter/khoa/{id?}', 'SinhVienController@showKhoa')->name('studentbykhoa');
		Route::get('student/filter/nganh/{id?}', 'SinhVienController@showNganh')->name('studentbynganh');
		Route::get('student/filter/khoahoc/{id?}', 'SinhVienController@showKhoaHoc')->name('studentbykhoahoc');
		Route::get('student/filter/lop/{lop?}', 'SinhVienController@showLop')->name('studentbylop');
		Route::get('student/filter/mssv/{mssv?}', 'SinhVienController@showMSSV')->name('studentbymssv');
		Route::get('student/filter/email/{email?}', 'SinhVienController@showEmail')->name('studentbyemail');
		
		// Bảng điểm rèn luyện
		Route::prefix('bangdiemrenluyen')->group(function(){
			Route::get('hockynamhoc', 'HocKyNamHocController@subadmin_hockynamhoc')->name('subadmin_bangdiemrenluyen_hockynamhoc');
			Route::get('hockynamhoc/{id}', 'LopController@subadmin_hockynamhoc_lop')->name('subadmin_bangdiemrenluyen_hockynamhoc_lop');
			Route::get('hockynamhoc/lop/{idhockynamhoc}/{idlop}', 'BangDiemRenLuyenController@subadmin_bangdiem_hockynamhoc_lop')->name('subadmin_bangdiemrenluyen_hockynamhoc_lop_ketqua');
			Route::get('export/hockynamhoc/lop/{idhockynamhoc}/{idlop}', 'BangDiemRenLuyenController@subadmin_bangdiemrenluyen_hockynamhoc_lop_export') ->name('subadmin_bangdiemdiemrenluyen_hockynamhoc_lop_export');
		});
		

		// Tiêu chí, Tiêu chí - Minh chứng
		Route::prefix('tieuchi')->group(function(){
			Route::get('', 'TieuChiController@adminindextieuchi')->name('admin_index_tieuchi');
			Route::get('minhchung', 'ServiceTieuChiMinhChungController@subadminindextieuchiminhchung')->name('subadmin_index_tieuchi_minhchung');
			Route::get('minhchung/{idhockynamhoc}/{idtieuchi}', 'ServiceTieuChiMinhChungController@subadmintieuchiminhchung')->name('subadmin_tieuchi_minhchung');
			Route::get('minhchung/download/fileimport/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@subadmintieuchiminhchungdownloadfileimport')->name('subadmin_tieuchi_minhchung_downloadfileimport');
			Route::get('minhchung/download/fileminhchung/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@subadmintieuchiminhchungdownloadfileminhchung')->name('subadmin_tieuchi_minhchung_downloadfileminhchung');
		});

		Route::get('student', 'AdminSinhVienTimKiemController@subadmin_index')->name('subadmin_sinhvien');
		Route::get('student/info/{id?}', 'SinhVienController@subadmin_show')->name('subadmin_sinhvien_show');
		Route::get('staff', 'CanBoGiangVienController@subadmin_index')->name('subadmin_canbogiangvien');
		Route::get('councils-faculty', 'GiaoVuKhoaController@subadmin_index')->name('subadmin_giaovukhoa');
		Route::get('councils-faculty/create', 'GiaoVuKhoaController@subadmin_create')->name('subadmin_giaovukhoa_create');
		Route::post('councils-faculty/store', 'GiaoVuKhoaController@subadmin_store')->name('subadmin_giaovukhoa_store');
		Route::get('councils-faculty/update/{id}', 'GiaoVuKhoaController@subadmin_updatestatus')->name('subadmin_giaovukhoa_updatestatus');

		Route::get('advisers', 'CoVanHocTapController@subadmin_index')->name('subadmin_covanhoctap');
		Route::get('advisers/create', 'CoVanHocTapController@subadmin_create')->name('subadmin_covanhoctap_create');
		Route::post('advisers/store', 'CoVanHocTapController@subadmin_store')->name('subadmin_covanhoctap_store');
		Route::get('advisers/update/{id}', 'CoVanHocTapController@subadmin_updatestatus')->name('subadmin_covanhoctap_updatestatus');
		Route::get('advisers/delete/{id}', 'CoVanHocTapController@subadmin_destroy')->name('subadmin_covanhoctap_destroy');

		Route::get('departments', 'KhoaController@subadmin_index')->name('subadmin_khoa');
		Route::get('groups', 'BoMonController@subadmin_index')->name('subadmin_bomon');
		Route::get('majors', 'NganhController@subadmin_index')->name('subadmin_nganhhoc');
		Route::get('class', 'LopController@subadmin_index')->name('subadmin_lop');
	});

	/**
	 * --------- Admin, Danh mục ---------
	 */
	Route::middleware('quantrihethong')->prefix('admin')->group(function(){

		//Học bổng
		Route::group(['prefix'=>'scholar'],function(){
        Route::get('/','AdminScholarController@index')->name('admin.get.list.scholar');
        Route::get('/create','AdminScholarController@create')->name('admin.create.scholar.form');
        Route::post('/create','AdminScholarController@store');
        Route::get('/update/{id}','AdminScholarController@edit')->name('admin.get.edit.scholar');
        Route::post('/update/{id}','AdminScholarController@update');
        Route::get('/{action}/{id}','AdminScholarController@action')->name('admin.action.list.scholar');

        //

        //Học bổng (Tìm sinh viên)
        Route::get('/tim-kiem','AdminScholarSearchController@StudentSearch')->name('admin.search.student');
        Route::get('/tim-kiem/getbomon/{id}','AdminScholarSearchController@getBoMon')->name('admin.get.bomon');
        Route::get('/tim-kiem/getnganh/{id}','AdminScholarSearchController@getNganh')->name('admin.get.nganh');
        Route::get('/tim-kiem/getlop/{id}','AdminScholarSearchController@getLop')->name('admin.get.lop');
    	});
		//Trao học bổng
		Route::get('/traohocbong/{id}','AdminAwardScholarController@create')->name('admin.award.scholar');
		Route::post('/traohocbong/{id}','AdminAwardScholarController@store');
		//Kiểm tra lịch sử
		Route::get('/history/{id}','AdminAwardScholarController@edit')->name('admin.edit.award');
		Route::get('/edit-history/{id}','AdminAwardScholarController@editHistory')->name('admin.edit.history');
		Route::post('/edit-history/{id}','AdminAwardScholarController@update')->name('admin.save.history');
		//Import
		Route::get('hocbong', 'AdminScholarController@importHB')->name('admin.hocbong.import');
		Route::post('/import_excel/import', 'AdminScholarController@import')->name('test.abc');
		//import test
		Route::get('hocbong/import', 'AdminScholarController@adminimport')->name('admin_hocbong_import');
		Route::post('hocbong/import', 'AdminScholarController@adminimportstore')->name('post_admin_hocbong_import');

		//
		Route::get('', 'ServiceAdminController@index')->name('admin');
		Route::get('trangthaihocky', 'TrangThaiHocKyController@index')->name('trangthaihocky');
		Route::post('trangthaihocky', 'TrangThaiHocKyController@store')->name('post_trangthaihocky');
		Route::post('trangthaihocky/update', 'TrangThaiHocKyController@update')->name('post_trangthaihocky_update');
		Route::get('trangthaihocky/del/{id}', 'TrangThaiHocKyController@destroy')->name('trangthaihocky_destroy')->where('id', '[0-9]+');

		// Học kỳ
		Route::get('hocky', 'HocKyController@index')->name('hocky');
		Route::post('hocky', 'HocKyController@store')->name('post_hocky');
		Route::post('hocky/update', 'HocKyController@update')->name('post_hocky_update');
		Route::get('hocky/del/{id}', 'HocKyController@destroy')->name('hocky_destroy')->where('id', '[0-9]+');

		// Năm học
		Route::get('namhoc', 'NamHocController@index')->name('namhoc');
		Route::get('namhoc/create', 'NamHocController@create')->name('namhoc_create');
		Route::post('namhoc', 'NamHocController@store')->name('post_namhoc');
		Route::post('namhoc/update', 'NamHocController@update')->name('post_namhoc_update');
		Route::get('namhoc/del/{id}', 'NamHocController@destroy')->name('namhoc_destroy')->where('id', '[0-9]+');

		// Học kỳ - Năm học
		Route::get('hockynamhoc', 'HocKyNamHocController@index')->name('hockynamhoc');
		Route::post('hockynamhoc', 'HocKyNamHocController@store')->name('post_hockynamhoc');
		Route::post('hockynamhoc/update', 'HocKyNamHocController@update')->name('post_hockynamhoc_update');
		Route::get('hockynamhoc/del/{id}', 'HocKyNamHocController@destroy')->name('hockynamhoc_destroy')->where('id', '[0-9]+');
		
		// Khóa học
		Route::prefix('khoahoc')->group(function(){
			Route::get('', 'KhoaHocController@adminindex')->name('admin_khoahoc_index');
			Route::get('create', 'KhoaHocController@admincreate')->name('admin_khoahoc_create');
			Route::post('store', 'KhoaHocController@adminstore')->name('admin_khoahoc_store');

			Route::get('edit/{id}', 'KhoaHocController@adminedit')->name('admin_khoahoc_edit');
			Route::post('update', 'KhoaHocController@adminupdate')->name('admin_khoahoc_update');
			Route::get('destroy/{id}', 'KhoaHocController@admindestroy')->name('admin_khoahoc_destroy');
		});

		// Bộ Tiêu chí - Tiêu chí
		Route::prefix('botieuchi')->group(function(){
			Route::get('', 'BoTieuChiController@adminindex')->name('admin_botieuchi_index');
			Route::get('create', 'BoTieuChiController@admincreate')->name('admin_botieuchi_create');
			Route::post('store', 'BoTieuChiController@adminstore')->name('admin_botieuchi_store');
			Route::get('edit/{id}', 'BoTieuChiController@adminedit')->name('admin_botieuchi_edit');
			Route::post('update', 'BoTieuChiController@adminupdate')->name('admin_botieuchi_update');
			Route::get('destroy/{id}', 'BoTieuChiController@admindestroy')->name('admin_botieuchi_destroy');
			Route::get('download/{id}', 'BoTieuChiController@admindownload')->name('admin_botieuchi_download');

			Route::prefix('tieuchi')->group(function(){
				Route::get('{idbotieuchi}', 'TieuChiController@adminindex')->name('admin_botieuchi_tieuchi_index');
				Route::get('create/{idbotieuchi}/{idtieuchicha?}', 'TieuChiController@admincreate')->name('admin_botieuchi_tieuchi_create');
				Route::post('store', 'TieuChiController@adminstore')->name('admin_botieuchi_tieuchi_store');
				Route::get('edit/{idbotieuchi}/{idtieuchi}', 'TieuChiController@adminedit')->name('admin_botieuchi_tieuchi_edit');
				Route::post('update', 'TieuChiController@adminupdate')->name('admin_botieuchi_tieuchi_update');
				Route::get('destroy/{idbotieuchi}/{idtieuchi}', 'TieuChiController@admindestroy')->name('admin_botieuchi_tieuchi_destroy');
			});
		});

		// Học kỳ - Năm học - Bộ tiêu chí
		Route::prefix('hockynamhoc/botieuchi')->group(function(){
			Route::get('', 'HocKyNamHocBoTieuChiController@adminindex')->name('admin_hockynamhocbotieuchi_index');
			Route::get('create/{idhockynamhoc}', 'HocKyNamHocBoTieuChiController@admincreate')->name('admin_hockynamhocbotieuchi_create');
			Route::post('store', 'HocKyNamHocBoTieuChiController@adminstore')->name('admin_hockynamhocbotieuchi_store');
			Route::get('edit/{idhockynamhocbotieuchi}', 'HocKyNamHocBoTieuChiController@adminedit')->name('admin_hockynamhocbotieuchi_edit');
			Route::post('update', 'HocKyNamHocBoTieuChiController@adminupdate')->name('admin_hockynamhocbotieuchi_update');
			Route::get('destroy/{idhockynamhocbotieuchi}', 'HocKyNamHocBoTieuChiController@admindestroy')->name('admin_hockynamhocbotieuchi_destroy');
			Route::get('create-mark/{idhockynamhoc}/{idbotieuchi}', 'HocKyNamHocBoTieuChiController@admingeneratemark')->name('admin_hockynamhocbotieuchi_generatemark');
		});

		// Tiêu chí, Tiêu chí - Minh chứng
		Route::prefix('tieuchi')->group(function(){
			Route::get('', 'TieuChiController@adminindextieuchi')->name('admin_index_tieuchi');
			Route::get('minhchung', 'ServiceTieuChiMinhChungController@adminindextieuchiminhchung')->name('admin_index_tieuchi_minhchung');
			Route::get('minhchung/{idhockynamhoc}/{idtieuchi}', 'ServiceTieuChiMinhChungController@admintieuchiminhchung')->name('admin_tieuchi_minhchung');
			Route::get('minhchung/module/{idhockynamhoc}/{idtieuchi}/{idmodule}', 'ServiceTieuChiMinhChungController@admintieuchiminhchungmodule')->name('admin_tieuchi_minhchung_module');
			Route::post('minhchung/module', 'TieuChiModuleThoiGianController@adminstore')->name('admin_tieuchi_minhchung_modulethoigianstore');
			Route::get('minhchung/module/kekhailylich/{idhockynamhoc}/{idtieuchi}/{idmodule}', 'ServiceTieuChiMinhChungController@admintieuchiminhchungmodulekekhailylich')->name('admin_tieuchi_minhchung_modulekekhailylich');
			Route::get('minhchung/import/{idhockynamhoc}/{idtieuchi}', 'ServiceTieuChiMinhChungController@admintieuchiminhchungimportcreate')->name('admin_tieuchi_minhchung_importcreate');
			Route::post('minhchung/import', 'ServiceTieuChiMinhChungController@admintieuchiminhchungimportstore')->name('admin_tieuchi_minhchung_importstore');
			Route::delete('minhchung/delete/{id}', 'ServiceTieuChiMinhChungController@admintieuchiminhchungdestroy')->name('admin_tieuchi_minhchung_destroy');
			Route::get('minhchung/download/fileimport/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@admintieuchiminhchungdownloadfileimport')->name('admin_tieuchi_minhchung_downloadfileimport');
			Route::get('minhchung/download/fileminhchung/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@admintieuchiminhchungdownloadfileminhchung')->name('admin_tieuchi_minhchung_downloadfileminhchung');
		});

		Route::prefix('hoatdong-sukien')->group(function(){
			Route::get('','HoatDongSuKienController@admin_index')->name('admin_hoatdongsukien');
			Route::get('create','HoatDongSuKienController@admin_create')->name('admin_hoatdongsukien_create');
			Route::post('store','HoatDongSuKienController@admin_store')->name('admin_hoatdongsukien_store');
			Route::get('edit/{id}','HoatDongSuKienController@admin_edit')->name('admin_hoatdongsukien_edit')->where('id','[0-9]+');
			Route::post('update','HoatDongSuKienController@admin_update')->name('admin_hoatdongsukien_update');
			Route::get('hoatdongsukien/danhsachsinhvien/del/{id}', 'DangKyHoatDongSuKienController@destroy')->name('dkhdsk_destroy')->where('id', '[0-9]+');
			Route::get('danhsachsinhvien/{idhoatdongsukien}','DangKyHoatDongSuKienController@admin_show')->name('admin_hoatdongsukien_danhsachsinhvien');
			Route::get('danhsachsinhvien/import/{idhoatdongsukien}','DangKyHoatDongSuKienController@Admin_ImportStudent')->name('admin_hdsk_importsv');
			Route::post('danhsachsinhvien/import','DangKyHoatDongSuKienController@Admin_storeImportStudent')->name('admin_post_hoatdongsukien_importsinhvien');
			Route::get('congdiem/{idhoatdongsukien}','DangKyHoatDongSuKienController@CongDiemChoSinhVienThamGiaHoatDongSuKien')->name('admin_hoatdongsukien_congdiemsinhvien');
		});

		// Bậc đào tạo
		Route::get('bacdaotao', 'BacDaoTaoController@index')-> name('bacdaotao');
		Route::post('bacdaotao', 'BacDaoTaoController@store')->name('post_bacdaotao');
		Route::post('bacdaotao/update', 'BacDaoTaoController@update')->name('post_bacdaotao_update');
		Route::get('bacdaotao/del/{id}', 'BacDaoTaoController@destroy')->name('bacdaotao_destroy')->where('id', '[0-9]+');

		// Hệ đào tạo
		Route::get('hedaotao', 'HeDaoTaoController@index')-> name('hedaotao');
		Route::post('hedaotao', 'HeDaoTaoController@store')->name('post_hedaotao');
		Route::post('hedaotao/update', 'HeDaoTaoController@update')->name('post_hedaotao_update');
		Route::get('hedaotao/del/{id}', 'HeDaoTaoController@destroy')->name('hedaotao_destroy')->where('id', '[0-9]+');

		// Dân tộc
		Route::get('dantoc', 'DanTocController@index')-> name('dantoc');
		Route::post('dantoc', 'DanTocController@store')->name('post_dantoc');
		Route::post('dantoc/update', 'DanTocController@update')->name('post_dantoc_update');
		Route::get('dantoc/del/{id}', 'DanTocController@destroy')->name('dantoc_destroy')->where('id', '[0-9]+');

		// Tôn giáo
		Route::get('tongiao', 'TonGiaoController@index')-> name('tongiao');
		Route::post('tongiao', 'TonGiaoController@store')->name('post_tongiao');
		Route::post('tongiao/update', 'TonGiaoController@update')->name('post_tongiao_update');
		Route::get('tongiao/del/{id}', 'TonGiaoController@destroy')->name('tongiao_destroy')->where('id', '[0-9]+');

		// Loại điểm (loại tiêu chí)
		Route::get('loaidiem', 'LoaiDiemController@index')-> name('loaidiem');
		Route::post('loaidiem', 'LoaiDiemController@store')->name('post_loaidiem');
		Route::post('loaidiem/update', 'LoaiDiemController@update')->name('post_loaidiem_update');
		Route::get('loaidiem/del/{id}', 'LoaiDiemController@destroy')->name('loaidiem_destroy')->where('id', '[0-9]+');

		// Trạng thái tiêu chí
		Route::get('trangthaitieuchi', 'TrangThaiTieuChiController@index')-> name('trangthaitieuchi');
		Route::post('trangthaitieuchi', 'TrangThaiTieuChiController@store')->name('post_trangthaitieuchi');
		Route::post('trangthaitieuchi/update', 'TrangThaiTieuChiController@update')->name('post_trangthaitieuchi_update');
		Route::get('trangthaitieuchi/del/{id}', 'TrangThaiTieuChiController@destroy')->name('trangthaitieuchi_destroy')->where('id', '[0-9]+');

		// Xếp loại điểm rèn luyện
		Route::get('xeploaidiemrenluyen', 'XepLoaiDiemRenLuyenController@index')-> name('xeploaidiemrenluyen');
		Route::post('xeploaidiemrenluyen', 'XepLoaiDiemRenLuyenController@store')->name('post_xeploaidiemrenluyen');
		Route::post('xeploaidiemrenluyen/update', 'XepLoaiDiemRenLuyenController@update')->name('post_xeploaidiemrenluyen_update');
		Route::get('xeploaidiemrenluyen/del/{id}', 'XepLoaiDiemRenLuyenController@destroy')->name('xeploaidiemrenluyen_destroy')->where('id', '[0-9]+');

		// Bảng điểm export
		Route::get('bangdiemrenluyen/export', 'BangDiemRenLuyenController@ExportBangDiemRenLuyenShow')->name('admin_exportbangdiemrenluyen_show');
		Route::post('bangdiemrenluyen/export', 'BangDiemRenLuyenController@ExportBangDiemRenLuyen')->name('admin_exportbangdiemrenluyen_export');

		// Khoa - Phòng
		Route::get('khoa', 'KhoaController@index')->name('khoa');
		Route::post('khoa', 'KhoaController@store')->name('post_khoa');
		Route::post('khoa/update', 'KhoaController@update')->name('post_khoa_update');
		Route::get('khoa/del/{id}', 'KhoaController@destroy')->name('khoa_destroy')->where('id', '[0-9]+');

		// Bộ môn - Tổ
		Route::get('bomon', 'BoMonController@index')->name('bomon');
		Route::post('bomon', 'BoMonController@store')->name('post_bomon');
		Route::post('bomon/update', 'BoMonController@update')->name('post_bomon_update');
		Route::get('bomon/del/{id}', 'BoMonController@destroy')->name('bomon_destroy')->where('id', '[0-9]+');

		// Ngành
		Route::get('nganh', 'NganhController@index')->name('nganh');
		Route::post('nganh', 'NganhController@store')->name('post_nganh');
		Route::post('nganh/update', 'NganhController@update')->name('post_nganh_update');
		Route::get('nganh/del/{id}', 'NganhController@destroy')-> name('nganh_destroy')-> where('id', '[0-9]+');

		// Lớp
		Route::get('lop', 'LopController@index')->name('lop');
		Route::post('lop', 'LopController@store')->name('post_lop');
		Route::post('lop/update', 'LopController@update')->name('post_lop_update');
		Route::get('lop/del/{id}', 'LopController@destroy')-> name('lop_destroy')-> where('id', '[0-9]+');
		Route::get('lop/import', 'ServiceLopController@showImportClass')->name('admin_lop_import_show');
		Route::post('lop/import', 'ServiceLopController@storeImportClass')->name('admin_lop_import_store');

		// Sinh viên
		Route::prefix('sinhvien')->group(function(){
			Route::get('loc', 'AdminSinhVienTimKiemController@index')->name('admin_sinhvien_timkiem');
			Route::get('create', 'AdminSinhVienTimKiemController@create')->name('admin_sinhvien_create');
			Route::post('store', 'AdminSinhVienTimKiemController@store')->name('admin_sinhvien_store');
			Route::get('import', 'ServiceSinhVienController@ImportStudent')->name('admin_sinhvien_import');
			Route::post('import', 'ServiceSinhVienController@storeImportStudent')->name('post_admin_sinhvien_import');
			// Bảng điểm rèn luyện
			Route::prefix('bangdiemrenluyen')->group(function(){
				// Route::get('','BangDiemRenLuyenController@sinhvien_index')->name('sinhvien_bangdiemrenluyen');
				Route::get('chitiet/{idhockynamhoc?}/{idsinhvien?}','BangDiemRenLuyenController@admin_bangdiemrenluyen_chitiet_theo_sinhvien_hockynamhoc')->name('admin_bangdiemrenluyen_sinhvien_hockynamhoc');
				Route::get('export/{idhockynamhoc}/{idsinhvien}','BangDiemRenLuyenController@admin_bangdiemrenluyen_sinhvien_hockynamhoc_export')->name('admin_bangdiemrenluyen_sinhvien_hockynamhoc_export');
			});
		});
		
		

		// Ban cán sự
		Route::get('bancansu/{idhocky?}', 'BanCanSuController@adminindex')->name('admin_bancansu')->where('idhocky', '[0-9]+');
		Route::get('bancansu/add', 'BanCanSuController@admincreate')->name('admin_bancansu_create');
		Route::post('bancansu/add', 'BanCanSuController@adminstore')->name('admin_bancansu_store');
		Route::get('bancansu/import', 'BanCanSuController@adminimport')->name('admin_bancansu_import');
		Route::post('bancansu/import', 'BanCanSuController@adminimportstore')->name('post_admin_bancansu_import');
		
		// Cán bộ giảng viên
		Route::get('canbogiangvien', 'CanBoGiangVienController@adminindex')->name('admin_canbogiangvien');
		Route::get('canbogiangvien/add', 'CanBoGiangVienController@admincreate')->name('admin_canbogiangvien_add');
		Route::post('canbogiangvien/store', 'CanBoGiangVienController@adminstore')->name('admin_canbogiangvien_store');
		Route::get('canbogiangvien/edit/{id?}', 'CanBoGiangVienController@adminshow')->name('admin_canbogiangvien_edit');
		Route::get('canbogiangvien/import', 'CanBoGiangVienController@ImportCanBoGiangVien')->name('admin_canbogiangvien_import');
		Route::post('canbogiangvien/import', 'CanBoGiangVienController@AdminStoreImportCanBoGiangVien')->name('post_admin_canbogiangvien_import');
		
		// Chuyên viên quản lý lớp
		Route::get('expers', 'ChuyenVienQuanLyLopController@adminindex')->name('admin_expers');
		Route::get('expers/create', 'ChuyenVienQuanLyLopController@admincreate')->name('admin_expers_create');
		Route::post('expers/store', 'ChuyenVienQuanLyLopController@adminstore')->name('admin_expers_store');
		Route::get('expers/edit/{id}', 'ChuyenVienQuanLyLopController@adminedit')->name('admin_expers_edit');
		Route::post('expers/update', 'ChuyenVienQuanLyLopController@adminupdate')->name('admin_expers_update');
		Route::get('expers/delete/{id}', 'ChuyenVienQuanLyLopController@admindestroy')->name('admin_expers_destroy');

		// Cố vấn học tập
		Route::prefix('covanhoctap')->group(function(){
			Route::get('', 'CoVanHocTapController@admin_index')->name('admin_covanhoctap');
			Route::get('create', 'CoVanHocTapController@admin_create')->name('admin_covanhoctap_create');
			Route::post('store', 'CoVanHocTapController@admin_store')->name('admin_covanhoctap_store');
			Route::get('edit/{id}', 'CoVanHocTapController@admin_edit')->name('admin_covanhoctap_edit');
			Route::post('update', 'CoVanHocTapController@admin_update')->name('admin_covanhoctap_update');
			Route::get('delete/{id}', 'CoVanHocTapController@admin_destroy')->name('admin_covanhoctap_destroy');
		});
		
		/*** User ***/
		Route::prefix('user')->group(function(){
			Route::get('', 'UserController@index')->name('user');
			Route::post('resetpass', 'UserController@resetpassdefault')->name('admin_user_resetpassdefault');
		});
		Route::get('user-group/edit/{iduser?}', 'UserController@show')->name('usergroupedit');
		Route::post('user-group/update', 'UserController@update')->name('postusergroupupdate');
		Route::get('user-group/filter/khoa/{id?}', 'UserController@showKhoa')->name('usergroupkhoa');
		Route::get('user-group/filter/nganh/{id?}', 'UserController@showNganh')->name('usergroupnganh');
		Route::get('user-group/filter/khoahoc/{id?}', 'UserController@showKhoaHoc')->name('usergroupkhoahoc');
		Route::get('user-group/filter/lop/{lop?}', 'UserController@showLop')->name('usergrouplop');
		Route::get('user-group/filter/mssv/{mssv?}', 'UserController@showMSSV')->name('usergroupmssv');
		Route::get('user-group/filter/email/{email?}', 'UserController@showEmail')->name('usergroupemail');
		Route::get('user-group/donvi/{iduser?}/{idloaiuser?}', 'UserController@getDonVi')->name('getdonvi');
		/*** User ***/

		// Thống kê - Báo cáo
		Route::get('search-filter', 'ServiceSearchFilterController@adminindex')->name('adminsearchfilterindex');
		Route::get('statical-region', 'ServiceSearchFilterController@adminstaticalregion')->name('adminstaticalregion');

		Route::get('capnhatthongtinsinhvien', function(){
			return view('admin.capnhatthongtinsinhvien');
		})->name('capnhatthongtinsinhvien');

		Route::get('sinhvien/update/{id?}', 'SinhVienController@getCapNhatThongTin')-> name('admin_getcapnhatthongtinsinhvien')-> where('id', '[0-9]+');
		Route::post('sinhvien/update', 'SinhVienController@update')->name('admin_poststudentupdate');

		Route::post('capnhatthongtinsinhvien', 'SinhVienController@postCapNhatThongTin')
			-> name('post_capnhatthongtinsinhvien');
		
		// Thẻ sinh viên
		Route::prefix('hinhthe')->group(function(){
			Route::get('', 'ServiceHinhTheController@adminindex') ->name('adminstudentpiccardhinhthe');
			Route::get('search-student', function(){ return view('admin.timsinhvien_hinhthe'); }) ->name('adminstudentsearch_hinhthe');
			Route::get('student-profile-pic/{id?}', 'SinhVienController@AdminStudentProfilePic')->name('adminstudentprofilepic')->where('id', '[0-9]+');
			Route::post('student-profile/pic-card', 'SinhVienController@AdminPostPicforStudentCard')-> name('adminpostpicforstudentcard');
			Route::post('student-profile/pic-card/copy', 'SinhVienController@AdminPostPicforStudentCardCopy')-> name('adminpostpicforstudentcardcopy');
		});
		
		// Download mẫu danh sách để import lên hệ thống
		Route::get('import-template', function(){ return view('admin.mauimport'); })->name('admin_import_template');
		Route::get('import-template/{id}', 'ImportTemplateController@download')->name('admin_import_template_download');
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

		// Bảng điểm rèn luyện
		Route::prefix('bangdiemrenluyen')->group(function(){
			Route::get('','BangDiemRenLuyenController@sinhvien_index')->name('sinhvien_bangdiemrenluyen');
			Route::get('chitiet/{idhockynamhoc}','BangDiemRenLuyenController@sinhvien_hockynamhoc')->name('sinhvien_bangdiemrenluyen_hockynamhoc');
			Route::get('export/{idhockynamhoc}','BangDiemRenLuyenController@sinhvien_hockynamhoc_export')->name('sinhvien_bangdiemrenluyen_hockynamhoc_export');
		});

		// Tiêu chí, Tiêu chí - Minh chứng
		Route::prefix('tieuchi')->group(function(){
			Route::get('minhchung', 'ServiceTieuChiMinhChungController@sinhvienindextieuchiminhchung')->name('sinhvien_index_tieuchi_minhchung');
			Route::get('minhchung/{idhockynamhoc}/{idtieuchi}', 'ServiceTieuChiMinhChungController@sinhvientieuchiminhchung')->name('sinhvien_tieuchi_minhchung');
			Route::get('minhchung/module/{idhockynamhoc}/{idtieuchi}/{idmodule}', 'ServiceTieuChiMinhChungController@sinhvientieuchiminhchungmodule')->name('sinhvien_tieuchi_minhchung_module');
			Route::get('minhchung/download/fileimport/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@sinhvientieuchiminhchungdownloadfileimport')->name('sinhvien_tieuchi_minhchung_downloadfileimport');
			Route::get('minhchung/download/fileminhchung/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@sinhvientieuchiminhchungdownloadfileminhchung')->name('sinhvien_tieuchi_minhchung_downloadfileminhchung');
		});

		// Lý lịch - Profile
		Route::prefix('profile')->group(function(){
			Route::get('', 'SinhVienController@getProfile')->name('sinhvien_profile');
			Route::post('','SinhVienController@postProfile')->name('sinhvien_postprofile');
			Route::get('export', 'SinhVienController@getPrintProfile')->name('sinhvien_profile_print');
		});

		// Hoạt động sự kiện
		Route::prefix('hoatdongsukien')->group(function(){
			Route::get('','HoatDongSuKienController@sinhvien_index')->name('sinhvien_hoatdongsukien');
			Route::get('{id}','HoatDongSuKienController@sinhvien_show')->name('sinhvien_hoatdongsukien_show')->where('id', '[0-9]+');
			Route::post('dangky/hoatdongsukien','DangKyHoatDongSuKienController@sinhvien_store')->name('post_sinhvien_dangkyhoatdongsukien_store');
			Route::post('{idhocky}','HoatDongSuKienController@HoatDongSuKienTheoHocKy')->name('sinhvien_hoatdongsukien_hocky');
		});
		
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
		})->name('bancansu');

		Route::prefix('bangdiemrenluyen')->group(function(){
			Route::get('', 'BangDiemRenLuyenController@bancansu_index')->name('bancansu_bangdiemrenluyen');
			Route::get('{idhockynamhoc}', 'BangDiemRenLuyenController@bancansu_bangdiem_hockynamhoc')->name('bancansu_bangdiemrenluyen_hockynamhoc');
			Route::get('export/hockynamhoc/{idhockynamhoc}/{idlop}', 'BangDiemRenLuyenController@bancansu_lop_hockynamhoc_export') ->name('bancansu_bangdiemdiemrenluyen_hockynamhoc_export');
		});

		// Tiêu chí, Tiêu chí - Minh chứng
		Route::prefix('tieuchi')->group(function(){
			Route::get('minhchung', 'ServiceTieuChiMinhChungController@bancansuindextieuchiminhchung')->name('bancansu_index_tieuchi_minhchung');
			Route::get('minhchung/{idhockynamhoc}/{idtieuchi}', 'ServiceTieuChiMinhChungController@bancansutieuchiminhchung')->name('bancansu_tieuchi_minhchung');
			Route::get('minhchung/module/{idhockynamhoc}/{idtieuchi}/{idmodule}', 'ServiceTieuChiMinhChungController@bancansutieuchiminhchungmodule')->name('bancansu_tieuchi_minhchung_module');
			Route::get('minhchung/download/fileimport/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@bancansutieuchiminhchungdownloadfileimport')->name('bancansu_tieuchi_minhchung_downloadfileimport');
			Route::get('minhchung/download/fileminhchung/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@bancansutieuchiminhchungdownloadfileminhchung')->name('bancansu_tieuchi_minhchung_downloadfileminhchung');
		});
	});
	/**
	 * --------- End Ban cán sự lớp ---------
	 */

	/*** --------- Cố vấn học tập --------- ***/
	Route::middleware('covanhoctap')->prefix('covanhoctap')->group(function(){
		Route::get('', 'ServiceCoVanHocTapController@index') ->name('covanhoctap');
		Route::get('sinhvien', 'SinhVienController@covanhoctap_index')->name('covanhoctap_sinhvien');
		Route::get('sinhvien/show/{id}', 'SinhVienController@covanhoctap_show')->name('covanhoctap_sinhvien_show');
		Route::get('hoatdongsukien', 'HoatDongSuKienController@covanhoctap_index')->name('covanhoctap_hoatdongsukien');
		Route::get('hoatdongsukien/show/{id}', 'HoatDongSuKienController@covanhoctap_show')->name('covanhoctap_hoatdongsukien_show');

		// Bảng điểm rèn luyện
		Route::prefix('bangdiemrenluyen')->group(function(){
			Route::get('', 'BangDiemRenLuyenController@covanhoctap_index')->name('covanhoctap_bangdiemrenluyen');
			Route::get('{idhockynamhoc}', 'BangDiemRenLuyenController@covanhoctap_bangdiem_hockynamhoc')->name('covanhoctap_bangdiemrenluyen_hockynamhoc');
			Route::get('export/hockynamhoc/{idhockynamhoc}/{idlop}', 'BangDiemRenLuyenController@covanhoctap_bangdiemrenluyen_lop_hockynamhoc_export') ->name('covanhoctap_bangdiemdiemrenluyen_hockynamhoc_export');
		});

		// Tiêu chí, Tiêu chí - Minh chứng
		Route::prefix('tieuchi')->group(function(){
			Route::get('minhchung', 'ServiceTieuChiMinhChungController@covanhoctapindextieuchiminhchung')->name('covanhoctap_index_tieuchi_minhchung');
			Route::get('minhchung/{idhockynamhoc}/{idtieuchi}', 'ServiceTieuChiMinhChungController@covanhoctaptieuchiminhchung')->name('covanhoctap_tieuchi_minhchung');
			Route::get('minhchung/module/{idhockynamhoc}/{idtieuchi}/{idmodule}', 'ServiceTieuChiMinhChungController@covanhoctaptieuchiminhchungmodule')->name('covanhoctap_tieuchi_minhchung_module');
			Route::get('minhchung/download/fileimport/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@covanhoctaptieuchiminhchungdownloadfileimport')->name('covanhoctap_tieuchi_minhchung_downloadfileimport');
			Route::get('minhchung/download/fileminhchung/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@covanhoctaptieuchiminhchungdownloadfileminhchung')->name('covanhoctap_tieuchi_minhchung_downloadfileminhchung');
		});
	});
	/*** --------- End Cố vấn học tập ---------***/

	/*** --------- Giáo vụ khoa --------- ***/
	Route::middleware('giaovukhoa')->prefix('giaovukhoa')->group(function(){
		Route::get('', 'GiaoVuKhoaController@index') ->name('giaovukhoa');
		Route::get('lop', 'GiaoVuKhoaController@giaovukhoa_lop')->name('giaovukhoa_lop');
		Route::get('lop/{id}/sinhvien/', 'SinhVienController@giaovukhoa_sinhvien')->name('giaovukhoa_lop_sinhvien');
		Route::get('sinhvien/show/{id}', 'SinhVienController@giaovukhoa_show')->name('giaovukhoa_sinhvien_show');
		Route::get('hoatdongsukien', 'HoatDongSuKienController@giaovukhoa_index')->name('giaovukhoa_hoatdongsukien');
		Route::get('hoatdongsukien/show/{id}', 'HoatDongSuKienController@giaovukhoa_show')->name('giaovukhoa_hoatdongsukien_show');
		
		// Bảng điểm rèn luyện
		Route::prefix('bangdiemrenluyen')->group(function(){
			Route::get('', 'HocKyNamHocController@giaovukhoa_hockynamhoc')->name('giaovukhoa_bangdiemrenluyen_hockynamhoc');
			Route::get('hockynamhoc/lop/{idhockynamhoc}', 'LopController@giaovukhoa_hockynamhoc_lop')->name('giaovukhoa_bangdiemrenluyen_hockynamhoc_lop');
			Route::get('hockynamhoc/lop/{idhockynamhoc}/{idlop}', 'BangDiemRenLuyenController@giaovukhoa_bangdiem_hockynamhoc')->name('giaovukhoa_bangdiemrenluyen_hockynamhoc_lop_ketqua');
			Route::get('export/hockynamhoc/lop/{idhockynamhoc}/{lop}', 'BangDiemRenLuyenController@giaovukhoa_bangdiemrenluyen_lop_hockynamhoc_export') ->name('giaovukhoa_bangdiemdiemrenluyen_hockynamhoc_export');
		});

		// Tiêu chí, Tiêu chí - Minh chứng
		Route::prefix('tieuchi')->group(function(){
			Route::get('minhchung', 'ServiceTieuChiMinhChungController@giaovukhoaindextieuchiminhchung')->name('giaovukhoa_index_tieuchi_minhchung');
			Route::get('minhchung/{idhockynamhoc}/{idtieuchi}', 'ServiceTieuChiMinhChungController@giaovukhoatieuchiminhchung')->name('giaovukhoa_tieuchi_minhchung');
			Route::get('minhchung/module/{idhockynamhoc}/{idtieuchi}/{idmodule}', 'ServiceTieuChiMinhChungController@giaovukhoatieuchiminhchungmodule')->name('giaovukhoa_tieuchi_minhchung_module');
			Route::get('minhchung/download/fileimport/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@giaovukhoatieuchiminhchungdownloadfileimport')->name('giaovukhoa_tieuchi_minhchung_downloadfileimport');
			Route::get('minhchung/download/fileminhchung/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@giaovukhoatieuchiminhchungdownloadfileminhchung')->name('giaovukhoa_tieuchi_minhchung_downloadfileminhchung');
		});
	});
	/*** --------- End Giáo vụ khoa --------- ***/

	/**
	 * --------- Trưởng đơn vị ---------
	 */
	Route::middleware('truongdonvi')->prefix('truongdonvi')->group(function(){
		Route::get('', 'ServiceTruongDonViController@index')->name('truongdonvi');
		Route::get('sinhvien', 'AdminSinhVienTimKiemController@truongdonviindex')->name('truongdonvi_sinhvien_timkiem');
		Route::get('sinhvien/thongtin/{id?}', 'SinhVienController@truongdonvi_show')->name('truongdonvi_sinhvien_show');
		Route::get('bancansu/{idhocky?}', 'BanCanSuController@truongdonviindex')->name('truongdonvi_bancansu')->where('idhocky', '[0-9]+');
		Route::get('covanhoctap', 'CoVanHocTapController@truongdonvi_index')->name('truongdonvi_covanhoctap');
		Route::get('chuyenvien', 'ChuyenVienQuanLyLopController@truongdonviindex')->name('truongdonvi_chuyenvien');
		Route::get('tieuchi', 'TieuChiController@truongdonviindextieuchi')->name('truongdonvi_index_tieuchi');
		Route::get('botieuchi', 'BoTieuChiController@truongdonviindex')->name('truongdonvi_botieuchi_index');
		Route::get('botieuchi/tieuchi/{idbotieuchi}', 'TieuChiController@truongdonviindex')->name('truongdonvi_botieuchi_tieuchi_index');
		Route::get('hocky-tieuchi', 'HocKyNamHocBoTieuChiController@truongdonviindex')->name('truongdonvi_hockynamhocbotieuchi_index');

		// Tiêu chí, Tiêu chí - Minh chứng
		Route::prefix('tieuchi')->group(function(){
			Route::get('minhchung', 'ServiceTieuChiMinhChungController@truongdonviindextieuchiminhchung')->name('truongdonvi_index_tieuchi_minhchung');
			Route::get('minhchung/{idhockynamhoc}/{idtieuchi}', 'ServiceTieuChiMinhChungController@truongdonvitieuchiminhchung')->name('truongdonvi_tieuchi_minhchung');
			Route::get('minhchung/module/{idhockynamhoc}/{idtieuchi}/{idmodule}', 'ServiceTieuChiMinhChungController@truongdonvitieuchiminhchungmodule')->name('truongdonvi_tieuchi_minhchung_module');
			Route::get('minhchung/download/fileimport/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@truongdonvitieuchiminhchungdownloadfileimport')->name('truongdonvi_tieuchi_minhchung_downloadfileimport');
			Route::get('minhchung/download/fileminhchung/{idtieuchiminhchung}', 'ServiceTieuChiMinhChungController@truongdonvitieuchiminhchungdownloadfileminhchung')->name('truongdonvi_tieuchi_minhchung_downloadfileminhchung');
		});

		// Tìm kiếm, thống kê
		Route::get('search-filter', 'ServiceSearchFilterController@truongdonviindex')->name('truongdonvisearchfilterindex');
		Route::get('statical-region', 'ServiceSearchFilterController@truongdonvistaticalregion')->name('truongdonvi_statical_region');

	});
	/**
	 * --------- End Trưởng đơn vị ---------
	 */

	/* --------- Group route Ajax --------- */
	Route::post('getnganhbykhoa', 'NganhController@getNganhByKhoa')->name('admin_getnganhbykhoa');
	Route::post('getlopbynganh', 'LopController@getLopByNganh')->name('admin_getlopbynganh');
	Route::post('getsinhvienfilter', 'SinhVienController@getSinhVienByKhoaNganhLop')->name('admin_getsinhvienbykhoanganhlop');
	Route::get('getsinhvienfilterexport', 'SinhVienController@getSinhVienByKhoaNganhLopExport')->name('admin_getsinhvienbykhoanganhlopexport');
	Route::get('hinhthe-export', 'ServiceHinhTheController@HinhTheByLopExport')->name('admin_getdshinhthebyloplopexport');
	Route::get('sinhvien/xoa/{id?}', 'SinhVienController@destroy')->name('sinhviendestroy');
	Route::get('khoa/bomon/{idkhoa?}', 'BoMonController@GetBoMonByKhoa')->name('admin_get_bomonbykhoa');
	Route::get('lopajax/{id}', 'LopController@getLop')->name('lopajax');
	Route::get('huyenajax/{tinh_id?}', 'HuyenController@getHuyen')->name('huyenajax');
	Route::get('xaajax/{huyen_id?}', 'XaController@getXa')->name('xaajax');

	Route::post('danhsach-huyen', 'HuyenController@getHuyenByTinh')->name('admin_gethuyenbytinh');
	Route::post('danhsach-xa', 'XaController@getXaByHuyen')->name('admin_getxabyhuyen');
	Route::post('sinhvientheotinhhuyenxa', 'ServiceSinhVienController@getSinhVienByTinhHuyenXa')->name('admin_getstaticalbytinhhuyenxa');
	Route::get('sinhvientheotinhhuyenxa', 'ServiceSinhVienController@getSinhVienByTinhHuyenXa');


	Route::get('searchsinhvienajax/{mssv?}', 'SinhVienController@getSinhVien')->name('searchsinhvienajax');
	Route::get('searchsinhvienajax2/{value?}/{type?}', 'SinhVienController@getSearchSinhVien')->name('searchsinhvienajax_multiparameter');
	Route::get('bancansu/lop/{idlop?}', 'BanCanSuController@getDSSinhVienTheoLop')->name('get_bancansu_lop');
	Route::get('bancansu/lop/hockynamhoc/{idlop?}/{idhockynamhoc?}', 'BanCanSuController@getDSSinhVienTheoLopTheoHocKy')->name('get_bancansu_lop_hockynamhoc');
	Route::get('chucvubancansu', 'ChucVuBanCanSuController@getDanhSachChucVuBanCanSu')->name('get_chucvubancansu');
	Route::get('chucvubancansu/hockynamhoc/sinhvien/chucvu/{idhockynamhoc?}/{idsinhvien?}/{idchucvu?}', 'BanCanSuController@getBanCanSuTheo_HocKy_SinhVien_ChucVu')->name('get_chucvubancansu_sinhvien_chucvu');
	Route::post('search-filter', 'ServiceSearchFilterController@adminindexpost')->name('adminsearchfilterindexpost');
	/* --------- End Group route Ajax --------- */

	Route::get('logout', 'LogoutController@Logout')->name('logout');
	// Route::get('signout/{provider}', 'Auth\LoginController@Logout')->name('signout');
	Route::get('signout/{provider}', 'Auth\LoginController@Logout')->name('signout');
	Route::get('user/change-password', 'UserController@showchangepassword')->name('changepassword');
	Route::post('user/change-password', 'UserController@storechangepassword')->name('storechangepassword');
	Route::get('profile', 'LogoutController@Logout')->name('profile');
});

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

	Route::get('{provider}/callback', 'Auth\LoginController@handleProviderCallback')
		->name('callback');
});

Auth::routes();

