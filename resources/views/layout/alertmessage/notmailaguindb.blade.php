@extends('layout.alertmessage.layout.master');
  @section('content_body')
    <h4>Email vừa đăng nhập chưa có trong hệ thống!</h4>
    <h5>Vui lòng liên hệ administrator hoặc nhấn vào nút đăng ký bên dưới để đăng ký trực tuyến.</h5>
  @endsection
  @section('content_footer')
    <a href="{{route('home')}}" class="btn btn-primary">Đăng ký</a>
  @endsection