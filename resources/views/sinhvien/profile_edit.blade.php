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
                    </div>
                </div>
            </div>
            <hr>
            <div class="row container">
                <div class="process">
                    <!-- nav tab -->
                    <div class="process-row nav nav-tabs">
                        <div class="process-step">
                            <button type="button" class="btn btn-info btn-circle" data-toggle="tab" href="#banthan"><i class="fa fa-user fa-3x"></i></button>
                            <p><small>Bản Thân</small></p>
                        </div>
                        <div class="process-step">
                            <button type="button" class="btn btn-default btn-circle" data-toggle="tab" href="#giadinh"><i class="fa fa-users fa-3x"></i></button>
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
                                        <label for="">Giới tính</label>
                                        <div class="form-control">
                                            <input id="gioitinhnam" type="radio" name="gioitinh" value="nam">
                                            <label for="gioitinhnam"> Nam </label>
                                            <input id="gioitinhnu" type="radio" name="gioitinh" value="nam">
                                            <label for="gioitinhnu"> Nữ </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Khóa</label>
                                        <select name="khoa" id="khoa" class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Điện thoại</label>
                                        <input type="text" class="form-control" placeholder="Điện thoại">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Điểm trúng tuyển</label>
                                        <input type="number" class="form-control">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Ngày, tháng, năm sinh</label>
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Nơi sinh</label>
                                        <input type="text" class="form-control" placeholder="Nơi sinh">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">CMND</label>
                                        <input type="text" class="form-control" placeholder="CMND">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Ngày cấp</label>
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Nơi cấp</label>
                                        <input type="text" class="form-control" placeholder="Nơi cấp">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Hộ khẩu thường trú</label>
                                        <input type="text" class="form-control" placeholder="Hộ khẩu thường trú">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Dân tộc</label>
                                        <input type="text" class="form-control" placeholder="Dân tộc">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Tôn giáo</label>
                                        <input type="text" class="form-control" placeholder="Tôn giáo">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                        <label for="">Ngày vào Đoàn TNCS HCM</label>
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                       <label for="">Tại</label>
                                       <input type="text" class="form-control" placeholder="Tại">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                       <label for="">Ngày vào Đảng CSVN</label>
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="col-md-12 col-lg-6 form-group">
                                       <label for="">Tại</label>
                                       <input type="text" class="form-control" placeholder="Tại">
                                    </div>
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
                                        <input type="text" class="form-control" placeholder="Họ tên cha">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                       <label for="">Năm sinh</label>
                                       <input type="date" class="form-control">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                        <label for="">Dân tộc</label>
                                        <select name="cha_dantoc" id="cha_dantoc" class="form-control">
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-12 form-group">
                                        <label for="">Hộ khẩu thường trú</label>
                                        <input type="text" class="form-control" placeholder="Hộ khẩu thường trú">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                       <label for="">Nghề nghiệp</label>
                                       <input type="text" class="form-control" placeholder="Nghề nghiệp">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                        <label for="">Điện thoại</label>
                                        <input type="text" class="form-control" placeholder="Điện thoại">
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
                                        <input type="text" class="form-control" placeholder="Họ tên mẹ">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                       <label for="">Năm sinh</label>
                                       <input type="date" class="form-control">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                        <label for="">Dân tộc</label>
                                        <select name="mẹ_dantoc" id="mẹ_dantoc" class="form-control">
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-12 form-group">
                                        <label for="">Hộ khẩu thường trú</label>
                                        <input type="text" class="form-control" placeholder="Hộ khẩu thường trú">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                       <label for="">Nghề nghiệp</label>
                                       <input type="text" class="form-control" placeholder="Nghề nghiệp">
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-4 form-group">
                                        <label for="">Điện thoại</label>
                                        <input type="text" class="form-control" placeholder="Điện thoại">
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
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5">
                                                        <div class="text-center">
                                                            <button class="btn btn-primary">Thêm</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
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