@extends('layout.alertmessage.layout.master');
  @section('content_body')
    <h4>Email vừa đăng nhập không phải là email của trường Đại học An Giang!</h4>
    <h5>Vui lòng đăng xuất google account và đăng nhập lại bằng tài khoản của trường Đại học An Giang (...@agu.edu.vn)</h5>
  @endsection
  @section('content_footer')
    <a target="_blank" href="https://mail.google.com" class="btn btn-warning"> Vào google để đăng xuất </a>
    <a href="{{route('index')}}" class="btn btn-primary"> Quay lại trang chủ </a>
  @endsection
