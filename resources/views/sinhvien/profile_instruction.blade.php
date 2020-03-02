@extends('layout.master')
@section('content_one_column')
    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="text-center">
                    <i class="fa fa-university card-image-container"></i>
                </div>
                <h4 class="card-title text-center">HƯỚNG DẪN KÊ KHAI LÝ LỊCH</h4>
                <p class="card-text text-justify">
                    Bước 1. Đăng nhập vào hệ thống. <b><strong> Sử dụng tài khoản email và mật khẩu đã được gửi trong Giấy báo nhập học.</strong></b>
                </p>
                <!-- <p class="card-text text-justify">
                    Bước 2. Nhấn vào nút Lý Lịch.
                </p> -->
                <p class="card-text text-justify">
                    Bước 2. Điền đầy đủ thông tin cho phần bản thân và gia đình.
                </p>
                <p class="card-text text-justify">
                    Bước 3. Nhấn nút lưu.
                </p>
                <p class="card-text text-justify">
                    Bước 4. <b><strong> Tải, in phiếu lý lịch và dán hình, ký tên -> nộp khi đăng ký nhập học.</strong></b>

                </p>
                <!-- <p class="card-text text-center">
                    <b><i>Hệ thống đang quá tải vui, lòng quay lại sau ngày 08/08/2018 để kê khai lý lịch, để giảm thời gian chờ của quý phụ huynh và tân sinh viên.</i></b>
                </p> -->
                <p class="card-text text-center">
                    <a target="_blank" href="{{route('gsignin', ['provider' => env('PROVIDER')])}}" class="btn-danger">
                        Click vào đây để vào trang đăng nhập và kê khai thông tin lý lịch
                    </a>
                </p>
            </div>
            <!-- <div class="card-footer text-right">
                <a href="#" class="card-link text-white"> <i class="fa fa-hand-o-right"></i> Xem chi tiet  </a>
            </div> -->
            <hr>
            <div class="card-body">
                <p class="card-text text-justify">
                    <i class="fa fa-vcard-o"></i>
                      Hồ sơ nhập học gồm các <b><strong>bản sao</strong></b> các loại giấy tờ sau:
                </p>

                <p class="card-text text-justify">
                    a. Học bạ;
                </p>
                <p class="card-text text-justify">
                    b. Sổ hộ khẩu thường trú;
                </p>
                <p class="card-text text-justify">
                    c. Giấy chứng nhận tốt nghiệp trung học phổ thông (THPT) tạm thời đối với những người tốt nghiệp THPT năm 2018 hoặc bằng tốt nghiệp THPT đối với những người đã tốt nghiệp THPT các năm trước đó;
                </p>

                <p class="card-text text-justify">
                    d. Giấy khai sinh;
                </p>
                <p class="card-text text-justify">
                    e. Các minh chứng để được hưởng chế độ "đối tượng ưu tiên" theo quy định trong văn bản hướng dẫn của Bộ GD&ĐT (nếu được hưởng ưu tiên);
                </p>
                
                <p class="card-text text-justify">
                    f. Giấy báo nhập học <i>(bản chính)</i>;
                </p>
                <!-- <p class="card-text text-justify">
                    g. Sơ yếu lý lịch theo mẫu kê khai trên hệ thống
                </p> -->
            </div>
        </div>
    </div>
    <!-- <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
        <div class="card text-white" style="background-color: #C79E4D;">
            <div class="card-body">
                <div class="text-center">
                    <i class="fa fa-sticky-note-o card-image-container"></i>
                </div>
                <h4 class="card-title text-center">THONG BAO SO 1</h4>
                <p class="card-text text-justify">
                    Noi dung thong bao. Noi dung thong bao. Noi dung thong bao. 
                </p>
            </div>
            <div class="card-footer text-right">
                <a href="#" class="card-link text-white"> <i class="fa fa-hand-o-right"></i> Xem chi tiet  </a>
            </div>
        </div>
    </div>
    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="text-center">
                    <i class="fa fa-newspaper-o card-image-container"></i>
                </div>
                <h4 class="card-title text-center">THONG BAO SO 1</h4>
                <p class="card-text text-justify" style="color: #08100e;">
                    Noi dung thong bao. Noi dung thong bao. Noi dung thong bao. 
                </p>
            </div>
            <div class="card-footer text-right">
                <a href="#" class="card-link text-white"> <i class="fa fa-hand-o-right"></i> Xem chi tiet  </a>
            </div>
        </div>
    </div> -->
@endsection