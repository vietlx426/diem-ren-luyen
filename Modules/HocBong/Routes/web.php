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
Route::middleware('quantrihethong')->prefix('admin')->group(function(){
	Route::prefix('hocbong')->group(function() {
	Route::get('/dashboard-hocbong', 'HocBongController@dashboard')->name('hocbong.dashboard');
    Route::get('/', 'HocBongController@index')->name('hocbong.index');
    Route::get('/create','HocBongController@create')->name('hocbong.create');
    Route::post('/create','HocBongController@store');
    Route::get('/update/{id}','HocBongController@edit')->name('hocbong.edit');
  	Route::post('/update/{id}','HocBongController@update');

  	Route::get('/tim-kiem','TimKiemSinhVienController@StudentSearch')->name('hocbong.timkiem.sinhvien');
  	Route::get('tim-kiem/lop/{idhb?}', 'TimKiemSinhVienController@getLopByKhoa')->name('admin_get_lopbykhoa');

  	Route::get('/delete/{id}','HocBongController@destroy')->name('hocbong.delete');
	});
	

	Route::get('thong-ke/khoa-moi/nam-hoc/{id}/{idnamhoc}','ThongKeController@faculty')->name('thongke.nammoi');
	Route::get('thong-ke/khoa-moi/hoc-ky/{id}/{idhocky}','ThongKeController@facultySemester')->name('thongke.hocky');

	Route::get('/history/{id}','TraoHocBongController@edit')->name('hocbong.lichsu.sinhvien');
	Route::get('/edit-history/{id}','TraoHocBongController@editHistory')->name('admin.edit.history');
	Route::get('/delete-history/{id}','TraoHocBongController@deleteHistory')->name('admin.delete.history');
	Route::post('/edit-history/{id}','TraoHocBongController@update')->name('admin.save.history');
	Route::get('/traohocbong/{id}','TraoHocBongController@create')->name('hocbong.trao');
	Route::post('/traohocbong/{id}','TraoHocBongController@store');
	// Route::get('/xuat-pdf/{id}','HocBongController@exportpdf')->name('hocbong.pdf');
	Route::get('hocbong/import', 'HocBongController@adminimport')->name('hocbong.import');
	Route::post('hocbong/import', 'HocBongController@adminimportstore');

	Route::get('hocbongsinhvien/import', 'TraoHocBongController@importDSSVHB')->name('hocbongsinhvien.import');
	Route::post('hocbongsinhvien/import', 'TraoHocBongController@importDSSVHBstore');

	Route::get('thong-ke/lop-moi/nam-hoc/{id}/{idnamhoc}','ThongKeController@class')->name('thongke.lop.theo.nammoi');
	Route::get('thong-ke/lop-moi/hoc-ky/{id}/{idhocky}','ThongKeController@classSemester')->name('thongke.lop.theo.hockymoi');
	Route::get('/info/{id}','HocBongController@info')->name('thongke.theo.hocbong.namcu');


	
	Route::get('/thong-bao','ThongBaoController@index')->name('hocbong.thongbao');
	Route::get('/them-thong-bao','ThongBaoController@create')->name('thongbao.create');
	Route::post('/them-thong-bao','ThongBaoController@store')->name('thongbao.store');

	Route::get('/sua-thong-bao/{id}','ThongBaoController@edit')->name('thongbao.edit');
	Route::post('/sua-thong-bao/{id}','ThongBaoController@update')->name('thongbao.update');
	Route::get('/xoa-thong-bao/{id}','ThongBaoController@destroy')->name('thongbao.delete');

	Route::get('/tat-thong-bao/{id}','ThongBaoController@offThongBao')->name('thongbao.off');
	Route::get('/bat-thong-bao/{id}','ThongBaoController@onThongBao')->name('thongbao.on');

	Route::get('/van-ban/{id}','ThongBaoController@dsVanBan')->name('vanban.index');
	Route::post('/them-van-ban','ThongBaoController@postThemVanBan')->name('vanban.store');
	Route::post('/sua-van-ban','ThongBaoController@postSuaVanBan')->name('vanban.update');
	Route::get('/xoa-van-ban/{id}','ThongBaoController@XoaVanBan')->name('vanban.delete');
	//Export PDF
	Route::get('export-pdf-1/{idnamhoc}/{idlop}', 'HocBongController@hocbong_export') ->name('admin_hocbong_export');
	Route::get('export-pdf-2/{idhocky}/{idlop}', 'HocBongController@hocbong_export_hknh') ->name('admin_hocbong_export_hknh');
	//

	//Excel
	Route::get('xuatexcel-toantruong-namhoc/{id}', 'ExportController@xuatExcel')->name('xuatexcel.namhoc');
	Route::get('xuatexcel-toantruong-hocky/{id}', 'ExportController@xuatExcelByHocKy')->name('xuatexcel.hocky');
	Route::get('xuatexcel-theokhoa-namhoc/{id}/{idnamhoc}', 'ExportController@xuatExcelByKhoaByNamhoc')->name('xuatexcel.theokhoa');
	Route::get('xuatexcel-theokhoa-hocky/{id}/{idhk}', 'ExportController@xuatExcelByKhoaByHocKy')->name('xuatexcel.theokhoa.hocky');

	//
	Route::post('traohocbong', 'TraoHocBongController@TraoHB')->name('admin.traoHB');

	
	Route::get('namhoc/hknh/{idnamhoc?}', 'HocBongController@GetHKNHByNH')->name('admin_get_hknhbyhk');

	Route::get('ho-so', 'ThongBaoController@getDSHoSo')->name('danhsach.hoso');
	Route::get('file-ho-so/{id}', 'ThongBaoController@getFile')->name('download.file.hoso');
	Route::post('/hoso-trao-hocbong','ThongBaoController@traoHBOnHoSo')->name('hoso.trao.hocbong');
	



});

Route::middleware('sinhvien')->prefix('sinhvien')->group(function(){

	Route::prefix('hocbong')->group(function(){
			Route::get('','SinhVienController@sinhvien_index_hocbong')->name('sinhvien.hocbong');
			Route::get('thongbao-hocbong/{id}','SinhVienController@sinhvien_thongbao')->name('sinhvien.thongbao.hocbong');
			Route::get('chitiet-ketqua/{id}','SinhVienController@sinhvien_chitiet')->name('sinhvien.chitiet.ketqua');
			Route::get('ketqua-hocbong','SinhVienController@ketquahocbongall')->name('sinhvien.ketqua.all');
			Route::get('/download/{id}','SinhVienController@sinhvien_download')->name('sinhvien.download');
			Route::post('/nop-hoso','SinhVienController@postNopHS')->name('hoso.store');
		});
		

});

Route::middleware('covanhoctap')->prefix('covanhoctap')->group(function(){
	Route::prefix('hocbong')->group(function(){
			Route::get('','CoVanHocTapController@index')->name('covanhoctap.hocbong');
			
			Route::get('sinhvien-lichsu/{id}/','CoVanHocTapController@covanhoctap_hocbong_lichsu')->name('covanhoctap.hocbong.lichsu');
			Route::get('/xem-thong-bao/{id}','CoVanHocTapController@covanhoctap_thongbao')->name('covanhoctap.thongbao');
			Route::get('/download/{id}','CoVanHocTapController@covanhoctap_download')->name('covanhoctap.download');

			
		});
});

Route::middleware('giaovukhoa')->prefix('giaovukhoa')->group(function(){
	Route::prefix('hocbong')->group(function(){
			Route::get('','GiaoVuKhoaController@index')->name('giaovukhoa.hocbong');
			Route::get('sinhvien-hocbong/{id}','GiaoVuKhoaController@giaovukhoa_hocbong_sinhvien')->name('giaovukhoa.hocbong.sinhvien');
			Route::get('sinhvien-lichsu/{id}','GiaoVuKhoaController@giaovukhoa_hocbong_lichsu')->name('giaovukhoa.hocbong.lichsu');
			Route::get('/xem-thong-bao/{id}','GiaoVuKhoaController@giaovukhoa_thongbao')->name('giaovukhoa.thongbao');
			Route::get('/download/{id}','GiaoVuKhoaController@giaovukhoa_download')->name('giaovukhoa.download');
		});
});

