@extends('sinhvien.layout.master')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/admin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/image-profile.css')}}">
@endsection
@section('content')
        <?php use App\Xa; ?>
        @if(isset($SV))
            <div class="page-header text-center">
                <br>
                <h4><b>SƠ YẾU LÝ LỊCH</b></h4>
            </div>
            
            <!-- Block error message -->
            @if($errors->all())
                <!-- danger -->
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                     - Lưu chưa thành công!
                    <br>
                     - Vui lòng nhập đầy đủ thông tin & kiểm tra lại những ô thông báo màu đỏ.
                </div>
            @endif

            @include('layout.block.message_flash')
            @include('layout.block.message_validation')

            <!-- Form information -->
            <form method="POST" action="{{route('sinhvien_postprofile')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="text" name="checkold" value="1" readonly="" hidden="true">
                <div class="row">
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2 col-xl-1">
                        <div class="form-group">
                            <div class="main-img-preview">
                                @if($LyLich)
                                    <input type="hidden" name="id" value="{{$LyLich->id}}" class="hidden" hidden="true">

                                    @if($LyLich->picture)
                                        <img class="thumbnail img-preview" width="100%" src="{{URL::asset($LyLich->picture)}}" title="Preview Logo">
                                    @else
                                        <img class="thumbnail img-preview" width="100%" src="{{URL::asset('images\nobody_m.original.jpg')}}" title="Preview Logo">
                                    @endif
                                    
                                @else
                                    <img class="thumbnail img-preview" width="100%" src="{{URL::asset('images\nobody_m.original.jpg')}}" title="Preview Logo">
                                @endif
                            </div>
                            <!-- Profile image -->
                            <div class="text-center">
                                <div class="form-group{{ $errors->has('picprofile') ? ' has-error' : '' }}">
                                    <input id="fakeUploadLogo" name="fakeUploadLogo" class="form-control fake-shadow hidden" placeholder="Choose File" disabled="disabled" hidden="true">
                                    <div class="input-group-btn">
                                        <div class="fileUpload btn btn-primary btn-block fake-shadow">
                                            <span><i class="glyphicon glyphicon-upload"></i> CHỌN HÌNH </span>
                                            <input id="picprofile" name="picprofile" type="file" class="attachment_upload">
                                        </div>
                                    </div>
                                    @if ($errors->has('picprofile'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('picprofile') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-8 col-md-8 col-lg-10 col-xl-11" >
                        <div class="container">
                            <div class="row">
                                <!-- Họ tên -->
                                <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                    <label for="">Họ tên: {!! $SV->hochulot !!} {!! $SV->ten !!}</label>
                                </div>
                                
                                <!-- MSSV -->
                                <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                    <label for="">Mã số sinh viên: {!! $SV->mssv !!}</label>
                                </div>

                                <!-- Ngày sinh -->
                                <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                    <label for="">Ngày sinh: {!! date('d/m/Y', strtotime($SV->ngaysinh))  !!}</label>
                                </div>

                                <!-- Giới tính -->
                                <div class="col-sm-12 col-md-12 col-lg-6 form-group">
                                    <label>
                                        Giới tính:
                                        @if(intval($SV->gioitinh) === intval(1))
                                            Nam
                                        @else
                                            Nữ
                                        @endif
                                    </label>
                                </div>

                                <!-- Điểm trúng tuyển -->
                                <div class="col-md-12 col-lg-6 form-group">
                                    <label for="">Điểm trúng tuyển: {!! floatval($SV->diemtrungtuyen) !!}</label>
                                </div>

                                <!-- Lớp -->
                                <div class="col-md-12 col-lg-6 form-group">
                                    <label for="">Lớp: {!! $SV->lop->tenlop !!}</label>
                                </div>

                                <!-- Ngành -->
                                <div class="col-md-12 col-lg-6 form-group">
                                    <label for="">Ngành: {!! $SV->lop->nganh->tennganh !!}</label>
                                </div>

                                <!-- Khoa -->
                                <div class="col-md-12 col-lg-6 form-group">
                                    <label for="">Khoa: {!! $SV->lop->nganh->bomon->khoa->tenkhoa !!}</label>
                                </div>

                                <!-- note -->
                                <!-- <div class="col-12 text-center">
                                    <span class="help-block" style="color: red;">
                                        <strong> * Những thông tin trên nếu chưa chính xác (không đúng). Vui lòng liên hệ thầy Lê Hoàng Anh (0946 857 875 - lhanh@agu.edu.vn), Nguyễn Ngọc Trọng (0949.309.899 - nntrong@agu.edu.vn).</strong>
                                    </span>
                                </div> -->
                            </div>
                        </div>
                        <div class="text-center">
                            <br>
                            <button type="submit" class="btn btn-danger btn-direction btn_save" title="Lưu ý: kiểm tra những ô dữ liệu ngày/tháng/năm phải nhập đầy đủ cả ngày/tháng/năm hệ thống mới cho lưu">
                                <i class="fa fa-save"></i>
                                <b>LƯU</b>
                            </button>
                            &nbsp;
                            @if($LyLich)
                                <a href="{{route('sinhvien_profile_print')}}" class="btn btn-warning btn-direction" title="Lý lịch chỉ lấy những thông tin đã được lưu trong hệ thống. Vui lòng lưu dữ liệu trước (nếu có thay đổi) trước khi tải lý lịch">
                                    <i class="fa fa-download"></i>
                                    <b>TẢI LÝ LỊCH</b>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="process container">
                        <!-- tab content -->
                        <div class="tab-content">
                            <!-- Bản thân -->
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 lbl-header">
                                        <i class="fa fa-user"></i> THÔNG TIN CÁ NHÂN
                                    </div>
                                </div>
                                <br>
                                @if($LyLich)
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('dienthoai') ? ' has-error' : '' }}">
                                                <label for="dienthoai" class="control-label">Điện thoại</label>
                                                <input id="dienthoai" type="text" class="form-control" name="dienthoai" value="{{ old('dienthoai',  $LyLich->dienthoai) }}" placeholder="Điện thoại" autofocus>
                                                @if ($errors->has('dienthoai'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('dienthoai') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Email -->
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label for="email" class="control-label">Email</label>
                                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email', $LyLich->email) }}" placeholder="Email" autofocus>
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <!-- Nơi sinh -->
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('noisinh') ? ' has-error' : '' }}">
                                                <label for="noisinh" class="control-label">Nơi sinh</label>
                                                <input id="noisinh" type="text" class="form-control" name="noisinh" value="{{ old('noisinh', $LyLich->noisinh) }}" placeholder="Nơi sinh" autofocus>
                                                @if ($errors->has('noisinh'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('noisinh') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Số CMND -->
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('cmnd') ? ' has-error' : '' }}">
                                                <label for="cmnd" class="control-label">Số CMND</label>

                                                <input id="cmnd" type="text" class="form-control" name="cmnd" value="{{ old('cmnd', $LyLich->cmnd ? $LyLich->cmnd : $SV->cmnd) }}" placeholder="Số CMND" autofocus>

                                                @if ($errors->has('cmnd'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('cmnd') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <!-- Ngày cấp CMND -->
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('ngaycapcmnd') ? ' has-error' : '' }}">
                                                <label for="ngaycapcmnd" class="control-label">Ngày cấp CMND</label>

                                                <input id="ngaycapcmnd" type="date" class="form-control" name="ngaycapcmnd" value="{{ old('ngaycapcmnd', $LyLich->ngaycapcmnd), date('d/m/Y') }}" placeholder="Ngày cấp CMND" autofocus>

                                                @if ($errors->has('ngaycapcmnd'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('ngaycapcmnd') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Nơi cấp CMND -->
                                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('noicapcmnd') ? ' has-error' : '' }}">
                                                <label for="noicapcmnd" class="control-label">Nơi cấp CMND</label>

                                                <input id="noicapcmnd" type="text" class="form-control" name="noicapcmnd" value="{{ old('noicapcmnd', $LyLich->noicapcmnd) }}" placeholder="Nơi cấp CMND" autofocus>

                                                @if ($errors->has('noicapcmnd'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('noicapcmnd') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="hr-orange">

                                    <!-- Địa chỉ thường trú, tạm trú -->
                                    <div class="row">
                                        <!-- Hộ khẩu thường trú -->
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">Địa chỉ hộ khẩu thường trú</label>
                                        </div>
                                        <!-- Tỉnh -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('tinh') ? ' has-error' : '' }}">
                                            <label for="tinh" class="control-label">Tỉnh - Thành phố</label>
                                            
                                            <select name="tinh" id="tinh" class="form-control" url="{{route('huyenajax')}}">
                                                <option value="0">----- Chọn Tỉnh - Thành phố -----</option>
                                                @if(isset($DanhSach_Tinh))
                                                    @foreach($DanhSach_Tinh as $Tinh)
                                                        <option value="{{$Tinh->id}}" 
                                                            {{intval(old('tinh', Xa::find($LyLich->xa_id)->huyen->tinh->id)) == intval($Tinh->id) ? 'selected="true"' : ''}}
                                                        >{{$Tinh->tentinh}}</option>

                                                    @endforeach
                                                @endif

                                            </select>

                                            @if ($errors->has('tinh'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tinh') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Quận - Huyện -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('huyen') ? ' has-error' : '' }}">
                                            <label for="huyen" class="control-label">Quận - Huyện</label>
                                            <select name="huyen" id="huyen" class="form-control" url="{{route('xaajax')}}">
                                                <option value="0">----- Chọn Quận - Huyện -----</option>
                                                @if($xa_id = old('xa', $LyLich->xa_id))
                                                    <?php 
                                                        $tinh_id = App\Xa::find($xa_id)->huyen->tinh->id;
                                                        $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Huyen as $Huyen)
                                                        <option value="{{$Huyen->id}}" {{intval(old('huyen', Xa::find($LyLich->xa_id)->huyen->id)) == intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen'))
                                                        <?php 
                                                            $tinh_id = App\Huyen::find($huyen_id)->tinh->id;
                                                            $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                        ?>
                                                        @foreach($DanhSach_Huyen as $Huyen)
                                                            <option value="{{$Huyen->id}}" {{intval(old('huyen', Xa::find($LyLich->xa_id)->huyen->id)) == intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                        @endforeach
                                                    @else
                                                        @if($tinh_id = old('tinh'))
                                                            <?php $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get(); ?>
                                                            @foreach($DanhSach_Huyen as $Huyen)
                                                                <option value="{{$Huyen->id}}" {{intval(old('huyen', Xa::find($LyLich->xa_id)->huyen->id)) == intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endif
                                            </select>
                                            @if ($errors->has('huyen'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('huyen') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Xã - Phường -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('xa') ? ' has-error' : '' }}">
                                            <label for="xa" class="control-label">Xã - Phường</label>
                                            <select name="xa" id="xa" class="form-control">
                                                <option value="0">----- Chọn Xã - Phường -----</option>
                                                @if($xa_id = old('xa', $LyLich->xa_id))
                                                    <?php 
                                                        $huyen_id = App\Xa::find($xa_id)->huyen->id;
                                                        $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Xa as $Xa)
                                                        <option value="{{$Xa->id}}" {{intval(old('xa', $LyLich->xa_id)) === intval($Xa->id) ? 'selected="true"' : ''}} >{{$Xa->tenxa}}</option>
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen'))
                                                        <?php $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get(); ?>
                                                        @foreach($DanhSach_Xa as $Xa)
                                                            <option value="{{$Xa->id}}" {{intval(old('xa', $LyLich->xa_id)) === intval($Xa->id) ? 'selected="true"' : ''}} >{{$Xa->tenxa}}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>
                                            @if ($errors->has('xa'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('xa') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group{{ $errors->has('hokhauthuongtru') ? ' has-error' : '' }}">
                                            <label for="hokhauthuongtru" class="control-label">Hộ khẩu thường trú</label>
                                            <i>(Số nhà, đường, Khóm - Ấp)</i>
                                            <input id="hokhauthuongtru" type="text" class="form-control" name="hokhauthuongtru" value="{{ old('hokhauthuongtru', $LyLich->hokhauthuongtru) }}" placeholder="Hộ khẩu thường trú" autofocus>
                                            @if ($errors->has('hokhauthuongtru'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hokhauthuongtru') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Địa chỉ tạm trú -->
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">Địa chỉ tạm trú</label>
                                            <p><i>Nếu chưa có địa chỉ tạm trú (ở trọ) thì chọn: Tỉnh An Giang -> Thành phố Long Xuyên -> Phường Đông Xuyên -> ô địa chỉ ghi: Ở trọ (chưa biết địa chỉ)</i></p>
                                        </div>
                                        
                                        <!-- Tỉnh -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('tinh_tamtru') ? ' has-error' : '' }}">
                                            <label for="tinh_tamtru" class="control-label">Tỉnh - Thành phố</label>
                                            <select name="tinh_tamtru" id="tinh_tamtru" class="form-control" url="{{route('huyenajax')}}">
                                                <option value="0">----- Chọn Tỉnh - Thành phố -----</option>
                                                @if(isset($DanhSach_Tinh))
                                                    @foreach($DanhSach_Tinh as $Tinh)
                                                        <option value="{{$Tinh->id}}" {{old('tinh_tamtru', Xa::find($LyLich->tamtru_xa_id)->huyen->tinh->id) == intval($Tinh->id) ? 'selected = "true"':''}}>{{$Tinh->tentinh}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('tinh_tamtru'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tinh_tamtru') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Quận - Huyện -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('huyen_tamtru') ? ' has-error' : '' }}">
                                            <label for="huyen_tamtru" class="control-label">Quận - Huyện</label>
                                            <select name="huyen_tamtru" id="huyen_tamtru" class="form-control" url="{{route('xaajax')}}">
                                                <option value="0">----- Chọn Quận - Huyện -----</option>
                                                @if($xa_id = old('xa_tamtru', $LyLich->tamtru_xa_id))
                                                    <?php 
                                                        $tinh_id = App\Xa::find($xa_id)->huyen->tinh->id;
                                                        $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Huyen as $Huyen)
                                                        <option value="{{$Huyen->id}}" {{intval(old('huyen_tamtru', Xa::find($LyLich->tamtru_xa_id)->huyen->id)) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen_tamtru'))
                                                        <?php 
                                                            $tinh_id = App\Huyen::find($huyen_id)->tinh->id;
                                                            $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                        ?>
                                                        @foreach($DanhSach_Huyen as $Huyen)
                                                            <option value="{{$Huyen->id}}" {{intval(old('huyen_tamtru', Xa::find($LyLich->tamtru_xa_id)->huyen->id)) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                        @endforeach
                                                    @else
                                                        @if($tinh_id = old('tinh_tamtru'))
                                                            <?php $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get(); ?>
                                                            @foreach($DanhSach_Huyen as $Huyen)
                                                                <option value="{{$Huyen->id}}" {{intval(old('huyen_tamtru', Xa::find($LyLich->tamtru_xa_id)->huyen->id)) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endif
                                            </select>
                                            @if ($errors->has('huyen_tamtru'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('huyen_tamtru') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Xã - Phường -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('xa_tamtru') ? ' has-error' : '' }}">
                                            <label for="xa_tamtru" class="control-label">Xã - Phường</label>
                                            <select name="xa_tamtru" id="xa_tamtru" class="form-control">
                                                <option value="0">----- Chọn Xã - Phường -----</option>
                                                @if($xa_id = old('xa_tamtru', $LyLich->tamtru_xa_id))
                                                    <?php 
                                                        $huyen_id = App\Xa::find($xa_id)->huyen->id;
                                                        $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Xa as $Xa)
                                                        <option value="{{$Xa->id}}" {{intval(old('xa_tamtru', $LyLich->tamtru_xa_id)) === intval($Xa->id) ? 'selected="true"' : ''}} >{{$Xa->tenxa}}</option>
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen_tamtru'))
                                                        <?php $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get(); ?>
                                                        @foreach($DanhSach_Xa as $Xa)
                                                            <option value="{{$Xa->id}}" {{intval(old('xa_tamtru', $LyLich->tamtru_xa_id)) === intval($Xa->id) ? 'selected="true"' : ''}} >{{$Xa->tenxa}}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>
                                            @if ($errors->has('xa_tamtru'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('xa_tamtru') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group{{ $errors->has('diachitamtru') ? ' has-error' : '' }}">
                                            <label for="diachitamtru" class="control-label">Địa chỉ tạm trú</label>
                                            <i>(Số nhà, đường, Khóm - Ấp)</i>
                                            <input id="diachitamtru" type="text" class="form-control" name="diachitamtru" value="{{ old('diachitamtru', $LyLich->diachitamtru) }}" placeholder="Địa chỉ tạm trú" autofocus>
                                            @if ($errors->has('diachitamtru'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('diachitamtru') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <hr class="hr-orange">

                                    <!-- Thông tin dân tộc, tôn giáo, đoàn, đảng -->
                                    <div class="row">
                                        <!-- Dân tộc -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('dantoc') ? ' has-error' : '' }}">
                                            <label for="dantoc" class="control-label">Dân tộc</label>
                                            <select name="dantoc" id="dantoc" class="form-control">
                                                <option value="0">----- Chọn dân tộc -----</option>
                                                @if(isset($DanhSach_DanToc))
                                                    @foreach($DanhSach_DanToc as $DanToc)
                                                        <option value="{{$DanToc->id}}" {{intval(old('dantoc', $LyLich->dantoc_id)) == intval($DanToc->id) ? 'selected="true"' : ''}} >{{$DanToc->tendantoc}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('dantoc'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dantoc') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Tôn giáo -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('tongiao') ? ' has-error' : '' }}">
                                            <label for="tongiao" class="control-label">Tôn giáo</label>
                                            <select name="tongiao" id="tongiao" class="form-control">
                                                <option value="0">----- Chọn tôn giáo -----</option>
                                                @if(isset($DanhSach_TonGiao))
                                                    @foreach($DanhSach_TonGiao as $TonGiao)
                                                        <option value="{{$TonGiao->id}}" {{intval(old('tongiao', $LyLich->tongiao_id)) == intval($TonGiao->id) ? 'selected="true"' : ''}} >{{$TonGiao->tentongiao}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('tongiao'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tongiao') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Ngày vào đoàn TNCS Hồ Chí Minh -->
                                        <div class="col-12">
                                            <p><i>Nếu chưa vào đoàn thì để trống Ngày vào Đoàn TNCS Hồ Chí Minh và Nơi vào Đoàn TNCS Hồ Chí Minh</i></p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('ngayvaodoan') ? ' has-error' : '' }}">
                                            <label for="ngayvaodoan" class="control-label">Ngày vào Đoàn TNCS Hồ Chí Minh</label>
                                            <input id="ngayvaodoan" type="date" class="form-control" name="ngayvaodoan" value="{{ old('ngayvaodoan', $LyLich->ngayvaodoantncshcm )}}" placeholder="Ngày vào Đoàn TNCS Hồ Chí Minh" autofocus>
                                            @if ($errors->has('ngayvaodoan'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('ngayvaodoan') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nơi vào đoàn TNCS Hồ Chí Minh -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('noivaodoan') ? ' has-error' : '' }}">
                                            <label for="noivaodoan" class="control-label">Nơi vào Đoàn TNCS Hồ Chí Minh</label>
                                            <input id="noivaodoan" type="text" class="form-control" name="noivaodoan" value="{{ old('noivaodoan', $LyLich->noivaodoantncshcm)}}" placeholder="Nơi vào Đoàn TNCS Hồ Chí Minh" autofocus>
                                            @if ($errors->has('noivaodoan'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('noivaodoan') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Ngày vào đảng CS Việt Nam -->
                                        <div class="col-12">
                                            <p><i>Nếu chưa vào Đảng thì để trống Ngày vào Đảng CS Việt Nam và Nơi vào Đảng CS Việt Nam</i></p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('ngayvaodang') ? ' has-error' : '' }}">
                                            <label for="ngayvaodang" class="control-label">Ngày vào Đảng CS Việt Nam</label>
                                            <input id="ngayvaodang" type="date" class="form-control" name="ngayvaodang" value="{{ old('ngayvaodang', $LyLich->ngayvaodangcsvn)}}"autofocus>
                                            @if ($errors->has('ngayvaodang'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('ngayvaodang') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nơi vào Đảng CS Việt Nam (Chi bộ, Đảng bộ) -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('noivaodang') ? ' has-error' : '' }}">
                                            <label for="noivaodang" class="control-label">Nơi vào Đảng CS Việt Nam </label>
                                            <i>(Chi bộ, Đảng bộ)</i>
                                            <input id="noivaodang" type="text" class="form-control" name="noivaodang" value="{{ old('noivaodang', $LyLich->noivaodangcsvn)}}" placeholder="Nơi vào Đảng CS Việt Nam (Chi bộ, Đảng bộ)" autofocus>
                                            @if ($errors->has('noivaodang'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('noivaodang') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                        
                                    <hr class="hr-orange">
                                    <!-- Gia đình thuộc diện nghèo, cận nghèo; Mồ côi cha, mẹ; Con thương bình, liệt -->
                                    <div class="row">
                                        <!-- Gia đình thuộc diện nghèo, cận nghèo -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('dienngheocanngheo') ? ' has-error' : '' }}">
                                            <label for="dienngheocanngheo" class="control-label">Gia đình thuộc diện hộ nghèo, cận nghèo</label>
                                            <div class="form-control none-border">
                                                <div class="row">
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">
                                                        <input id="dienngheocanngheo_ngheo" type="checkbox" class="" name="dienngheocanngheo_ngheo" value="1" {{old('checkold') ? ( old('dienngheocanngheo_ngheo') ? 'checked="true"' : '' ) : ($LyLich->hongheo ? 'checked="true"' : '')}} >
                                                        <label for="dienngheocanngheo_ngheo" class="control-label"> Hộ nghèo </label>
                                                    </div>
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">
                                                        <input id="dienngheocanngheo_canngheo" type="checkbox" class="" name="dienngheocanngheo_canngheo" value="1"  {{old('checkold') ? ( old('dienngheocanngheo_canngheo') ? 'checked="true"' : '' ) : ($LyLich->hocanngheo ? 'checked="true"' : '')}}>
                                                        <label for="dienngheocanngheo_canngheo" class="control-label"> Hộ cận nghèo </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('dienngheocanngheo'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dienngheocanngheo') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Thuộc diện mồ côi -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('dienmocoi') ? ' has-error' : '' }}">
                                            <label for="dienmocoi" class="control-label">Thuộc diện mồ côi</label>
                                            <div class="form-control none-border">
                                                <div class="row">
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">
                                                        <input id="dienmocoi_cha" type="checkbox" class="" name="dienmocoi_cha" value="1" {{old('checkold') ? ( old('dienmocoi_cha') ? 'checked="true"' : '' ) : ($LyLich->mocoicha ? 'checked="true"' : '')}}>
                                                        <label for="dienmocoi_cha" class="control-label"> Mồ côi cha </label>
                                                    </div>
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">
                                                        <input id="dienmocoi_me" type="checkbox" class="" name="dienmocoi_me" value="1" {{old('checkold') ? ( old('dienmocoi_me') ? 'checked="true"' : '' ) : ($LyLich->mocoime ? 'checked="true"' : '')}}>
                                                        <label for="dienmocoi_me" class="control-label"> Mồ côi mẹ </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('dienmocoi'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dienmocoi') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Con thương binh, liệt sỹ -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('conthuongbinhlietsy') ? ' has-error' : '' }}">
                                            <label for="conthuongbinhlietsy" class="control-label">Con thương binh, liệt sỹ</label>
                                            <div class="form-control none-border">
                                                <div class="row">
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">
                                                        <input id="conthuongbinhlietsy_thuongbinh" type="checkbox" class="" name="conthuongbinhlietsy_thuongbinh" value="1"  {{old('checkold') ? ( old('conthuongbinhlietsy_thuongbinh') ? 'checked="true"' : '' ) : ($LyLich->conthuongbinh ? 'checked="true"' : '')}} >
                                                        <label for="conthuongbinhlietsy_thuongbinh" class="control-label"> Con thương binh </label>
                                                    </div>
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">
                                                        <input id="conthuongbinhlietsy_lietsy" type="checkbox" class="" name="conthuongbinhlietsy_lietsy" value="1" {{old('checkold') ? ( old('conthuongbinhlietsy_lietsy') ? 'checked="true"' : '' ) : ($LyLich->conlietsy ? 'checked="true"' : '')}} >
                                                        <label for="conthuongbinhlietsy_lietsy" class="control-label"> Con liệt sỹ </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('conthuongbinhlietsy'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('conthuongbinhlietsy') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Tàn tật -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('tantat') ? ' has-error' : '' }}">
                                            <label for="tantat" class="control-label">Tàn tật</label>
                                            <div class="form-control none-border">
                                                <div class="row">
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">
                                                        <input id="tantat" type="checkbox" class="" name="tantat" value="1" {{old('checkold') ? ( old('tantat') ? 'checked="true"' : '' ) : ($LyLich->tantat ? 'checked="true"' : '')}}>
                                                        <label for="tantat" class="control-label"> Tàn tật </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('tantat'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tantat') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <!-- Điện thoại -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('dienthoai') ? ' has-error' : '' }}">
                                            <label for="dienthoai" class="control-label">Điện thoại</label>

                                            <input id="dienthoai" type="text" class="form-control" name="dienthoai" value="{{ old('dienthoai') }}" placeholder="Điện thoại" autofocus>

                                            @if ($errors->has('dienthoai'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dienthoai') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Email -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label for="email" class="control-label">Email</label>

                                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" autofocus>

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Nơi sinh -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('noisinh') ? ' has-error' : '' }}">
                                            <label for="noisinh" class="control-label">Nơi sinh</label>

                                            <input id="noisinh" type="text" class="form-control" name="noisinh" value="{{ old('noisinh') }}" placeholder="Nơi sinh" autofocus>

                                            @if ($errors->has('noisinh'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('noisinh') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Số CMND -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('cmnd') ? ' has-error' : '' }}">
                                            <label for="cmnd" class="control-label">Số CMND</label>

                                            <input id="cmnd" type="text" class="form-control" name="cmnd" value="{{ old('cmnd') }}" placeholder="Số CMND" autofocus>

                                            @if ($errors->has('cmnd'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('cmnd') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Ngày cấp CMND -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('ngaycapcmnd') ? ' has-error' : '' }}">
                                            <label for="ngaycapcmnd" class="control-label">Ngày cấp CMND</label>

                                            <input id="ngaycapcmnd" type="date" class="form-control" name="ngaycapcmnd" value="{{ old('ngaycapcmnd'), date('d/m/Y') }}" placeholder="Ngày cấp CMND" autofocus>

                                            @if ($errors->has('ngaycapcmnd'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('ngaycapcmnd') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nơi cấp CMND -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('noicapcmnd') ? ' has-error' : '' }}">
                                            <label for="noicapcmnd" class="control-label">Nơi cấp CMND</label>

                                            <input id="noicapcmnd" type="text" class="form-control" name="noicapcmnd" value="{{ old('noicapcmnd') }}" placeholder="Nơi cấp CMND" autofocus>

                                            @if ($errors->has('noicapcmnd'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('noicapcmnd') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <hr class="hr-orange">

                                    <!-- Địa chỉ thường trú, tạm trú -->
                                    <div class="row">
                                        <!-- Hộ khẩu thường trú -->
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">Địa chỉ hộ khẩu thường trú</label>
                                        </div>
                                        <!-- Tỉnh -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('tinh') ? ' has-error' : '' }}">
                                            <label for="tinh" class="control-label">Tỉnh - Thành phố</label>
                                            
                                            <select name="tinh" id="tinh" class="form-control" url="{{route('huyenajax')}}">
                                                <option value="0">----- Chọn Tỉnh - Thành phố -----</option>
                                                @if(isset($DanhSach_Tinh))
                                                    @foreach($DanhSach_Tinh as $Tinh)
                                                        <option value="{{$Tinh->id}}" 
                                                            {{intval(old('tinh')) == intval($Tinh->id) ? 'selected="true"' : ''}}
                                                        >{{$Tinh->tentinh}}</option>

                                                    @endforeach
                                                @endif
                                            </select>

                                            @if ($errors->has('tinh'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tinh') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Quận - Huyện -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('huyen') ? ' has-error' : '' }}">
                                            <label for="huyen" class="control-label">Quận - Huyện</label>
                                            <select name="huyen" id="huyen" class="form-control" url="{{route('xaajax')}}">
                                                <option value="0">----- Chọn Quận - Huyện -----</option>
                                                @if($xa_id = old('xa'))
                                                    <?php 
                                                        $tinh_id = App\Xa::find($xa_id)->huyen->tinh->id;
                                                        $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Huyen as $Huyen)
                                                        <option value="{{$Huyen->id}}" {{intval(old('huyen')) == intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen'))
                                                        <?php 
                                                            $tinh_id = App\Huyen::find($huyen_id)->tinh->id;
                                                            $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                        ?>

                                                        @foreach($DanhSach_Huyen as $Huyen)
                                                            <option value="{{$Huyen->id}}"
                                                                {{intval(old('huyen')) == intval($Huyen->id) ? 'selected="true"' : ''}}
                                                            >{{$Huyen->tenhuyen}}</option>
                                                        @endforeach
                                                    @else
                                                        @if($tinh_id = old('tinh'))
                                                            <?php $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get(); ?>
                                                            @foreach($DanhSach_Huyen as $Huyen)
                                                                <option value="{{$Huyen->id}}" {{intval(old('huyen')) == intval($Huyen->id) ? 'selected="true"' : ''}}>{{$Huyen->tenhuyen}}</option>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endif

                                            </select>

                                            @if ($errors->has('huyen'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('huyen') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Xã - Phường -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('xa') ? ' has-error' : '' }}">
                                            <label for="xa" class="control-label">Xã - Phường</label>
                                            <select name="xa" id="xa" class="form-control">
                                                <option value="0">----- Chọn Xã - Phường -----</option>
                                                @if($xa_id = old('xa'))
                                                    <?php 
                                                        $huyen_id = App\Xa::find($xa_id)->huyen->id;
                                                        $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Xa as $Xa)
                                                        <option value="{{$Xa->id}}" {{intval(old('xa')) === intval($Xa->id) ? 'selected="true"' : ''}}>{{$Xa->tenxa}}</option>
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen'))
                                                        <?php $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get(); ?>
                                                        @foreach($DanhSach_Xa as $Xa)
                                                            <option value="{{$Xa->id}}" {{intval(old('xa')) === intval($Xa->id) ? 'selected="true"' : ''}}>{{$Xa->tenxa}}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>

                                            @if ($errors->has('xa'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('xa') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group{{ $errors->has('hokhauthuongtru') ? ' has-error' : '' }}">
                                            <label for="hokhauthuongtru" class="control-label">Hộ khẩu thường trú</label>
                                            <i>(Số nhà, đường, Khóm - Ấp)</i>
                                            <input id="hokhauthuongtru" type="text" class="form-control" name="hokhauthuongtru" value="{{ old('hokhauthuongtru') }}" placeholder="Hộ khẩu thường trú" autofocus>
                                            @if ($errors->has('hokhauthuongtru'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hokhauthuongtru') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Địa chỉ tạm trú -->
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">Địa chỉ tạm trú</label>
                                            <p><i>Nếu chưa có địa chỉ tạm trú (ở trọ) thì chọn: Tỉnh An Giang -> Thành phố Long Xuyên -> Phường Đông Xuyên -> ô địa chỉ ghi: Ở trọ (chưa biết địa chỉ)</i></p>
                                        </div>
                                        
                                        <!-- Tỉnh -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('tinh_tamtru') ? ' has-error' : '' }}">
                                            <label for="tinh_tamtru" class="control-label">Tỉnh - Thành phố</label>
                                            
                                            <select name="tinh_tamtru" id="tinh_tamtru" class="form-control" url="{{route('huyenajax')}}">
                                                <option value="0">----- Chọn Tỉnh - Thành phố -----</option>
                                                @if(isset($DanhSach_Tinh))
                                                    @foreach($DanhSach_Tinh as $Tinh)
                                                        <option value="{{$Tinh->id}}" {{intval(old('tinh_tamtru')) == intval($Tinh->id) ? 'selected = "true"':''}}>{{$Tinh->tentinh}}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                            @if ($errors->has('tinh_tamtru'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tinh_tamtru') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Quận - Huyện -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('huyen_tamtru') ? ' has-error' : '' }}">
                                            <label for="huyen_tamtru" class="control-label">Quận - Huyện</label>
                                            
                                            <select name="huyen_tamtru" id="huyen_tamtru" class="form-control" url="{{route('xaajax')}}">
                                                <option value="0">----- Chọn Quận - Huyện -----</option>

                                                @if($xa_id = old('xa_tamtru'))
                                                    <?php 
                                                        $tinh_id = App\Xa::find($xa_id)->huyen->tinh->id;
                                                        $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                    ?>

                                                    @foreach($DanhSach_Huyen as $Huyen)
                                                        <option value="{{$Huyen->id}}" {{intval(old('huyen_tamtru')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>

                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen_tamtru'))
                                                        <?php 
                                                            $tinh_id = App\Huyen::find($huyen_id)->tinh->id;
                                                            $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                        ?>

                                                        @foreach($DanhSach_Huyen as $Huyen)
                                                            <option value="{{$Huyen->id}}"
                                                                {{intval(old('huyen_tamtru')) === intval($Huyen->id) ? 'selected="true"' : ''}} 
                                                            >{{$Huyen->tenhuyen}}</option>

                                                        @endforeach
                                                    @else
                                                        @if($tinh_id = old('tinh_tamtru'))
                                                            <?php 
                                                                $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                             ?>
                                                            @foreach($DanhSach_Huyen as $Huyen)
                                                               
                                                                <option value="{{$Huyen->id}}"
                                                                    {{intval(old('huyen_tamtru')) === intval($Huyen->id) ? 'selected="true"' : ''}} 
                                                                >{{$Huyen->tenhuyen}}</option>

                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endif
                                            </select>

                                            @if ($errors->has('huyen_tamtru'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('huyen_tamtru') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Xã - Phường -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('xa_tamtru') ? ' has-error' : '' }}">
                                            <label for="xa_tamtru" class="control-label">Xã - Phường</label>
                                            
                                            <select name="xa_tamtru" id="xa_tamtru" class="form-control">
                                                <option value="0">----- Chọn Xã - Phường -----</option>

                                                @if($xa_id = old('xa_tamtru'))
                                                    <?php 
                                                        $huyen_id = App\Xa::find($xa_id)->huyen->id;
                                                        $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get();
                                                    ?>

                                                    @foreach($DanhSach_Xa as $Xa)
                                                        <option value="{{$Xa->id}}" {{intval(old('xa_tamtru')) === intval($Xa->id) ? 'selected="true"' : ''}} >{{$Xa->tenxa}}</option>

                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen_tamtru'))
                                                        <?php $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get(); ?>

                                                        @foreach($DanhSach_Xa as $Xa)
                                                            <option value="{{$Xa->id}}" {{intval(old('xa_tamtru')) === intval($Xa->id) ? 'selected="true"' : ''}} >{{$Xa->tenxa}}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>

                                            @if ($errors->has('xa_tamtru'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('xa_tamtru') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group{{ $errors->has('diachitamtru') ? ' has-error' : '' }}">
                                            <label for="diachitamtru" class="control-label">Địa chỉ tạm trú</label>
                                            <i>(Số nhà, đường, Khóm - Ấp)</i>
                                            <input id="diachitamtru" type="text" class="form-control" name="diachitamtru" value="{{ old('diachitamtru') }}" placeholder="Địa chỉ tạm trú" autofocus>
                                            @if ($errors->has('diachitamtru'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('diachitamtru') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <hr class="hr-orange">

                                    <!-- Thông tin dân tộc, tôn giáo, đoàn, đảng -->
                                    <div class="row">
                                        <!-- Dân tộc -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('dantoc') ? ' has-error' : '' }}">
                                            <label for="dantoc" class="control-label">Dân tộc</label>

                                            <select name="dantoc" id="dantoc" class="form-control">
                                                <option value="0">----- Chọn dân tộc -----</option>
                                                @if(isset($DanhSach_DanToc))
                                                    @foreach($DanhSach_DanToc as $DanToc)
                                                        <option value="{{$DanToc->id}}"
                                                            {{intval(old('dantoc')) == intval($DanToc->id) ? 'selected="true"' : ''}}
                                                        >{{$DanToc->tendantoc}}</option>

                                                    @endforeach
                                                @endif
                                            </select>

                                            @if ($errors->has('dantoc'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dantoc') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Tôn giáo -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('tongiao') ? ' has-error' : '' }}">
                                            <label for="tongiao" class="control-label">Tôn giáo</label>

                                            <select name="tongiao" id="tongiao" class="form-control">
                                                <option value="0">----- Chọn tôn giáo -----</option>
                                                @if(isset($DanhSach_TonGiao))
                                                    @foreach($DanhSach_TonGiao as $TonGiao)
                                                        <option value="{{$TonGiao->id}}"
                                                            {{intval(old('tongiao')) == intval($TonGiao->id) ? 'selected="true"' : ''}}
                                                        >{{$TonGiao->tentongiao}}</option>

                                                    @endforeach
                                                @endif
                                            </select>

                                            @if ($errors->has('tongiao'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tongiao') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Ngày vào đoàn TNCS Hồ Chí Minh -->
                                        <div class="col-12">
                                            <p><i>Nếu chưa vào đoàn thì để trống Ngày vào Đoàn TNCS Hồ Chí Minh và Nơi vào Đoàn TNCS Hồ Chí Minh</i></p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('ngayvaodoan') ? ' has-error' : '' }}">
                                            <label for="ngayvaodoan" class="control-label">Ngày vào Đoàn TNCS Hồ Chí Minh</label>
                                            
                                            <input id="ngayvaodoan" type="date" class="form-control" name="ngayvaodoan" value="{{ old('ngayvaodoan')}}" placeholder="Ngày vào Đoàn TNCS Hồ Chí Minh" autofocus>

                                            @if ($errors->has('ngayvaodoan'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('ngayvaodoan') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nơi vào đoàn TNCS Hồ Chí Minh -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('noivaodoan') ? ' has-error' : '' }}">
                                            <label for="noivaodoan" class="control-label">Nơi vào Đoàn TNCS Hồ Chí Minh</label>

                                            <input id="noivaodoan" type="text" class="form-control" name="noivaodoan" value="{{ old('noivaodoan')}}" placeholder="Nơi vào Đoàn TNCS Hồ Chí Minh" autofocus>

                                            @if ($errors->has('noivaodoan'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('noivaodoan') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Ngày vào đảng CS Việt Nam -->
                                        <div class="col-12">
                                            <p><i>Nếu chưa vào Đảng thì để trống Ngày vào Đảng CS Việt Nam và Nơi vào Đảng CS Việt Nam</i></p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('ngayvaodang') ? ' has-error' : '' }}">
                                            <label for="ngayvaodang" class="control-label">Ngày vào Đảng CS Việt Nam</label>

                                            <input id="ngayvaodang" type="date" class="form-control" name="ngayvaodang" value="{{ old('ngayvaodang')}}"autofocus>

                                            @if ($errors->has('ngayvaodang'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('ngayvaodang') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nơi vào Đảng CS Việt Nam (Chi bộ, Đảng bộ) -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('noivaodang') ? ' has-error' : '' }}">
                                            <label for="noivaodang" class="control-label">Nơi vào Đảng CS Việt Nam </label>
                                            <i>(Chi bộ, Đảng bộ)</i>

                                            <input id="noivaodang" type="text" class="form-control" name="noivaodang" value="{{ old('noivaodang')}}" placeholder="Nơi vào Đảng CS Việt Nam (Chi bộ, Đảng bộ)" autofocus>

                                            @if ($errors->has('noivaodang'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('noivaodang') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                        
                                    <hr class="hr-orange">
                                    <!-- Gia đình thuộc diện nghèo, cận nghèo; Mồ côi cha, mẹ; Con thương bình, liệt -->
                                    <div class="row">
                                        <!-- Gia đình thuộc diện nghèo, cận nghèo -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('dienngheocanngheo') ? ' has-error' : '' }}">
                                            <label for="dienngheocanngheo" class="control-label">Gia đình thuộc diện hộ nghèo, cận nghèo</label>
                                            <div class="form-control none-border">
                                                <div class="row">
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">
                                                        <input id="dienngheocanngheo_ngheo" type="checkbox" class="" name="dienngheocanngheo_ngheo" value="1" {{old('dienngheocanngheo_ngheo') ? 'checked="true"' : ''}} >

                                                        <label for="dienngheocanngheo_ngheo" class="control-label"> Hộ nghèo </label>
                                                    </div>
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">
                                                        <input id="dienngheocanngheo_canngheo" type="checkbox" class="" name="dienngheocanngheo_canngheo" value="1" {{old('dienngheocanngheo_canngheo') ? 'checked="true"' : ''}}>

                                                        <label for="dienngheocanngheo_canngheo" class="control-label"> Hộ cận nghèo </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('dienngheocanngheo'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dienngheocanngheo') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Thuộc diện mồ côi -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('dienmocoi') ? ' has-error' : '' }}">
                                            <label for="dienmocoi" class="control-label">Thuộc diện mồ côi</label>
                                            <div class="form-control none-border">
                                                <div class="row">
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">
                                                        <input id="dienmocoi_cha" type="checkbox" class="" name="dienmocoi_cha" value="1" {{old('dienmocoi_cha') ? 'checked="true"' : ''}}>

                                                        <label for="dienmocoi_cha" class="control-label"> Mồ côi cha </label>
                                                    </div>

                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">
                                                        <input id="dienmocoi_me" type="checkbox" class="" name="dienmocoi_me" value="1" {{old('dienmocoi_me') ? 'checked="true"' : ''}}>

                                                        <label for="dienmocoi_me" class="control-label"> Mồ côi mẹ </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('dienmocoi'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dienmocoi') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Con thương binh, liệt sỹ -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('conthuongbinhlietsy') ? ' has-error' : '' }}">
                                            <label for="conthuongbinhlietsy" class="control-label">Con thương binh, liệt sỹ</label>
                                            <div class="form-control none-border">
                                                <div class="row">
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">
                                                        <input id="conthuongbinhlietsy_thuongbinh" type="checkbox" class="" name="conthuongbinhlietsy_thuongbinh" value="1" {{old('conthuongbinhlietsy_thuongbinh') ? 'checked="true"' : ''}} >


                                                        <label for="conthuongbinhlietsy_thuongbinh" class="control-label"> Con thương binh </label>
                                                    </div>
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">

                                                        <input id="conthuongbinhlietsy_lietsy" type="checkbox" class="" name="conthuongbinhlietsy_lietsy" value="1" {{old('conthuongbinhlietsy_lietsy') ? 'checked="true"' : ''}} >

                                                        <label for="conthuongbinhlietsy_lietsy" class="control-label"> Con liệt sỹ </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('conthuongbinhlietsy'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('conthuongbinhlietsy') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Tàn tật -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 form-group{{ $errors->has('tantat') ? ' has-error' : '' }}">
                                            <label for="tantat" class="control-label">Tàn tật</label>
                                            <div class="form-control none-border">
                                                <div class="row">
                                                    <div class="col-6 col-sm-4 col-md-5 col-lg-6">

                                                        <input id="tantat" type="checkbox" class="" name="tantat" value="1" {{old('tantat') ? 'checked="true"' : ''}} >

                                                        <label for="tantat" class="control-label"> Tàn tật </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($errors->has('tantat'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tantat') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Gia đình -->
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 lbl-header">
                                        <i class="fa fa-group"></i> THÔNG TIN GIA ĐÌNH
                                    </div>
                                </div>
                                <br>
                                @if($LyLich)
                                    <!-- Cha -->
                                    <div id="divcha" class="row" {{ old('checkold') ? (old('dienmocoi_cha') ? ' hidden="true"' : '') : ( $LyLich->mocoicha ? ' hidden="true"' : '')}}>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">1. Cha</label>
                                        </div>

                                        <!-- Họ tên cha -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('hotencha') ? ' has-error' : '' }}">
                                            <label for="hotencha" class="control-label">Họ tên cha</label>
                                            <input id="hotencha" type="text" class="form-control" name="hotencha" value="{{ old('hotencha', $LyLich->hotencha)}}" placeholder="Họ tên cha" autofocus>
                                            @if ($errors->has('hotencha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hotencha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Ngày sinh của cha -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('ngaysinhcha') ? ' has-error' : '' }}" title="Nếu chỉ có năm thì nhập 01/01/năm">
                                            <label for="ngaysinhcha" class="control-label">Ngày sinh</label>
                                            <input id="ngaysinhcha" type="date" class="form-control" name="ngaysinhcha" value="{{ old('ngaysinhcha', $LyLich->ngaysinhcha)}}" autofocus>
                                            @if ($errors->has('ngaysinhcha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('ngaysinhcha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Điện thoại của cha -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('dienthoaicha') ? ' has-error' : '' }}">
                                            <label for="dienthoaicha" class="control-label">Điện thoại</label>
                                            <input id="dienthoaicha" type="text" class="form-control" name="dienthoaicha" value="{{ old('dienthoaicha', $LyLich->dienthoaicha)}}" placeholder="Điện thoại" autofocus>
                                            @if ($errors->has('dienthoaicha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dienthoaicha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Dân tộc của cha -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('dantoccha') ? ' has-error' : '' }}">
                                            <label for="dantoccha" class="control-label">Dân tộc</label>
                                            <select name="dantoccha" id="dantoccha" class="form-control">
                                                <option value="0">----- Chọn dân tộc -----</option>
                                                @if(isset($DanhSach_DanToc))
                                                    @foreach($DanhSach_DanToc as $DanToc)
                                                        <option value="{{$DanToc->id}}" {{intval(old('dantoccha', $LyLich->dantoc_idcha)) == intval($DanToc->id) ? 'selected="true"' : ''}} >{{$DanToc->tendantoc}}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                            @if ($errors->has('dantoccha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dantoccha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nghề nghiệp của cha -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('nghenghiepcha') ? ' has-error' : '' }}">
                                            <label for="nghenghiepcha" class="control-label">Nghề nghiệp</label>
                                            <input id="nghenghiepcha" type="text" class="form-control" name="nghenghiepcha" value="{{ old('nghenghiepcha', $LyLich->nghenghiepcha)}}" placeholder="Nghề nghiệp" autofocus>
                                            @if ($errors->has('nghenghiepcha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('nghenghiepcha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nơi làm việc của cha -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('noilamvieccha') ? ' has-error' : '' }}">
                                            <label for="noilamvieccha" class="control-label">Nơi làm việc</label>
                                            <input id="noilamvieccha" type="text" class="form-control" name="noilamvieccha" value="{{ old('noilamvieccha', $LyLich->noilamvieccha)}}" placeholder="Nơi làm việc" autofocus>
                                            @if ($errors->has('noilamvieccha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('noilamvieccha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Hộ khẩu thường trú của cha -->
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">Địa chỉ thường trú</label>
                                        </div>

                                        <!-- Tỉnh -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('tinh_thuongtru_cha') ? ' has-error' : '' }}">
                                            <label for="tinh_thuongtru_cha" class="control-label">Tỉnh - Thành phố</label>
                                            
                                            <select name="tinh_thuongtru_cha" id="tinh_thuongtru_cha" class="form-control" url="{{route('huyenajax')}}">
                                                <option value="0">----- Chọn Tỉnh - Thành phố -----</option>
                                                @if(isset($DanhSach_Tinh))
                                                    @foreach($DanhSach_Tinh as $Tinh)
                                                        @if($LyLich->xa_idcha)
                                                            <option value="{{$Tinh->id}}"
                                                                {{intval(old('tinh_thuongtru_cha', Xa::find($LyLich->xa_idcha)->huyen->tinh->id)) == intval($Tinh->id) ? 'selected="true"' : ''}}
                                                            >{{$Tinh->tentinh}}</option>
                                                        @else
                                                            <option value="{{$Tinh->id}}"
                                                                {{intval(old('tinh_thuongtru_cha')) == intval($Tinh->id) ? 'selected="true"' : ''}}
                                                            >{{$Tinh->tentinh}}</option>
                                                        @endif

                                                    @endforeach
                                                @endif
                                            </select>

                                            @if ($errors->has('tinh_thuongtru_cha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tinh_thuongtru_cha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Quận - Huyện -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('huyen_thuongtru_cha') ? ' has-error' : '' }}">
                                            <label for="huyen_thuongtru_cha" class="control-label">Quận - Huyện</label>
                                            <select name="huyen_thuongtru_cha" id="huyen_thuongtru_cha" class="form-control" url="{{route('xaajax')}}">
                                                <option value="0">----- Chọn Quận - Huyện -----</option>
                                                @if($xa_id = old('xa_thuongtru_cha', $LyLich->xa_idcha))
                                                    <?php 
                                                        $tinh_id = App\Xa::find($xa_id)->huyen->tinh->id;
                                                        $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Huyen as $Huyen)
                                                        @if($LyLich->xa_idcha)
                                                            <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_cha', Xa::find($LyLich->xa_idcha)->huyen->id)) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                        @else
                                                            <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_cha')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen_thuongtru_cha'))
                                                        <?php 
                                                            $tinh_id = App\Huyen::find($huyen_id)->tinh->id;
                                                            $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                        ?>
                                                        @foreach($DanhSach_Huyen as $Huyen)
                                                            @if($LyLich->xa_idcha)
                                                                <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_cha', Xa::find($LyLich->xa_idcha)->huyen->id)) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                            @else
                                                                <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_cha')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @if($tinh_id = old('tinh_thuongtru_cha'))
                                                            <?php $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get(); ?>
                                                            @foreach($DanhSach_Huyen as $Huyen)
                                                                @if($LyLich->xa_idcha)
                                                                    <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_cha', Xa::find($LyLich->xa_idcha)->huyen->id)) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                                @else
                                                                    <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_cha')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endif
                                            </select>
                                            @if ($errors->has('huyen_thuongtru_cha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('huyen_thuongtru_cha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Xã - Phường -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('xa_thuongtru_cha') ? ' has-error' : '' }}">
                                            <label for="xa_thuongtru_cha" class="control-label">Xã - Phường</label>
                                            <select name="xa_thuongtru_cha" id="xa_thuongtru_cha" class="form-control">
                                                <option value="0">----- Chọn Xã - Phường -----</option>
                                                @if($xa_id = old('xa_thuongtru_cha', $LyLich->xa_idcha))
                                                    <?php 
                                                        $huyen_id = App\Xa::find($xa_id)->huyen->id;
                                                        $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Xa as $Xa)
                                                        <option value="{{$Xa->id}}" {{intval(old('xa_thuongtru_cha', $LyLich->xa_idcha)) === intval($Xa->id) ? 'selected="true"' : ''}} >{{$Xa->tenxa}}</option>
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen_thuongtru_cha'))
                                                        <?php $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get(); ?>
                                                        @foreach($DanhSach_Xa as $Xa)
                                                            <option value="{{$Xa->id}}" {{intval(old('xa_thuongtru_cha', $LyLich->xa_idcha)) === intval($Xa->id) ? 'selected="true"' : ''}} >{{$Xa->tenxa}}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>
                                            @if ($errors->has('xa_thuongtru_cha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('xa_thuongtru_cha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Địa chỉ thường trú của cha -->
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group{{ $errors->has('hokhauthuongtrucha') ? ' has-error' : '' }}">
                                            <label for="hokhauthuongtrucha" class="control-label">Hộ khẩu thường trú</label>
                                            <i>(Số nhà, đường, Khóm - Ấp)</i>
                                            <input id="hokhauthuongtrucha" type="text" class="form-control" name="hokhauthuongtrucha" value="{{ old('hokhauthuongtrucha', $LyLich->hokhauthuongtrucha)}}" placeholder="Hộ khẩu thường trú" autofocus>
                                            @if ($errors->has('hokhauthuongtrucha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hokhauthuongtrucha') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <hr  class="hr-orange">
                                        </div>
                                    </div>
                                    
                                    <!-- Mẹ -->
                                    <div id="divme" class="row" {{ old('checkold') ? (old('dienmocoi_me') ? 'hidden="true"' : '') : ( $LyLich->mocoime ? 'hidden="true"' : '')}}>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">2. Mẹ</label>
                                        </div>
                                        <!-- Họ tên mẹ -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('hotenme') ? ' has-error' : '' }}">
                                            <label for="hotenme" class="control-label">Họ tên mẹ</label>
                                            <input id="hotenme" type="text" class="form-control" name="hotenme" value="{{ old('hotenme', $LyLich->hotenme)}}" placeholder="Họ tên mẹ" autofocus>
                                            @if ($errors->has('hotenme'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hotenme') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Ngày sinh của me -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('ngaysinhme') ? ' has-error' : '' }}" title="Nếu chỉ có năm thì nhập 01/01/năm">
                                            <label for="ngaysinhme" class="control-label">Ngày sinh</label>
                                            <input id="ngaysinhme" type="date" class="form-control" name="ngaysinhme" value="{{ old('ngaysinhme', $LyLich->ngaysinhme)}}" autofocus>
                                            @if ($errors->has('ngaysinhme'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('ngaysinhme') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Điện thoại của me -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('dienthoaime') ? ' has-error' : '' }}">
                                            <label for="dienthoaime" class="control-label">Điện thoại</label>
                                            <input id="dienthoaime" type="text" class="form-control" name="dienthoaime" value="{{ old('dienthoaime', $LyLich->dienthoaime)}}" placeholder="Điện thoại" autofocus>
                                            @if ($errors->has('dienthoaime'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dienthoaime') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Dân tộc của me -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('dantocme') ? ' has-error' : '' }}">
                                            <label for="dantocme" class="control-label">Dân tộc</label>
                                            <select name="dantocme" id="dantocme" class="form-control">
                                                <option value="0">----- Chọn dân tộc -----</option>
                                                @if(isset($DanhSach_DanToc))
                                                    @foreach($DanhSach_DanToc as $DanToc)
                                                        <option value="{{$DanToc->id}}" {{intval(old('dantocme', $LyLich->dantoc_idme)) == intval($DanToc->id) ? 'selected="true"' : ''}} >{{$DanToc->tendantoc}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('dantocme'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dantocme') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nghề nghiệp của me -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('nghenghiepme') ? ' has-error' : '' }}">
                                            <label for="nghenghiepme" class="control-label">Nghề nghiệp</label>
                                            <input id="nghenghiepme" type="text" class="form-control" name="nghenghiepme" value="{{ old('nghenghiepme', $LyLich->nghenghiepme)}}" placeholder="Nghề nghiệp" autofocus>
                                            @if ($errors->has('nghenghiepme'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('nghenghiepme') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nơi làm việc của me -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('noilamviecme') ? ' has-error' : '' }}">
                                            <label for="noilamviecme" class="control-label">Nơi làm việc</label>
                                            <input id="noilamviecme" type="text" class="form-control" name="noilamviecme" value="{{ old('noilamviecme', $LyLich->noilamviecme)}}" placeholder="Nơi làm việc" autofocus>
                                            @if ($errors->has('noilamviecme'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('noilamviecme') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Hộ khẩu thường trú của mẹ -->
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-lg-12">
                                            <label class="lblbold" for="">Địa chỉ thường trú</label>
                                        </div>

                                        <!-- Tỉnh -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('tinh_thuongtru_me') ? ' has-error' : '' }}">
                                            <label for="tinh_thuongtru_me" class="control-label">Tỉnh - Thành phố</label>
                                            <select name="tinh_thuongtru_me" id="tinh_thuongtru_me" class="form-control" url="{{route('huyenajax')}}">
                                                <option value="0">----- Chọn Tỉnh - Thành phố -----</option>
                                                @if(isset($DanhSach_Tinh))
                                                    @foreach($DanhSach_Tinh as $Tinh)
                                                        @if($LyLich->xa_idme)
                                                            <option value="{{$Tinh->id}}" {{intval(old('tinh_thuongtru_me', Xa::find($LyLich->xa_idme)->huyen->tinh->id)) == intval($Tinh->id) ? 'selected="true"' : ''}} >{{$Tinh->tentinh}}</option>
                                                        @else
                                                            <option value="{{$Tinh->id}}" {{intval(old('tinh_thuongtru_me')) == intval($Tinh->id) ? 'selected="true"' : ''}} >{{$Tinh->tentinh}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>

                                            @if ($errors->has('tinh_thuongtru_me'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tinh_thuongtru_me') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Quận - Huyện -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('huyen_thuongtru_me') ? ' has-error' : '' }}">
                                            <label for="huyen_thuongtru_me" class="control-label">Quận - Huyện</label>
                                            <select name="huyen_thuongtru_me" id="huyen_thuongtru_me" class="form-control" url="{{route('xaajax')}}">
                                                <option value="0">----- Chọn Quận - Huyện -----</option>
                                                @if($xa_id = old('xa_thuongtru_me', $LyLich->xa_idme))
                                                    <?php 
                                                        $tinh_id = App\Xa::find($xa_id)->huyen->tinh->id;
                                                        $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Huyen as $Huyen)
                                                        @if($LyLich->xa_idme)
                                                            <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_me', Xa::find($LyLich->xa_idme)->huyen->id)) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                        @else
                                                            <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_me')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen_thuongtru_me'))
                                                        <?php 
                                                            $tinh_id = App\Huyen::find($huyen_id)->tinh->id;
                                                            $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                        ?>
                                                        @foreach($DanhSach_Huyen as $Huyen)
                                                            @if($LyLich->xa_idme)
                                                                <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_me', Xa::find($LyLich->xa_idme)->huyen->id)) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                            @else
                                                                <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_me')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @if($tinh_id = old('tinh_thuongtru_me'))
                                                            <?php $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get(); ?>
                                                            @foreach($DanhSach_Huyen as $Huyen)
                                                                @if($LyLich->xa_idme)
                                                                    <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_me', Xa::find($LyLich->xa_idme)->huyen->id)) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                                @else
                                                                    <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_me')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endif
                                            </select>
                                            @if ($errors->has('huyen_thuongtru_me'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('huyen_thuongtru_me') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Xã - Phường -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('xa_thuongtru_me') ? ' has-error' : '' }}">
                                            <label for="xa_thuongtru_me" class="control-label">Xã - Phường</label>
                                            <select name="xa_thuongtru_me" id="xa_thuongtru_me" class="form-control">
                                                <option value="0">----- Chọn Xã - Phường -----</option>
                                                @if($xa_id = old('xa_thuongtru_me', $LyLich->xa_idme))
                                                    <?php 
                                                        $huyen_id = App\Xa::find($xa_id)->huyen->id;
                                                        $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Xa as $Xa)
                                                        @if($LyLich->xa_idme)
                                                            <option value="{{$Xa->id}}" {{intval(old('xa_thuongtru_me', $LyLich->xa_idme)) == intval($Xa->id) ? 'selected="tru"' : ''}} >{{$Xa->tenxa}}</option>
                                                        @else
                                                            <option value="{{$Xa->id}}" {{intval(old('xa_thuongtru_me')) == intval($Xa->id) ? 'selected="true"' : ''}} >{{$Xa->tenxa}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen_thuongtru_me'))
                                                        <?php $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get(); ?>
                                                        @foreach($DanhSach_Xa as $Xa)
                                                            @if($LyLich->xa_idme)
                                                                <option value="{{$Xa->id}}" {{intval(old('xa_thuongtru_me', $LyLich->xa_idme)) == intval($Xa->id) ? 'selected="tru"' : ''}} >{{$Xa->tenxa}}</option>
                                                            @else
                                                                <option value="{{$Xa->id}}" {{intval(old('xa_thuongtru_me')) == intval($Xa->id) ? 'selected="true"' : ''}} >{{$Xa->tenxa}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>

                                            @if ($errors->has('xa_thuongtru_me'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('xa_thuongtru_me') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <!-- Địa chỉ thường trú của mẹ -->
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group{{ $errors->has('hokhauthuongtrume') ? ' has-error' : '' }}">
                                            <label for="hokhauthuongtrume" class="control-label">Hộ khẩu thường trú</label>
                                            <i>(Số nhà, đường, Khóm - Ấp)</i>
                                            <input id="hokhauthuongtrume" type="text" class="form-control" name="hokhauthuongtrume" value="{{ old('hokhauthuongtrume', $LyLich->hokhauthuongtrume)}}" placeholder="Hộ khẩu thường trú" autofocus>
                                            @if ($errors->has('hokhauthuongtrume'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hokhauthuongtrume') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <hr class="hr-orange">
                                        </div>
                                    </div>
                                    <!-- Anh, Chị, Em ruột -->
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">3. Anh, Chị, Em ruột</label>
                                        </div>
                                        <div id="div_table_anhchiem" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
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
                                                                <input type="text" id="anhchiem_inp_noio_0" class="form-control" placeholder="Nơi ở">
                                                            </td>
                                                            <td class="text-center">
                                                                <button class="btn btn-warning btn-remove-row" title="Xóa"><i class="fa fa-remove"></i></button>
                                                            </td>
                                                        </tr>

                                                        @if(old('anhchiem_inp_hoten'))
                                                            @for($i = 0; $i < count(old('anhchiem_inp_hoten')); $i++)
                                                                <tr id="{{($i+1)}}">
                                                                    <td>
                                                                        <select name="anhchiem_sel_moiquanhe[]" class="form-control">
                                                                            <option value="0">-Chọn-</option>
                                                                            @if(isset($DanhSach_MoiQuanHe))
                                                                                @foreach($DanhSach_MoiQuanHe as $MoiQuanHe)
                                                                                    <option value="{{$MoiQuanHe->id}}" {{intval(old('anhchiem_sel_moiquanhe.' . $i)) == intval($MoiQuanHe->id) ? 'selected = "true"' : ''}}>{{$MoiQuanHe->tenmoiquanhe}}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="anhchiem_inp_hoten[]" class="form-control" value="{{old('anhchiem_inp_hoten.' . $i)}}" placeholder="Họ và tên">
                                                                    </td>
                                                                    <td>
                                                                        <input type="date" name="anhchiem_dat_namsinh[]" class="form-control" value="{{ old('anhchiem_dat_namsinh.' . $i) }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="anhchiem_inp_nghenghiep[]" value="{{ old('anhchiem_inp_nghenghiep.' . $i) }}" class="form-control" placeholder="Nghề nghiệp">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="anhchiem_inp_noio[]"  class="form-control" value="{{ old('anhchiem_inp_noio.' . $i) }}" placeholder="Nơi ở">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button class="btn btn-warning btn-remove-row" title="Xóa"><i class="fa fa-remove"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endfor
                                                        @else
                                                            <?php $i = 0; ?>
                                                            @if(count($DanhSach_AnhChiEm)>0)
                                                                @foreach($DanhSach_AnhChiEm as $AnhChiEm)
                                                                    <tr id="{{($i+1)}}">
                                                                        <td>
                                                                            <select name="anhchiem_sel_moiquanhe[]" class="form-control">
                                                                                <option value="0">-Chọn-</option>
                                                                                @if(isset($DanhSach_MoiQuanHe))
                                                                                    @foreach($DanhSach_MoiQuanHe as $MoiQuanHe)
                                                                                        <option value="{{$MoiQuanHe->id}}" {{intval($AnhChiEm->moiquanhe_id) == intval($MoiQuanHe->id) ? 'selected = "true"' : ''}}>{{$MoiQuanHe->tenmoiquanhe}}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="anhchiem_inp_hoten[]" class="form-control" value="{{$AnhChiEm->hoten}}" placeholder="Họ và tên">
                                                                        </td>
                                                                        <td>
                                                                            <input type="date" name="anhchiem_dat_namsinh[]" class="form-control" value="{{ $AnhChiEm->namsinh }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="anhchiem_inp_nghenghiep[]" value="{{ $AnhChiEm->nghenghiep }}" class="form-control" placeholder="Nghề nghiệp">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="anhchiem_inp_noio[]"  class="form-control" value="{{ $AnhChiEm->noio }}" placeholder="Nơi ở">
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button class="btn btn-warning btn-remove-row" title="Xóa"><i class="fa fa-remove"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6">
                                                                <span class="help-block">
                                                                    <strong id="str_error_anhchiem"></strong>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                            <td colspan="6">
                                                                <br>
                                                                <div class="text-center">
                                                                    <button class="btn btn-primary add-tr-anhchiem" title="Thêm Anh, Chị, Em">
                                                                        <i class="fa fa-plus"></i> <b> THÊM ANH/CHỊ/EM</b>
                                                                    </button>
                                                                </div>
                                                                <br>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Cha -->
                                    <div id="divcha" class="row" {{old('dienmocoi_cha')? 'hidden="true"' : ''}}>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">1. Cha</label>
                                        </div>

                                        <!-- Họ tên cha -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('hotencha') ? ' has-error' : '' }}">
                                            <label for="hotencha" class="control-label">Họ tên cha</label>
                                            <input id="hotencha" type="text" class="form-control" name="hotencha" value="{{ old('hotencha')}}" placeholder="Họ tên cha" autofocus>
                                            @if ($errors->has('hotencha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hotencha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Ngày sinh của cha -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('ngaysinhcha') ? ' has-error' : '' }}" title="Nếu chỉ có năm thì nhập 01/01/năm">
                                            <label for="ngaysinhcha" class="control-label">Ngày sinh</label>
                                            <input id="ngaysinhcha" type="date" class="form-control" name="ngaysinhcha" value="{{ old('ngaysinhcha')}}" autofocus>
                                            @if ($errors->has('ngaysinhcha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('ngaysinhcha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Điện thoại của cha -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('dienthoaicha') ? ' has-error' : '' }}">
                                            <label for="dienthoaicha" class="control-label">Điện thoại</label>
                                            <input id="dienthoaicha" type="text" class="form-control" name="dienthoaicha" value="{{ old('dienthoaicha')}}" placeholder="Điện thoại" autofocus>
                                            @if ($errors->has('dienthoaicha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dienthoaicha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Dân tộc của cha -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('dantoccha') ? ' has-error' : '' }}">
                                            <label for="dantoccha" class="control-label">Dân tộc</label>
                                            <select name="dantoccha" id="dantoccha" class="form-control">
                                                <option value="0">----- Chọn dân tộc -----</option>
                                                @if(isset($DanhSach_DanToc))
                                                    @foreach($DanhSach_DanToc as $DanToc)
                                                        <option value="{{$DanToc->id}}" {{intval(old('dantoccha')) == intval($DanToc->id) ? 'selected="true"' : ''}} >{{$DanToc->tendantoc}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('dantoccha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dantoccha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nghề nghiệp của cha -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('nghenghiepcha') ? ' has-error' : '' }}">
                                            <label for="nghenghiepcha" class="control-label">Nghề nghiệp</label>
                                            <input id="nghenghiepcha" type="text" class="form-control" name="nghenghiepcha" value="{{ old('nghenghiepcha')}}" placeholder="Nghề nghiệp" autofocus>
                                            @if ($errors->has('nghenghiepcha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('nghenghiepcha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nơi làm việc của cha -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('noilamvieccha') ? ' has-error' : '' }}">
                                            <label for="noilamvieccha" class="control-label">Nơi làm việc</label>
                                            <input id="noilamvieccha" type="text" class="form-control" name="noilamvieccha" value="{{ old('noilamvieccha')}}" placeholder="Nơi làm việc" autofocus>
                                            @if ($errors->has('noilamvieccha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('noilamvieccha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Hộ khẩu thường trú của cha -->
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">Địa chỉ thường trú</label>
                                        </div>

                                        <!-- Tỉnh -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('tinh_thuongtru_cha') ? ' has-error' : '' }}">
                                            <label for="tinh_thuongtru_cha" class="control-label">Tỉnh - Thành phố</label>
                                            <select name="tinh_thuongtru_cha" id="tinh_thuongtru_cha" class="form-control" url="{{route('huyenajax')}}">
                                                <option value="0">----- Chọn Tỉnh - Thành phố -----</option>
                                                @if(isset($DanhSach_Tinh))
                                                    @foreach($DanhSach_Tinh as $Tinh)
                                                        <option value="{{$Tinh->id}}" {{intval(old('tinh_thuongtru_cha')) == intval($Tinh->id) ? 'selected="true"' : ''}} >{{$Tinh->tentinh}}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                            @if ($errors->has('tinh_thuongtru_cha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tinh_thuongtru_cha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Quận - Huyện -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('huyen_thuongtru_cha') ? ' has-error' : '' }}">
                                            <label for="huyen_thuongtru_cha" class="control-label">Quận - Huyện</label>
                                            <select name="huyen_thuongtru_cha" id="huyen_thuongtru_cha" class="form-control" url="{{route('xaajax')}}">
                                                <option value="0">----- Chọn Quận - Huyện -----</option>
                                                @if($xa_id = old('xa_thuongtru_cha'))
                                                    <?php 
                                                        $tinh_id = App\Xa::find($xa_id)->huyen->tinh->id;
                                                        $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                    ?>

                                                    @foreach($DanhSach_Huyen as $Huyen)
                                                        <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_cha')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen_thuongtru_cha'))
                                                        <?php 
                                                            $tinh_id = App\Huyen::find($huyen_id)->tinh->id;
                                                            $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                        ?>
                                                        @foreach($DanhSach_Huyen as $Huyen)
                                                            <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_cha')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                        @endforeach
                                                    @else
                                                        @if($tinh_id = old('tinh_thuongtru_cha'))
                                                            <?php $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get(); ?>

                                                            @foreach($DanhSach_Huyen as $Huyen)
                                                                <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_cha')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endif
                                            </select>
                                            @if ($errors->has('huyen_thuongtru_cha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('huyen_thuongtru_cha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Xã - Phường -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('xa_thuongtru_cha') ? ' has-error' : '' }}">
                                            <label for="xa_thuongtru_cha" class="control-label">Xã - Phường</label>
                                            
                                            <select name="xa_thuongtru_cha" id="xa_thuongtru_cha" class="form-control">
                                                <option value="0">----- Chọn Xã - Phường -----</option>

                                                @if($xa_id = old('xa_thuongtru_cha'))
                                                    <?php 
                                                        $huyen_id = App\Xa::find($xa_id)->huyen->id;
                                                        $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Xa as $Xa)
                                                        <option value="{{$Xa->id}}" {{intval(old('xa_thuongtru_cha')) == intval($Xa->id) ? 'selected="true"' : ''}} >{{$Xa->tenxa}}</option>
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen_thuongtru_cha'))
                                                        <?php $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get(); ?>
                                                        @foreach($DanhSach_Xa as $Xa)
                                                            <option value="{{$Xa->id}}" {{intval(old('xa_thuongtru_cha')) == intval($Xa->id) ? 'selected="true"' : ''}} >{{$Xa->tenxa}}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>
                                            @if ($errors->has('xa_thuongtru_cha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('xa_thuongtru_cha') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Địa chỉ thường trú của cha -->
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group{{ $errors->has('hokhauthuongtrucha') ? ' has-error' : '' }}">
                                            <label for="hokhauthuongtrucha" class="control-label">Hộ khẩu thường trú</label>
                                            <i>(Số nhà, đường, Khóm - Ấp)</i>
                                            <input id="hokhauthuongtrucha" type="text" class="form-control" name="hokhauthuongtrucha" value="{{ old('hokhauthuongtrucha')}}" placeholder="Hộ khẩu thường trú" autofocus>
                                            @if ($errors->has('hokhauthuongtrucha'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hokhauthuongtrucha') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Mẹ -->
                                    <div id="divme" class="row" {{old('dienmocoi_me')? 'hidden="true"' : ''}}>
                                        <div class="col-12">
                                            <hr class="hr-orange">
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">2. Mẹ</label>
                                        </div>
                                        <!-- Họ tên mẹ -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('hotenme') ? ' has-error' : '' }}">
                                            <label for="hotenme" class="control-label">Họ tên mẹ</label>

                                            <input id="hotenme" type="text" class="form-control" name="hotenme" value="{{ old('hotenme')}}" placeholder="Họ tên mẹ" autofocus>

                                            @if ($errors->has('hotenme'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hotenme') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Ngày sinh của me -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('ngaysinhme') ? ' has-error' : '' }}" title="Nếu chỉ có năm thì nhập 01/01/năm">
                                            <label for="ngaysinhme" class="control-label">Ngày sinh</label>

                                            <input id="ngaysinhme" type="date" class="form-control" name="ngaysinhme" value="{{ old('ngaysinhme')}}" autofocus>

                                            @if ($errors->has('ngaysinhme'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('ngaysinhme') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Điện thoại của me -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('dienthoaime') ? ' has-error' : '' }}">
                                            <label for="dienthoaime" class="control-label">Điện thoại</label>

                                            <input id="dienthoaime" type="text" class="form-control" name="dienthoaime" value="{{ old('dienthoaime')}}" placeholder="Điện thoại" autofocus>

                                            @if ($errors->has('dienthoaime'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dienthoaime') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Dân tộc của me -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('dantocme') ? ' has-error' : '' }}">
                                            <label for="dantocme" class="control-label">Dân tộc</label>

                                            <select name="dantocme" id="dantocme" class="form-control">
                                                <option value="0">----- Chọn dân tộc -----</option>
                                                @if(isset($DanhSach_DanToc))
                                                    @foreach($DanhSach_DanToc as $DanToc)
                                                        <option value="{{$DanToc->id}}"
                                                            {{intval(old('dantocme')) == intval($DanToc->id) ? 'selected="true"' : ''}}
                                                        >{{$DanToc->tendantoc}}</option>

                                                    @endforeach
                                                @endif
                                            </select>

                                            @if ($errors->has('dantocme'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('dantocme') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nghề nghiệp của me -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('nghenghiepme') ? ' has-error' : '' }}">
                                            <label for="nghenghiepme" class="control-label">Nghề nghiệp</label>

                                            <input id="nghenghiepme" type="text" class="form-control" name="nghenghiepme" value="{{ old('nghenghiepme')}}" placeholder="Nghề nghiệp" autofocus>

                                            @if ($errors->has('nghenghiepme'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('nghenghiepme') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Nơi làm việc của me -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('noilamviecme') ? ' has-error' : '' }}">
                                            <label for="noilamviecme" class="control-label">Nơi làm việc</label>

                                            <input id="noilamviecme" type="text" class="form-control" name="noilamviecme" value="{{ old('noilamviecme')}}" placeholder="Nơi làm việc" autofocus>

                                            @if ($errors->has('noilamviecme'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('noilamviecme') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Hộ khẩu thường trú của mẹ -->
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">Địa chỉ thường trú</label>
                                        </div>

                                        <!-- Tỉnh -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('tinh_thuongtru_me') ? ' has-error' : '' }}">
                                            <label for="tinh_thuongtru_me" class="control-label">Tỉnh - Thành phố</label>
                                            <select name="tinh_thuongtru_me" id="tinh_thuongtru_me" class="form-control" url="{{route('huyenajax')}}">
                                                <option value="0">----- Chọn Tỉnh - Thành phố -----</option>
                                                @if(isset($DanhSach_Tinh))
                                                    @foreach($DanhSach_Tinh as $Tinh)
                                                        <option value="{{$Tinh->id}}" {{intval(old('tinh_thuongtru_me')) == intval($Tinh->id) ? 'selected="true"' : ''}} >{{$Tinh->tentinh}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('tinh_thuongtru_me'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('tinh_thuongtru_me') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Quận - Huyện -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('huyen_thuongtru_me') ? ' has-error' : '' }}">
                                            <label for="huyen_thuongtru_me" class="control-label">Quận - Huyện</label>
                                            <select name="huyen_thuongtru_me" id="huyen_thuongtru_me" class="form-control" url="{{route('xaajax')}}">
                                                <option value="0">----- Chọn Quận - Huyện -----</option>
                                                @if($xa_id = old('xa_thuongtru_me'))
                                                    <?php 
                                                        $tinh_id = App\Xa::find($xa_id)->huyen->tinh->id;
                                                        $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Huyen as $Huyen)
                                                        <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_me')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen_thuongtru_me'))
                                                        <?php 
                                                            $tinh_id = App\Huyen::find($huyen_id)->tinh->id;
                                                            $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                        ?>
                                                        @foreach($DanhSach_Huyen as $Huyen)
                                                            <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_me')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                        @endforeach
                                                    @else
                                                        @if($tinh_id = old('tinh_thuongtru_me'))
                                                            <?php 
                                                                $DanhSach_Huyen = App\Huyen::where('tinh_id', '=', $tinh_id)->get();
                                                            ?>
                                                            @foreach($DanhSach_Huyen as $Huyen)
                                                                <option value="{{$Huyen->id}}" {{intval(old('huyen_thuongtru_me')) === intval($Huyen->id) ? 'selected="true"' : ''}} >{{$Huyen->tenhuyen}}</option>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endif
                                            </select>
                                            @if ($errors->has('huyen_thuongtru_me'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('huyen_thuongtru_me') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Xã - Phường -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 form-group{{ $errors->has('xa_thuongtru_me') ? ' has-error' : '' }}">
                                            <label for="xa_thuongtru_me" class="control-label">Xã - Phường</label>
                                            <select name="xa_thuongtru_me" id="xa_thuongtru_me" class="form-control">
                                                <option value="0">----- Chọn Xã - Phường -----</option>
                                                @if($xa_id = old('xa_thuongtru_me'))
                                                    <?php 
                                                        $huyen_id = App\Xa::find($xa_id)->huyen->id;
                                                        $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get();
                                                    ?>
                                                    @foreach($DanhSach_Xa as $Xa)
                                                        <option value="{{$Xa->id}}" {{intval(old('xa_thuongtru_me')) == intval($Xa->id) ? 'selected="tru"' : ''}} >{{$Xa->tenxa}}</option>
                                                    @endforeach
                                                @else
                                                    @if($huyen_id = old('huyen_thuongtru_me'))
                                                        <?php $DanhSach_Xa = App\Xa::where('huyen_id', '=', $huyen_id)->get(); ?>
                                                        @foreach($DanhSach_Xa as $Xa)
                                                            <option value="{{$Xa->id}}" {{intval(old('xa_thuongtru_me')) == intval($Xa->id) ? 'selected="tru"' : ''}} >{{$Xa->tenxa}}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>
                                            @if($errors->has('xa_thuongtru_me'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('xa_thuongtru_me') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <!-- Địa chỉ thường trú của mẹ -->
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xl-12 form-group{{ $errors->has('hokhauthuongtrume') ? ' has-error' : '' }}">
                                            <label for="hokhauthuongtrume" class="control-label">Hộ khẩu thường trú</label>
                                            <i>(Số nhà, đường, Khóm - Ấp)</i>
                                            <input id="hokhauthuongtrume" type="text" class="form-control" name="hokhauthuongtrume" value="{{ old('hokhauthuongtrume')}}" placeholder="Hộ khẩu thường trú" autofocus>
                                            @if ($errors->has('hokhauthuongtrume'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hokhauthuongtrume') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Anh, Chị, Em ruột -->
                                    <div class="row">
                                        <div class="col-12">
                                            <hr class="hr-orange">
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <label class="lblbold" for="">3. Anh, Chị, Em ruột</label>
                                        </div>
                                        <div id="div_table_anhchiem" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 form-group">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
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
                                                                <input type="text" id="anhchiem_inp_noio_0" class="form-control" placeholder="Nơi ở">
                                                            </td>
                                                            <td class="text-center">
                                                                <button class="btn btn-warning btn-remove-row" title="Xóa"><i class="fa fa-remove"></i></button>
                                                            </td>
                                                        </tr>

                                                        @if(old('anhchiem_inp_hoten'))
                                                            @for($i = 0; $i < count(old('anhchiem_inp_hoten')); $i++)
                                                                <tr id="{{($i+1)}}">
                                                                    <td>
                                                                        <select name="anhchiem_sel_moiquanhe[]" class="form-control">
                                                                            <option value="0">-Chọn-</option>
                                                                            @if(isset($DanhSach_MoiQuanHe))
                                                                                @foreach($DanhSach_MoiQuanHe as $MoiQuanHe)
                                                                                    <option value="{{$MoiQuanHe->id}}" {{intval(old('anhchiem_sel_moiquanhe.' . $i)) == intval($MoiQuanHe->id) ? 'selected = "true"' : ''}}>{{$MoiQuanHe->tenmoiquanhe}}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="anhchiem_inp_hoten[]" class="form-control" value="{{old('anhchiem_inp_hoten.' . $i)}}" placeholder="Họ và tên">
                                                                    </td>
                                                                    <td>
                                                                        <input type="date" name="anhchiem_dat_namsinh[]" class="form-control" value="{{ old('anhchiem_dat_namsinh.' . $i) }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="anhchiem_inp_nghenghiep[]" value="{{ old('anhchiem_inp_nghenghiep.' . $i) }}" class="form-control" placeholder="Nghề nghiệp">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="anhchiem_inp_noio[]"  class="form-control" value="{{ old('anhchiem_inp_noio.' . $i) }}" placeholder="Nơi ở">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button class="btn btn-warning btn-remove-row" title="Xóa"><i class="fa fa-remove"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endfor
                                                        @endif
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6">
                                                                <span class="help-block">
                                                                    <strong id="str_error_anhchiem"></strong>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                            <td colspan="6">
                                                                <br>
                                                                <div class="text-center">
                                                                    <button class="btn btn-primary add-tr-anhchiem" title="Thêm Anh, Chị, Em">
                                                                        <strong><i class="fa fa-plus"></i> THÊM ANH/CHỊ/EM </strong>
                                                                    </button>
                                                                </div>
                                                                <br>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <br>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-danger btn-direction btn_save" title="Lưu ý: kiểm tra những ô dữ liệu ngày/tháng/năm phải nhập đầy đủ cả ngày/tháng/năm hệ thống mới cho lưu">
                                        <i class="fa fa-save"></i>
                                        <b>LƯU</b>
                                    </button>
                                    &nbsp;
                                    @if($LyLich)
                                        <a href="{{route('sinhvien_profile_print')}}" class="btn btn-warning btn-direction" title="Lý lịch chỉ lấy những thông tin đã được lưu trong hệ thống. Vui lòng lưu dữ liệu trước (nếu có thay đổi) trước khi tải lý lịch">
                                            <i class="fa fa-download"></i>
                                            <b>TẢI LÝ LỊCH</b>
                                        </a>
                                    @endif
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="page-header text-center">
                <br>
                <h4><b>Không tìm thấy thông tin</b></h4>
                <h5><b>Vui lòng liên hệ quản trị hệ thống nntrong@agu.edu.vn - 0949.309.899</b></h5>
                <hr>
            </div>
        @endif
    <!-- </div> -->
@endsection
@section('javascript')
    @parent
    <script type="text/javascript" src="{!! URL::asset('js/profile_register.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/ajax.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/upload-image-profile.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/donvihanhchinh.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/moment.js') !!}"></script>
    <script>
        $('.btn_save').click(function(e){
            loadereffectshow();
        });
    </script>

@endsection