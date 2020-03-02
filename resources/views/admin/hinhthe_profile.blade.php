@extends('admin.layout.master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/admin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/sinhvien.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/image-profile.css')}}">
    <!-- Core CSS file for photoswipe -->
    <link rel="stylesheet" href="{{URL::asset('css/photoswipe/photoswipe.css')}}"> 
    <link rel="stylesheet" href="{{URL::asset('css/photoswipe/default-skin.css')}}"> 
    <link rel="stylesheet" href="{{URL::asset('css/photoswipe/photoswipe_mycustom.css')}}"> 
@endsection
@section('content')
    <?php use App\Xa; ?>
    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2> THÔNG TIN LÝ LỊCH - CẬP NHẬT HÌNH THẺ </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- Block error message -->
                @include('layout.block.message_flash')
                @include('layout.block.message_validation')

                @if(isset($SV))
                    <div class="row">
                        <form method="POST" action="{{route('adminpostpicforstudentcard')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="text" hidden="true" name="sinhvien_id" value="{{$SV->id}}">
                            <input type="text" hidden="true" name="mssv" value="{{$SV->mssv}}">
                            <div class="col-md-4 col-xs-12 col-sm-6 col-lg-2">
                                <div class="form-group">
                                    <div class="main-img-preview">
                                        @if($SV->hinhthe)
                                            <img class="thumbnail img-preview" src="{{URL::asset($SV->hinhthe)}}" title="Preview Logo">
                                        @else
                                            @if(isset($LyLich) && $LyLich->picture)
                                                <img class="thumbnail img-preview" src="{{URL::asset($LyLich->picture)}}" title="Preview Logo">
                                            @else
                                                <img class="thumbnail img-preview" src="{{URL::asset('images\nobody_m.original.jpg')}}" title="Preview Logo">
                                            @endif
                                        @endif
                                    </div>
                                    <!-- Profile image -->
                                    <div class="text-center">
                                        <div class="form-group{{ $errors->has('picprofile') ? ' has-error' : '' }}">
                                            <input id="fakeUploadLogo" name="fakeUploadLogo" class="form-control fake-shadow" placeholder="Choose File" disabled="disabled" hidden="true">
                                            <div class="input-group-btn">
                                                <div class="fileUpload btn btn-danger btn-block fake-shadow">
                                                    <span><i class="fa fa-upload"></i> Upload Picture</span>
                                                    <input id="picprofile" name="picprofile" type="file" class="attachment_upload">
                                                </div>
                                            </div>
                                            @if ($errors->has('picprofile'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('picprofile') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-center" title="Lưu hình đại diện">
                                            <button type="submit" class="btn btn-primary btn-direction btn_save btn-block">
                                                <i class="fa fa-save"></i>
                                                <b>LƯU</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-xs-12 col-sm-6 col-lg-9" >
                                <div class="container">
                                    <div class="row">
                                        <!-- Họ tên -->
                                        <div class="form-group col-sm-12 col-md-6">
                                            <label for="">Họ tên: {!! $SV->hochulot !!} {!! $SV->ten !!}</label>
                                        </div>
                                        
                                        <!-- MSSV -->
                                        <div class="form-group col-sm-12 col-md-6">
                                            <label for="">Mã số sinh viên: {!! $SV->mssv !!}</label>
                                        </div>

                                        <!-- Ngày sinh -->
                                        <div class="form-group col-sm-12 col-md-6">
                                            <label for="">Ngày sinh: {!! date('d/m/Y', strtotime( $SV->ngaysinh)) !!}</label>
                                        </div>

                                        <!-- Giới tính -->
                                        <div class="col-sm-12 col-md-6 form-group">
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
                                                <strong> * Những thông tin trên nếu chưa chính xác (không đúng). Vui lòng liên hệ thầy Nguyễn Ngọc Trọng (0949.309.899 - nntrong@agu.edu.vn).</strong>
                                            </span>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if(isset($DanhSach_LyLich))
                        <div class="row col-12">
                            <hr>
                            <div class="col-12">
                                <div class="x_title">
                                    <h2> <i class="fa fa-file-image-o"></i> HÌNH ẢNH </h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <input type="text" id="picpath" name="picpath" value="" class="hidden" hidden="true">
                                        <div class="my-gallery" itemscope>
                                            @foreach($DanhSach_LyLich as $LyLich)
                                                @if($LyLich->picture)
                                                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 text-center">
                                                        <div class="row" style="height=150px; background-color=red;">
                                                        <label for="rad_lylich_{{$LyLich->id}}">
                                                            <figure itemprop="associatedMedia" itemscope>
                                                                <a href="{{URL::asset($LyLich->picture)}}" class="img-card" itemprop="contentUrl" data-size="1024x1024">
                                                                    <img src="{{URL::asset($LyLich->picture)}}" itemprop="thumbnail" alt="Image description" />
                                                                </a>
                                                            </figure>
                                                        </label>
                                                        </div>
                                                        <div class="btn btn-default btn-check-lylich-pic" value="{{URL::asset($LyLich->picture)}}"><i class="fa fa-square-o"></i></div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <!-- Root element of PhotoSwipe. Must have class pswp. -->
                                        <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                                        <!-- Background of PhotoSwipe. 
                                            It's a separate element, as animating opacity is faster than rgba(). -->
                                        <div class="pswp__bg"></div>
                                        <!-- Slides wrapper with overflow:hidden. -->
                                        <div class="pswp__scroll-wrap">
                                            <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
                                            <!-- don't modify these 3 pswp__item elements, data is added later on. -->
                                            <div class="pswp__container">
                                                <div class="pswp__item"></div>
                                                <div class="pswp__item"></div>
                                                <div class="pswp__item"></div>
                                            </div>
                                            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                                            <div class="pswp__ui pswp__ui--hidden">
                                                <div class="pswp__top-bar">
                                                    <!--  Controls are self-explanatory. Order can be changed. -->
                                                    <div class="pswp__counter"></div>
                                                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                                                    <button class="pswp__button pswp__button--share" title="Share"></button>
                                                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                                                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                                                    <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                                                    <!-- element will get class pswp__preloader--active when preloader is running -->
                                                    <div class="pswp__preloader">
                                                        <div class="pswp__preloader__icn">
                                                            <div class="pswp__preloader__cut">
                                                                <div class="pswp__preloader__donut"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                                    <div class="pswp__share-tooltip"></div> 
                                                </div>
                                                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"> </button>
                                                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"> </button>
                                                <div class="pswp__caption">
                                                    <div class="pswp__caption__center"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-primary btn-save-hinhthe-copy"><strong><i class="fa fa-save"></i> LƯU </strong></button>
                            </div>
                        </div>
                    @endif
                @else
                    <br>
                    <h4 class="text-center"><b>Không tìm thấy thông tin</b></h4>
                    <h5 class="text-center"><b>Vui lòng liên hệ quản trị hệ thống nntrong@agu.edu.vn - 0949.309.899</b></h5>
                    <hr>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2> THÔNG TIN LÝ LỊCH </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if(isset($LyLich))
                    <div class="col-12">
                        <!-- Bản thân -->
                        <div>
                            <div class="row">
                                <div class="col-xs-12 lbl-header">
                                    <i class="fa fa-user-circle-o"></i>
                                    THÔNG TIN CÁ NHÂN
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <!-- Điện thoại -->
                                <div class="col-md-12 col-lg-6 form-group{{ $errors->has('dienthoai') ? ' has-error' : '' }}">
                                    <label for="dienthoai" class="control-label">Điện thoại: {{$LyLich->dienthoai}}</label>
                                </div>

                                <!-- Email -->
                                <div class="col-md-12 col-lg-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">Email: {{$LyLich->email}} </label>
                                </div>
                                
                                <!-- Nơi sinh -->
                                <div class="col-md-12 col-lg-6 form-group{{ $errors->has('noisinh') ? ' has-error' : '' }}">
                                    <label for="noisinh" class="control-label">Nơi sinh: {{$LyLich->noisinh}} </label>
                                </div>

                            <!-- Số CMND -->
                                <div class="col-md-12 col-lg-6 form-group{{ $errors->has('cmnd') ? ' has-error' : '' }}">
                                    <label for="cmnd" class="control-label">Số CMND: {{$SV->cmnd}} </label>
                                </div>
                                
                                <!-- Ngày cấp CMND -->
                                <div class="col-md-12 col-lg-6 form-group{{ $errors->has('ngaycapcmnd') ? ' has-error' : '' }}">
                                    <label for="ngaycapcmnd" class="control-label">Ngày cấp CMND: {{date('d/m/Y', strtotime($LyLich->ngaycapcmnd))}} </label>
                                </div>

                                <!-- Nơi cấp CMND -->
                                <div class="col-md-12 col-lg-6 form-group{{ $errors->has('noicapcmnd') ? ' has-error' : '' }}">
                                    <label for="noicapcmnd" class="control-label">Nơi cấp CMND: {{$LyLich->noicapcmnd}} </label>
                                </div>

                                <!-- Địa chỉ thường trú, tạm trú -->
                                <div class="col-md-12 col-lg-12 form-group{{ $errors->has('noicapcmnd') ? ' has-error' : '' }}">
                                    <label for="noicapcmnd" class="control-label">Địa chỉ hộ khẩu thường trú: {{  $LyLich->hokhauthuongtru . ', ' . $LyLich->xa_id ? (Xa::find($LyLich->xa_id)->tenxa . ', ' . Xa::find($LyLich->xa_id)->huyen->tenhuyen . ', ' . Xa::find($LyLich->xa_id)->huyen->tinh->tentinh) : ''}} </label>
                                </div>

                                <!-- Địa chỉ thường trú, tạm trú -->
                                <div class="col-md-12 col-lg-12 form-group{{ $errors->has('noicapcmnd') ? ' has-error' : '' }}">
                                    <label for="noicapcmnd" class="control-label">Địa chỉ tạm trú: {{ $LyLich->diachitamtru . ', ' . $LyLich->tamtru_xa_id ? (Xa::find($LyLich->tamtru_xa_id)->tenxa . ', ' . Xa::find($LyLich->tamtru_xa_id)->huyen->tenhuyen . ', ' . Xa::find($LyLich->tamtru_xa_id)->huyen->tinh->tentinh) : ''}} </label>
                                </div>
                            </div>

                            <!-- Thông tin dân tộc, tôn giáo, đoàn, đảng -->
                            <div class="row">
                                <!-- Dân tộc -->
                                <div class="col-md-12 col-lg-6 form-group{{ $errors->has('dantoc') ? ' has-error' : '' }}">
                                    <label for="dantoc" class="control-label">Dân tộc: {{$LyLich->dantoc->tendantoc}} </label>
                                </div>

                                <!-- Tôn giáo -->
                                <div class="col-md-12 col-lg-6 form-group{{ $errors->has('tongiao') ? ' has-error' : '' }}">
                                    <label for="tongiao" class="control-label">Tôn giáo: {{$LyLich->tongiao->tentongiao}}</label>
                                </div>

                                <!-- Ngày vào đoàn TNCS Hồ Chí Minh -->
                                <div class="col-md-12 col-lg-6 form-group{{ $errors->has('ngayvaodoan') ? ' has-error' : '' }}">
                                    <label for="ngayvaodoan" class="control-label">Ngày vào Đoàn TNCS Hồ Chí Minh: {{ $LyLich->ngayvaodoantncshcm ? date('d/m/Y', strtotime($LyLich->ngayvaodoantncshcm)) : 'Chưa' }}</label>
                                </div>

                                <!-- Nơi vào đoàn TNCS Hồ Chí Minh -->
                                <div class="col-md-12 col-lg-6 form-group{{ $errors->has('noivaodoan') ? ' has-error' : '' }}">
                                    <label for="noivaodoan" class="control-label">Nơi vào Đoàn TNCS Hồ Chí Minh: {{$LyLich->noivaodoantncshcm}} </label>
                                </div>

                                <!-- Ngày vào đảng CS Việt Nam -->
                                <div class="col-md-12 col-lg-6 form-group{{ $errors->has('ngayvaodang') ? ' has-error' : '' }}">
                                    <label for="ngayvaodang" class="control-label">Ngày vào Đảng CS Việt Nam: {{$LyLich->ngayvaodangcsvn ? date('d/m/Y', strtotime($LyLich->ngayvaodangcsvn)) : 'Chưa' }} </label>
                                </div>

                                <!-- Nơi vào Đảng CS Việt Nam (Chi bộ, Đảng bộ) -->
                                <div class="col-md-12 col-lg-6 form-group{{ $errors->has('noivaodang') ? ' has-error' : '' }}">
                                    <label for="noivaodang" class="control-label">Nơi vào Đảng CS Việt Nam: {{$LyLich->noivaodangcsvn}} </label>
                                </div>
                            </div>
                                
                            <!-- Gia đình thuộc diện nghèo, cận nghèo; Mồ côi cha, mẹ; Con thương bình, liệt -->
                            <div class="row">
                                <!-- Gia đình thuộc diện nghèo, cận nghèo -->
                                <div class="col-md-6 col-sm-12 col-lg-3 form-group{{ $errors->has('dienngheocanngheo') ? ' has-error' : '' }}">
                                    <label for="dienngheocanngheo" class="control-label">Gia đình thuộc diện: {{ $LyLich->hongheo ? 'Hộ nghèo, ' : '' }} {{ $LyLich->hocanngheo ? 'Hộ cận nghèo, ' : '' }} </label>
                                </div>

                                <!-- Thuộc diện mồ côi -->
                                <div class="col-md-6 col-sm-12 col-lg-3 form-group{{ $errors->has('dienmocoi') ? ' has-error' : '' }}">
                                    <label for="dienmocoi" class="control-label">Thuộc diện mồ côi: {{ $LyLich->mocoicha ? 'Mồ côi cha, ' : '' }} {{ $LyLich->mocoime ? 'Mồ côi mẹ, ' : '' }} </label>
                                </div>

                                <!-- Con thương binh, liệt sỹ -->
                                <div class="col-md-6 col-sm-12 col-lg-3 form-group{{ $errors->has('conthuongbinhlietsy') ? ' has-error' : '' }}">
                                    <label for="conthuongbinhlietsy" class="control-label">Con thương binh, liệt sỹ: {{ $LyLich->conthuongbinh ? 'Con thương binh, ' : '' }} {{ $LyLich->conlietsy ? 'Con liệt sỹ' : '' }} </label>
                                </div>

                                <!-- Tàn tật -->
                                <div class="col-md-6 col-sm-12 col-lg-3 form-group{{ $errors->has('tantat') ? ' has-error' : '' }}">
                                    <label for="tantat" class="control-label">Tàn tật: {{ $LyLich->tantat ? 'Tàn tật' : 'Không' }} </label>
                                </div>
                            </div>
                            <br>
                        </div>

                        <!-- Gia đình -->
                        <div>
                            <div class="row">
                                <div class="col-md-12 lbl-header">
                                    <i class="fa fa-users"></i>
                                    THÔNG TIN GIA ĐÌNH
                                </div>
                            </div>
                            <br>

                            <!-- Cha -->
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <label class="lblbold" for="">1. Cha</label>
                                </div>

                                <!-- Họ tên cha -->
                                <div class="col-md-12 col-lg-6 col-xl-4 form-group{{ $errors->has('hotencha') ? ' has-error' : '' }}">
                                    <label for="hotencha" class="control-label">Họ tên cha: {{ $LyLich->hotencha }} </label>
                                </div>

                                <!-- Ngày sinh của cha -->
                                <div class="col-md-12 col-lg-6 col-xl-4 form-group{{ $errors->has('ngaysinhcha') ? ' has-error' : '' }}">
                                    <label for="ngaysinhcha" class="control-label">Ngày sinh: {{ $LyLich->ngaysinhcha ? date('d/m/Y', strtotime($LyLich->ngaysinhcha)) : '' }} </label>
                                </div>

                                <!-- Điện thoại của cha -->
                                <div class="col-md-12 col-lg-6 col-xl-4 form-group{{ $errors->has('dienthoaicha') ? ' has-error' : '' }}">
                                    <label for="dienthoaicha" class="control-label">Điện thoại: {{$LyLich->dienthoaicha}} </label>
                                </div>

                                <!-- Dân tộc của cha -->
                                <div class="col-md-12 col-lg-6 col-xl-4 form-group{{ $errors->has('dantoccha') ? ' has-error' : '' }}">
                                    <label for="dantoccha" class="control-label">Dân tộc: {{ $LyLich->dantoc_idcha ? $LyLich->dantoccha->tendantoc : '' }} </label>
                                </div>

                                <!-- Nghề nghiệp của cha -->
                                <div class="col-md-12 col-lg-6 col-xl-4 form-group{{ $errors->has('nghenghiepcha') ? ' has-error' : '' }}">
                                    <label for="nghenghiepcha" class="control-label">Nghề nghiệp: {{$LyLich->nghenghiepcha}} </label>
                                </div>

                                <!-- Nơi làm việc của cha -->
                                <div class="col-md-12 col-lg-6 col-xl-4 form-group{{ $errors->has('noilamvieccha') ? ' has-error' : '' }}">
                                    <label for="noilamvieccha" class="control-label">Nơi làm việc: {{ $LyLich->noilamvieccha }}</label>
                                </div>

                                <!-- Hộ khẩu thường trú của cha -->
                                <div class="col-md-12 col-lg-12">
                                    <label for="">Địa chỉ thường trú: {{ $LyLich->xa_idcha ? ( $LyLich->hokhauthuongtrucha . ', ' . App\Xa::find($LyLich->xa_idcha)->tenxa . ', ' . App\Xa::find($LyLich->xa_idcha)->huyen->tenhuyen . ', ' . App\Xa::find($LyLich->xa_idcha)->huyen->tinh->tentinh) : '' }} </label>
                                </div>
                            </div>
                            
                            <hr  class="hr-orange">

                            <!-- Mẹ -->
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <label class="lblbold" for="">2. Mẹ</label>
                                </div>
                                <!-- Họ tên mẹ -->
                                <div class="col-md-12 col-lg-6 col-xl-4 form-group{{ $errors->has('hotenme') ? ' has-error' : '' }}">
                                    <label for="hotenme" class="control-label">Họ tên mẹ: {{ $LyLich->hotenme }} </label>
                                </div>

                                <!-- Ngày sinh của me -->
                                <div class="col-md-12 col-lg-6 col-xl-4 form-group{{ $errors->has('ngaysinhme') ? ' has-error' : '' }}">
                                    <label for="ngaysinhme" class="control-label">Ngày sinh: {{ $LyLich->ngaysinhme ? date('d/m/Y', strtotime($LyLich->ngaysinhme)) : '' }} </label>
                                </div>

                                <!-- Điện thoại của me -->
                                <div class="col-md-12 col-lg-6 col-xl-4 form-group{{ $errors->has('dienthoaime') ? ' has-error' : '' }}">
                                    <label for="dienthoaime" class="control-label">Điện thoại: {{ $LyLich->dienthoaime }} </label>
                                </div>

                                <!-- Dân tộc của me -->
                                <div class="col-md-12 col-lg-6 col-xl-4 form-group{{ $errors->has('dantocme') ? ' has-error' : '' }}">
                                    <label for="dantocme" class="control-label">Dân tộc: {{ $LyLich->dantoc_idme ? $LyLich->dantocme->tendantoc : '' }} </label>
                                </div>

                                <!-- Nghề nghiệp của me -->
                                <div class="col-md-12 col-lg-6 col-xl-4 form-group{{ $errors->has('nghenghiepme') ? ' has-error' : '' }}">
                                    <label for="nghenghiepme" class="control-label">Nghề nghiệp: {{ $LyLich->nghenghiepme }} </label>
                                </div>

                                <!-- Nơi làm việc của me -->
                                <div class="col-md-12 col-lg-6 col-xl-4 form-group{{ $errors->has('noilamviecme') ? ' has-error' : '' }}">
                                    <label for="noilamviecme" class="control-label">Nơi làm việc: {{ $LyLich->noilamviecme }} </label>
                                </div>

                                <!-- Hộ khẩu thường trú của mẹ -->
                                <div class="col-md-12 col-lg-12">
                                    <label for="">Địa chỉ thường trú: {{ $LyLich->xa_idme ? ( $LyLich->hokhauthuongtrume . ', ' . App\Xa::find($LyLich->xa_idme)->tenxa . ', ' . App\Xa::find($LyLich->xa_idme)->huyen->tenhuyen . ', ' . App\Xa::find($LyLich->xa_idme)->huyen->tinh->tentinh) : '' }} </label>
                                </div>
                            </div>
                            <!-- Anh, Chị, Em ruột -->
                            <hr class="hr-orange">
                            <div class="row">
                                
                                <div class="col-md-12 col-lg-12">
                                    <label class="lblbold" for="">3. Anh, Chị, Em ruột</label>
                                </div>
                                <div id="div_table_anhchiem" class="col-md-12 col-lg-12 form-group">
                                    <div class="col-md-12 col-lg-12">
                                        @if(isset($DanhSach_AnhChiEm))
                                            <table class="table-bordered" width="100%">
                                                <thead >
                                                    <th width="10%" class="text-center">Quan hệ</th>
                                                    <th width="20%">Họ tên</th>
                                                    <th width="15%" class="text-center">Năm sinh</th>
                                                    <th width="25%">Nghề nghiệp</th>
                                                    <th width="30%">Nơi ở</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($DanhSach_AnhChiEm as $AnhChiEm)
                                                        <tr>
                                                            <td class="text-center"> {{ $AnhChiEm->moiquanhe->tenmoiquanhe }} </td>
                                                            <td>
                                                            {{$AnhChiEm->hoten}}
                                                            </td>
                                                            <td class="text-center">
                                                            {{ $AnhChiEm->namsinh ? date('d/m/Y', strtotime($AnhChiEm->namsinh)) : '' }}
                                                            </td>
                                                            <td>
                                                                {{ $AnhChiEm->nghenghiep }}
                                                            </td>
                                                            <td>
                                                                {{ $AnhChiEm->noio }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center" style="color: red;">
                        <h3>CHƯA CÓ THÔNG TIN VỀ LÝ LỊCH</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    @parent
    <script type="text/javascript" src="{!! URL::asset('js/profile_register.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/subadmin.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/function.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/upload-image-profile.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/donvihanhchinh.js') !!}"></script>
    <!-- Core JS file for photoswipe -->
    <script src="{{ URL::asset('js/photoswipe/photoswipe.min.js') }}"></script> 
    <script src="{{ URL::asset('js/photoswipe/photoswipe_mycustom.js') }}"></script> 
    <!-- UI JS file for photoswipe -->
    <script src="{{ URL::asset('js/photoswipe/photoswipe-ui-default.min.js') }}"></script>
    <script>
        var urlRoute_adminpostpicforstudentcardcopy = "{{route('adminpostpicforstudentcardcopy')}}";
        var idSinhVien = "{{isset($SV)?$SV->id:''}}";
    </script>
@endsection