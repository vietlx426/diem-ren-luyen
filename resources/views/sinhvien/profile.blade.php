@extends('sinhvien.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <content>
        <a href="#sidebar" data-toggle="collapse"><i class="fa fa-navicon fa-lg"></i></a>
        <hr>
        <div class="page-header text-center">
            <h4> SƠ YẾU LÝ LỊCH SINH VIÊN </h4>
            <hr>
        </div>
        <div class="page-content">
            <div class="row col-12">
                <div class="col-md-4 col-xs-12 col-sm-6 col-lg-3">
                    <!-- <img alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.jpg" id="profile-image1" class="img-circle img-responsive"> -->
                    <img width="100%" alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" id="profile-image1" class="img-circle img-responsive"> 
                </div>
                <div class="col-md-8 col-xs-12 col-sm-6 col-lg-9" >
                    <div class="container" >
                        <h5><i class="fa fa-id-badge"></i> Lê Hoàng Anh - DTH123456 </h5>  
                    </div>
                    <hr>
                    <div class="row col-12">
                        <div class="col-md-12 col-lg-4">
                            <i class="fa fa-home"></i> Lớp DH18TH
                        </div>
                        <div class="col-md-12 col-lg-8">
                            <i class="fa fa-object-group"></i> Ngành Công nghệ thông tin
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <i class="fa fa-phone-square"></i> 0946 857 875
                        </div>
                        <div class="col-md-12 col-lg-8">
                            <i class="fa fa-envelope"></i> lhanh@agu.edu.vn
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row container">
                <div class="process">
                    <!-- nav tab -->
                    <div class="process-row nav nav-tabs">
                        <div class="process-step">
                            <button type="button" class="btn btn-info btn-circle" data-toggle="tab" href="#banthan"><i class="fa fa-info fa-3x"></i></button>
                            <p><small>Bản Thân</small></p>
                        </div>
                        <div class="process-step">
                            <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#giadinh"><i class="fa fa-file-text-o fa-3x"></i></button>
                            <p><small>Gia Đình</small></p>
                        </div>
                        <div class="process-step">
                            <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#banthan2"><i class="fa fa-file-text-o fa-3x"></i></button>
                            <p><small>Gia Đình</small></p>
                        </div>
                    </div>
                </div>

                <div class="process container">
                    <!-- tab content -->
                        <div class="tab-content">
                            <div id="banthan" class="tab-pane fade active in show">
                                <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    Giới tính: Nam
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    Khóa: DH18
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    Khoa: Công nghệ thông tin
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    Điểm trúng tuyển: 18
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    Ngày, tháng, năm sinh: 13/11/19912
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    Nơi sinh: An Giang
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    CMND: 1236512789
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    Ngày cấp: 12/08/2009
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    Nơi cấp: CA An Giang
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    Hộ khẩu thường trú: CA An Giang
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    Dân tộc: Kinh
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    Tôn giáo: Không
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    Ngày vào Đoàn TNCS HCM: Không
                                </div>
                                <div class="col-md-12 col-lg-6">
                                   Tại: Không
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    Ngày vào Đảng CSVN: Không
                                </div>
                                <div class="col-md-12 col-lg-6">
                                   Tại: Không
                                </div>
                                </div>
                            </div>
                            <div id="giadinh" class="tab-pane fade">
                                <!-- Cha -->
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        1. Cha
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        Họ tên cha
                                        <b> Nguyễn Văn A </b>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                       Sinh năm <b> 1970 </b></label>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        Dân tộc <b> Kinh </b></label>
                                    </div>
                                    <div class="col-md-12 col-lg-12">
                                        Hộ khẩu thường trú <b> 8E Võ Thị Sáu </b></label>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        Nghề nghiệp <b> Làm ruộng </b></label>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        Điện thoại <b> 0946 857 875 </b></label>
                                    </div>
                                </div>

                                <!-- Mẹ -->
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        2. Mẹ
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        Họ tên cha
                                        <b> Nguyễn Văn A </b>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                       Sinh năm <b> 1970 </b></label>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        Dân tộc <b> Kinh </b></label>
                                    </div>
                                    <div class="col-md-12 col-lg-12">
                                        Hộ khẩu thường trú <b> 8E Võ Thị Sáu </b></label>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        Nghề nghiệp <b> Làm ruộng </b></label>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        Điện thoại <b> 0946 857 875 </b></label>
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
                                            <thead>
                                                <th>Quan hệ</th>
                                                <th>Họ tên</th>
                                                <th>Năm sinh</th>
                                                <th>Nghề nghiệp</th>
                                                <th>Nơi ở</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Em</td>
                                                    <td>Nguyễn Văn B</td>
                                                    <td>1995</td>
                                                    <td>Nhân viên</td>
                                                    <td>Long Xuyên - An Giang</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
        </div>
    </content>
@endsection
@section('javascript')
    @parent
    <script type="text/javascript" src="{!! URL::asset('js/profile.js') !!}"></script>
@endsection