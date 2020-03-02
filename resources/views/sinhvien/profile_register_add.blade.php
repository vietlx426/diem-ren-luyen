@extends('layout.master_noneblock')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/admin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/image-profile.css')}}">
@endsection
@section('content_one_column')
    <content style="background-color: #ededed;">
        <div class="page-header text-center">
            <br>
            <h4><b>SƠ YẾU LÝ LỊCH SINH VIÊN</b></h4>
            <hr>
        </div>
        
        <div class="page-content">
            <!-- Block error message -->
            @include('layout.block.message_flash')
            @include('layout.block.message_validation')

            <!-- Form information -->
            <form method="POST" action="{{route('post_profilesv')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row col-12">
                    <div class="col-md-4 col-xs-12 col-sm-6 col-lg-3">
                        <!-- <img width="100%" alt="User Pic" src="{{URL::asset('images\nobody_m.original.jpg')}}" class="img-circle img-responsive"> -->
                        
                        <div class="form-group">
                            <div class="main-img-preview">
                                <!-- <img class="thumbnail img-preview" src="http://farm4.static.flickr.com/3316/3546531954_eef60a3d37.jpg" title="Preview Logo"> -->
                                <img class="thumbnail img-preview" src="{{URL::asset('images\nobody_m.original.jpg')}}" title="Preview Logo">
                            </div>
                            <!-- <div class="input-group"> -->
                            <div class="text-center" style="background-color: #e6e6e6;">
                                <input id="fakeUploadLogo" class="form-control fake-shadow" placeholder="Choose File" disabled="disabled" hidden="true">
                                <div class="input-group-btn">
                                    <div class="fileUpload btn btn-danger btn-block fake-shadow">
                                        <span><i class="glyphicon glyphicon-upload"></i> Upload Picture</span>
                                        <!-- <input id="logo-id" name="picprofile" type="file" class="attachment_upload"> -->
                                        <input id="picprofile" name="picprofile" type="file" class="attachment_upload">
                                    </div>
                                </div>
                            </div>
                            <p class="help-block">* Upload hình đại hiện.</p>
                        </div>
                    </div>

                    <div class="col-md-8 col-xs-12 col-sm-6 col-lg-9" >
                        <div class="container">
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="">Họ lót</label>
                                    <input type="text" id="holot" name="holot" class="form-control" value="{!! old('holot') !!}" placeholder="Họ và chữ lót">
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="">Tên</label>
                                    <input type="text" id="ten" name="ten" class="form-control" value="{!! old('ten') !!}" placeholder="Tên">
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="">Mã số sinh viên</label>
                                    <input type="text" id="mssv" name="mssv" class="form-control" value="{!! old('mssv') !!}" placeholder="Mã số sinh viên">
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="">Giới tính</label>
                                    <div class="form-control" style="border: none;">
                                        @if(!is_null(old('gioitinh')) && intval(old('gioitinh')) === intval(1))
                                            <input class="gioitinh" id="gioitinhnam" type="radio" name="gioitinh" checked="true" value="1">
                                        @else
                                            <input class="gioitinh" id="gioitinhnam" type="radio" name="gioitinh" value="1">
                                        @endif

                                        <label for="gioitinhnam"> Nam </label>
                                        &ensp;&ensp;&ensp;
                                        @if(!is_null(old('gioitinh')) && intval(old('gioitinh')) === intval(0))
                                            <input class="gioitinh" id="gioitinhnu" type="radio" name="gioitinh" checked="true" value="0">
                                        @else
                                            <input class="gioitinh" id="gioitinhnu" type="radio" name="gioitinh" value="0">
                                        @endif
                                        <label for="gioitinhnu"> Nữ </label>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="">Ngành</label>
                                    <select name="nganh" id="nganh" class="nganh form-control">
                                        <option value="0">----- Chọn ngành học -----</option>
                                        @if(isset($DanhSach_Nganh))
                                            @foreach($DanhSach_Nganh as $Nganh)
                                                @if(!is_null(old('nganh')) && intval(old('nganh')) === $Nganh->id)
                                                    <option value="{{$Nganh->id}}" selected="true" >{{$Nganh->tennganh}}</option>
                                                @else
                                                    <option value="{{$Nganh->id}}">{{$Nganh->tennganh}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                               <!--  <div class="col-sm-12 col-md-6 form-group">
                                    <label for="">Khoa</label>
                                    <input type="text" name="khoadaotao" value="{{old('khoadaotao')}}" placeholder="Khoa đào tạo" disabled="true" class="form-control">
                                </div> -->
                                
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label for="">Lớp</label>
                                    <select name="lop" id="lop" class="lop form-control" disabled="true">
                                        <option value="0">----- Chọn lớp học -----</option>
                                        @if(isset($DanhSach_Lop))
                                            @foreach($DanhSach_Lop as $Lop)
                                                @if(!is_null(old('lop')) && intval(old('lop')) === $Lop->id)
                                                    <option value="{{$Lop->id}}" selected="true">{{$Lop->tenlop}}</option>
                                                @else
                                                    <option value="{{$Lop->id}}">{{$Lop->tenlop}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- <div class="col-sm-12 col-md-6 form-group">
                                    <label for="">Khóa học</label>
                                    <input type="text" name="khoahoc" value="{{old('khoahoc')}}" placeholder="Khóa học" disabled="true" class="form-control">
                                </div> -->

                                <div class="col-md-12 col-lg-6 form-group">
                                    <label for="">Điểm trúng tuyển</label>
                                    <input type="number" name="diemtrungtuyen" id="diemtrungtuyen" value="{{old('diemtrungtuyen')}}" class="diemtrungtuyen form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row container">
                    <div class="process">
                        <!-- nav tab -->
                        <div class="process-row nav nav-tabs">
                            <div class="process-step">
                                <button id="btn_nav_process_banthan" type="button" class="btn btn-info btn-circle" data-toggle="tab" href="#banthan"><i class="fa fa-user fa-3x"></i></button>
                                <p><small>Bản Thân</small></p>
                            </div>
                            <div class="process-step">
                                <button id="btn_nav_process_giadinh" type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#giadinh"><i class="fa fa-users fa-3x"></i></button>
                                <p><small>Gia Đình</small></p>
                            </div>
                        </div>
                    </div>

                    <div class="process container">
                        <!-- tab content -->
                        <div class="tab-content">
                            <div id="banthan" class="tab-pane fade active in show">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Điện thoại</label>
                                        <input type="text" name="dienthoai" id="dienthoai" class="dienthoai form-control" value="{{old('dienthoai')}}" placeholder="Điện thoại">
                                        <!-- <div class="input-group">
                                            <div class="input-group-append">
                                                <i class="btn fa fa-search"></i> 
                                            </div>
                                            <input class="form-control py-2" type="search" value="search" id="example-search-input">
                                            
                                        </div> -->
                                    </div>
                                    <!-- <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Điểm trúng tuyển</label>
                                        <input type="number" name="diemtrungtuyen" id="diemtrungtuyen" value="{{old('diemtrungtuyen')}}" class="diemtrungtuyen form-control">
                                    </div> -->

                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Email</label>
                                        <input type="text" name="email" id="email" value="{{old('email')}}" class="email form-control">
                                    </div>

                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Ngày, tháng, năm sinh</label>
                                        <input type="date" name="namsinh" id="namsinh" class="namsinh form-control" value="{{ old('namsinh'), date('d/m/Y') }}">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Nơi sinh</label>
                                        <input type="text" name="noisinh" id="noisinh" class="noisinh form-control" value="{{old('noisinh')}}" placeholder="Nơi sinh">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Số CMND</label>
                                        <input type="text" name="cmnd" id="cmnd" class="cmnd form-control" value="{{old('cmnd')}}" placeholder="CMND">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Ngày cấp CMND</label>
                                        <input type="date" name="ngaycapcmnd" id="ngaycapcmnd" class="ngaycapcmnd form-control" value="{{ old('ngaycapcmnd'), date('d/m/Y') }}">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Nơi cấp CMND</label>
                                        <input type="text" name="noicapcmnd" id="noicapcmnd" class="noicapcmnd form-control" value="{{old('noicapcmnd')}}" placeholder="Nơi cấp">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Hộ khẩu thường trú</label>
                                        <input type="text" name="hokhauthuongtru" id="hokhauthuongtru" class="hokhauthuongtru form-control" value="{{old('hokhauthuongtru')}}" placeholder="Hộ khẩu thường trú">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Dân tộc</label>
                                        <select name="dantoc" id="dantoc" class="form-control">
                                            <option value="0">----- Chọn dân tộc -----</option>
                                            @if(isset($DanhSach_DanToc))
                                                @foreach($DanhSach_DanToc as $DanToc)
                                                    @if(!is_null(old('dantoc')) && intval(old('dantoc')) === intval($DanToc->id))
                                                        <option value="{{$DanToc->id}}" selected="true">{{$DanToc->tendantoc}}</option>
                                                    @else
                                                        <option value="{{$DanToc->id}}">{{$DanToc->tendantoc}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Tôn giáo</label>
                                        <select name="tongiao" id="tongiao" class="form-control">
                                            <option value="0">----- Chọn tôn giáo -----</option>
                                            @if(isset($DanhSach_TonGiao))
                                                @foreach($DanhSach_TonGiao as $TonGiao)
                                                    @if(!is_null(old('tongiao')) && intval(old('tongiao')) === intval($TonGiao->id))
                                                        <option value="{{$TonGiao->id}}" selected="true">{{$TonGiao->tentongiao}}</option>
                                                    @else
                                                        <option value="{{$TonGiao->id}}">{{$TonGiao->tentongiao}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Ngày vào Đoàn TNCS HCM</label>
                                        <input type="date" name="ngayvaodoan" id="ngayvaodoan" class="ngayvaodoan form-control" value="{{ old('ngayvaodoan'), date('d/m/Y') }}">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                       <label for="">Vào Đoàn TNCS HCM tại</label>
                                       <input type="text" name="vaodoantai" id="vaodoantai" class="vaodoantai form-control" value="{{old('vaodoantai')}}" placeholder="Vào Đoàn TNCS HCM tại">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                       <label for="">Ngày vào Đảng CSVN</label>
                                        <input type="date" name="ngayvaodang" id="ngayvaodang" class="ngayvaodang form-control" value="{{ old('ngayvaodang'), date('d/m/Y') }}">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                       <label for="">Vào Đảng CSVN tại</label>
                                       <input type="text" name="vaodangtai" id="vaodangtai" class="vaodangtai form-control" value="{{old('vaodangtai')}}" placeholder="Vào Đảng CSVN tại">
                                    </div>
                                </div>
                                <br>
                                <div class="nav text-center">
                                    <button id="btn-next-giadinh" data-toggle="tab" href="#giadinh" class="btn btn-success btn-direction">
                                        <b>TIẾP TỤC</b>
                                        <i class="fa fa-arrow-circle-o-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="giadinh" class="tab-pane fade">
                                <!-- Cha -->
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <label class="lblbold" for="">1. Cha</label>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                        <label for="">Họ tên cha</label>
                                        <input type="text" name="cha_hoten" id="cha_hoten" class="cha_hoten form-control" value="{{old('cha_hoten')}}" placeholder="Họ tên cha">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                       <label for="">Năm sinh</label>
                                       <input type="date" name="cha_namsinh" id="cha_namsinh" class="cha_namsinh form-control" value="{{ old('cha_namsinh'), date('d/m/Y') }}">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                        <label for="">Dân tộc</label>
                                        <select name="cha_dantoc" id="cha_dantoc" class="form-control">
                                            <option value="0">----- Chọn dân tộc -----</option>
                                            @if(isset($DanhSach_DanToc))
                                                @foreach($DanhSach_DanToc as $DanToc)
                                                    @if(!is_null(old('cha_dantoc')) && intval(old('cha_dantoc')) === intval($DanToc->id))
                                                        <option value="{{$DanToc->id}}" selected="true">{{$DanToc->tendantoc}}</option>
                                                    @else
                                                        <option value="{{$DanToc->id}}">{{$DanToc->tendantoc}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-12 form-group">
                                        <label for="">Hộ khẩu thường trú</label>
                                        <input type="text" name="cha_hokhauthuongtru" id="cha_hokhauthuongtru" class=" cha_hokhauthuongtru form-control" value="{{old('cha_hokhauthuongtru')}}" placeholder="Hộ khẩu thường trú">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                       <label for="">Nghề nghiệp</label>
                                       <input type="text" name="cha_nghenghiep" id="cha_nghenghiep" class="cha_nghenghiep form-control" value="{{old('cha_nghenghiep')}}" placeholder="Nghề nghiệp">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                        <label for="">Điện thoại</label>
                                        <input type="text" name="cha_dienthoai" id="cha_dienthoai" class="dienthoai cha_dienthoai form-control" value="{{old('cha_dienthoai')}}" placeholder="Điện thoại">
                                    </div>
                                </div>

                                <!-- Mẹ -->
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <label class="lblbold" for="">2. Mẹ</label>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                        <label for="">Họ tên mẹ</label>
                                        <input type="text" name="me_hoten" id="me_hoten" class="me_hoten form-control" value="{{old('me_hoten')}}" placeholder="Họ tên mẹ">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                       <label for="">Năm sinh</label>
                                       <input type="date" name="me_namsinh" id="me_namsinh" class="me_namsinh form-control" value="{{ old('me_namsinh'), date('d/m/Y') }}">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                        <label for="">Dân tộc</label>
                                        <select name="me_dantoc" id="me_dantoc" class="form-control">
                                            <option value="0">----- Chọn dân tộc -----</option>
                                            @if(isset($DanhSach_DanToc))
                                                @foreach($DanhSach_DanToc as $DanToc)
                                                    @if(!is_null(old('me_dantoc')) && intval(old('me_dantoc')) === intval($DanToc->id))
                                                        <option value="{{$DanToc->id}}" selected="true">{{$DanToc->tendantoc}}</option>
                                                    @else
                                                        <option value="{{$DanToc->id}}">{{$DanToc->tendantoc}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-12 form-group">
                                        <label for="">Hộ khẩu thường trú</label>
                                        <input type="text" name="me_hokhauthuongtru" id="me_hokhauthuongtru" class="me_hokhauthuongtru form-control" value="{{old('me_hokhauthuongtru')}}" placeholder="Hộ khẩu thường trú">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                       <label for="">Nghề nghiệp</label>
                                       <input type="text" name="me_nghenghiep" id="me_nghenghiep" class="me_nghenghiep form-control" value="{{old('me_nghenghiep')}}" placeholder="Nghề nghiệp">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                        <label for="">Điện thoại</label>
                                        <input type="text" name="me_dienthoai" id="me_dienthoai" class="dienthoai me_dienthoai form-control" value="{{old('me_dienthoai')}}" placeholder="Điện thoại">
                                    </div>
                                </div>
                                <!-- Anh, Chị, Em ruột -->
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        3. Anh, Chị, Em ruột
                                    </div>
                                    <div class="col-md-12 col-lg-12">
                                        <table class="table-bordered" width="100%">
                                            <thead class="text-center">
                                                <th width="10%">Quan hệ</th>
                                                <th width="20%">Họ tên</th>
                                                <th width="15%">Năm sinh</th>
                                                <th width="25%">Nghề nghiệp</th>
                                                <th width="25%">Nơi ở</th>
                                                <th width="5%"></th>
                                            </thead>
                                            <tbody id="tbody_anhchiem">
                                                <tr id="0" class="hidden" hidden="true">
                                                    <td>
                                                        <select id="anhchiem_sel_moiquanhe_0" class="form-control">
                                                            <option value="0">-Chọn-</option>
                                                            @if(isset($DanhSach_MoiQuanHe))
                                                                @foreach($DanhSach_MoiQuanHe as $MoiQuanHe)
                                                                    <option value="{{$MoiQuanHe->id}}">{{$MoiQuanHe->tenmoiquanhe}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="anhchiem_inp_hoten_0" class="form-control" placeholder="Họ và tên">
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control" value="{{ date('d/m/Y') }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="anhchiem_inp_nghenghiep_0"  class="form-control" placeholder="Nghề nghiệp">
                                                    </td>
                                                    <td>
                                                        <input type="text" id="anhchiem_inp_noio_0"  class="form-control" placeholder="Nơi ở">
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-warning btn-remove-row" title="Xóa"><i class="fa fa-remove"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6">
                                                        <br>
                                                        <div class="text-center">
                                                            <button class="btn btn-primary add-tr-anhchiem" title="Thêm Anh, Chị, Em">
                                                                <i class="fa fa-plus"></i> Thêm
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                
                                <br>
                                <div class="nav text-center">
                                    <button id="btn-previous-banthan" data-toggle="tab" href="#banthan" class="btn btn-success btn-direction">
                                        <i class="fa fa-arrow-circle-o-left"></i>
                                        <b>VỀ TRƯỚC</b>
                                    </button>
                                    &nbsp;
                                    <button type="submit" class="btn btn-danger btn-direction btn_save">
                                        <i class="fa fa-save"></i>
                                        <b>LƯU</b>
                                    </button>
                                </div>
                            </div>
                            <div id="banthan2" class="tab-pane fade tab-process">
                                <h3>Menu 5</h3>
                                <p>Some content in menu 5.</p>
                                <ul class="list-unstyled list-inline pull-right">
                                    <li><button type="button" class="btn btn-default prev-step"><i class="fa fa-chevron-left"></i> Back</button></li>
                                    <li><button type="button" class="btn btn-success"><i class="fa fa-check"></i> Done!</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </content>
@endsection
@section('javascript')
    @parent
    <script type="text/javascript" src="{!! URL::asset('js/profile_register.js') !!}"></script>

    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/upload-image-profile.js') !!}"></script>
@endsection