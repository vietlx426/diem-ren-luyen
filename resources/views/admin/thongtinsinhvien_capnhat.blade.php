@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/admin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/image-profile.css')}}">
@endsection
@section('content')
    <!-- <div class="row col container"> -->
        <?php use App\Xa; ?>
        @if(isset($SV) && count($SV) > 0)
            <div class="page-header text-center">
                <br>
                <h4><b>THÔNG TIN SINH VIÊN</b></h4>
                <hr>
            </div>
            
            <!-- Block error message -->
            @include('layout.block.message_flash')
            @include('layout.block.message_validation')

            <!-- Form information -->
            <form method="POST" action="{{route('post_capnhatthongtinsinhvien')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="text" name="checkold" value="1" readonly="" hidden="true">
                <input type="text" name="sinhvien_id" value="{{$SV->id}}" readonly="" hidden="true">
                <div class="row">
                    <div class="col-md-4 col-xs-12 col-sm-6 col-lg-2">
                        <!-- <img width="100%" alt="User Pic" src="{{URL::asset('images\nobody_m.original.jpg')}}" class="img-circle img-responsive"> -->
                        
                        <div class="form-group">
                            <div class="main-img-preview">
                                
                                @if($SV->hinhthe)
                                    <img class="thumbnail img-preview" src="{{URL::asset($SV->hinhthe)}}" title="Preview Logo">
                                @else
                                    @if(count($LyLich)>0 && $LyLich->picture)
                                        <img class="thumbnail img-preview" src="{{URL::asset($LyLich->picture)}}" title="Preview Logo">
                                    @else
                                        <img class="thumbnail img-preview" src="{{URL::asset('images\nobody_m.original.jpg')}}" title="Preview Logo">
                                    @endif
                                @endif
                            </div>
                            <!-- Profile image -->
                            <!-- <div class="text-center">
                                <div class="form-group{{ $errors->has('picprofile') ? ' has-error' : '' }}">
                                    <input id="fakeUploadLogo" name="fakeUploadLogo" class="form-control fake-shadow" placeholder="Choose File" disabled="disabled" hidden="true">
                                    <div class="input-group-btn">
                                        <div class="fileUpload btn btn-danger btn-block fake-shadow">
                                            <span><i class="glyphicon glyphicon-upload"></i> Upload Picture</span>
                                            <input id="picprofile" name="picprofile" type="file" class="attachment_upload">
                                        </div>
                                    </div>

                                    @if ($errors->has('picprofile'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('picprofile') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="col-md-8 col-xs-12 col-sm-6 col-lg-9" >
                        <div class="container">
                            <div class="row">
                                <!-- Họ tên -->
                                <div class="form-group col-sm-12 col-md-12 col-lg-6">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-8 {{ $errors->has('hovachulot') ? ' has-error' : '' }} ">
                                            <label for="ten">Họ và chữ lót</label>
                                            <input name="hovachulot" type="text" class="form-control" value="{!! old('hovachulot', $SV->hochulot) !!}" placeholder="Họ và chữ lót">

                                            @if ($errors->has('hovachulot'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('hovachulot') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 {{ $errors->has('ten') ? ' has-error' : '' }}">
                                            <label for="ten">Tên</label>
                                            <input name="ten" type="text" class="form-control" value="{!! old('ten', $SV->ten) !!}" placeholder="Tên">

                                            @if ($errors->has('ten'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('ten') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- MSSV -->
                                <div class="form-group col-sm-12 col-md-12 col-lg-6 {{ $errors->has('mssv') ? ' has-error' : '' }}">
                                    <label for="mssv">Mã số sinh viên</label>
                                    <input type="text" name="mssv" class="form-control" value="{!! old('mssv', $SV->mssv) !!}" placeholder="Mã số sinh viên">
                                    @if ($errors->has('mssv'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('mssv') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Ngày sinh -->
                                <div class="form-group col-sm-12 col-md-12 col-lg-6 {{ $errors->has('ngaysinh') ? ' has-error' : '' }}">
                                    <label for="ngaysinh">Ngày sinh</label>
                                    <input type="date" name="ngaysinh" class="form-control" value="{{old('ngaysinh', $SV->ngaysinh, date('d/m/Y'))}}" placeholder="form-control">
                                    @if ($errors->has('ngaysinh'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('ngaysinh') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Giới tính -->
                                <div class="col-sm-12 col-md-12 col-lg-6 form-group {{ $errors->has('gioitinh') ? ' has-error' : '' }}">
                                    <label for="gioitinh">
                                        Giới tính
                                    </label>
                                    <div class="row col-12">
                                        @if(isset($DanhSach_GioiTinh))
                                            @foreach($DanhSach_GioiTinh as $GioiTinh)
                                                &emsp;
                                                <label for="gioitinh{{$GioiTinh->id}}">{{$GioiTinh->tengioitinh}}: &nbsp;&nbsp;</label>
                                                
                                                <input id="gioitinh{{$GioiTinh->id}}" type="radio" name="gioitinh" value="{{$GioiTinh->id}}" {{ intval(old('gioitinh', $SV->gioitinh)) === intval($GioiTinh->id)?'checked="true"': ''}}>
                                                &emsp;&emsp;
                                            @endforeach
                                        @endif
                                    </div>
                                    @if ($errors->has('gioitinh'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('gioitinh') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Điểm trúng tuyển -->
                                <div class="col-md-12 col-lg-6 form-group {{ $errors->has('diemtrungtuyen') ? ' has-error' : '' }}">
                                    <label for="">Điểm trúng tuyển</label>
                                    @if(old('checkold'))
                                        <input type="text" name="diemtrungtuyen" value="{{old('diemtrungtuyen')}}" class="form-control">
                                    @else
                                        <input type="text" name="diemtrungtuyen" value="{{$SV->diemtrungtuyen}}" class="form-control">
                                    @endif

                                    @if ($errors->has('diemtrungtuyen'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('diemtrungtuyen') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Lớp -->
                                <div class="col-md-12 col-lg-6 form-group {{ $errors->has('lop') ? ' has-error' : '' }}">
                                    <label for="">Lớp</label>
                                    
                                    <select name="lop" id="lop" class="form-control">
                                        @if(isset($DanhSach_Lop))
                                            @foreach($DanhSach_Lop as $Lop)
                                                <option value="{{$Lop->id}}" {{intval($Lop->id) === intval(old('lop', $SV->lop->id))? 'selected="true"' : '' }} > {{$Lop->tenlop}} </option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @if ($errors->has('lop'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('lop') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Email -->
                                <div class="form-group col-sm-12 col-md-12 col-lg-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Email AGU</label>
                                    <input type="text" name="email" class="form-control" value="{!! old('email', $SV->email_agu) !!}" placeholder="Email AGU">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- CMND -->
                                <div class="form-group col-sm-12 col-md-12 col-lg-6 {{ $errors->has('cmnd') ? ' has-error' : '' }}">
                                    <label for="cmnd">CMND</label>
                                    <input type="text" name="cmnd" class="form-control" value="{!! old('cmnd', $SV->cmnd) !!}" placeholder="CMND">
                                    @if ($errors->has('cmnd'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cmnd') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-danger btn_save" title="Click để lưu thông tin cập nhật">
                        <i class="fa fa-save"></i>
                        <b>LƯU</b>
                    </button>
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
    <script type="text/javascript" src="{!! URL::asset('js/upload-image-profile.js') !!}"></script>

    <script src="{{URL::asset('js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{URL::asset('js/bootstrap.min.js')}}" type="text/javascript" charset="utf-8" async defer></script>

     <script type="text/javascript" src="{!! URL::asset('js/donvihanhchinh.js') !!}"></script>
     <script type="text/javascript" src="{!! URL::asset('js/moment.js') !!}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
@endsection